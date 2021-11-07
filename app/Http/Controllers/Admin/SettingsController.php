<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\support\Facades\Hash;
use App\Setting;

class SettingsController extends Controller
{
    public function __contruct() {
    
        $this->middleware('auth');
    }

    public function index() {

        $setttings  = [];

        $settings = Setting::get();

        return view('admin.settings.index', compact('settings'));
    }

    public function save(Request $request) {

        $data = $request->all();

        $validator = $this->validator($data);
        
        if($validator->fails()) {

            return redirect()->back();
                
        } else {

          Setting::create($data);

            return redirect()
                    ->back()
                    ->with('success', 'Configuração criada com sucesso!');
        }
    }

    protected function validator(array $data) {

        return Validator::make($data, [

            'name' => ['required', 'string', 'max:100'],
            'content' => ['required', 'string'],
            'bgText' => ['required', 'string', 'regex:/[A-Z0-9]{6}/i'],
            'bgColor' => ['required', 'string', 'regex:/[A-Z0-9]{6}/i']
        ]);
    }
}
