<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\RelationshipController;
use App\Http\Controllers\ModificationController;
use App\Http\Controllers\VoteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // People routes
    Route::resource('people', PersonController::class)->only([
        'index', 'show', 'create', 'store'
    ]);

    // Relationships routes
    Route::get('/relationships/create', [RelationshipController::class, 'create'])
        ->name('relationships.create');
    Route::post('/relationships', [RelationshipController::class, 'store'])
        ->name('relationships.store');

    // Modifications routes
    Route::get('/modifications', [ModificationController::class, 'index'])->name('modifications.index');
    Route::get('/people/{person}/modifications/create-person', [ModificationController::class, 'createForPerson'])
        ->name('modifications.create.person');
    Route::post('/people/{person}/modifications', [ModificationController::class, 'storeForPerson'])
        ->name('modifications.store.person');
    Route::get('/modifications/create-relationship', [ModificationController::class, 'createForRelationship'])
        ->name('modifications.create.relationship');
    Route::post('/relationships/modifications', [ModificationController::class, 'storeForRelationship'])
        ->name('modifications.store.relationship');
    Route::get('/modifications/{modification}', [ModificationController::class, 'show'])
        ->name('modifications.show');

    // Propositions
    Route::post('/people/{person}/propose-modification', [PersonController::class, 'proposeModification'])
        ->name('people.propose-modification')
        ->can('proposeModification', 'person');

    // Votes
    Route::post('/modifications/{modification}/vote', [ModificationController::class, 'storeVote'])
        ->name('modifications.vote')
        ->can('voteOnModification', App\Models\Modification::class);
});

require __DIR__.'/auth.php';
