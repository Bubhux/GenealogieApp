<?php

namespace Tests\Feature;

use App\Models\Person;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class RelationshipsRealDataTest extends TestCase
{
    // Désactive le rafraîchissement de la base pour utiliser les données existantes
    protected $refreshDatabase = false;

    public function test_degree_between_84_and_1265()
    {
        DB::enableQueryLog();
        $startTime = microtime(true);

        $person84 = Person::find(84);
        $this->assertNotNull($person84, "La personne 84 n'existe pas dans la base");

        $result = $person84->getDegreeWith(1265);
        $this->assertNotFalse($result, "Aucune relation trouvée");

        $executionTime = microtime(true) - $startTime;
        $queryCount = count(DB::getQueryLog());

        dump([
            'degree' => $result['degree'],
            'path' => $result['path'],
            'time_seconds' => round($executionTime, 4),
            'queries_count' => $queryCount
        ]);

        $this->assertEquals(13, $result['degree']);
        $this->assertEquals('84->248->47->37->287->197->624->626->745->790->1257->1259->1263->1265', $result['path']);
        $this->assertLessThan(100, $queryCount, "Trop de requêtes SQL exécutées");
    }
}