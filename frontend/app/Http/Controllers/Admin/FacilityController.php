<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ApiClient;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    public function index(ApiClient $api)
    {
        $token = session('api_token');
        $facilities = $api->get('admin/facilities', [], $token)->json('data') ?? [];
        return view('admin.facilities.index', compact('facilities'));
    }

    public function create()
    {
        return view('admin.facilities.form');
    }

    public function store(Request $request, ApiClient $api)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'quantity' => 'nullable|integer|min:0',
            'condition_status' => 'required|in:baik,rusak_ringan,rusak_berat',
            'image' => 'nullable|image|max:3072',
        ]);

        $token = session('api_token');
        $data = $request->except(['image']);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image');
        }

        $res = $api->post('admin/facilities', $data, $token, $request->hasFile('image'));

        if (!$res->successful() || !$res->json('success')) {
            return back()->withInput()->with('error', $res->json('message') ?? 'Gagal menyimpan fasilitas.');
        }

        return redirect()->route('admin.fasilitas.index')->with('success', 'Fasilitas berhasil disimpan.');
    }

    public function edit($id, ApiClient $api)
    {
        $token = session('api_token');
        $facility = $api->get("admin/facilities/{$id}", [], $token)->json('data');
        if (!$facility) {
            return redirect()->route('admin.fasilitas.index')->with('error', 'Fasilitas tidak ditemukan.');
        }
        return view('admin.facilities.form', compact('facility'));
    }

    public function update(Request $request, $id, ApiClient $api)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'quantity' => 'nullable|integer|min:0',
            'condition_status' => 'required|in:baik,rusak_ringan,rusak_berat',
            'image' => 'nullable|image|max:3072',
        ]);

        $token = session('api_token');
        $data = $request->except(['image']);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image');
        }

        $res = $api->put("admin/facilities/{$id}", $data, $token, $request->hasFile('image'));

        if (!$res->successful() || !$res->json('success')) {
            return back()->withInput()->with('error', $res->json('message') ?? 'Gagal memperbarui fasilitas.');
        }

        return redirect()->route('admin.fasilitas.index')->with('success', 'Fasilitas berhasil diperbarui.');
    }

    public function destroy($id, ApiClient $api)
    {
        $token = session('api_token');
        $res = $api->delete("admin/facilities/{$id}", $token);

        if (!$res->successful() || !$res->json('success')) {
            return back()->with('error', $res->json('message') ?? 'Gagal menghapus fasilitas.');
        }

        return redirect()->route('admin.fasilitas.index')->with('success', 'Fasilitas berhasil dihapus.');
    }
}
