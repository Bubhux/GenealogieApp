<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modification extends Model
{
    protected $fillable = [
        'user_id', 'person_id', 'relationship_id', 
        'field', 'old_value', 'new_value', 'status', 'reason'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function relationship()
    {
        return $this->belongsTo(Relationship::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function approveVotesCount()
    {
        return $this->votes()->where('vote', true)->count();
    }

    public function rejectVotesCount()
    {
        return $this->votes()->where('vote', false)->count();
    }
}