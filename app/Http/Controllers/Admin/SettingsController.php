<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Settings::first();

        if (!$settings) {
            return response()->json(['message' => 'Settings not found'], 404);
        }

        return response()->json($settings, 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:255',
        ]);

        // Settings::createOrUpdate($validated);
        $settings = Settings::updateOrCreate(
            ['id' => 1], // Assuming you want to update the first record
            $validated
        );

        return response()->json(
            [
                'message' => 'Settings created successfully',
                'settings' => $settings,
            ],
            201
        );
    }
}
