<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:255',
        ]);

        Settings::create($validated);

        return response()->json(
            [
                'message' => 'Settings created successfully',
                'settings' => $validated,
            ],
            201
        );
    }
}
