<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class InstructorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get the user from route parameters
        $user = $request->user(); // Ensure route model binding is working

        if (!$user instanceof User) {
            return response()->json(['message' => 'User with role instructor found'], 404);
        }

        // Check if the user has role 'student'
        if ($user->role === 'instructor') {
            return $next($request);
        }

        return response()->json(['message' => 'Unauthorized - Not a Instructor'], 403);
    }
}
