<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ApiClient;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index(ApiClient $api)
    {
        $token = session('api_token');
        $teachers = $api->get('admin/teachers', [], $token)->json('data') ?? [];
        return view('admin.teachers.index', compact('teachers'));
    }

    public function create()
    {
        return view('admin.teachers.form');
    }

    public function store(Request $request, ApiClient $api)
    {
        $request->validate([
            'name' => 'required|string|max:120',
            'type' => 'required|in:guru,tendik',
            'position' => 'nullable|string|max:120',
            'subject' => 'nullable|string|max:100',
            'nip' => 'nullable|string|max:40',
            'email' => 'nullable|email|max:120',
            'photo' => 'nullable|image|max:3072',
        ]);

        $token = session('api_token');
        $data = $request->except(['photo']);
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo');
        }

        $res = $api->post('admin/teachers', $data, $token, $request->hasFile('photo'));

        if (!$res->successful() || !$res->json('success')) {
            return back()->withInput()->with('error', $res->json('message') ?? 'Gagal menyimpan data pendidik.');
        }

        return redirect()->route('admin.guru.index')->with('success', 'Data guru/staf berhasil disimpan.');
    }

    public function edit($id, ApiClient $api)
    {
        $token = session('api_token');
        $teacher = $api->get("admin/teachers/{$id}", [], $token)->json('data');
        if (!$teacher) {
            return redirect()->route('admin.guru.index')->with('error', 'Data tidak ditemukan.');
        }
        return view('admin.teachers.form', compact('teacher'));
    }

    public function update(Request $request, $id, ApiClient $api)
    {
        $request->validate([
            'name' => 'required|string|max:120',
            'type' => 'required|in:guru,tendik',
            'position' => 'nullable|string|max:120',
            'subject' => 'nullable|string|max:100',
            'nip' => 'nullable|string|max:40',
            'email' => 'nullable|email|max:120',
            'photo' => 'nullable|image|max:3072',
        ]);

        $token = session('api_token');
        $data = $request->except(['photo']);
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo');
        }

        $res = $api->put("admin/teachers/{$id}", $data, $token, $request->hasFile('photo'));

        if (!$res->successful() || !$res->json('success')) {
            return back()->withInput()->with('error', $res->json('message') ?? 'Gagal memperbarui data pendidik.');
        }

        return redirect()->route('admin.guru.index')->with('success', 'Data guru/staf berhasil diperbarui.');
    }

    public function destroy($id, ApiClient $api)
    {
        $token = session('api_token');
        $res = $api->delete("admin/teachers/{$id}", $token);

        if (!$res->successful() || !$res->json('success')) {
            return back()->with('error', $res->json('message') ?? 'Gagal menghapus data.');
        }

        return redirect()->route('admin.guru.index')->with('success', 'Data berhasil dihapus.');
    }
}
