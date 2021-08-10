<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\support\Facades\Hash;
use App\User;

class ProfileController extends Controller
{
    public function __contruct() {
    
        $this->middleware('auth');
    }

    public function index() {

        $isLogged = intval(Auth::id());

        $user = User::findOrFail($isLogged);

        if($user) {

            return view('admin.profile.index', [
                'user' => $user
            ]);

        } else {

            return redirect()->route('login');
        }
    }

    public function save(Request $request) {

    $isLogged = intVal(Auth::id());

    $user = User::findOrFail($isLogged);

    // verifica se existe usuário

    if($user) {
        $data = $request->only([
            'name',
            'email',
            'password',
            'password_confirmation'
        ]);
        
        // valida as informações recebidas por request

        $validator = Validator::make([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password']
        ], [
            'name' => ['string', 'max:100'],
            'email' => ['email', 'string', 'max:100'],
            'password' => ['min:4', 'password', 'string', 'confirmed']
        ]);

        dd($validator->fails());

        // se falhar, redireciona o id com os validators

        if($validator->fails()) {

            return redirect()->back()
                ->withErrors($validator);
        }

        // alterações 

        if($request->has('name')) {

            $user->name = $data['name'];
        } 

        if($request->has('email')) {
            $user->email = $data['email'];
        }
        
        if($data['password'] == $data['password_confirmation']) {
            $user->password = Hash::make($data['password']);
        }
                
        $user->update($data);

        return redirect()->route('users.index')->with('success', 'Editado o perfil com sucesso!');

        }

        return redirect()->route('users.index');

    }
}
