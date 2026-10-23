<?php

namespace App\Http\Controllers;

use App\Services\ApiClient;

class ProfilController extends Controller
{
    public function index(ApiClient $api)
    {
        $profile = $api->get('profile')->json('data') ?? [];
        return view('profil.index', compact('profile'));
    }

    public function visiMisi(ApiClient $api)
    {
        $profile = $api->get('profile')->json('data') ?? [];
        return view('profil.visi-misi', compact('profile'));
    }

    public function sambutan(ApiClient $api)
    {
        $profile = $api->get('profile')->json('data') ?? [];
        return view('profil.sambutan', compact('profile'));
    }
}
