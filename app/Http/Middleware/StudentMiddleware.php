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
        // if user is from route or auth
        $user = $request->route('user') ?? $request->user();

        if (!$user instanceof User) {
            return response()->json(['message' => 'User with role student not found'], 404);
        }

        // Check if the user has role 'student'
        if ($user->role === 'student') {
            return $next($request);
        }

        return response()->json(['message' => 'Unauthorized - Not a Student'], 403);
    }
}
