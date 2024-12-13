<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\FeedbackVideoController;
use App\Http\Controllers\Api\BusinessUnitLoginController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(BusinessUnitLoginController::class)->group(function() {
    Route::post('/check-unit-login',  'loginBusinessUnit');
});

Route::post('/save-feedback-video', [FeedbackVideoController::class, 'saveFeedbackVideo']);

