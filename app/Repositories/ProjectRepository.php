<?php

namespace App\Repositories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class ProjectRepository
{
    public function all()
    {
        return Project::where('disable', false)->get();
    }

    public function find($id)
    {
        return Project::where('id', $id)
            ->where('disable', false)
            ->first();
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
            ->where('disable', 'false')
            ->where(function ($query) use ($keyword, $columns) {
                foreach ($columns as $column) {
                    $query->orWhere($column, 'LIKE', "%{$keyword}%");
                }
            })
            ->paginate($perPage);
    }
    public function findByFields(array $conditions)
    {
        $query = Project::query();

        foreach ($conditions as $field => $value) {
            $query->where($field, $value);
        }
        $query->where('disable', 'false');

        return $query->first();
    }
    public function searchPeopleNotInProject(?string $keyword, array $columns, int $perPage, string $projectId)
    {
        // Lấy project
        $project = Project::find($projectId);

        if (!$project) {
            Log::warning("Project not found", ['projectId' => $projectId]);

            // Trả về empty paginator để tránh lỗi null
            return User::query()->whereRaw('1=0')->paginate($perPage);
        }

        // Lấy danh sách user_id trong members (nếu null thì thay bằng mảng rỗng)
        $memberIds = collect($project->members ?? [])->pluck('user_id')->toArray();

        return User::query()
            ->where('disable', 'false')
            ->when(!empty($memberIds), function ($query) use ($memberIds) {
                $query->whereNotIn('id', $memberIds); // loại bỏ user đã có trong project
            })
            ->when($keyword, function ($query, $keyword) use ($columns) {
                $query->where(function ($q) use ($columns, $keyword) {
                    foreach ($columns as $column) {
                        $q->orWhere($column, 'LIKE', "%{$keyword}%");
                    }
                });
            })
            ->paginate($perPage);
    }
}
