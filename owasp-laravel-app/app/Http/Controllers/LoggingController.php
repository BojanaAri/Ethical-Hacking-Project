<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class LoggingController extends Controller
{
    // Insecure logging example (vulnerable)
    public function insecureLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // BAD: Logging sensitive information in plaintext
        Log::info("Login attempt with credentials: " . json_encode($credentials));

        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    // Secure logging example
    public function secureLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // GOOD: Logging only non-sensitive information
        Log::info("Login attempt for email: " . $request->email, [
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        if (Auth::attempt($credentials)) {
            // GOOD: Log successful login with context but no credentials
            Log::info("User logged in", [
                'user_id' => Auth::id(),
                'ip' => $request->ip()
            ]);

            return redirect()->intended('dashboard');
        }

        // GOOD: Log failed attempt without credentials
        Log::warning("Failed login attempt", [
            'email' => $request->email,
            'ip' => $request->ip()
        ]);

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    // Example of missing critical event logging (vulnerable)
    public function insecureAdminAction(Request $request)
    {
        // Perform sensitive admin action without logging

        return response()->json(['message' => 'Action completed']);
    }

    // Example of proper critical event logging
    public function secureAdminAction(Request $request)
    {
        // Perform sensitive admin action

        // GOOD: Log the critical action with all relevant context
        Log::channel('security')->info("Admin action performed", [
            'action' => 'user_permissions_change',
            'admin_id' => Auth::id(),
            'target_user' => $request->user_id,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'changes' => $request->except('_token')
        ]);

        return response()->json(['message' => 'Action completed']);
    }

    // Example of log injection vulnerability
    public function logInjection(Request $request)
    {
        $userInput = $request->input('search');
        $processedInput = str_replace('\n', "\n", $userInput); // Convert literal \n to actual newline
        $processedInput = str_replace('\r', "\r", $processedInput);
        // BAD: Directly logging user input without sanitization
        Log::info("User search: " . $processedInput);

        return back()->with('status', 'Insecure log attempt processed. Check logs!');
    }

    // Example of proper log sanitization
    public function safeLogging(Request $request)
    {
        $userInput = $request->input('search');

        // GOOD: Sanitizing log output
        $sanitizedInput = preg_replace('/[\r\n]/', '', $userInput);
        Log::info("User search: " . $sanitizedInput);

        return back();
    }
}
