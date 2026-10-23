<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ApiClient;
use Illuminate\Http\Request;

class ExtracurricularController extends Controller
{
    public function index(ApiClient $api)
    {
        $token = session('api_token');
        $extracurriculars = $api->get('admin/extracurriculars', [], $token)->json('data') ?? [];
        return view('admin.extracurriculars.index', compact('extracurriculars'));
    }

    public function create()
    {
        return view('admin.extracurriculars.form');
    }

    public function store(Request $request, ApiClient $api)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'schedule' => 'nullable|string|max:150',
            'coach' => 'nullable|string|max:100',
            'image' => 'nullable|image|max:3072',
        ]);

        $token = session('api_token');
        $data = $request->except(['image']);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image');
        }

        $res = $api->post('admin/extracurriculars', $data, $token, $request->hasFile('image'));

        if (!$res->successful() || !$res->json('success')) {
            return back()->withInput()->with('error', $res->json('message') ?? 'Gagal menyimpan ekstrakurikuler.');
        }

        return redirect()->route('admin.ekstrakurikuler.index')->with('success', 'Ekstrakurikuler berhasil disimpan.');
    }

    public function edit($id, ApiClient $api)
    {
        $token = session('api_token');
        $item = $api->get("admin/extracurriculars/{$id}", [], $token)->json('data');
        if (!$item) {
            return redirect()->route('admin.ekstrakurikuler.index')->with('error', 'Ekstrakurikuler tidak ditemukan.');
        }
        $extracurricular = $item;
        return view('admin.extracurriculars.form', compact('extracurricular', 'item'));
    }

    public function update(Request $request, $id, ApiClient $api)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'schedule' => 'nullable|string|max:150',
            'coach' => 'nullable|string|max:100',
            'image' => 'nullable|image|max:3072',
        ]);

        $token = session('api_token');
        $data = $request->except(['image']);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image');
        }

        $res = $api->put("admin/extracurriculars/{$id}", $data, $token, $request->hasFile('image'));

        if (!$res->successful() || !$res->json('success')) {
            return back()->withInput()->with('error', $res->json('message') ?? 'Gagal memperbarui ekstrakurikuler.');
        }

        return redirect()->route('admin.ekstrakurikuler.index')->with('success', 'Ekstrakurikuler berhasil diperbarui.');
    }

    public function destroy($id, ApiClient $api)
    {
        $token = session('api_token');
        $res = $api->delete("admin/extracurriculars/{$id}", $token);

        if (!$res->successful() || !$res->json('success')) {
            return back()->with('error', $res->json('message') ?? 'Gagal menghapus data.');
        }

        return redirect()->route('admin.ekstrakurikuler.index')->with('success', 'Ekstrakurikuler berhasil dihapus.');
    }
}
