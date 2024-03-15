<?php

namespace App\Http\Controllers\Api\Auth;



use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Mail\VerificationCodeMail;
use App\Models\User;
use App\Models\UserRegisterToken;
use App\Traits\User\AuthTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthContoller extends Controller
{
    //
    use AuthTrait;


    protected $user;
    protected $userRegisterToken;
    public function __construct(User $user, UserRegisterToken $userRegisterToken)
    {
        $this->user = $user;
        $this->userRegisterToken = $userRegisterToken;
    }

    // Rigister
    public  function register(RegisterRequest $request)
    {
        try {
            $userData = $request->validated();
            $existingUser = $this->checkExistingUser($userData);
            if ($existingUser) {
                return errorResponse('User already exists.', [], JsonResponse::HTTP_CONFLICT);
            }

            $user = $this->createUser($userData);
            if (!isset($userData['phone'])) {
                $this->sendEmail($user, VerificationCodeMail::class, $user->verification_code);
                return successResponse('User created successfully. Please check your email for the verification code.', $user, JsonResponse::HTTP_CREATED);
            }
            return successResponse('User created successfully.', $user, JsonResponse::HTTP_CREATED);
        } catch (\Exception $e) {
            return errorResponse('Failed to verify code.', [], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function login(LoginRequest $request)
    {
        try {
            $credentials = $request->validated();
            if ($token = Auth::attempt($credentials)) {
                $user = Auth::user();
                $token = JWTAuth::fromUser($user);
                return successResponse('Login successfully', ['user' => $user, 'token' => $token], JsonResponse::HTTP_OK);
            } else {
                return errorResponse('Unauthorized', [], JsonResponse::HTTP_UNAUTHORIZED);
            }
        } catch (\Exception $e) {
            return errorResponse('Internal Server Error.', [], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function verifyCode(Request $request)
    {
        try {
            $verificationCode = $request->input('token');
            $email = $request->input('email');

            $user  = $this->user->where('email', $email)->first();
            $userRegister = $this->userRegisterToken->where('email', $email)->first();

            if (!$userRegister) {
                return errorResponse('User not found', [], JsonResponse::HTTP_NOT_FOUND);
            }

            if ($this->isValidVerificationCode($userRegister, $verificationCode)) {
                $this->markUserAsVerified($user);
                $userRegister->where('email', $email)->delete();
                return successResponse('Verification successful. You can now log in.', [], JsonResponse::HTTP_OK);
            } else {
                return errorResponse('Invalid verification code.', [], JsonResponse::HTTP_BAD_REQUEST);
            }
        } catch (\Exception $e) {
            return errorResponse('Failed to verify code.', [], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    //******************* This helper Method *******************//
    private function checkExistingUser(array $userData)
    {
        if (isset($userData['email']) && isset($userData['phone'])) {
            return $this->user->where('email', $userData['email'])
                ->orWhere('phone', $userData['phone'])
                ->first();
        } elseif (isset($userData['email'])) {
            return $this->user->where('email', $userData['email'])->first();
        }
        return null;
    }

    // create new user
    private function createUser(array $userData)
    {
        $verificationCode = $this->generateVerificationCode();
        $this->userRegisterToken->updateOrCreate([
            'email' => $userData['email'],
            'token' => $verificationCode
        ]);

        return $this->user->create($userData);
    }
}
