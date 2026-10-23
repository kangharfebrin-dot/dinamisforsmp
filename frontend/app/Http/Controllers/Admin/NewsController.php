<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ApiClient;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(Request $request, ApiClient $api)
    {
        $token = session('api_token');
        $query = [
            'page' => $request->query('page', 1),
            'limit' => 15,
            'q' => $request->query('q'),
            'category' => $request->query('category'),
            'status' => $request->query('status'), // Admin can view drafts & published
        ];

        $response = $api->get('admin/news', array_filter($query), $token);
        $news = $response->json('data') ?? [];
        $meta = $response->json('meta') ?? ['page' => 1, 'total' => 0, 'total_pages' => 1];

        $categories = $api->get('news/categories')->json('data') ?? [];
        $posts = $news;

        return view('admin.news.index', compact('posts', 'news', 'meta', 'categories'));
    }

    public function create(ApiClient $api)
    {
        $categories = $api->get('news/categories')->json('data') ?? [];
        return view('admin.news.form', compact('categories'));
    }

    public function store(Request $request, ApiClient $api)
    {
        $request->validate([
            'title' => 'required|string|max:200',
            'category_id' => 'required|integer',
            'content' => 'required|string',
            'status' => 'required|in:draft,published',
            'cover_image' => 'nullable|image|max:3072',
        ]);

        $token = session('api_token');
        $data = [
            'title' => $request->input('title'),
            'category_id' => $request->input('category_id'),
            'excerpt' => $request->input('excerpt'),
            'content' => $request->input('content'),
            'status' => $request->input('status'),
        ];

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image');
        }

        $res = $api->post('admin/news', $data, $token, $request->hasFile('cover_image'));

        if (!$res->successful() || !$res->json('success')) {
            return back()->withInput()->with('error', $res->json('message') ?? 'Gagal menyimpan berita.');
        }

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil disimpan.');
    }

    public function edit($id, ApiClient $api)
    {
        $token = session('api_token');
        $post = $api->get("admin/news/{$id}", [], $token)->json('data');
        if (!$post) {
            return redirect()->route('admin.berita.index')->with('error', 'Berita tidak ditemukan.');
        }

        $categories = $api->get('news/categories')->json('data') ?? [];
        return view('admin.news.form', compact('post', 'categories'));
    }

    public function update(Request $request, $id, ApiClient $api)
    {
        $request->validate([
            'title' => 'required|string|max:200',
            'category_id' => 'required|integer',
            'content' => 'required|string',
            'status' => 'required|in:draft,published',
            'cover_image' => 'nullable|image|max:3072',
        ]);

        $token = session('api_token');
        $data = [
            'title' => $request->input('title'),
            'category_id' => $request->input('category_id'),
            'excerpt' => $request->input('excerpt'),
            'content' => $request->input('content'),
            'status' => $request->input('status'),
        ];

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image');
        }

        $res = $api->put("admin/news/{$id}", $data, $token, $request->hasFile('cover_image'));

        if (!$res->successful() || !$res->json('success')) {
            return back()->withInput()->with('error', $res->json('message') ?? 'Gagal memperbarui berita.');
        }

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy($id, ApiClient $api)
    {
        $token = session('api_token');
        $res = $api->delete("admin/news/{$id}", $token);

        if (!$res->successful() || !$res->json('success')) {
            return back()->with('error', $res->json('message') ?? 'Gagal menghapus berita.');
        }

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil dihapus.');
    }
}
