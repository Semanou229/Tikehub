<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeocodingService
{
    /**
     * Géocoder une adresse en coordonnées (latitude, longitude)
     * Utilise l'API Nominatim d'OpenStreetMap
     */
    public function geocode(string $address): ?array
    {
        try {
            $response = Http::timeout(5)->get('https://nominatim.openstreetmap.org/search', [
                'q' => $address,
                'format' => 'json',
                'limit' => 1,
                'addressdetails' => 1,
            ]);

            if ($response->successful() && $response->json()) {
                $results = $response->json();
                
                if (!empty($results) && isset($results[0]['lat']) && isset($results[0]['lon'])) {
                    return [
                        'latitude' => (float) $results[0]['lat'],
                        'longitude' => (float) $results[0]['lon'],
                        'address' => $results[0]['display_name'] ?? $address,
                        'details' => $results[0]['address'] ?? [],
                    ];
                }
            }
        } catch (\Exception $e) {
            Log::error('Erreur de géocodage: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Reverse géocodage : convertir des coordonnées en adresse
     */
    public function reverseGeocode(float $latitude, float $longitude): ?array
    {
        try {
            $response = Http::timeout(5)->get('https://nominatim.openstreetmap.org/reverse', [
                'lat' => $latitude,
                'lon' => $longitude,
                'format' => 'json',
                'addressdetails' => 1,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['address'])) {
                    return [
                        'address' => $data['display_name'] ?? '',
                        'details' => $data['address'] ?? [],
                    ];
                }
            }
        } catch (\Exception $e) {
            Log::error('Erreur de reverse géocodage: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Construire une adresse complète à partir des champs
     */
    public function buildAddress(?string $address, ?string $city, ?string $country): string
    {
        $parts = array_filter([$address, $city, $country]);
        return implode(', ', $parts);
    }
}

