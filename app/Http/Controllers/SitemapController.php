<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $urls = [
            '/' => 'daily',
            '/cek-status' => 'always',
            '/sparepart' => 'daily',
            '/contact' => 'monthly',
        ];

        return response()->view('sitemap', [
            'urls' => $urls
        ])->header('Content-Type', 'text/xml');
    }
}
