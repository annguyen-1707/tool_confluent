<?php

namespace App\Repositories;

use App\Models\Project;

class ProjectRepository
{
    public function all()
    {
        return Project::all();
    }

    public function find($id)
    {
        return Project::find($id);
    }

    public function create(array $data)
    {
        if (isset($data['members']) && is_string($data['members'])) {
            $decoded = json_decode($data['members'], true);
            $data['members'] = $decoded ?? [];
        }
        return Project::create($data);
    }


    public function update(Project $project, array $data)
    {
        $project->update($data);
        return $project;
    }

    public function delete(Project $project)
    {
        return $project->delete();
    }

    public function search(?string $keyword = null, array $columns, int $perPage)
    {
        return Project::query()
            ->where(function ($query) use ($keyword, $columns) {
                foreach ($columns as $column) {
                    $query->orWhere($column, 'LIKE', "%{$keyword}%");
                }
            })
            ->paginate($perPage);
    }
}
