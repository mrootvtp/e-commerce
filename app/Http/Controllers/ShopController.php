<?php

namespace App\Http\Controllers;
use App\Models\Product;

use Illuminate\Http\Request;

class ShopController extends Controller
{
    
    public function show()
        {
        
        $products = Product::paginate(9);

        return view('shop', compact('products'));
        
        }

}
