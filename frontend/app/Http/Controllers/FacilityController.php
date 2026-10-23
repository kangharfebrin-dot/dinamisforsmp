<?php

namespace App\Http\Controllers;

use App\Services\ApiClient;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    public function index(Request $request, ApiClient $api)
    {
        $profile = $api->get('profile')->json('data') ?? [];
        $facilities = $api->get('facilities')->json('data') ?? [];
        $extracurriculars = $api->get('extracurriculars')->json('data') ?? [];

        return view('facilities.index', compact('profile', 'facilities', 'extracurriculars'));
    }
}
