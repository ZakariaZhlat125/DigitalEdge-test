<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Traits\System\ImageUploadTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ImageUploadTrait;
    protected $product;

    public function  __construct(Product $product)
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
        return view('Products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('Products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        try {
            // Validate the incoming request using the rules defined in ProductRequest
            $validatedData = $request->validated();

            // Upload image
            $imagePath = $this->uploadImage($request, 'image', 'storage/Product');

            // Add the image path to the validated data
            $validatedData['image'] = $imagePath;

            // Create product
            $product = $this->product->create($validatedData);

            return redirect()->route('products.index')->with('success', 'Product created successfully');
        } catch (\Exception $e) {
            // Redirect back with error message if an exception occurs
            return redirect()->back()->with('error', 'Error creating product');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $product  = $this->product->findOrFail($id);
            return view('Products.show', compact('product'));
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Product Not found');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
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

            return redirect()->route('products.index')->with('success', 'Products Updates successfully');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Product Not found');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error Create Products');
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
            return redirect()->route('products.index')->with('success', 'Products Deleted successfully');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Product Not found' . $e->getMessage());
        }
    }
}
