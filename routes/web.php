<?php

use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\NotesController;
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

    Route::get('/notes/{id}', [NotesController::class, 'view'])
        ->name('notes.view');

    Route::get('/new', function() {
        return view('tinymce');
    });

    Route::get('/search', [NotesController::class, 'search'])->name('notes.search');

    Route::get("/files/{id}", [FileUploadController::class, 'view'])->name('files.view');
    Route::get("/files/{id}/download", [FileUploadController::class, 'download'])->name('files.download');
    Route::delete("/files/{id}/delete", [FileUploadController::class, 'delete'])->name('files.delete');
    Route::get('/files/{id}/link', [FileUploadController::class, 'link'])->name('files.link');
    Route::post('/upload', [FileUploadController::class, 'upload'])->name('files.upload');
    Route::get('/files', [FileUploadController::class, 'index'])->name('files');

});
