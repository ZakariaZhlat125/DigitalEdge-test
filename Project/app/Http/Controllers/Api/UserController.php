<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordRequest;
use App\Http\Requests\ProfileRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function showInfo()
    {
        // Retrieve the currently authenticated user
        $user = auth()->user();
        // Dump the user object for debugging
        return successResponse('Success', $user, JsonResponse::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateInfo(ProfileRequest $request)
    {
        try {

            $user = auth()->user();
            $user->update($request->all());

            return successResponse('User data updated successfully', $user, JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            return errorResponse('Failed to update user data', null, JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function changePassword(PasswordRequest $request)
    {
        try {
            $user = auth()->user();
            $user->update(['password' => Hash::make($request->get('password'))]);
            return successResponse('Password updated successfully', null, JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            return errorResponse('Failed to update password', null, JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


}
