<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ApiClient;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index(ApiClient $api)
    {
        $token = session('api_token');
        $announcements = $api->get('admin/announcements', [], $token)->json('data') ?? [];
        return view('admin.announcements.index', compact('announcements'));
    }

    public function create()
    {
        return view('admin.announcements.form');
    }

    public function store(Request $request, ApiClient $api)
    {
        $request->validate([
            'title' => 'required|string|max:200',
            'content' => 'required|string',
            'status' => 'required|in:draft,published',
            'priority' => 'nullable|integer',
            'attachment' => 'nullable|file|max:5120',
        ]);

        $token = session('api_token');
        $data = [
            'title' => $request->title,
            'content' => $request->content,
            'status' => $request->status,
            'priority' => $request->priority ?? 0,
        ];

        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment');
        }

        $res = $api->post('admin/announcements', $data, $token, $request->hasFile('attachment'));

        if (!$res->successful() || !$res->json('success')) {
            return back()->withInput()->with('error', $res->json('message') ?? 'Gagal menyimpan pengumuman.');
        }

        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman berhasil disimpan.');
    }

    public function edit($id, ApiClient $api)
    {
        $token = session('api_token');
        $announcement = $api->get("admin/announcements/{$id}", [], $token)->json('data');
        if (!$announcement) {
            return redirect()->route('admin.pengumuman.index')->with('error', 'Pengumuman tidak ditemukan.');
        }
        return view('admin.announcements.form', compact('announcement'));
    }

    public function update(Request $request, $id, ApiClient $api)
    {
        $request->validate([
            'title' => 'required|string|max:200',
            'content' => 'required|string',
            'status' => 'required|in:draft,published',
            'priority' => 'nullable|integer',
            'attachment' => 'nullable|file|max:5120',
        ]);

        $token = session('api_token');
        $data = [
            'title' => $request->title,
            'content' => $request->content,
            'status' => $request->status,
            'priority' => $request->priority ?? 0,
        ];

        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment');
        }

        $res = $api->put("admin/announcements/{$id}", $data, $token, $request->hasFile('attachment'));

        if (!$res->successful() || !$res->json('success')) {
            return back()->withInput()->with('error', $res->json('message') ?? 'Gagal memperbarui pengumuman.');
        }

        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy($id, ApiClient $api)
    {
        $token = session('api_token');
        $res = $api->delete("admin/announcements/{$id}", $token);

        if (!$res->successful() || !$res->json('success')) {
            return back()->with('error', $res->json('message') ?? 'Gagal menghapus pengumuman.');
        }

        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman berhasil dihapus.');
    }
}
