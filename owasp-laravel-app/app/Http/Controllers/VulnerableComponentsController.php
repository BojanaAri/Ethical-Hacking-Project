<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class VulnerableComponentsController extends Controller
{
    // Demo of using outdated/deprecated components
    public function showOutdatedDependencies()
    {
        // Intentionally using an outdated version check
        $laravelVersion = app()->version();
        $isOutdated = version_compare($laravelVersion, '10.0.0', '<');

        // Simulate using a vulnerable package
        $vulnerablePackage = [
            'name' => 'old/package',
            'version' => '1.2.3',
            'vulnerabilities' => [
                'CVE-2023-1234' => 'Remote Code Execution',
                'CVE-2023-5678' => 'SQL Injection'
            ]
        ];

        return view('vulnerable_components', [
            'laravelVersion' => $laravelVersion,
            'isOutdated' => $isOutdated,
            'vulnerablePackage' => $vulnerablePackage
        ]);
    }

    // Demo of unpatched vulnerability
    public function exploitVulnerability(Request $request)
    {
        // Simulate a vulnerable component (like old XML parser)
        $xml = $request->input('xml');

        // UNSAFE: Using deprecated/unpatched XML parser
        try {
            $parsed = simplexml_load_string($xml);
            return response()->json([
                'status' => 'success',
                'data' => json_decode(json_encode($parsed)),
                'warning' => 'Used vulnerable XML parser!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // Demo of insecure API usage
    public function checkUpdates()
    {
        // UNSAFE: Using HTTP instead of HTTPS for update checks
        $response = Http::get('http://example.com/updates/laravel');

        return $response->json();
    }
}
