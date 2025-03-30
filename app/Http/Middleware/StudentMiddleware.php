<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class StudentMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get the user from route parameters
        $user = $request->route('user'); // Ensure route model binding is working

        if (!$user instanceof User) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Check if the user has role 'student'
        if ($user->role === 'student') {
            return $next($request);
        }

        return response()->json(['message' => 'Unauthorized - Not a Student'], 403);
    }
}
