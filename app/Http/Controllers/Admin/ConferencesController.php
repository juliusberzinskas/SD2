<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ConferenceRequest;
use App\Models\Conference;

class ConferencesController extends Controller
{
    public function index()
    {
        $conferences = Conference::orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->get();

        return view('admin.conferences.index', compact('conferences'));
    }

    public function show(int $id)
    {
        $conference = Conference::findOrFail($id);

        return view('admin.conferences.show', compact('conference'));
    }

    public function create()
    {
        $conference = new Conference();

        return view('admin.conferences.create', compact('conference'));
    }

    public function store(ConferenceRequest $request)
    {
        Conference::create($request->validated());

        return redirect()
            ->route('admin.conferences.index')
            ->with('success', 'Konferencija sukurta.');
    }

    public function edit(int $id)
    {
        $conference = Conference::findOrFail($id);

        return view('admin.conferences.edit', compact('conference'));
    }

    public function update(ConferenceRequest $request, int $id)
    {
        $conference = Conference::findOrFail($id);
        $conference->update($request->validated());

        return redirect()
            ->route('admin.conferences.index')
            ->with('success', 'Konferencija atnaujinta.');
    }

    public function destroy(int $id)
    {
        $conference = Conference::findOrFail($id);

        // jei praėjusi - neleidžiam trinti
        $isPast = now()->greaterThan(
            \Carbon\Carbon::parse($conference->date . ' ' . $conference->time)
        );

        if ($isPast) {
            return redirect()
                ->route('admin.conferences.index')
                ->with('error', __('app.conference.cannot_delete_past'));
        }

        $conference->delete();

        return redirect()
            ->route('admin.conferences.index')
            ->with('success', 'Konferencija ištrinta.');
    }
}
