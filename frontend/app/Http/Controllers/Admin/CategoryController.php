<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ApiClient;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(ApiClient $api)
    {
        $token = session('api_token');
        $categories = $api->get('admin/categories', [], $token)->json('data') ?? [];
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request, ApiClient $api)
    {
        $request->validate(['name' => 'required|string|max:100']);
        $token = session('api_token');
        $res = $api->post('admin/categories', ['name' => $request->name], $token);

        if (!$res->successful() || !$res->json('success')) {
            return back()->with('error', $res->json('message') ?? 'Gagal menambahkan kategori.');
        }

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $request, $id, ApiClient $api)
    {
        $request->validate(['name' => 'required|string|max:100']);
        $token = session('api_token');
        $res = $api->put("admin/categories/{$id}", ['name' => $request->name], $token);

        if (!$res->successful() || !$res->json('success')) {
            return back()->with('error', $res->json('message') ?? 'Gagal memperbarui kategori.');
        }

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy($id, ApiClient $api)
    {
        $token = session('api_token');
        $res = $api->delete("admin/categories/{$id}", $token);

        if (!$res->successful() || !$res->json('success')) {
            return back()->with('error', $res->json('message') ?? 'Gagal menghapus kategori.');
        }

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
