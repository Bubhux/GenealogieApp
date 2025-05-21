<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    // Ajoutez ces 3 sections :
    protected $fillable = [
        'created_by',
        'first_name', 
        'last_name',
        'birth_name',
        'middle_names',
        'date_of_birth'
    ];

    public function children()
    {
        return $this->hasManyThrough(
            Person::class,
            Relationship::class,
            'parent_id',
            'id',
            'id',
            'child_id'
        );
    }

    public function parents()
    {
        return $this->hasManyThrough(
            Person::class,
            Relationship::class,
            'child_id',
            'id',
            'id',
            'parent_id'
        );
    }
}