<?php

namespace App;

use App\Models\Note;

class NoteService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function searchNotes($search, $perPage = 10)
    {
        return Note::query()
            ->when($search, function ($query, $search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            })
            ->paginate($perPage);
    }
}
