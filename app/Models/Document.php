<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Document extends Model
{
    protected $connection = 'mongodb';      // connection trong config/database.php
    protected $collection = 'documents';     // tên collection

    // Các trường có thể gán hàng loạt
    protected $fillable = [
        'title',
        'file_url',
        'allowed_users',
        'members',
        'project_id',
        'description',
        'status',
        'created_by',
        'created_at',
        'updated_at'
    ];

    // Nếu bạn muốn dùng timestamps mặc định (created_at, updated_at)
    public $timestamps = true;

    // Ép kiểu cho đúng
    protected $casts = [
        'allowed_users' => 'array',
        'members'      => 'array',
        'created_at'   => 'datetime',
        'updated_at'   => 'datetime',
    ];
}