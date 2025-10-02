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

    public function findByFields(array $conditions)
    {
        return $this->repo->findByFields($conditions);
    }
}