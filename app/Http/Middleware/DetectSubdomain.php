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
        $domain = parse_url(config('app.url'), PHP_URL_HOST) ?? 'tikehub.com';
        
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
