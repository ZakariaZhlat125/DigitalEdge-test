<?php

namespace App\Http\Controllers\api\Auth;

use App\Http\Controllers\Controller;
use App\Models\PasswordResetToken;
use App\Models\User;
use App\Traits\User\AuthTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Mail\ResetPasswordMail;

class ResetPasswordController extends Controller
{
    use AuthTrait;

    protected $user;
    protected $passwordResetToken;
    public function __construct(User $user, PasswordResetToken $passwordResetToken)
    {
        $this->user = $user;
        $this->passwordResetToken = $passwordResetToken;
    }


    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $user = $this->user->where('email', $request->email)->first();


        if (!$user) {
            return errorResponse('User not found', [], JsonResponse::HTTP_NOT_FOUND);
        }

        $token = $this->generateVerificationCode();

        $this->passwordResetToken->updateOrCreate(
            ['email' => $request->email],
            ['token' => $token, 'created_at' => now()]
        );

        $this->sendEmail($user, ResetPasswordMail::class, $token);

        return successResponse('Password reset email sent', [], JsonResponse::HTTP_OK);
    }



    public function resetPassword(Request $request, $token)
    {
        $passwordResetToken = $this->passwordResetToken->where('token', $token)->first();

        if (!$passwordResetToken) {
            return errorResponse('Invalid or expired token', [], JsonResponse::HTTP_BAD_REQUEST);
        }

        $user = $this->user->where('email',  $passwordResetToken->email)->first();
        if (!$user) {
            return errorResponse('User not found', [], JsonResponse::HTTP_NOT_FOUND);
        }

        $request->validate([
            'password' => 'required|min:6|confirmed',
        ]);

        $user->update(['password' => Hash::make($request->get('password'))]);

        $passwordResetToken->where('token', $token)->delete();
        return successResponse('Password reset successfully', [], JsonResponse::HTTP_OK);
    }
}
