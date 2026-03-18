<?php

use App\Http\Controllers\ActionController;
use Illuminate\Support\Facades\Route;

//Route::any('/bot', function (Nutgram $bot) {$bot->run();});

Route::post('/hashtag/answer', [ActionController::class, 'sendAnswer']);
Route::post('/hashtag/edit', [ActionController::class, 'editAnswer']);

Route::post('/clarification/answer', [ActionController::class, 'sendClarification']);
Route::post('/clarification/edit', [ActionController::class, 'editClarification']);

Route::post('/file/url', [ActionController::class, 'getFileUrl']);
