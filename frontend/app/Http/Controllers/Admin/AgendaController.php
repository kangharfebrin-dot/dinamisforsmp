<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ApiClient;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    public function index(ApiClient $api)
    {
        $token = session('api_token');
        $agendas = $api->get('admin/agendas', [], $token)->json('data') ?? [];
        return view('admin.agendas.index', compact('agendas'));
    }

    public function create()
    {
        return view('admin.agendas.form');
    }

    public function store(Request $request, ApiClient $api)
    {
        $request->validate([
            'title' => 'required|string|max:200',
            'start_at' => 'required|date',
            'end_at' => 'nullable|date|after_or_equal:start_at',
            'status' => 'required|in:draft,published',
            'location' => 'nullable|string|max:200',
            'description' => 'nullable|string',
        ]);

        $token = session('api_token');
        $res = $api->post('admin/agendas', $request->all(), $token);

        if (!$res->successful() || !$res->json('success')) {
            return back()->withInput()->with('error', $res->json('message') ?? 'Gagal menyimpan agenda.');
        }

        return redirect()->route('admin.agenda.index')->with('success', 'Agenda berhasil disimpan.');
    }

    public function edit($id, ApiClient $api)
    {
        $token = session('api_token');
        $agenda = $api->get("admin/agendas/{$id}", [], $token)->json('data');
        if (!$agenda) {
            return redirect()->route('admin.agenda.index')->with('error', 'Agenda tidak ditemukan.');
        }
        return view('admin.agendas.form', compact('agenda'));
    }

    public function update(Request $request, $id, ApiClient $api)
    {
        $request->validate([
            'title' => 'required|string|max:200',
            'start_at' => 'required|date',
            'end_at' => 'nullable|date|after_or_equal:start_at',
            'status' => 'required|in:draft,published',
            'location' => 'nullable|string|max:200',
            'description' => 'nullable|string',
        ]);

        $token = session('api_token');
        $res = $api->put("admin/agendas/{$id}", $request->all(), $token);

        if (!$res->successful() || !$res->json('success')) {
            return back()->withInput()->with('error', $res->json('message') ?? 'Gagal memperbarui agenda.');
        }

        return redirect()->route('admin.agenda.index')->with('success', 'Agenda berhasil diperbarui.');
    }

    public function destroy($id, ApiClient $api)
    {
        $token = session('api_token');
        $res = $api->delete("admin/agendas/{$id}", $token);

        if (!$res->successful() || !$res->json('success')) {
            return back()->with('error', $res->json('message') ?? 'Gagal menghapus agenda.');
        }

        return redirect()->route('admin.agenda.index')->with('success', 'Agenda berhasil dihapus.');
    }
}
