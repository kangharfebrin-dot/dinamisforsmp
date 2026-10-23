<?php

namespace App\Http\Controllers;

use App\Services\ApiClient;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    public function index(Request $request, ApiClient $api)
    {
        $profile = $api->get('profile')->json('data') ?? [];
        $agendas = $api->get('agendas', ['status' => 'published'])->json('data') ?? [];

        return view('agendas.index', compact('profile', 'agendas'));
    }

    public function show($id, ApiClient $api)
    {
        $profile = $api->get('profile')->json('data') ?? [];
        $agenda = $api->get("agendas/{$id}")->json('data');

        if (!$agenda) {
            abort(404, 'Agenda tidak ditemukan.');
        }

        return view('agendas.show', compact('profile', 'agenda'));
    }
}
