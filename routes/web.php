<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectIdeaController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/project-idea', [ProjectIdeaController::class, 'index'])->name('project-idea.index');
Route::post('/project-idea/generate', [ProjectIdeaController::class, 'generate'])->name('project-idea.generate');