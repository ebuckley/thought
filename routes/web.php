<?php

use App\Http\Controllers\AssetController;
use App\Http\Controllers\AssetTypeController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\NotesController;
use App\Http\Controllers\PreSignupEmailController;
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

    Route::get('/assettype/{id}', [AssetTypeController::class, 'view'])->name('assettype.view');

    Route::get('/expirations', [AssetController::class, 'listExpirations'])->name('expirations');

    Route::resource('structure', AssetTypeController::class);

//    Route::resource('structure.asset', AssetController::class);
    Route::get('/structure/{asset_type}/asset', [AssetController::class, 'index'])
        ->name('structure.asset');
    Route::get('/structure/{asset_type}/asset/create', [AssetController::class, 'create'])
        ->name('structure.asset.create');
    Route::get('/structure/{asset_type}/asset/{asset}', [AssetController::class, 'show'])
        ->name('structure.asset.show');
    Route::get('/structure/{asset_type}/asset/{asset}/edit', [AssetController::class, 'edit'])
        ->name('structure.asset.edit');
    Route::delete('/structure/{asset_type}/asset/{asset}', [AssetController::class, 'destroy'])
        ->name('structure.asset.destroy');


    Route::middleware([
        \App\Http\Middleware\CheckUserEmail::class
    ])->group(function () {
        Route::resource('/admin/pre-signup-emails', PreSignupEmailController::class);
    });

});

