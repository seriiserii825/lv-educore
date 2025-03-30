<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class InstructorRequestController extends Controller
{
    public function index()
    {
        $users = User::where('approve_status', 'pending')->orWhere('approve_status', 'rejected')->select('id', 'name', 'approve_status')->get();
        return response()->json($users, 200);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'approve_status' => 'required|in:initial,pending,approved,rejected',
        ]);
        if ($request->approve_status === 'approved') {
            $user->role = 'instructor';
        }
        $user->approve_status = $request->approve_status;
        $user->save();
        return response()->json($user, 200);
    }
}
