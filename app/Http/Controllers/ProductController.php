<?php

namespace App\Http\Controllers;

use App\Models\Product;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    
    public function index()
    {
       return view('shop');

    }

//     public function search(Request $request)
// {
//     $query = $request->get('q', '');

//     if (strlen($query) < 2) {
//         return response()->json([]); 
//     }

//     $products = Product::where('name', 'LIKE', "%{$query}%")
//         ->take(5)
//         ->get(['id', 'name', 'price', 'image']); 

//     return response()->json($products);
// }

    public function show()
    {
        // $product = Product::findOrFail($id);
        return view('product');

    }


}
