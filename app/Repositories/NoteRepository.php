<?php

namespace App\Repositories;

use App\Models\Note;

class NoteRepository
{
    public function all()
    {
        return Note::all();
    }

    public function find($id)
    {
        return Note::find($id);
    }

    public function create(array $data)
    {
        return Note::create($data);
    }

    public function update(Note $note, array $data)
    {
        $note->update($data);
        return $note;
    }

    public function delete(Note $note)
    {
        return $note->delete();
    }
}
