<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return back()
                ->withErrors(['email' => 'Neteisingi prisijungimo duomenys.'])
                ->withInput();
        }

        // nusistatome rolę (pirma role)
        $role = $user->roles()->pluck('name')->first() ?? 'client';

        session([
            'auth_user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $role,
            ]
        ]);

        return $this->redirectByRole($role);
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'first_name' => ['required', 'string', 'min:2'],
            'last_name' => ['required', 'string', 'min:2'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:4'],
        ]);

        // email unique (DB)
        $exists = User::where('email', $data['email'])->exists();
        if ($exists) {
            return back()->withErrors(['email' => 'Toks el. paštas jau egzistuoja.'])->withInput();
        }

        $fullName = trim($data['first_name'] . ' ' . $data['last_name']);

        $user = User::create([
            'name' => $fullName,
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // priskiriam client rolę
        $clientRole = Role::firstOrCreate(['name' => 'client']);
        $user->roles()->syncWithoutDetaching([$clientRole->id]);

        session([
            'auth_user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => 'client',
            ]
        ]);

        return redirect()->route('client.conferences.index')
            ->with('success', 'Paskyra sukurta ir prisijungta.');
    }

    public function logout(Request $request)
    {
        session()->forget('auth_user');
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function loginAsAdmin()
    {
        $user = User::whereHas('roles', fn ($q) => $q->where('name', 'admin'))->first();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Admin vartotojas nerastas DB. Paleisk seeder.');
        }

        session([
            'auth_user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => 'admin',
            ]
        ]);

        return redirect()->route('admin.index');
    }

    public function loginAsEmployee()
    {
        $user = User::whereHas('roles', fn ($q) => $q->where('name', 'employee'))->first();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Employee vartotojas nerastas DB. Paleisk seeder.');
        }

        session([
            'auth_user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => 'employee',
            ]
        ]);

        return redirect()->route('employee.conferences.index');
    }

    private function redirectByRole(string $role)
    {
        return match ($role) {
            'admin' => redirect()->route('admin.index'),
            'employee' => redirect()->route('employee.conferences.index'),
            default => redirect()->route('client.conferences.index'),
        };
    }
}