<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@foreach ($urls as $url => $freq)
    <url>
        <loc>{{ url($url) }}</loc>
        <lastmod>{{ now()->tz('UTC')->toAtomString() }}</lastmod>
        <changefreq>{{ $freq }}</changefreq>
        <priority>{{ $url == '/' ? '1.0' : '0.8' }}</priority>
    </url>
@endforeach
</urlset>
