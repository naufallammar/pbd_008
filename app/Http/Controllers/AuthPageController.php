<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthPageController extends Controller
{
    public function showLogin()
    {
        return view('halaman.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = DB::table('user')->where('username', $request->username)->first();

        if ($user && $request->password === $user->password) {

            Auth::loginUsingId($user->iduser);

            $userDetail = DB::table('v_detail_user')
                            ->where('iduser', $user->iduser)
                            ->first();

            session(['nama_role' => $userDetail->nama_role]);
            session(['username' => $userDetail->username]);

            return redirect()->route('dashboard')->with('success', 'Selamat datang kembali!');
        }

        return back()->withErrors(['loginError' => 'Username atau password salah!'])->withInput();
    }

    public function logout()
    {
        Auth::logout();
        session()->flush();
        return redirect()->route('login');
    }
}
