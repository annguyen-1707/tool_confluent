<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Project extends Model
{
    protected $connection = 'mongodb';      // connection trong config/database.php
    protected $collection = 'projects';     // tên collection

    // Các trường có thể gán hàng loạt
    protected $fillable = [
        'title',
        'start_date',
        'end_date',
        'members',
        'description',
        'status',
        'created_by',
        'created_at',
        'updated_at',
        'disable'
    ];

    // Nếu bạn muốn dùng timestamps mặc định (created_at, updated_at)
    public $timestamps = true;

    // Ép kiểu cho đúng
    protected $casts = [
        'start_date'   => 'datetime',
        'end_date'     => 'datetime',
        'members'      => 'array',
        'created_at'   => 'datetime',
        'updated_at'   => 'datetime',
    ];
}