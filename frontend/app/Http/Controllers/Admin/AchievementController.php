<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ApiClient;
use Illuminate\Http\Request;

class AchievementController extends Controller
{
    public function index(ApiClient $api)
    {
        $token = session('api_token');
        $achievements = $api->get('admin/achievements', [], $token)->json('data') ?? [];
        return view('admin.achievements.index', compact('achievements'));
    }

    public function create()
    {
        return view('admin.achievements.form');
    }

    public function store(Request $request, ApiClient $api)
    {
        $request->validate([
            'title' => 'required|string|max:200',
            'level' => 'required|in:kecamatan,kabupaten,provinsi,nasional,internasional',
            'year' => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'student_name' => 'nullable|string|max:150',
            'event_name' => 'nullable|string|max:150',
            'medal' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:3072',
        ]);

        $token = session('api_token');
        $data = $request->except(['image']);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image');
        }

        $res = $api->post('admin/achievements', $data, $token, $request->hasFile('image'));

        if (!$res->successful() || !$res->json('success')) {
            return back()->withInput()->with('error', $res->json('message') ?? 'Gagal menyimpan prestasi.');
        }

        return redirect()->route('admin.prestasi.index')->with('success', 'Prestasi berhasil disimpan.');
    }

    public function edit($id, ApiClient $api)
    {
        $token = session('api_token');
        $achievement = $api->get("admin/achievements/{$id}", [], $token)->json('data');
        if (!$achievement) {
            return redirect()->route('admin.prestasi.index')->with('error', 'Prestasi tidak ditemukan.');
        }
        return view('admin.achievements.form', compact('achievement'));
    }

    public function update(Request $request, $id, ApiClient $api)
    {
        $request->validate([
            'title' => 'required|string|max:200',
            'level' => 'required|in:kecamatan,kabupaten,provinsi,nasional,internasional',
            'year' => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'student_name' => 'nullable|string|max:150',
            'event_name' => 'nullable|string|max:150',
            'medal' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:3072',
        ]);

        $token = session('api_token');
        $data = $request->except(['image']);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image');
        }

        $res = $api->put("admin/achievements/{$id}", $data, $token, $request->hasFile('image'));

        if (!$res->successful() || !$res->json('success')) {
            return back()->withInput()->with('error', $res->json('message') ?? 'Gagal memperbarui prestasi.');
        }

        return redirect()->route('admin.prestasi.index')->with('success', 'Prestasi berhasil diperbarui.');
    }

    public function destroy($id, ApiClient $api)
    {
        $token = session('api_token');
        $res = $api->delete("admin/achievements/{$id}", $token);

        if (!$res->successful() || !$res->json('success')) {
            return back()->with('error', $res->json('message') ?? 'Gagal menghapus prestasi.');
        }

        return redirect()->route('admin.prestasi.index')->with('success', 'Prestasi berhasil dihapus.');
    }
}
