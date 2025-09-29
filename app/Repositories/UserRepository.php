<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function all()
    {
        return User::all();
    }

    public function find($id)
    {
        return User::find($id);
    }

    public function create(array $data)
    {
        return User::create($data);
    }

    public function update(User $user, array $data)
    {
        $user->update($data);
        return $user;
    }

    public function delete(User $user)
    {
        return $user->delete();
    }

    public function search(?string $keyword = null, array $columns, int $perPage)
    {
        return User::query()
            ->where('status', 'public')
            ->where(function ($query) use ($keyword, $columns) {
                foreach ($columns as $column) {
                    $query->orWhere($column, 'LIKE', "%{$keyword}%");
                }
            })
            ->paginate($perPage);
    }
   
}
