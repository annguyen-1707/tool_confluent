<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Log extends Model
{
    protected $connection = 'mongodb';      // connection trong config/database.php
    protected $collection = 'logs';     // tên collection

    // Các trường có thể gán hàng loạt
    protected $fillable = [
        'project_id',
        'node_id',
        'type',
        'action',
        'old_value',
        'new_value',
        'created_by',

    ];

    // Nếu bạn muốn dùng timestamps mặc định (created_at, updated_at)
    public $timestamps = true;

    // Ép kiểu cho đúng
    protected $casts = [
        'created_at'   => 'datetime',
        'updated_at'   => 'datetime',
    ];
}