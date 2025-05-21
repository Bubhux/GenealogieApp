<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Relationship extends Model
{
    protected $fillable = ['created_by', 'parent_id', 'child_id'];

    public function parent()
    {
        return $this->belongsTo(Person::class, 'parent_id');
    }

    public function child()
    {
        return $this->belongsTo(Person::class, 'child_id');
    }
}