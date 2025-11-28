<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $this->getLocale($request);

        if ($locale && $this->isValidLocale($locale)) {
            App::setLocale($locale);
            session(['locale' => $locale]);
        } else {
            $locale = config('app.locale');
            App::setLocale($locale);
        }

        return $next($request);
    }

    protected function getLocale(Request $request): ?string
    {
        // Priorité 1: paramètre de requête
        if ($request->has('locale')) {
            return $request->get('locale');
        }

        // Priorité 2: session
        if (session()->has('locale')) {
            return session('locale');
        }

        // Priorité 3: en-tête Accept-Language (parser)
        if ($request->hasHeader('Accept-Language')) {
            return $this->parseAcceptLanguage($request->header('Accept-Language'));
        }

        // Priorité 4: configuration par défaut
        return config('app.locale');
    }

    protected function parseAcceptLanguage(string $acceptLanguage): ?string
    {
        // Parser l'en-tête Accept-Language: "fr-BJ,fr-FR;q=0.9,fr;q=0.8,en-US;q=0.7,en;q=0.6"
        $locales = [];
        $parts = explode(',', $acceptLanguage);

        foreach ($parts as $part) {
            $part = trim($part);
            // Extraire la locale (avant le point-virgule)
            $locale = explode(';', $part)[0];
            $locale = trim($locale);
            
            // Extraire le poids (q=0.9) si présent
            $weight = 1.0;
            if (preg_match('/q=([\d.]+)/', $part, $matches)) {
                $weight = (float) $matches[1];
            }
            
            $locales[$locale] = $weight;
        }

        // Trier par poids décroissant
        arsort($locales);

        // Retourner la première locale valide
        foreach (array_keys($locales) as $locale) {
            // Normaliser la locale (fr-BJ -> fr, en-US -> en)
            $normalized = $this->normalizeLocale($locale);
            if ($this->isValidLocale($normalized)) {
                return $normalized;
            }
        }

        return null;
    }

    protected function normalizeLocale(string $locale): string
    {
        // Extraire uniquement la partie langue (fr-BJ -> fr, en-US -> en)
        $parts = explode('-', $locale);
        return strtolower($parts[0]);
    }

    protected function isValidLocale(string $locale): bool
    {
        // Liste des locales supportées
        $supportedLocales = ['fr', 'en', 'es', 'de', 'it', 'pt'];
        
        return in_array($locale, $supportedLocales);
    }
}

