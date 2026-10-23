<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ApiClient;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function index(Request $request, ApiClient $api)
    {
        $token = session('api_token');
        $category = $request->query('category');
        $query = $category ? ['category' => $category] : [];
        $documents = $api->get('admin/documents', $query, $token)->json('data') ?? [];

        return view('admin.documents.index', compact('documents', 'category'));
    }

    public function store(Request $request, ApiClient $api)
    {
        $request->validate([
            'title' => 'required|string|max:150',
            'category' => 'nullable|string|max:100',
            'file' => 'required|file|max:10240', // max 10MB
        ]);

        $token = session('api_token');
        $data = $request->only(['title', 'category']);
        $data['file'] = $request->file('file');

        $res = $api->post('admin/documents', $data, $token, true);

        if (!$res->successful() || !$res->json('success')) {
            return back()->withInput()->with('error', $res->json('message') ?? 'Gagal mengunggah dokumen.');
        }

        return redirect()->route('admin.unduhan.index')->with('success', 'Dokumen berhasil diunggah.');
    }

    public function destroy($id, ApiClient $api)
    {
        $token = session('api_token');
        $res = $api->delete("admin/documents/{$id}", $token);

        if (!$res->successful() || !$res->json('success')) {
            return back()->with('error', $res->json('message') ?? 'Gagal menghapus dokumen.');
        }

        return redirect()->route('admin.unduhan.index')->with('success', 'Dokumen berhasil dihapus.');
    }
}
