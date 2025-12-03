<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Event;
use App\Models\Contest;
use App\Models\Fundraising;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index()
    {
        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $sitemap .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        
        $baseUrl = config('app.url');
        
        // Sitemap principal
        $sitemap .= '  <sitemap>' . "\n";
        $sitemap .= '    <loc>' . $baseUrl . '/sitemap-pages.xml</loc>' . "\n";
        $sitemap .= '    <lastmod>' . now()->toAtomString() . '</lastmod>' . "\n";
        $sitemap .= '  </sitemap>' . "\n";
        
        // Sitemap blog
        $sitemap .= '  <sitemap>' . "\n";
        $sitemap .= '    <loc>' . $baseUrl . '/sitemap-blog.xml</loc>' . "\n";
        $sitemap .= '    <lastmod>' . now()->toAtomString() . '</lastmod>' . "\n";
        $sitemap .= '  </sitemap>' . "\n";
        
        // Sitemap événements
        $sitemap .= '  <sitemap>' . "\n";
        $sitemap .= '    <loc>' . $baseUrl . '/sitemap-events.xml</loc>' . "\n";
        $sitemap .= '    <lastmod>' . now()->toAtomString() . '</lastmod>' . "\n";
        $sitemap .= '  </sitemap>' . "\n";
        
        // Sitemap concours
        $sitemap .= '  <sitemap>' . "\n";
        $sitemap .= '    <loc>' . $baseUrl . '/sitemap-contests.xml</loc>' . "\n";
        $sitemap .= '    <lastmod>' . now()->toAtomString() . '</lastmod>' . "\n";
        $sitemap .= '  </sitemap>' . "\n";
        
        // Sitemap collectes
        $sitemap .= '  <sitemap>' . "\n";
        $sitemap .= '    <loc>' . $baseUrl . '/sitemap-fundraisings.xml</loc>' . "\n";
        $sitemap .= '    <lastmod>' . now()->toAtomString() . '</lastmod>' . "\n";
        $sitemap .= '  </sitemap>' . "\n";
        
        $sitemap .= '</sitemapindex>';
        
        return response($sitemap, 200)
            ->header('Content-Type', 'application/xml');
    }
    
    public function pages()
    {
        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        
        $baseUrl = config('app.url');
        $pages = [
            ['url' => '/', 'priority' => '1.0', 'changefreq' => 'daily'],
            ['url' => '/events', 'priority' => '0.9', 'changefreq' => 'daily'],
            ['url' => '/contests', 'priority' => '0.8', 'changefreq' => 'daily'],
            ['url' => '/fundraisings', 'priority' => '0.8', 'changefreq' => 'daily'],
            ['url' => '/blog', 'priority' => '0.8', 'changefreq' => 'daily'],
            ['url' => '/faq', 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['url' => '/contact', 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['url' => '/pricing', 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['url' => '/how-it-works', 'priority' => '0.8', 'changefreq' => 'monthly'],
        ];
        
        foreach ($pages as $page) {
            $sitemap .= '  <url>' . "\n";
            $sitemap .= '    <loc>' . $baseUrl . $page['url'] . '</loc>' . "\n";
            $sitemap .= '    <lastmod>' . now()->toAtomString() . '</lastmod>' . "\n";
            $sitemap .= '    <changefreq>' . $page['changefreq'] . '</changefreq>' . "\n";
            $sitemap .= '    <priority>' . $page['priority'] . '</priority>' . "\n";
            $sitemap .= '  </url>' . "\n";
        }
        
        $sitemap .= '</urlset>';
        
        return response($sitemap, 200)
            ->header('Content-Type', 'application/xml');
    }
    
    public function blog()
    {
        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        
        $baseUrl = config('app.url');
        $blogs = Blog::published()->orderBy('published_at', 'desc')->get();
        
        foreach ($blogs as $blog) {
            $sitemap .= '  <url>' . "\n";
            $sitemap .= '    <loc>' . $baseUrl . '/blog/' . $blog->slug . '</loc>' . "\n";
            $sitemap .= '    <lastmod>' . $blog->updated_at->toAtomString() . '</lastmod>' . "\n";
            $sitemap .= '    <changefreq>weekly</changefreq>' . "\n";
            $sitemap .= '    <priority>0.7</priority>' . "\n";
            $sitemap .= '  </url>' . "\n";
        }
        
        $sitemap .= '</urlset>';
        
        return response($sitemap, 200)
            ->header('Content-Type', 'application/xml');
    }
    
    public function events()
    {
        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        
        $baseUrl = config('app.url');
        $events = Event::where('is_approved', true)
            ->where('start_date', '>=', now())
            ->orderBy('start_date', 'asc')
            ->get();
        
        foreach ($events as $event) {
            $sitemap .= '  <url>' . "\n";
            $sitemap .= '    <loc>' . $baseUrl . '/events/' . $event->id . '</loc>' . "\n";
            $sitemap .= '    <lastmod>' . $event->updated_at->toAtomString() . '</lastmod>' . "\n";
            $sitemap .= '    <changefreq>daily</changefreq>' . "\n";
            $sitemap .= '    <priority>0.8</priority>' . "\n";
            $sitemap .= '  </url>' . "\n";
        }
        
        $sitemap .= '</urlset>';
        
        return response($sitemap, 200)
            ->header('Content-Type', 'application/xml');
    }
    
    public function contests()
    {
        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        
        $baseUrl = config('app.url');
        $contests = Contest::where('is_active', true)
            ->where('end_date', '>=', now())
            ->orderBy('end_date', 'asc')
            ->get();
        
        foreach ($contests as $contest) {
            $sitemap .= '  <url>' . "\n";
            $sitemap .= '    <loc>' . $baseUrl . '/contests/' . $contest->id . '</loc>' . "\n";
            $sitemap .= '    <lastmod>' . $contest->updated_at->toAtomString() . '</lastmod>' . "\n";
            $sitemap .= '    <changefreq>daily</changefreq>' . "\n";
            $sitemap .= '    <priority>0.7</priority>' . "\n";
            $sitemap .= '  </url>' . "\n";
        }
        
        $sitemap .= '</urlset>';
        
        return response($sitemap, 200)
            ->header('Content-Type', 'application/xml');
    }
    
    public function fundraisings()
    {
        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        
        $baseUrl = config('app.url');
        $fundraisings = Fundraising::where('is_active', true)
            ->where('end_date', '>=', now())
            ->orderBy('end_date', 'asc')
            ->get();
        
        foreach ($fundraisings as $fundraising) {
            $sitemap .= '  <url>' . "\n";
            $sitemap .= '    <loc>' . $baseUrl . '/fundraisings/' . $fundraising->id . '</loc>' . "\n";
            $sitemap .= '    <lastmod>' . $fundraising->updated_at->toAtomString() . '</lastmod>' . "\n";
            $sitemap .= '    <changefreq>daily</changefreq>' . "\n";
            $sitemap .= '    <priority>0.7</priority>' . "\n";
            $sitemap .= '  </url>' . "\n";
        }
        
        $sitemap .= '</urlset>';
        
        return response($sitemap, 200)
            ->header('Content-Type', 'application/xml');
    }
}

