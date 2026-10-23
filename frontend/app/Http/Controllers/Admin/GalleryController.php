<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ApiClient;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(Request $request, ApiClient $api)
    {
        $token = session('api_token');
        $albums = $api->get('admin/albums', [], $token)->json('data') ?? [];
        $selectedAlbumId = $request->query('album_id');
        $photosQuery = $selectedAlbumId ? ['album_id' => $selectedAlbumId] : [];
        $photos = $api->get('admin/galleries', $photosQuery, $token)->json('data') ?? [];

        return view('admin.gallery.index', compact('albums', 'photos', 'selectedAlbumId'));
    }

    public function storeAlbum(Request $request, ApiClient $api)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'description' => 'nullable|string',
        ]);

        $token = session('api_token');
        $res = $api->post('admin/albums', $request->only(['name', 'description']), $token);

        if (!$res->successful() || !$res->json('success')) {
            return back()->with('error', $res->json('message') ?? 'Gagal membuat album.');
        }

        return back()->with('success', 'Album foto berhasil dibuat.');
    }

    public function updateAlbum(Request $request, $id, ApiClient $api)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'description' => 'nullable|string',
        ]);

        $token = session('api_token');
        $res = $api->put("admin/albums/{$id}", $request->only(['name', 'description']), $token);

        if (!$res->successful() || !$res->json('success')) {
            return back()->with('error', $res->json('message') ?? 'Gagal memperbarui album.');
        }

        return back()->with('success', 'Album berhasil diperbarui.');
    }

    public function destroyAlbum($id, ApiClient $api)
    {
        $token = session('api_token');
        $res = $api->delete("admin/albums/{$id}", $token);

        if (!$res->successful() || !$res->json('success')) {
            return back()->with('error', $res->json('message') ?? 'Gagal menghapus album.');
        }

        return redirect()->route('admin.galeri.index')->with('success', 'Album dan foto di dalamnya berhasil dihapus.');
    }

    public function storePhoto(Request $request, ApiClient $api)
    {
        $request->validate([
            'album_id' => 'nullable|integer',
            'title' => 'nullable|string|max:150',
            'alt_text' => 'nullable|string|max:150',
            'image' => 'required|image|max:5120',
        ]);

        $token = session('api_token');
        $data = $request->only(['album_id', 'title', 'alt_text']);
        $data['image'] = $request->file('image');

        $res = $api->post('admin/galleries', $data, $token, true);

        if (!$res->successful() || !$res->json('success')) {
            return back()->with('error', $res->json('message') ?? 'Gagal mengunggah foto.');
        }

        return back()->with('success', 'Foto berhasil ditambahkan ke galeri.');
    }

    public function destroyPhoto($id, ApiClient $api)
    {
        $token = session('api_token');
        $res = $api->delete("admin/galleries/{$id}", $token);

        if (!$res->successful() || !$res->json('success')) {
            return back()->with('error', $res->json('message') ?? 'Gagal menghapus foto.');
        }

        return back()->with('success', 'Foto berhasil dihapus.');
    }
}
