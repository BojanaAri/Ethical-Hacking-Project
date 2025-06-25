<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    // ------------------------------- A03 SQL Injection -----------------------------------
    public function searchUsers(Request $request): object
    {
        $searchTerm = $request->input('search');

        // Directly concatenating user input into SQL (VULNERABLE)
        $users = DB::select("SELECT * FROM users WHERE name = '" . $searchTerm . "'");

        return view('dashboard', ['users' => $users]);
    }

    public function secureSearchUsers(Request $request)
    {
        $validated = $request->validate([
            'search' => 'required|string|max:255'
        ]);

        $users = User::where('name', $validated['search'])->get();

        return view('dashboard', ['users' => $users]);
    }
}
