<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Talk extends Model
{
    protected $table = 'talks';

    protected $guarded = [];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function assignment()
    {
        return $this->belongsTo(Assignment::class, 'assignment_id');
    }
}
