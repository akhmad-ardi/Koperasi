<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function HalamanLogin() {
        return view('vendor.adminlte.auth.login');
    }

    public function login(Request $request) {
        $request->validate([
            'username' => ['required'],
            'password' => ['required']
        ]);

        $data = [
            'username' => $request->input('username'),
            'password' => $request->input('password')
        ];

        // if (Auth::attempt()) {}
    }
}
