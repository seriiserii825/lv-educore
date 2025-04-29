<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\InstructorRequest\UpdateRequest;
use App\Mail\InstructorRequestEmail;
use App\Models\User;
use App\Services\Instructor\InstructorRequestService;
use App\Traits\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class InstructorRequestController extends Controller
{
    use FileUpload;
    public function index()
    {
        $users = User::where('role', 'student')->where(function (Builder $query) {
            $query->where('approve_status', 'pending')->orWhere('approve_status', 'rejected');
        })->select('id', 'name',  'email', 'approve_status', 'document')->get();
        return response()->json($users, 200);
    }

    public function update(UpdateRequest $request, User $user, InstructorRequestService $service)
    {
        $service->store($request->approve_status, $user);
        $service->sendEmail();
        return response()->json($user, 200);
    }

    public function becomeInstructor(Request $request, User $user)
    {
        $request->validate([
            'document' => 'required|file|mimes:pdf,doc,docx',
        ]);

        $user->document = $this->uploadFile($request->file('document'));
        $user->approve_status = 'pending';
        $user->save();

        if (config('mail_queue.is_queue')) {
            Mail::to($user->email)->queue(new InstructorRequestEmail($user));
        } else {
            Mail::to($user->email)->send(new InstructorRequestEmail($user));
        }

        return response()->json($user, 200);
    }
}
