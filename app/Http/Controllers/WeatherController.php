<?php

namespace App\Http\Controllers;

use App\Http\Integrations\OpenWeatherMap\OpenWeatherMapConnector;

class WeatherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(OpenWeatherMapConnector $openWeatherMapConnector)
    {
        $weatherData = $openWeatherMapConnector->getCurrentWeather();
        
        return view('weather', compact('weatherData'));
    }
}
