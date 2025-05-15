<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class GeocoderService 
{
    public static function getCoordinates($address)
    {
        $cacheKey = 'geo_'.md5($address);
        
        return Cache::remember($cacheKey, now()->addDays(30), function () use ($address) {
            // Normalisation de l'adresse
            $normalizedAddress = self::normalizeAddress($address);
            
            // Essai avec Google Maps
            $googleData = self::getFromGoogle($normalizedAddress);
            if ($googleData) return $googleData;

            // Fallback à OpenStreetMap
            $osmData = self::getFromOSM($normalizedAddress);
            if ($osmData) return $osmData;

            // Fallback manuel pour les grandes villes marocaines
            return self::getManualCoordinates($normalizedAddress);
        });
    }

    protected static function normalizeAddress(string $address): string
    {
        $address = trim($address);
        if (!str_ends_with($address, 'Maroc')) {
            $address .= ', Maroc';
        }
        return $address;
    }

    protected static function getFromGoogle(string $address)
    {
        try {
            $client = new Client();
            $response = $client->get('https://maps.googleapis.com/maps/api/geocode/json', [
                'query' => [
                    'address' => $address,
                    'key' => config('services.google.maps_key'),
                    'region' => 'ma',
                    'language' => 'fr'
                ],
                'timeout' => 3
            ]);

            $data = json_decode($response->getBody(), true);

            if ($data['status'] === 'OK' && isset($data['results'][0]['geometry']['location'])) {
                return [
                    'lat' => (float)$data['results'][0]['geometry']['location']['lat'],
                    'lng' => (float)$data['results'][0]['geometry']['location']['lng'],
                    'source' => 'google'
                ];
            }
        } catch (\Exception $e) {
            Log::error("Google Maps API error: " . $e->getMessage());
        }

        return null;
    }

    protected static function getFromOSM(string $address)
    {
        try {
            $client = new Client();
            $response = $client->get('https://nominatim.openstreetmap.org/search', [
                'query' => [
                    'q' => $address,
                    'format' => 'json',
                    'limit' => 1,
                    'countrycodes' => 'ma',
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
            Log::error("Nominatim error: " . $e->getMessage());
        }

        return null;
    }

    protected static function getManualCoordinates(string $address)
    {
        $villes = [
            'casablanca' => [33.5731, -7.5898],
            'rabat' => [34.0209, -6.8416],
            'marrakech' => [31.6295, -7.9811],
            'tanger' => [35.7595, -5.8340],
            'fès' => [34.0435, -4.9812],
            'agadir' => [30.4278, -9.5981]
        ];

        foreach ($villes as $ville => $coords) {
            if (str_contains(strtolower($address), $ville)) {
                return [
                    'lat' => $coords[0],
                    'lng' => $coords[1],
                    'source' => 'manual'
                ];
            }
        }

        // Coordonnées par défaut (centre du Maroc)
        return [
            'lat' => 31.7917,
            'lng' => -7.0926,
            'source' => 'default'
        ];
    }
}