<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $fillable = [
        'person_id',
        'email',
        'token',
        'message',
        'invited_by',
        'expires_at',
        'accepted_at'
    ];

    protected $dates = [
        'expires_at',
        'accepted_at'
    ];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function invitedBy()
    {
        return $this->belongsTo(User::class, 'invited_by');
    }
}