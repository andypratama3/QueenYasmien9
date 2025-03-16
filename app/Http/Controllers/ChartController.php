<?php

namespace App\Http\Controllers;

use App\Models\Chart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChartController extends Controller
{
    public function index()
    {
        return view('chart.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'qty' => 'required|integer|min:1',
            'product_id' => 'required|exists:products,id',
        ]);


        if(Auth::check()){

            $product = Product::find($request->product_id);

            // Cek apakah produk ada
            if (!$product) {
                return back()->withErrors(['product_id' => 'Produk tidak ditemukan.']);
            }

            // Cek apakah produk sudah ada di chart user
            $chart = Chart::where('user_id', auth()->id())
                        ->where('product_id', $product->id)
                        ->first();

            if($product->stock < $request->qty){
                return response()->json([
                    'status' => 'error',
                    'message' => "Stok produk $product->name tidak mencukupi."
                ]);
            }


            if ($chart) {
                $chart->update(['qty' => $chart->qty + $request->qty]);
            } else {
                Chart::create([
                    'user_id' => auth()->id(),
                    'product_id' => $product->id,
                    'qty' => $request->qty,
                ]);
            }


            return response()->json([
                'status' => 'success',
                'message' => "Produk $product->name berhasil ditambahkan."
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => "Anda harus login terlebih dahulu."
            ]);
        }

        // return back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function destroy($id)
    {
        $cart = Chart::find($id);


        if ($cart) {
            $cart->delete();
            return response()->json([
                'status' => 'success',
                'message' => "Produk berhasil dihapus."
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => "Produk tidak ditemukan."
            ]);
        }

    }
}
