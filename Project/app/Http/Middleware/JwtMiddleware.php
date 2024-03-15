<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next): Response
    {

        try {
            $token = JWTAuth::parseToken()->authenticate();

        } catch (Exception $e) {
            if ($e instanceof UnauthorizedHttpException) {
                // Token not provided or invalid
                return errorResponse('Unauthorized' ,[],JsonResponse::HTTP_UNAUTHORIZED);
                // return response()->json(['error' => 'Unauthorized'], 401);
            }
            // Other exceptions
            return response()->json(['error' => 'Something went wrong'], 500);
        }
        return $next($request);
    }
}
