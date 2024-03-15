<?php

namespace App\Traits\User;

use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;


trait AuthTrait
{
    /**
     * Create token for the given user.
     *
     * @param \App\User $user
     * @return JsonResponse
     */
    public function createToken($user): JsonResponse
    {
        // Create Token
        $token = JWTAuth::fromUser($user);

        // Response
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 3600,
        ]);
    }


    /**
     * Respond with the token array structure.
     *
     * @param string $token
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken(string $token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 3600,
        ]);
    }


    protected function generateVerificationCode()
    {
        return str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);;
    }


    protected function sendEmail($user, $mailClassName, $token)
    {
        $mailClass = new $mailClassName($token);
        Mail::to($user->email)->send($mailClass);
    }


    // Check if the provided verification code is valid
    protected function isValidVerificationCode($userRegister, $verificationCode)
    {
        return $userRegister &&$userRegister->token === $verificationCode;
    }

    // Mark user as verified
    protected function markUserAsVerified($user)
    {
        $user->update(['verified' => true, 'email_verified_at' => now()]);
    }
}
