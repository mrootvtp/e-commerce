<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class productController extends Controller
{
    
    public function search (Request $request) {
   $query = $request->query('query');

    if (!$query) return [];

    return Product::where('name', 'like', "%{$query}%")
                  ->select('id', 'name', 'price')
                  ->limit(10)
                  ->get();
    }



    public function index()
    {
        $products = Product::latest()->paginate(10);
        return response()->json($products);
    }

    // POST /api/products
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            // 'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048'
        ]);

        // if($request->hasFile('image')) {
        //     $data['image'] = $request->file('image')->store('products', 'public');
        // }

        $product = Product::create($data);

        return response()->json([
            'message' => 'Product created successfully',
            'product' => $product
        ], 201);
    }

    // GET /api/products/{product}
    public function show(Product $product)
    {
        return response()->json($product);
    }

    // PUT/PATCH /api/products/{product}
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            // 'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048'
        ]);

        // if($request->hasFile('image')) {
        //     $data['image'] = $request->file('image')->store('products', 'public');
        // }

        $product->update($data);

        return response()->json([
            'message' => 'Product updated successfully',
            'product' => $product
        ]);
    }

    // DELETE /api/products/{product}
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json([
            'message' => 'Product deleted successfully'
        ]);
    }


}
