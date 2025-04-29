<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\InstructorRequest\UpdateRequest;
use App\Http\Requests\InstructorRequestBecomeInstructor\StoreRequest;
use App\Models\User;
use App\Services\Instructor\InstructorRequestService;
use Illuminate\Database\Eloquent\Builder;

class InstructorRequestController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'student')->where(function (Builder $query) {
            $query->where('approve_status', 'pending')->orWhere('approve_status', 'rejected');
        })->select('id', 'name',  'email', 'approve_status', 'document')->get();
        return response()->json($users, 200);
    }

    public function update(UpdateRequest $request, User $user, InstructorRequestService $service)
    {
        $service->update($request->approve_status, $user);
        $service->sendEmail();
        return response()->json($user, 200);
    }

    public function becomeInstructor(StoreRequest $request, User $user, InstructorRequestService $service)
    {
        $service->store($request->file('document'), $user);
        $service->sendEmail();

        return response()->json($user, 200);
    }
}
