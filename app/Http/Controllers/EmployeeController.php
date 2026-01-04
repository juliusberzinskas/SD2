<?php

namespace App\Http\Controllers;

use App\Models\Conference;

class EmployeeController extends Controller
{
    public function index()
    {
        $conferences = Conference::orderBy('date', 'asc')
            ->orderBy('time', 'asc')
            ->get();

        return view('employee.conferences.index', compact('conferences'));
    }

    public function show(int $id)
    {
        $conference = Conference::with(['users'])->findOrFail($id);
        $clients = $conference->users;

        return view('employee.conferences.show', compact('conference', 'clients'));
    }
}