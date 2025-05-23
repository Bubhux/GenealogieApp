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

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

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

    public function getDegreeWith($target_person_id)
    {
        if ($this->id == $target_person_id) {
            return 0;
        }

        $visited = [$this->id => 0];
        $queue = new \SplQueue();
        $queue->enqueue($this->id);

        while (!$queue->isEmpty()) {
            $current = $queue->dequeue();
            $currentDegree = $visited[$current];

            if ($currentDegree >= 25) {
                return false;
            }

            // Get all relationships for current person
            $relationships = DB::select("
                SELECT parent_id, child_id 
                FROM relationships 
                WHERE parent_id = ? OR child_id = ?
            ", [$current, $current]);

            foreach ($relationships as $rel) {
                $relatedId = $rel->parent_id == $current ? $rel->child_id : $rel->parent_id;

                if ($relatedId == $target_person_id) {
                    return $currentDegree + 1;
                }

                if (!isset($visited[$relatedId])) {
                    $visited[$relatedId] = $currentDegree + 1;
                    $queue->enqueue($relatedId);
                }
            }
        }

        return false; // No relationship found
    }
}