<?php

namespace App\Services;

use App\Enums\Status;
use App\Repositories\LogRepository;
use App\Repositories\ProjectRepository;
use App\Repositories\UserRepository;
use Error;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProjectService
{
    protected $repo;
    protected $repoUser;
    protected $repoLog;

    public function __construct(ProjectRepository $repo, UserRepository $repoUser, LogRepository $repoLog)
    {
        $this->repo = $repo;
        $this->repoUser = $repoUser;
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
        $data['status'] = Status::Public->value;
        $data['members'] = [];
        $project =  $this->repo->create($data);
        // Ghi log
        $this->repoLog->create([
            'title'       => 'Tạo dự án mới',
            'project_id'  => $project->id,
            'type'        => 'project',
            'action'      => 'create',
            'old_value'   => null,
            'new_value'   => $data,
            'created_by'  => $data['created_by'] ?? null,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);
        return $project;
    }

    public function addMembersInProject(array $userIds, $projectId)
    {
        $project = $this->repo->find($projectId);
        if (!$project) {
            throw new \Exception("Không tìm thấy dự án");
        }

        $currentMembers = $project->members ?? [];

        foreach ($userIds as $userId) {
            $user = $this->repoUser->find($userId);
            Log::alert("UserIds", $userIds);
            if ($user instanceof \Illuminate\Support\Collection) {
                $user = $user->first();
            }

            if ($user) {
                $exists = collect($currentMembers)->firstWhere('user_id', $userId);
                if (!$exists) {
                    $currentMembers[] = [
                        'user_id'  => $userId,
                        'name'     => $user->name,
                        'username' => $user->username,
                    ];
                }
            } else {
                Log::warning("User not found when adding to project", [
                    'userId' => $userId,
                    'projectId' => $projectId
                ]);
            }
        }

        $project->members = $currentMembers;
        $project->save();

        return $currentMembers;
    }

    public function removeMemberInProject($projectId, $userId)
    {
        $project = $this->repo->find($projectId);
        if (!$project) {
            return null;
        }
        $members = $project->members ?? [];
        $members = collect(($members))
            ->reject(fn($member) => $member['user_id'] === $userId)
            ->values()
            ->toArray();
        $project->members = $members;
        $project->save();
        return $userId;
    }

    public function update($id, array $data)
    {
        $oldProject = $this->repo->find($id);
        if (!$oldProject) return null;
        $newProject =  $this->repo->update($oldProject, $data);
        $this->repoLog->create([
            'title'       => 'Cập nhật thông tin dự án',
            'project_id'  => $newProject->id,
            'type'        => 'project',
            'action'      => 'update',
            'old_value'   => $oldProject,
            'new_value'   => $newProject,
            'created_by'  => $data['created_by'] ?? null,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);
        return $newProject;
    }

    public function delete($id)
    {
        $project = $this->repo->find($id);
        if (!$project) return false;

        return $this->repo->delete($project);
    }

    public function deleteSoft($id)
    {
        $project = $this->repo->find($id);
    }
}
