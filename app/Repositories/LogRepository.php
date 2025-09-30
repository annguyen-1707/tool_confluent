<?php

namespace App\Repositories;

use App\Models\Log;

class LogRepository
{
    public function all()
    {
        return Log::all();
    }

    public function getAll($perPage = 10, $userId = null, $projectId = null, $type = null)
    {
        $query = Log::query();

        if ($userId) {
            $query->where('created_by', $userId);
        }

        if ($projectId) {
            $query->where('project_id', $projectId);
        }

        if ($type) {
            $query->where('type', $type);
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function getByUserId($userId, $perPage = 10)
    {
        return Log::where('created_by', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    public function getByProjectId($projectId, $perPage = 10)
    {
        return Log::where('project_id', $projectId)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    public function find($id)
    {
        return Log::find($id);
    }

    public function create(array $data)
    {
        return Log::create($data);
    }

    public function update(Log $log, array $data)
    {
        $log->update($data);
        return $log;
    }

    public function delete(Log $log)
    {
        return $log->delete();
    }
}
