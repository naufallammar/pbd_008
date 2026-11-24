<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

        $user = DB::selectOne("SELECT * FROM user WHERE username = ?", [$request->username]);

        if ($user && $request->password === $user->password) {

            Auth::loginUsingId($user->iduser);

            $userDetail = DB::selectOne("SELECT * FROM v_detail_user WHERE iduser = ?", [$user->iduser]);

            session([
                'iduser'    => $userDetail->iduser,
                'nama_role' => $userDetail->nama_role,
                'username'  => $userDetail->username,
            ]);

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
