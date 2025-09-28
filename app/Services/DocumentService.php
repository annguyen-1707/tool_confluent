<?php

namespace App\Services;

use App\Repositories\DocumentRepository;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class DocumentService
{
    protected $documentRepository;

    public function __construct(DocumentRepository $documentRepository)
    {
        $this->documentRepository = $documentRepository;
    }

    public function getAllDocuments()
    {
        return $this->documentRepository->getAll();
    }

    public function getDocumentById(string $id)
    {
        $document = $this->documentRepository->getById($id);
        if (!$document) {
            throw new InvalidArgumentException('Document not found');
        }
        return $document;
    }

    public function createDocument(array $data)
    {
        $validator = Validator::make($data, [
            'title' => 'required|string|max:255',
            'file_url' => 'required|url',
            'project_id' => 'required|string',
            'created_by' => 'required|string',
            'allowed_users' => 'sometimes|array',
            'members' => 'sometimes|array',
            'description' => 'sometimes|string',
            'status' => 'sometimes|string|in:draft,published,archived'
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        // Set default values
        $data['allowed_users'] = $data['allowed_users'] ?? [];
        $data['members'] = $data['members'] ?? [];
        $data['status'] = $data['status'] ?? 'draft';

        return $this->documentRepository->create($data);
    }

    public function updateDocument(string $id, array $data)
    {
        $validator = Validator::make($data, [
            'title' => 'sometimes|string|max:255',
            'file_url' => 'sometimes|url',
            'allowed_users' => 'sometimes|array',
            'members' => 'sometimes|array',
            'description' => 'sometimes|string',
            'status' => 'sometimes|string|in:draft,published,archived'
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        $document = $this->documentRepository->update($id, $data);
        if (!$document) {
            throw new InvalidArgumentException('Document not found');
        }

        return $document;
    }

    public function deleteDocument(string $id)
    {
        $result = $this->documentRepository->delete($id);
        if (!$result) {
            throw new InvalidArgumentException('Document not found');
        }
        return $result;
    }

    public function getDocumentsByProject(string $projectId)
    {
        return $this->documentRepository->getByProjectId($projectId);
    }

    public function getDocumentsByUser(string $userId)
    {
        return $this->documentRepository->getByUserId($userId);
    }
}