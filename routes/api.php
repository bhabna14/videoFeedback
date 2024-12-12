<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\FeedbackVideoController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(PoojaDetailsController::class)->group(function() {
    Route::post('/save-pooja-details',  'savePoojadetails');
});

Route::post('/save-feedback-video', [FeedbackVideoController::class, 'saveFeedbackVideo']);

