<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductsController extends Controller
{
    public function show()
    {
        $products = Product::get();
        return view('products.show', compact('products'));
    }
}