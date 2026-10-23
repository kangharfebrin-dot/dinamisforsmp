<?php

namespace App\Http\Controllers;

use App\Services\ApiClient;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function index(Request $request, ApiClient $api)
    {
        $profile = $api->get('profile')->json('data') ?? [];
        $category = $request->query('category');
        $query = $category ? ['category' => $category] : [];
        $documents = $api->get('documents', $query)->json('data') ?? [];

        return view('documents.index', compact('profile', 'documents', 'category'));
    }

    public function download($id, ApiClient $api)
    {
        $res = $api->get("documents/{$id}/download")->json();
        if (isset($res['file_path'])) {
            $url = ApiClient::assetUrl($res['file_path']);
            return redirect()->away($url);
        }
        return back()->with('error', 'Dokumen tidak ditemukan.');
    }
}
