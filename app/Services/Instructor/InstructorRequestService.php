<?php

namespace App\Services\Instructor;

use App\Mail\InstructorRejectRequestEmail;
use App\Mail\InstructorRequestEmail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class InstructorRequestService
{
    private $user;
    private $approve_status;

    public function store(string $approve_status, User $user)
    {
        $this->approve_status = $approve_status;
        $this->user = $user;

        if ($this->approve_status === 'approved') {
            $this->user->role = 'instructor';
        } else {
            $this->user->role = 'student';
        }
        $this->user->approve_status = $this->approve_status;
        $this->user->login_as = 'instructor';
        $this->user->save();
    }
    public function sendEmail()
    {
        if ($this->approve_status === 'rejected') {
            if (config('mail_queue.is_queue')) {
                Mail::to($this->user->email)->queue(new InstructorRejectRequestEmail($this->user));
            } else {
                Mail::to($this->user->email)->send(new InstructorRejectRequestEmail($this->user));
            }
            return response()->json($this->user, 200);
        }
        if (config('mail_queue.is_queue')) {
            Mail::to($this->user->email)->queue(new InstructorRequestEmail($this->user));
        } else {
            Mail::to($this->user->email)->send(new InstructorRequestEmail($this->user));
        }
    }
}
