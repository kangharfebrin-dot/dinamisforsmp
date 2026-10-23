<?php

namespace App\Http\Controllers;

use App\Services\ApiClient;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(Request $request, ApiClient $api)
    {
        $profile = $api->get('profile')->json('data') ?? [];
        $categories = $api->get('news/categories')->json('data') ?? [];

        $query = [
            'page' => $request->query('page', 1),
            'limit' => 9,
            'q' => $request->query('q'),
            'category' => $request->query('category'),
            'status' => 'published',
        ];

        $response = $api->get('news', array_filter($query));
        $news = $response->json('data') ?? [];
        $meta = $response->json('meta') ?? ['page' => 1, 'total' => 0, 'total_pages' => 1];

        return view('news.index', compact('profile', 'news', 'meta', 'categories'));
    }

    public function show(string $slug, ApiClient $api)
    {
        $profile = $api->get('profile')->json('data') ?? [];
        $response = $api->get("news/{$slug}");

        if (!$response->successful() || !$response->json('success')) {
            abort(404, 'Berita tidak ditemukan.');
        }

        $post = $response->json('data');
        $related = $response->json('related') ?? [];

        return view('news.show', compact('profile', 'post', 'related'));
    }
}
