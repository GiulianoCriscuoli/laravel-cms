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
        ], 
        [
            'name' => ['string', 'max:100'],
            'email' => ['email', 'string', 'max:100']
        ]);

        // se falhar, redireciona o id com os validators

        if($validator->fails()) {

            return redirect()->route('profile.index')
                ->withErrors($validator);
        }

        // alterações 

        if($request->has('name')) {

            $user->name = $data['name'];
        } 

        if($request->has('email')) {
            $user->email = $data['email'];
        }

        if(!isset($data['password'])) {

            $validator->errors()->add('password', __('validation.required', [
                'attribute' => 'password'

            ]));
        }
        
        if($data['password'] == $data['password_confirmation']) {
            
            if(strlen($data['password']) >= 4) {
                $user->password = Hash::make($data['password']);

            }  else {

                $validator->errors()->add('password', __('validation.min:4.string', [
                    'attribute' => 'password',
                    'min' => 4
                ]));
            }
        } else {

            $validator->errors()->add('password', __('validation.confirmed', [
                'attribute' => 'password'
            ]));
        }

        if(count($validator->errors()) > 0) {
            return redirect()
                    ->back()
                    ->withErrors($validator);
        }
                
        $user->update($data);

        return redirect()->route('profile.index')->with('success', 'Editado o perfil com sucesso!');

        }

        return redirect()->route('profile.index');

    }
}
