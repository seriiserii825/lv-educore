<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class InstructorRequestController extends Controller
{
    public function index()
    {
        $users = User::where('approve_status', 'pending')->select('id', 'name', 'approve_status')->get();
        return response()->json($users, 200);
    }
}
