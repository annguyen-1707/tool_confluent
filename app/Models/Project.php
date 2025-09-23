<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Project extends Model
{
    protected $connection = 'mongodb';      // connection trong config/database.php
    protected $collection = 'projects';     // tên collection

    // Các trường có thể gán hàng loạt
    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'members',
        'attachments',
    ];

    // Nếu bạn muốn dùng timestamps mặc định (created_at, updated_at)
    public $timestamps = true;

    // Ép kiểu cho đúng
    protected $casts = [
        'start_date'   => 'datetime',
        'end_date'     => 'datetime',
        'members'      => 'array',
        'attachments'  => 'array',
        'created_at'   => 'datetime',
        'updated_at'   => 'datetime',
    ];
}
