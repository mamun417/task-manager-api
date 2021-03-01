<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static latest()
 * @method static create(array $requested_data)
 */
class Task extends Model
{
    protected $fillable = [
        'user_id', 'status', 'title', 'description', 'due_date'
    ];

    protected $casts = [
        'due_date' => 'datetime',
    ];
}
