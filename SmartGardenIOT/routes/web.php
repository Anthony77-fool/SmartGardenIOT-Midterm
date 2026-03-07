<?php

use App\Http\Controllers\PlantController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

// This is for your main dashboard
Route::get('/', [PlantController::class, 'index']); 

// This is the GET route for your history page
Route::get('/history', [PlantController::class, 'history']);

// This is the POST route for your API endpoint that the ESP8266 will send data to
//for webhooks
Route::get('/api/vitals', function() {
    $latest = \App\Models\PlantReading::latest()->first();
    $history = \App\Models\PlantReading::latest()->take(10)->get()->reverse();
    
    return response()->json([
        'latest' => $latest,
        'history' => $history
    ]);
});