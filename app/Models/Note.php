<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Note extends Model
{
    protected $connection = 'mongodb';      // connection trong config/database.php
    protected $collection = 'notes';     // tên collection

  // Các trường có thể gán hàng loạt
    protected $fillable = [
        'title',
        'file_url',
        'project_id',
        'description',
        'created_by',
        'created_at',
        'updated_at'
    ];

    // Nếu bạn muốn dùng timestamps mặc định (created_at, updated_at)
    public $timestamps = true;

    // Ép kiểu cho đúng
    protected $casts = [
        'created_at'   => 'datetime',
        'updated_at'   => 'datetime',
    ];
}
