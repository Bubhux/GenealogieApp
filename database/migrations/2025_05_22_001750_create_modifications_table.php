<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
 * Run the migrations.
 */
public function up(): void
{
    Schema::create('modifications', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('person_id')->nullable()->constrained('people')->onDelete('cascade');
        $table->foreignId('relationship_id')->nullable()->constrained('relationships')->onDelete('cascade');
        $table->string('field')->nullable(); // Pour les modifications de personne
        $table->text('old_value')->nullable();
        $table->text('new_value');
        $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
        $table->text('reason')->nullable(); // Raison de la modification
        $table->timestamps();
    });
}

/**
 * Reverse the migrations.
 */
public function down(): void
{
    Schema::dropIfExists('modifications');
    }
};
