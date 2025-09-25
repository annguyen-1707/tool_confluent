<?php

namespace App\Services;

use App\Repositories\LogRepository;
use App\Repositories\ProjectRepository;
use App\Repositories\UserRepository;
use Error;

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
        $project =  $this->repo->create($data);
        // Ghi log
        $this->repoLog->create([
            'title'       => 'Tạo dự án mới',
            'project_id'  => $project->_id,
            'type'        => 'project',
            'action'      => 'create',
            'old_value'   => null,
            'new_value'   => json_encode($data),
            'created_by'  => $data['created_by'] ?? null,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);
    }

    public function addMembersInProject(array $userIds, $projectId)
    {
        $project = $this->repo->find($projectId);
        if (!$project) {
            throw new Error("Không tìm thấy dự án");
        }
        $members = $project->members ?? [];
        foreach ($userIds as $userId) {
            $user = $this->repoUser->find($userId);
            if (!$user) {
                $exists = collect($members)->firstWhere('user_id', $userId);
                if (!$exists) {
                    $members[] = [
                        'user_id' => $userId,
                        'name' => $user->name,
                        'username' => $user->username
                    ];
                }
            }
        }
        $project->members = $members;
        $project->save();

        return $members;
    }

    public function removeMemberInProject($userId, $projectId)
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
        $project = $this->repo->find($id);
        if (!$project) return null;

        return $this->repo->update($project, $data);
    }

    public function delete($id)
    {
        $project = $this->repo->find($id);
        if (!$project) return false;

        return $this->repo->delete($project);
    }
}
