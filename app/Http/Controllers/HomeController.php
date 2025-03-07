<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $recaptchaSiteKey = config('services.recaptcha.site');

        $apiKey = env('GOOGLE_PLACES_API_KEY'); // Usa .env para seguridad
        $placeId = "ChIJ1TsR4OGEpxIRsH8QPJHds5Y";
        $url = "https://maps.googleapis.com/maps/api/place/details/json?place_id=$placeId&fields=reviews&language=es&key=$apiKey";

        $response = file_get_contents($url);
        $data = json_decode($response, true);
        $opiniones = $data['result']['reviews'] ?? [];

        if (!empty($opiniones)) {
            // Ordenamos las reseñas de mayor a menor rating.
            usort($opiniones, function ($a, $b) {
                // Utilizamos el operador spaceship (disponible en PHP 7+)
                return $b['rating'] <=> $a['rating'];
            });
            // Tomamos las 3 primeras reseñas.
            $opiniones = array_slice($opiniones, 0, 3);
        }
        return view('pages/home', compact('recaptchaSiteKey', 'opiniones')); // Apunta a una vista específica
    }
}
