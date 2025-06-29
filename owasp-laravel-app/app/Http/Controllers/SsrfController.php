<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SsrfController extends Controller
{
    // Vulnerable SSRF endpoint - fetches any URL without validation
    public function fetchUrl(Request $request)
    {
        $url = $request->input('url');

        try {
            // BAD: Directly fetching user-provided URL without validation
            $response = Http::get($url);

            return response()->json([
                'status' => 'success',
                'content' => $response->body(),
                'headers' => $response->headers()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // Secure SSRF endpoint - with validation and allowlist
    public function fetchUrlSecure(Request $request)
    {
        $request->validate([
            'url' => 'required|url'
        ]);

        $url = $request->input('url');
        $parsedUrl = parse_url($url);

        // Define allowed domains (adjust as needed)
        $allowedDomains = [
            'api.example.com',
            'trusted-service.com'
        ];

        // Check if the domain is allowed
        if (!in_array($parsedUrl['host'], $allowedDomains)) {
            Log::warning("SSRF attempt blocked for URL: $url");
            return response()->json([
                'status' => 'error',
                'message' => 'Access to the requested domain is not allowed'
            ], 403);
        }

        // Additional security checks
        if (isset($parsedUrl['port']) && $parsedUrl['port'] != 80 && $parsedUrl['port'] != 443) {
            return response()->json([
                'status' => 'error',
                'message' => 'Access to non-standard ports is not allowed'
            ], 403);
        }

        try {
            // GOOD: Fetching with timeout and proper error handling
            $response = Http::timeout(5)
                ->withOptions([
                    'verify' => true, // Enable SSL verification
                ])
                ->get($url);

            return response()->json([
                'status' => 'success',
                'content' => $response->body(),
                'headers' => $response->headers()
            ]);
        } catch (\Exception $e) {
            Log::error("SSRF secure fetch failed: " . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch the URL'
            ], 500);
        }
    }

    // Demo page to show SSRF examples
    public function demo()
    {
        return view('ssrf_demo');
    }
}
