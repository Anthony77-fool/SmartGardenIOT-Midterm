<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlantReading; // You'll create this model next

class PlantController extends Controller
{
    // For the main Dashboard
    public function index()
		{
			// 1. Get the last 10 readings for the charts (Oldest to Newest)
			$history = PlantReading::latest()->take(10)->get()->reverse();

			// 2. Get the single latest reading for the big display numbers
			// We take it from the history collection so we don't have to query the DB again
			$latestReading = $history->last();

			// 3. Finds the last time the soil was below 35% (Watering Event)
    	$lastWatering = PlantReading::where('soil_percent', '<', 35)
                                ->latest()
                                ->first();

			// Pass both to the view
			return view('home', compact('latestReading', 'history', 'lastWatering'));
		}

    // For the History Page
    public function history() {
			// Get last 50 readings for the table
			$history = \App\Models\PlantReading::latest()->paginate(50);
			
			// Get last 24 readings for the "Trend" chart
			$chartData = \App\Models\PlantReading::orderBy('created_at', 'desc')->take(24)->get()->reverse()->values();

			return view('history', compact('history', 'chartData'));
		}

    // THE API: This is what the ESP8266 will talk to
    public function store(Request $request)
    {
        // Validate the incoming data from the sensor
        $request->validate([
            'moisture' => 'required|numeric',
            'temp' => 'required|numeric',
            'humidity' => 'required|numeric',
        ]);

        // Save to database
        PlantReading::create($request->all());

        return response()->json(['status' => 'Data Received'], 201);
    }
}