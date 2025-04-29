<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id', 'status', 'input', 'result'];
    protected $casts = [
        'input' => 'array',
    ];
}

