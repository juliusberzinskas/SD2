<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use App\Models\User;

class ClientController extends Controller
{
    public function index()
    {
        $conferences = Conference::orderBy('date', 'asc')
            ->orderBy('time', 'asc')
            ->get();

        return view('client.conferences.index', compact('conferences'));
    }

    public function show(int $id)
    {
        $conference = Conference::findOrFail($id);

        // pasiimam prisijungusį user iš session (kol dar nenaudojam Laravel Auth)
        $auth = session('auth_user');

        // ar šitas user jau užsiregistravęs į šią konferenciją
        $alreadyRegistered = false;

        if ($auth) {
            $alreadyRegistered = $conference->users()
                ->where('users.id', $auth['id'])
                ->exists();
        }

        return view('client.conferences.show', compact('conference', 'alreadyRegistered'));
    }

    public function register(int $id)
{
    $conference = Conference::findOrFail($id);

    $auth = session('auth_user');
    if (!$auth) {
        return redirect()->route('login')->with('error', 'Prašome prisijungti.');
    }

    $user = User::findOrFail($auth['id']);

    // jei jau yra — pranešam ir nieko nedarom
    $alreadyRegistered = $conference->users()
        ->where('users.id', $user->id)
        ->exists();

    if ($alreadyRegistered) {
        return redirect()
            ->route('client.conferences.show', $conference->id)
            ->with('success', 'Jūs jau esate užsiregistravęs į šią konferenciją.');
    }

    $user->conferences()->attach($conference->id);

    return redirect()
        ->route('client.conferences.show', $conference->id)
        ->with('success', 'Sėkmingai užsiregistravote į konferenciją!');
}
}