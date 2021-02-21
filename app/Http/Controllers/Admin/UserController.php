<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\User;

class UserController extends Controller
{

   public function  __construct() 
    {   
        $this->middleware('auth');
        $this->middleware('can:edit-users');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(10);

        $isLogged = intval(Auth::id());

        return view('admin.users.index', [
            'users' => $users,
            'isLogged' => $isLogged
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->only([
            'name',
            'email',
            'password',
            'password_confirmation'
        ]);

        $validator = Validator::make($data, [
            'name' => ['string', 'required', 'max:100'],
            'email' => ['string', 'required', 'email', 'max:100', 'unique:users'],
            'password' => ['required', 'password', 'string', 'min:4', 'confirmed'],
        ]);

        if($validator->fails()) {

            return redirect()->route('users.create')
                              ->withErrors($validator)
                              ->withInput();
        }

        $user = new User;

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);

        $user->save();

        return redirect()->route('users.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        if($user) {

            return view('admin.users.edit', ['user' => $user ]);
        } else {
            return redirect()->route('users.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // verifica se existe usuário

        if($user) {
            $data = $request->only([
                'name',
                'email',
                'password',
                'password_confirmation'
            ]);

            // valida as informações recebidas pkr request

            $validator = Validator::make([
                'name' => $data['name'],
                'email' => $data['email']
            ], [
                'name' => ['required', 'string', 'max:100'],
                'email' => ['required', 'email', 'string', 'max:100', 'unique:users']
            ]);

            // se falhar, redireciona o id com os validators

            if($validator->fails()) {

                return redirect()->route('users.edit', [
                    'user' => $id
                ])->withErrors($validator);
            }

            // alterações 

            $user->name = $data['name'];

            if($user->email !== $data['email']) {

                $hasEmail = User::where('email', $data['email'])->get();

                if(count($hasEmail) === 0) {

                    $user->email = $data['email']; 

                } else {

                    $validator->errors()->add('email', 'Email Já existente!');

                    return redirect()->route('users.edit', ['user' => $id]);
                }
            } else {

                $validator->errors()->add('email', 'Este email não pode ser atualizado!');
            }
            
            if(!empty($data['password'])) {

                if(strlen($data['password']) >= 4) {
                    
                    if($data['password'] === $data['password_confirmation']) {
                        
                        $user->password = Hash::make($data['password']);

                    } else {

                        $validator->errors()->add('password', __('validation.min.string',[
                            
                            'attribute' => 'password',
                            'min' => 4
                        ]));
                    }                       
                }

                $user->save();
            }
        }

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $isLogged = intval(Auth::id()); // retorna o id do usuário logado

        if($isLogged !== intval($id)) {

            User::findOrFail($id)->delete();

            // ou pode ser feito dessa forma também

            // $user = User::find($id);
            // $user->delete();

        }

        return redirect()->route('users.index');
    }
}
