<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

class ApiClient
{
    protected string $baseUrl;
    protected int $timeout;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('services.api.base_url', env('API_BASE_URL', 'http://localhost:5000/api')), '/');
        $this->timeout = (int) config('services.api.timeout', env('API_TIMEOUT', 10));
    }

    public function get(string $uri, array $query = [], ?string $token = null): Response
    {
        return $this->request('GET', $uri, $query, [], $token);
    }

    public function post(string $uri, array $data = [], ?string $token = null, bool $multipart = false): Response
    {
        return $this->request('POST', $uri, [], $data, $token, $multipart);
    }

    public function put(string $uri, array $data = [], ?string $token = null, bool $multipart = false): Response
    {
        return $this->request('PUT', $uri, [], $data, $token, $multipart);
    }

    public function delete(string $uri, ?string $token = null): Response
    {
        return $this->request('DELETE', $uri, [], [], $token);
    }

    private function request(string $method, string $uri, array $query = [], array $data = [], ?string $token = null, bool $multipart = false): Response
    {
        $cleanUri = ltrim($uri, '/');
        $url = "{$this->baseUrl}/{$cleanUri}";

        $http = Http::timeout($this->timeout)
            ->acceptJson();

        if ($token) {
            $http = $http->withToken($token);
        }

        try {
            if ($multipart) {
                $parts = [];
                foreach ($data as $key => $value) {
                    if ($value instanceof UploadedFile) {
                        $parts[] = [
                            'name'     => $key,
                            'contents' => fopen($value->getRealPath(), 'r'),
                            'filename' => $value->getClientOriginalName(),
                        ];
                    } elseif ($value !== null) {
                        $parts[] = [
                            'name'     => $key,
                            'contents' => (string) $value,
                        ];
                    }
                }
                $response = $http->asMultipart()->post($url, $parts);
            } else {
                $response = $http->send($method, $url, [
                    'query' => $query,
                    'json'  => !empty($data) ? $data : null,
                ]);
            }

            return $response;
        } catch (\Exception $e) {
            Log::error("ApiClient connection error to {$url}: " . $e->getMessage());
            
            // Return dummy failed response to prevent 500 fatal page crash
            return new Response(
                new \GuzzleHttp\Psr7\Response(
                    503,
                    ['Content-Type' => 'application/json'],
                    json_encode([
                        'success' => false,
                        'message' => 'Layanan API tidak dapat dijangkau. Pastikan server backend aktif.',
                        'data'    => null,
                    ])
                )
            );
        }
    }

    /**
     * Helper to resolve backend image / upload URLs
     */
    public static function assetUrl(?string $path, string $fallback = ''): string
    {
        if (empty($path)) {
            return $fallback;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        $backendHost = rtrim(str_replace('/api', '', config('services.api.base_url', 'http://localhost:5000')), '/');
        return $backendHost . '/' . ltrim($path, '/');
    }
}
