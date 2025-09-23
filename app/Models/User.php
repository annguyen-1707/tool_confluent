<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class User extends Model
{
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
}
