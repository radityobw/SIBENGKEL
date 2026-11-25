<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_routes_return_ok(): void
    {
        $routes = ['/', '/cek-status', '/contact-us', '/sparepart', '/masuk', '/daftar', '/up'];

        foreach ($routes as $uri) {
            $response = $this->get($uri);
            $response->assertStatus(200, "Failed asserting status 200 on {$uri}");
        }
    }

    public function test_sitemap_returns_xml(): void
    {
        $response = $this->get('/sitemap.xml');

        $response->assertStatus(200);
        $this->assertStringContainsString('xml', (string) $response->headers->get('Content-Type'));
        $response->assertSee('<urlset', false);
    }
}
