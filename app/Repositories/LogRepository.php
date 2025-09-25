<?php

namespace App\Repositories;

use App\Models\Log;

class LogRepository
{
    public function all()
    {
        return Log::all();
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
