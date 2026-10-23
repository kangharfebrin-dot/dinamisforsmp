<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ApiClient;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index(ApiClient $api)
    {
        $token = session('api_token');
        $pages = $api->get('admin/pages', [], $token)->json('data') ?? [];
        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.form');
    }

    public function store(Request $request, ApiClient $api)
    {
        $request->validate([
            'title' => 'required|string|max:150',
            'content' => 'required|string',
            'meta_title' => 'nullable|string|max:150',
            'meta_description' => 'nullable|string|max:255',
            'status' => 'required|in:published,draft',
        ]);

        $token = session('api_token');
        $res = $api->post('admin/pages', $request->only(['title', 'content', 'meta_title', 'meta_description', 'status']), $token);

        if (!$res->successful() || !$res->json('success')) {
            return back()->withInput()->with('error', $res->json('message') ?? 'Gagal membuat halaman.');
        }

        return redirect()->route('admin.halaman.index')->with('success', 'Halaman berhasil dibuat.');
    }

    public function edit($id, ApiClient $api)
    {
        $token = session('api_token');
        $page = $api->get("admin/pages/{$id}", [], $token)->json('data');
        if (!$page) {
            return redirect()->route('admin.halaman.index')->with('error', 'Halaman tidak ditemukan.');
        }
        return view('admin.pages.form', compact('page'));
    }

    public function update(Request $request, $id, ApiClient $api)
    {
        $request->validate([
            'title' => 'required|string|max:150',
            'content' => 'required|string',
            'meta_title' => 'nullable|string|max:150',
            'meta_description' => 'nullable|string|max:255',
            'status' => 'required|in:published,draft',
        ]);

        $token = session('api_token');
        $res = $api->put("admin/pages/{$id}", $request->only(['title', 'content', 'meta_title', 'meta_description', 'status']), $token);

        if (!$res->successful() || !$res->json('success')) {
            return back()->withInput()->with('error', $res->json('message') ?? 'Gagal memperbarui halaman.');
        }

        return redirect()->route('admin.halaman.index')->with('success', 'Halaman berhasil diperbarui.');
    }

    public function destroy($id, ApiClient $api)
    {
        $token = session('api_token');
        $res = $api->delete("admin/pages/{$id}", $token);

        if (!$res->successful() || !$res->json('success')) {
            return back()->with('error', $res->json('message') ?? 'Gagal menghapus halaman.');
        }

        return redirect()->route('admin.halaman.index')->with('success', 'Halaman berhasil dihapus.');
    }
}
