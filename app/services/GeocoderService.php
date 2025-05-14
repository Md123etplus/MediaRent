<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class GeocoderService 
{
    public static function getCoordinates($address)
    {
        $cacheKey = 'geo_'.md5($address);
        
        return Cache::remember($cacheKey, now()->addDays(30), function () use ($address) {
            // Utilisation d'une API simple et mondiale
            return self::getFromOSM($address);
        });
    }

    protected static function getFromOSM(string $address)
    {
        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->get('https://nominatim.openstreetmap.org/search', [
                'query' => [
                    'q' => $address,
                    'format' => 'json',
                    'limit' => 1,
                    'accept-language' => 'fr'
                ],
                'headers' => [
                    'User-Agent' => 'MediaRentApp/1.0'
                ],
                'timeout' => 3
            ]);

            $data = json_decode($response->getBody(), true);

            if (!empty($data[0])) {
                return [
                    'lat' => (float)$data[0]['lat'],
                    'lng' => (float)$data[0]['lon'],
                    'source' => 'osm'
                ];
            }
        } catch (\Exception $e) {
            // Fallback statique si l'API échoue
            return self::getStaticCoordinates();
        }

        return self::getStaticCoordinates();
    }

    protected static function getStaticCoordinates()
    {
        // Coordonnées par défaut (centre géographique du monde)
        return [
            'lat' => 20.5937,
            'lng' => 78.9629,
            'source' => 'default'
        ];
    }
}