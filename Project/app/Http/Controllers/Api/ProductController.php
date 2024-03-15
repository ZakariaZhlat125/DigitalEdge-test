<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Traits\System\ImageUploadTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{

    use ImageUploadTrait;
    protected $product;
    public function __construct(Product $product)
    {
        $this->product = $product;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $per_page = $request->input('per_page', 5);
        $products = $this->product->paginate($per_page);
        return successResponse('Successfully', $products,  JsonResponse::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {

        $productData = $request->validated();
        $imagePath = $this->uploadImage($request, 'image', 'storage/Product');
        $productData['image'] =  $imagePath;
        $product = $this->product->create($productData);
        return successResponse('Product created Successfully', $product, JsonResponse::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $product = $this->product->findOrFail($id);
            return successResponse('Product retrieved Successfully', $product, JsonResponse::HTTP_OK);
        } catch (ModelNotFoundException  $e) {
            return errorResponse('Product not found', [], JsonResponse::HTTP_NOT_FOUND);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, $id)
    {
        try {
            $product = $this->product->findOrFail($id);

            // Validate incoming request data
            $data = $request->validated();

            // Check if a new image is being uploaded
            if ($request->hasFile('image')) {
                // Delete old image
                if ($product->image) {
                    $this->deleteOldImage($product->image);
                }
                // Upload new image
                $imagePath = $this->uploadImage($request, 'image', 'storage/Product');
                $data['image'] = $imagePath;
            }

            // Update product data
            $product->update($data);

            return successResponse('Product updated successfully', $product, JsonResponse::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return errorResponse('Product not found', null, JsonResponse::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            return errorResponse('Failed to update product', null, JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $product = $this->product->findOrFail($id);
            $this->deleteOldImage($product->image);
            $product->delete();
            return successResponse('Product Deleted Successfully', null,  JsonResponse::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return errorResponse('Product not found', JsonResponse::HTTP_NOT_FOUND);
        }
    }
}
