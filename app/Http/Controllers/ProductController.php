<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return view('product.index');
    }

    public function show(Request $request)
    {
        $product = Product::with('category', 'product_reseller')->findOrFail($request->product_id);

        // Pre-format the price using PHP's number_format
        $product->price_formatted = number_format($product->price, 0, ',', '.');

        // If product category is "Paket Reseller", you can also format the reseller prices
        $product_resellers = [];
        if ($product->category && $product->category->name === 'Paket Reseller') {
            $product_resellers = $product->product_reseller->map(function ($reseller) {
                $reseller->price_formatted = number_format($reseller->price_reseller, 0, ',', '.');
                return $reseller;
            });
        }

        return response()->json([
            'status' => 'success',
            'data' => $product,
            'product_resellers' => $product_resellers
        ]);
    }



}
