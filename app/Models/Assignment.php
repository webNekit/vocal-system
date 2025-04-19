<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $table = 'assignments';

    protected $guarded = [];

    protected $casts = [
      'user_id' => 'integer',
      'mentor_id' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function mentor()
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }
}
