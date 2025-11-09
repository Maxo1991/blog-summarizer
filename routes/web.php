<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SummarizerController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/api/summarize', [SummarizerController::class, 'summarize']);
Route::get('/api/summaries', [SummarizerController::class, 'getAll']); 
Route::get('/summaries', function () {
    return view('summaries');
});
