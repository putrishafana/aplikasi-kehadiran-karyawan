<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function go_login(Request $request)
    {
        if(Auth::guard('karyawan')->attempt(['email' => $request->email, 'password' => $request->password])){
            return redirect('/dashboard');
        }else{
            return redirect('/')->with(['warning'=> 'Email atau Password Salah']);
        }
    }

    public function go_logout()
    {
        if(Auth::guard('karyawan')->check()){
            Auth::guard('karyawan')->logout();
            return redirect('/');
        }
    }

    public function login_admin(Request $request)
    {
    if (Auth::guard('user')->attempt(['email' => $request->email, 'password' => $request->password])) {
        $user = Auth::guard('user')->user();
        if ($user->status == 'Aktif') {
            return redirect('/panel/admindashboard');
        } else {
            Auth::guard('user')->logout(); // Logout jika akun tidak aktif
            return redirect('/panel')->with(['warning' => 'Akun Anda Tidak Aktif!']);
        }
    } else {
        return redirect('/panel')->with(['warning' => 'Email atau Password Salah']);
    }
    }


    public function logout_admin()
    {
        if(Auth::guard('user')->check()){
            Auth::guard('user')->logout();
            return redirect('/panel');
        }
    }
}
