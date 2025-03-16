<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index()
    {
        $catalogs = Catalog::orderBy('created_at', 'asc')->get();
        return view('catalog.index', compact('catalogs'));
    }

    public function show($slug)
    {
        $catalog = Catalog::where('slug', $slug)->firstOrFail();
        return view('catalog.show', compact('catalog'));
    }
}
