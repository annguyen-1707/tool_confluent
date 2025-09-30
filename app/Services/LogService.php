<?php

namespace App\Services;

use App\Repositories\LogRepository;

class LogService
{
    protected $repo;

    public function __construct(LogRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getAll($perPage = 10, $userId = null, $projectId = null, $type = null)
    {
        return $this->repo->getAll($perPage, $userId, $projectId, $type);
    }

    public function getById($id)
    {
        return $this->repo->find($id);
    }

    public function getByUserId($userId, $perPage = 10)
    {
        return $this->repo->getByUserId($userId, $perPage);
    }

    public function getByProjectId($projectId, $perPage = 10)
    {
        return $this->repo->getByProjectId($projectId, $perPage);
    }

    public function create(array $data)
    {
        return $this->repo->create($data);
    }

    public function update($id, array $data)
    {
        $log = $this->repo->find($id);
        if (!$log) return null;
        return $this->repo->update($log, $data);
    }

    public function delete($id)
    {
        $log = $this->repo->find($id);
        if (!$log) return false;

        return $this->repo->delete($log);
    }
}
