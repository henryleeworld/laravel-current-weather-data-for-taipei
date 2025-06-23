<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ __('Taipei Weather') }}</title>     
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
        <!-- Styles -->
        @vite(['resources/css/app.css'])
    </head>
    
    <body class="bg-gray-50 text-gray-900 min-h-screen">
        <header class="bg-blue-600 text-white shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center py-6">
                    <div>
                        <h1 class="text-3xl font-bold">🌤️ {{ __('Taipei Weather') }}</h1>
                        <p class="text-blue-100 mt-1">{!! __('Real-time weather information from :open_weather_map_api', ['open_weather_map_api' => '<a class="text-white underline" href="https://openweathermap.org/api" target="_blank">OpenWeatherMap API</a>']) !!}</p>
                    </div>
                </div>
            </div>
        </header>
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            @if($weatherData['success'])
                <div class="bg-white rounded-2xl shadow-xl p-8 mb-8">
                    <div class="text-center mb-8">
                        <div class="flex items-center justify-center mb-4">
                            @if(isset($weatherData['icon']))
                                <img src="https://openweathermap.org/img/wn/{{ $weatherData['icon'] }}@4x.png" 
                                     alt="{{ $weatherData['description'] ?? 'Weather' }}" 
                                     class="w-32 h-32">
                            @endif
                        </div>
                        <h2 class="text-6xl font-bold text-gray-800 mb-2">{{ $weatherData['temperature'] }}°C</h2>
                        <p class="text-2xl text-gray-600 mb-2 capitalize">{{ $weatherData['description'] ?? 'N/A' }}</p>
                        <p class="text-lg text-gray-500">{{ __('Feels like') . ' ' . $weatherData['feels_like'] }}°C</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-6 rounded-xl">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-blue-900">{{ __('Humidity') }}</h3>
                                <p class="text-3xl font-bold text-blue-800">{{ $weatherData['humidity'] }}%</p>
                            </div>
                            <div class="text-4xl text-blue-600">💧</div>
                        </div>
                    </div>
                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-6 rounded-xl">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-purple-900">{{ __('Pressure') }}</h3>
                                <p class="text-3xl font-bold text-purple-800">{{ $weatherData['pressure'] }} hPa</p>
                            </div>
                            <div class="text-4xl text-purple-600">🌡️</div>
                        </div>
                    </div>
                    <div class="bg-gradient-to-br from-green-50 to-green-100 p-6 rounded-xl">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-green-900">{{ __('Wind Speed') }}</h3>
                                <p class="text-3xl font-bold text-green-800">{{ $weatherData['wind_speed'] }} m/s</p>
                            </div>
                            <div class="text-4xl text-green-600">💨</div>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="bg-gradient-to-br from-yellow-50 to-orange-100 p-6 rounded-xl text-center">
                        <div class="text-4xl text-yellow-600 mb-3">🌅</div>
                        <h3 class="text-lg font-semibold text-orange-900 mb-2">{{ __('Sunrise') }}</h3>
                        <p class="text-2xl font-bold text-orange-800">{{ $weatherData['sunrise'] ?? __('N/A') }}</p>
                    </div>

                    <div class="bg-gradient-to-br from-orange-50 to-red-100 p-6 rounded-xl text-center">
                        <div class="text-4xl text-orange-600 mb-3">🌇</div>
                        <h3 class="text-lg font-semibold text-red-900 mb-2">{{ __('Sunset') }}</h3>
                        <p class="text-2xl font-bold text-red-800">{{ $weatherData['sunset'] ?? __('N/A') }}</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @if(isset($weatherData['visibility']))
                        <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 p-6 rounded-xl">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-semibold text-indigo-900">{{ __('Visibility') }}</h3>
                                    <p class="text-2xl font-bold text-indigo-800">{{ $weatherData['visibility'] }} km</p>
                                </div>
                                <div class="text-4xl text-indigo-600">👁️</div>
                            </div>
                        </div>
                    @endif

                    <div class="bg-gradient-to-br from-gray-50 to-gray-100 p-6 rounded-xl">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">{{ __('Cloud Cover') }}</h3>
                                <p class="text-2xl font-bold text-gray-800">{{ $weatherData['clouds'] }}%</p>
                            </div>
                            <div class="text-4xl text-gray-600">☁️</div>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white rounded-2xl shadow-xl p-8 text-center">
                    <div class="text-6xl text-red-400 mb-4">⚠️</div>
                    <h2 class="text-3xl font-bold text-red-600 mb-4">{{ __('Weather Service Error') }}</h2>
                    <p class="text-xl text-gray-600 mb-6">{{ __('Unable to fetch weather data for Taipei') }}</p>
                    
                    <div class="bg-red-50 border border-red-200 p-6 rounded-xl mb-6 text-left">
                        <p class="text-red-700 font-medium">{{ $weatherData['error'] ?? __('Unknown error occurred') }}</p>
                    </div>
                </div>
            @endif
        </main>
        @vite(['resources/js/app.js'])
    </body>
</html>
