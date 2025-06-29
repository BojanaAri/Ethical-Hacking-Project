<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SoftwareIntegrityController extends Controller
{
    // Vulnerable: Downloads and executes code without verification
    public function insecureUpdate(Request $request)
    {
        $updateUrl = $request->input('update_url', 'https://example.com/updates/latest.zip');

        // BAD: Download and execute update without verification
        try {
            $response = Http::withoutVerifying()->get($updateUrl);
            $updateScript = $response->body();

            // Even worse: directly evaluating the downloaded code
            eval($updateScript);

            return back()->with('status', 'System updated successfully (INSECURE!)');
        } catch (\Exception $e) {
            Log::error("Insecure update failed: " . $e->getMessage());
            return back()->with('error', 'Update failed: ' . $e->getMessage());
        }
    }

    // Secure: Verifies update with checksum and signature
    public function secureUpdate(Request $request)
    {
        $updateUrl = 'https://example.com/updates/latest.zip';
        $signatureUrl = 'https://example.com/updates/latest.sig';
        $checksum = 'a1b2c3d4e5f6...'; // Known good checksum

        try {
            // Download update
            $response = Http::withOptions(['verify' => true])->get($updateUrl);
            $updateContent = $response->body();

            // Verify checksum
            $downloadedChecksum = hash('sha256', $updateContent);
            if ($downloadedChecksum !== $checksum) {
                throw new \Exception("Checksum verification failed");
            }

            // Verify signature (pseudo-code)
            $signature = Http::withOptions(['verify' => true])->get($signatureUrl)->body();
            if (!$this->verifySignature($updateContent, $signature)) {
                throw new \Exception("Signature verification failed");
            }

            // Safe update process would go here
            return back()->with('status', 'System updated securely after verification');
        } catch (\Exception $e) {
            Log::error("Secure update failed: " . $e->getMessage());
            return back()->with('error', 'Update failed: ' . $e->getMessage());
        }
    }

    private function verifySignature($data, $signature)
    {
        // In a real app, this would verify using proper cryptographic signatures
        return true; // Simplified for demo
    }

    // Vulnerable: Processes serialized data without validation
    public function processSerializedData(Request $request)
    {
        $data = $request->input('serialized_data');

        // BAD: Unserializing user input directly
        $decoded = unserialize($data);

        return response()->json([
            'result' => $decoded,
            'status' => 'Processed serialized data (INSECURE!)'
        ]);
    }

    // Secure: Processes data with JSON instead of serialization
    public function processJsonData(Request $request)
    {
        $data = $request->input('json_data');

        // GOOD: Using JSON instead of serialization
        $decoded = json_decode($data, true);

        return response()->json([
            'result' => $decoded,
            'status' => 'Processed JSON data securely'
        ]);
    }
}
