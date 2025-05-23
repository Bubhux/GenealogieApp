<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $fillable = ['modification_id', 'user_id', 'vote', 'comment'];

    public function modification()
    {
        return $this->belongsTo(Modification::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}