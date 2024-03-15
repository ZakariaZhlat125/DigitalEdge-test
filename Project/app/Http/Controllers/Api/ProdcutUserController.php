<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;

class ProdcutUserController extends Controller
{
    protected $user;
    protected $product;
    protected $productUser;

    public function __construct(User $user, Product $product)
    {
        $this->user = $user;
        $this->product = $product;
    }

    // assign prodcuts to Users
    public function assignProductToUser(Request $request )
    {
        $validator = Validator::make($request->all(), [
            'product_id' => ['required', 'exists:products,id'],
            'userId'=> ['required', 'exists:users,id'],
        ]);

        if ($validator->fails()) {
            return errorResponse('Error in validation', [], JsonResponse::HTTP_BAD_REQUEST);
        }

        try {
            $user = $this->user->findOrFail($request->userId);

            if ($user->products()->where('products.id', $request->product_id)->exists()) {
                return errorResponse('Product is already assigned to the user', [], JsonResponse::HTTP_CONFLICT);
            }

            $user->products()->attach($request->product_id);
            return successResponse('Product assigned to user successfully', [], JsonResponse::HTTP_OK);
        } catch (QueryException $e) {
            return errorResponse('Database error', [], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Exception $e) {
            return errorResponse('Unexpected error', [], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // show user products with paginate
    public function getUserProducts(Request $request)
    {
        // Check if there's an authenticated user
        if (!auth()->check()) {
            return errorResponse('User not authenticated', [], JsonResponse::HTTP_UNAUTHORIZED);
        }

        // Get the authenticated user
        $user = auth()->user();

        // Check if the user has products
        if (!$user) {
            return errorResponse('User not found', [], JsonResponse::HTTP_NOT_FOUND);
        }

        // Paginate the user's products
        $perPage = $request->input('per_page', 10);
        $products = $user->products()->paginate($perPage);

        return successResponse('Success', $products, JsonResponse::HTTP_OK);
    }
}
