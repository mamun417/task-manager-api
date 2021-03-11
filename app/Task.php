<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Task
 * @mixin Eloquent
 */
class Task extends Model
{
    protected $fillable = [
        'user_id', 'status', 'title', 'description', 'due_date'
    ];

    protected $casts = [
        'due_date' => 'datetime',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
