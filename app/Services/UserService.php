<?php

namespace App\Services;

use App\Enums\Status;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;

class UserService
{
    protected $repo;

    public function __construct(UserRepository $repo)
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
        $data['password'] = Hash::make($data['password']);
        $data['status'] = Status::Public->value;
        return $this->repo->create($data);
    }

    public function update($id, array $data)
    {
        $user = $this->repo->find($id);
        if (!$user) return null;

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return $this->repo->update($user, $data);
    }

    public function delete($id)
    {
        $user = $this->repo->find($id);
        if (!$user) return false;

        return $this->repo->delete($user);
    }

    public function search(?string $keyword, int $perPage)
    {
        return $this->repo->search($keyword, ['name', 'username'], $perPage);
    }

   
}
