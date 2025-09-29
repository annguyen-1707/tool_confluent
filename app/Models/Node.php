<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Node extends Model
{
    protected $connection = 'mongodb';      // connection trong config/database.php
    protected $collection = 'nodes';     // tên collection

    // Các trường có thể gán hàng loạt
    protected $fillable = [
        'title',
        'project_id',
        'description',
        'created_by',
        'created_at',
        'updated_at',
        'avatar',
        'status'
    ];

    // Nếu bạn muốn dùng timestamps mặc định (created_at, updated_at)
    public $timestamps = true;

    // Ép kiểu cho đúng
    protected $casts = [
        'created_at'   => 'datetime',
        'updated_at'   => 'datetime',
    ];
}