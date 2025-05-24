<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Person extends Model
{
    use HasFactory;

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

    public function user()
    {
        return $this->belongsTo(User::class);
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

        // Charge toutes les relations en une seule requête
        $allRelationships = DB::table('relationships')
            ->select('parent_id', 'child_id')
            ->get()
            ->groupBy('parent_id')
            ->toArray();

        $visited = [$this->id => ['degree' => 0, 'path' => (string)$this->id]];
        $queue = new \SplQueue();
        $queue->enqueue($this->id);

        while (!$queue->isEmpty()) {
            $current = $queue->dequeue();
            $currentDegree = $visited[$current]['degree'];

            if ($currentDegree >= 25) {
                return false;
            }

            // Récupére les relations depuis le cache
            $relationships = $allRelationships[$current] ?? [];

            foreach ($relationships as $rel) {
                $relatedId = $rel->child_id;

                if (!isset($visited[$relatedId])) {
                    $visited[$relatedId] = [
                        'degree' => $currentDegree + 1,
                        'path' => $visited[$current]['path'] . '->' . $relatedId
                    ];

                    if ($relatedId == $target_person_id) {
                        return [
                            'degree' => $currentDegree + 1,
                            'path' => $visited[$relatedId]['path']
                        ];
                    }

                    $queue->enqueue($relatedId);
                }
            }

            // Vérifie aussi les relations inverses (parents)
            $parentRelationships = array_filter($allRelationships, function($rels) use ($current) {
                return in_array($current, array_column($rels, 'child_id'));
            });

            foreach ($parentRelationships as $parentId => $rels) {
                if (!isset($visited[$parentId])) {
                    $visited[$parentId] = [
                        'degree' => $currentDegree + 1,
                        'path' => $visited[$current]['path'] . '->' . $parentId
                    ];

                    if ($parentId == $target_person_id) {
                        return [
                            'degree' => $currentDegree + 1,
                            'path' => $visited[$parentId]['path']
                        ];
                    }

                    $queue->enqueue($parentId);
                }
            }
        }

        return false;
    }

    public static function createsCycle($parentId, $childId)
    {
        if ($parentId == $childId) return true;

        $visited = [$childId];
        $queue = new \SplQueue();
        $queue->enqueue($childId);

        while (!$queue->isEmpty()) {
            $current = $queue->dequeue();

            $parents = DB::table('relationships')
                ->where('child_id', $current)
                ->pluck('parent_id');

            foreach ($parents as $parent) {
                if ($parent == $parentId) return true;
                if (!in_array($parent, $visited)) {
                    $visited[] = $parent;
                    $queue->enqueue($parent);
                }
            }
        }

        return false;
    }
}