<?php

namespace  App\Http\Integrations\OpenWeatherMap;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

final class OpenWeatherMapConnector
{
    private $apiKey;
    private $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.open_weather.key');
        $this->baseUrl = config('services.open_weather.url');
    }

    public function getCurrentWeather()
    {
        $lat = 25.037840;
        $lon = 121.560204;

        try {
            if (!$this->apiKey) {
                throw new Exception(__('OpenWeatherMap API key not configured'));
            }

            $response = Http::get("{$this->baseUrl}/weather", [
                'lat' => $lat,
                'lon' => $lon,
                'appid' => $this->apiKey,
                'units' => 'metric'
            ]);

            if ($response->successful()) {
                $data = $response->json();
                Log::info(__('Weather data'), $data);
                
                return [
                    'success' => true,
                    'location' => $data['name'] ?? __('Unknown'),
                    'country' => $data['sys']['country'] ?? '',
                    'temperature' => round($data['main']['temp'] ?? 0),
                    'feels_like' => round($data['main']['feels_like'] ?? 0),
                    'description' => ucfirst($data['weather'][0]['description'] ?? __('No description')),
                    'icon' => $data['weather'][0]['icon'] ?? '01d',
                    'humidity' => $data['main']['humidity'] ?? 0,
                    'pressure' => $data['main']['pressure'] ?? 0,
                    'wind_speed' => $data['wind']['speed'] ?? 0,
                    'wind_deg' => $data['wind']['deg'] ?? 0,
                    'visibility' => isset($data['visibility']) ? $data['visibility'] / 1000 : null, // Convert to km
                    'clouds' => $data['clouds']['all'] ?? 0,
                    'sunrise' => isset($data['sys']['sunrise']) ? date('H:i', $data['sys']['sunrise']) : null,
                    'sunset' => isset($data['sys']['sunset']) ? date('H:i', $data['sys']['sunset']) : null,
                ];
            }

            $statusCode = $response->status();
            $errorData = $response->json();
            $errorMessage = $errorData['message'] ?? __('Weather service unavailable');

            Log::error(__('Weather API error'), [
                'status' => $statusCode,
                'message' => $errorMessage,
            ]);

            throw new Exception(__('Weather API error ') . __('(') . $statusCode . __(')') . __(': ') . $errorMessage);

        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'location' => __('Taipei'),
                'country' => 'TW',
                'temperature' => '--',
                'description' => __('Weather data unavailable'),
            ];
        }
    }
} 