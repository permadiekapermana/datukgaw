<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Session;

use Alert;

class AuthController extends Controller
{
    //
    public function Login(){
        if(Session::has('login')){
            return redirect('/cms');
        } else {
            return view('Login', ["title" => 'Login']);
        }
    }

    public function login_process(Request $request, $role){
        // session()->forget('unAuth');
        // session(['login' => true]);
        // session(['role' => $request->header('role')]);
        $request->session()->put('login', true);
        $request->session()->put('role', $role);
        return redirect('/cms');
    }

    public function logout(){
        session()->forget('login');
        session()->forget('role');
        return redirect('/login');
    }
}
