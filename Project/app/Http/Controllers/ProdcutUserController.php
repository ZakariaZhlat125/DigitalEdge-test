<?php

namespace App\Http\Controllers;

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

    public function __construct(User $user, Product $product)
    {
        $this->user = $user;
        $this->product = $product;
    }

    // show all prodcuts  ass end to user
    public function index()
    {
        // Fetch all users along with their assigned products
        $usersWithProducts = User::with('products')->paginate(2);
        // dd($usersWithProducts);
        return view('ProductUsers.index', compact('usersWithProducts'));
    }


    public function assign()
    {
        $users = $this->user->all();
        $products = $this->product->all();
        return view('ProductUsers.assignProductToUser', compact('users', 'products'));
    }
    // assign prodcuts to Users
    //

    public function assignProductToUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => ['required'],
            'user_id' => ['required'],
        ]);


        if ($validator->fails()) {
            return errorResponse('Error in validation', [], JsonResponse::HTTP_BAD_REQUEST);
        }
        try {

            $user = $this->user->findOrFail($request->user_id);
            if ($user->products()->where('products.id', $request->product_id)->exists()) {
                return  redirect()->route('productsUser.index')->with('error', 'Product is already assigned to the user');
            }
            $user->products()->attach($request->product_id);
            return redirect()->route('productsUser.index')->with('success', 'Product assigned to user successfully');
        } catch (QueryException $e) {
            redirect()->back()->with('error', 'Database error');
        } catch (\Exception $e) {
            // Redirect back with error message if an exception occurs
            return redirect()->back()->with('error', 'Error nexpected error');
        }
    }


    // unassign Product from  user
    public function unassignProductFromUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => ['required'],
            'user_id' => ['required'],
        ]);

        if ($validator->fails()) {
            return errorResponse('Error in validation', [], JsonResponse::HTTP_BAD_REQUEST);
        }

        try {
            $user = $this->user->findOrFail($request->user_id);

            if (!$user->products()->where('products.id', $request->product_id)->exists()) {
                return redirect()->route('productsUser.index')->with('error', 'Product is not assigned to the user');
            }

            // Detach the product from the user
            $user->products()->detach($request->product_id);

            return redirect()->route('productsUser.index')->with('success', 'Product unassigned from user successfully');
        } catch (QueryException $e) {
            return redirect()->back()->with('error', 'Database error');
        } catch (\Exception $e) {
            // Redirect back with error message if an exception occurs
            return redirect()->back()->with('error', 'Unexpected error');
        }
    }



    // show user products with paginate
    public function getUserProducts(Request $request, $userId)
    {
        $user = $this->user->findOrFail($userId);
        $perPage = $request->input('per_page', 10);
        $products = $user->products()->paginate($perPage);

        return successResponse('Success', $products, JsonResponse::HTTP_OK);
    }
}
