<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the user profile.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    /**
     * Show the form for editing the profile.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Update the user profile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'nik' => 'required|string|max:20',
            'company_name' => 'required|string|max:255',
            'unit' => 'required|string|max:100',
            'position' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
        ]);
        
        // Get the current authenticated user ID
        $userId = Auth::id();
        
        // Update using DB facade instead of model's save method
        DB::table('users')
            ->where('id', $userId)
            ->update([
                'full_name' => $validated['full_name'],
                'nik' => $validated['nik'],
                'company_name' => $validated['company_name'],
                'unit' => $validated['unit'],
                'position' => $validated['position'],
                'telephone' => $validated['telephone'],
                'updated_at' => now(),
            ]);

        return redirect()->route('profile.index')->with('success', 'Profile updated successfully');
    }
}