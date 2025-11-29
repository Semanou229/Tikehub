<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DetectSubdomain
{
    public function handle(Request $request, Closure $next): Response
    {
        $host = $request->getHost();
        $appUrl = config('app.url', 'http://localhost');
        $domain = parse_url($appUrl, PHP_URL_HOST);
        
        // Si on est en localhost, pas de gestion de sous-domaine
        if (!$domain || $domain === 'localhost' || $domain === '127.0.0.1') {
            return $next($request);
        }
        
        // Extraire le sous-domaine
        $subdomain = str_replace('.' . $domain, '', $host);
        $subdomain = str_replace('www.', '', $subdomain);
        
        // Si c'est le domaine principal, continuer normalement
        if ($subdomain === $domain || empty($subdomain) || $subdomain === 'www') {
            return $next($request);
        }
        
        // Stocker le sous-domaine dans la requête
        $request->attributes->set('subdomain', $subdomain);
        
        return $next($request);
    }
}
