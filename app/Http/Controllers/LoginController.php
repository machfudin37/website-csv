<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function login()
    {
        $data = [
            'title' => 'Sign In',
        ];
        if (Auth::check()) {
            return redirect('dasboard');
        } else {
            return view('auth.login.index', $data);
        }
    }

    public function actionlogin(Request $request)
    {
        $data = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];

        if (Auth::Attempt($data)) {
            if (Auth::user()->role == 'admin') {
                return redirect('login');
            } elseif (Auth::user()->role == 'user') {
                return redirect('penyakit');
            }
        } else {
            Session::flash('error', 'Email atau Password Salah');
            return redirect('/');
        }
    }

    public function actionlogout()
    {
        Auth::logout();
        return redirect('/');
    }
}
