<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $auth = session('auth_user');

        // jei neprisijungęs -> į login
        if (!$auth) {
            return redirect()->route('login');
        }

        $role = $auth['role'] ?? 'client';

        return view('home', compact('auth', 'role'));
    }
}