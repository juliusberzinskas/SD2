<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    {
        // su rolėm (pivot)
        $users = User::with('roles')
            ->orderBy('id', 'asc')
            ->get();

        return view('admin.users.index', compact('users'));
    }

    public function edit(int $id)
    {
        $user = User::with('roles')->findOrFail($id);

        // kad admin galėtų pasirinkti rolę iš sąrašo
        $roles = Role::orderBy('name')->get();

        // patogiai: dabartinė rolė (pirmoji)
        $currentRole = $user->roles->pluck('id')->first();

        return view('admin.users.edit', compact('user', 'roles', 'currentRole'));
    }

    public function update(Request $request, int $id)
    {
        $user = User::with('roles')->findOrFail($id);

        $data = $request->validate([
            'name' => ['required', 'string', 'min:3'],
            'email' => ['required', 'email'],
            'role_id' => ['required', 'exists:roles,id'],
        ]);

        // atnaujinam user
        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
        ]);

        // vienas user -> viena rolė (paprasčiausia)
        $user->roles()->sync([$data['role_id']]);

        // jei admin keičia pats save — atnaujink session role/name,
        // kad navbar’e iškart pasikeistų
        $auth = session('auth_user');
        if ($auth && (int)$auth['id'] === $user->id) {
            $roleName = Role::find($data['role_id'])->name;

            session([
                'auth_user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $roleName,
                ]
            ]);
        }

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Naudotojas atnaujintas.');
    }
}