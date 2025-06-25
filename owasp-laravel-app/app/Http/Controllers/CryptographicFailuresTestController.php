<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CryptographicFailuresTestController extends Controller
{
    public function storePassword(Request $request): string
    {
        $password = $request->input('password');

        // BAD: Store password in plaintext (vulnerable)
        DB::table('insecure_passwords')->insert([
            'email' => $request->input('email'),
            'password' => $password,
        ]);

        // GOOD: Hash using bcrypt
        DB::table('secure_passwords')->insert([
            'email' => $request->input('email'),
            'password' => Hash::make($password),
        ]);

        return redirect('/crypto-demo');
    }

    public function showStoredPasswords(): object
    {
        $insecure = DB::table('insecure_passwords')->get();
        $secure = DB::table('secure_passwords')->get();

        return view('crypto_demo', [
            'insecurePasswords' => $insecure,
            'securePasswords' => $secure,
        ]);
    }
}
