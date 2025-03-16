<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Pemesanan;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        // Pastikan items tidak kosong
        if (!$request->has('items') || empty($request->items)) {
            return response()->json(['error' => 'Tidak ada produk yang dipilih'], 400);
        }

        // Ubah string menjadi array
        $items = explode(',', $request->items);
        $totalAmount = 0;

        DB::beginTransaction();

        try {
            foreach ($items as $item) {
                // Ambil data produk
                $product = Product::find($item);

                // Jika produk tidak ada
                if (!$product) {
                    return response()->json(['error' => "Produk dengan ID $item tidak ditemukan"], 400);
                }

                // Jika stok tidak mencukupi
                if ($product->stock < 1) {
                    return response()->json(['error' => "Stok untuk produk {$product->name} tidak mencukupi"], 400);
                }
                // Tambahkan ke total harga
                $totalAmount += $product->price;
            }

            // Simpan pemesanan
            $pemesanan = Pemesanan::create([
                'gross_amount' => $totalAmount,
                'pengiriman' => $request->pengiriman,
            ]);

            DB::commit();
            return response()->json(['success' => 'Produk berhasil diproses', 'data' => $pemesanan]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Terjadi kesalahan saat memproses checkout: ' . $e->getMessage()], 500);
        }
    }
}
