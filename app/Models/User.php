<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Model implements Authenticatable, JWTSubject
{
    use AuthenticatableTrait;

    protected $connection = 'mongodb';      // connection trong config/database.php
    protected $collection = 'users';        // collection trong MongoDB

    protected $fillable = [
        'name',
        'username',
        'password',
        'role'
    ];

    // Ẩn password khi return JSON
    protected $hidden = ['password'];

    // 🔹 Bắt buộc khi implement JWTSubject
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
