<?php

namespace App\Services;

use App\Enums\Role;
use App\Enums\Status;
use App\Repositories\LogRepository;
use App\Repositories\NoteRepository;
use Illuminate\Support\Facades\Auth;

class NoteService
{
    protected $repo;
    protected $repoLog;

    public function __construct(NoteRepository $repo, LogRepository $repoLog)
    {
        $this->repo = $repo;
        $this->repoLog = $repoLog;
    }

    public function getAll()
    {
        return $this->repo->all();
    }

    public function getById($id)
    {
        return $this->repo->find($id);
    }

    public function create(array $data)
    {
        $data['created_by'] = Auth::id();
        if (Auth::user()->role === Role::Manager->value) {
            $data['status'] = Status::Public->value;
        } else {
            $data['status'] = Status::Pending->value;
        }
        $note = $this->repo->create($data);
        $this->repoLog->create([
            'title' => 'Tạo ghi chú thành công',
            'project_id' => $note->project_id,
            'type' => 'Note',
            'action' => 'Create',
            'old_value' => null,
            'new_value' => $data,
            'created_by' => Auth::id(),
            'target_id' => $note->id,
        ]);
        return $note;
    }

    public function update($id, array $data)
    {
        $oldNote = $this->repo->find($id);
        if (!$oldNote) return null;
        $newNote =  $this->repo->update($oldNote, $data);
        $this->repoLog->create([
            'title' => 'Cập nhật ghi chú thành công',
            'project_id' => $newNote->project_id,
            'type' => 'Note',
            'action' => 'Update',
            'old_value' => $oldNote,
            'new_value' => $newNote,
            'created_by' => Auth::id(),
            'target_id' => $newNote->id,
        ]);
        return $newNote;
    }

    public function delete($id)
    {
        $note = $this->repo->find($id);
        if (!$note) return false;

        return $this->repo->delete($note);
    }
}
