<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/notes/{id}', [\App\Http\Controllers\NotesController::class, 'view'])
        ->name('notes.view');

    Route::get('/new', function() {
        return view('tinymce');
    });
});
