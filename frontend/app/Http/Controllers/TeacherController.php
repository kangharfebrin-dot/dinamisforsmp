<?php

namespace App\Http\Controllers;

use App\Services\ApiClient;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index(Request $request, ApiClient $api)
    {
        $profile = $api->get('profile')->json('data') ?? [];
        $type = $request->query('type');
        $teachers = $api->get('teachers', array_filter(['type' => $type]))->json('data') ?? [];

        return view('guru.index', compact('profile', 'teachers', 'type'));
    }
}
