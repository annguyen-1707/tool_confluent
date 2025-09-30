<?php

namespace App\Repositories;

use App\Models\Document;

class DocumentRepository
{
    protected $model;

    public function __construct(Document $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function getById(string $id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(string $id, array $data)
    {
        $document = $this->getById($id);
        if ($document) {
            $document->update($data);
            return $document->fresh();
        }
        return null;
    }

    public function delete(string $id)
    {
        $document = $this->getById($id);
        if ($document) {
            return $document->delete();
        }
        return false;
    }

    public function getByProjectId(string $projectId)
    {
        return $this->model->where('project_id', $projectId)->get();
    }

    public function getByUserId(string $userId)
    {
        return $this->model->where('allowed_users', $userId)
            ->orWhere('created_by', $userId)
            ->get();
    }
}