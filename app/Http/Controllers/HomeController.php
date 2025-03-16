<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categorys = Category::orderBy('name', 'asc')->get();
        $products = Product::orderBy('created_at','asc')->get();

        $products_best = Product::orderBy('sell_count', 'desc')->limit(10)->get();
        return view('beranda', compact('products', 'categorys','products_best'));
    }
}
