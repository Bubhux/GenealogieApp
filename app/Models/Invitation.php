<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $fillable = ['inviter_id', 'person_id', 'email', 'token', 'status'];

    public function inviter()
    {
        return $this->belongsTo(User::class, 'inviter_id');
    }

    public function person()
    {
        return $this->belongsTo(Person::class);
    }
}