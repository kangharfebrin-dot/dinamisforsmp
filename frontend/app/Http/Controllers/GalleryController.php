<?php

namespace App\Http\Controllers;

use App\Services\ApiClient;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(Request $request, ApiClient $api)
    {
        $profile = $api->get('profile')->json('data') ?? [];
        $albums = $api->get('albums')->json('data') ?? [];
        $galleries = $api->get('galleries')->json('data') ?? [];

        return view('gallery.index', compact('profile', 'albums', 'galleries'));
    }
}
