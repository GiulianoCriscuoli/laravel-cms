<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
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

    $data = $request->only([
        'name',
        'email',
        'password',
        'password_confirmation' 
    ]);
    
    $validator = Validator::make([

        $data['name'] = $request->name,
        $data['email'] = $request->email
    ],[
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email', 'max:255', 'string']
    ]);

    $isLogged = intval(Auth::id());

    $user = User::findOrFail($isLogged);

    if($user) {

        if($validator->fails()) {

            return redirect()->route('profile.save')->withErrors($validator);
        }

        // alterações 

        $user->name = $data['name'];

        if($user->email !== $data['email']) {

            $hasEmail = User::where('email', $data['email'])->get();

            if(count($hasEmail) === 0) {

                $user->email = $data['email']; 

            } else {

                $validator->errors()->add('email', 'Email Já existente!');

                return redirect()->route('profile.index');
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

            return redirect()->route('profile')
                             ->with('warning', 'Perfil modificado com sucesso!');
        }
    }

    return redirect()->route('users.index');
    }
}
