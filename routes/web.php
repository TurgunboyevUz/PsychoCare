<?php

use App\Http\Controllers\MoodController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/mood/{hash}', [MoodController::class, 'mood'])->name('mood.index');
Route::get('/export/mood-list/{hash}', [MoodController::class, 'exportMoodListPDF']);
Route::get('/export/full-report/{hash}', [MoodController::class, 'exportFullReportPDF']);
