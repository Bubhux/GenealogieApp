<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('modification_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->boolean('vote'); // true pour approver, false pour rejeter
            $table->text('comment')->nullable();
            $table->timestamps();
            
            // Empêche un utilisateur de voter plusieurs fois pour la même modification
            $table->unique(['modification_id', 'user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('votes');
    }
};