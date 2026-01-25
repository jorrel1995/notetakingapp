<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNoteRequest;
use App\Models\Note;
use App\NoteService;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class NoteController extends Controller
{
    public function index(NoteService $notesService)
    {
        Log::info('NoteController@index hit');
        $search = request('search');
        $perPage = intval(request('perPage', 10));
        $notes = $notesService->searchNotes($search, $perPage);

        return Inertia::render('Notes/Index', [
            'notes' => $notes,
            'search' => $search,
            'perPage' => $perPage,
        ]);
    }

    public function store(StoreNoteRequest $request)
    {
        $note = Note::create($request->all());

        return redirect(route('notes.index'))->with('success', 'Note created successfully');
    }

    public function show($id)
    {
        $note = Note::findOrFail($id);

        return Inertia::render('Notes/Edit', [
            'note' => $note,
        ]);
    }

    public function create()
    {
        return Inertia::render('Notes/Create');
    }

    public function update(StoreNoteRequest $request, $id)
    {
        $note = Note::findOrFail($id);
        $note->update($request->all());

        return redirect(route('notes.index'))->with('success', 'Note updated successfully');
    }

    public function destroy($id)
    {
        $note = Note::findOrFail($id);
        $note->delete();

        return redirect(route('notes.index'))->with('success', 'Note deleted successfully');
    }
}
