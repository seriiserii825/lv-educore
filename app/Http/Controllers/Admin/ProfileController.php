<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\FileUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    use FileUpload;
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users,email,' . $user->id,
            'headline' => 'nullable|string',
            'gender' => 'nullable|in:male,female',
            'bio' => 'nullable|string',
            'facebook' => 'nullable|string',
            'twitter' => 'nullable|string',
            'linkedin' => 'nullable|string',
            'website' => 'nullable|string',
            'github' => 'nullable|string'
        ]);


        $user->update($validated);
        return response()->json($user, 200);
    }

    public function updatePassword(Request $request, User $user)
    {
        $validated = $request->validate([
            'new_password' => 'required|string|min:6',
            'password' => 'required|string|min:6|confirmed',
        ]);
        // Check if the current password is correct
        if ($validated['password'] && !Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'errors' => [
                    'password' => ['The provided password does not match our records.']
                ]
            ], 401);
        }

        // update password
        if ($validated['password']) {
            $validated['password'] = Hash::make($validated['new_password']);
        }

        $user->update($validated);
        return response()->json($user, 200);
    }
    public function updateImage(Request $request, User $user)
    {
        $validated = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $image_path = $this->uploadFile($validated['image']);
        $user->update(['image' => $image_path]);
        return response()->json($user, 200);
    }
}
