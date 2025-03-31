<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\InstructorRejectRequestEmail;
use App\Mail\InstructorRequestEmail;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class InstructorRequestController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'student')->where(function (Builder $query) {
            $query->where('approve_status', 'pending')->orWhere('approve_status', 'rejected');
        })->select('id', 'name', 'approve_status', 'document')->get();
        // $users = User::where('approve_status', 'pending')->orWhere('approve_status', 'rejected')->select('id', 'name', 'approve_status')->get();
        // $users = User::select('id', 'name', 'approve_status')->get();
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

        if ($request->approve_status === 'rejected') {
            if (config('mail_queue.is_queue')) {
                Mail::to($user->email)->queue(new InstructorRejectRequestEmail($user));
            } else {
                Mail::to($user->email)->send(new InstructorRejectRequestEmail($user));
            }
            return response()->json($user, 200);
        }
        if (config('mail_queue.is_queue')) {
            Mail::to($user->email)->queue(new InstructorRequestEmail($user));
        } else {
            Mail::to($user->email)->send(new InstructorRequestEmail($user));
        }

        return response()->json($user, 200);
    }
}
