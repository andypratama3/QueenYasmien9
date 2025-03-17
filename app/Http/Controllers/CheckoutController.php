<?php

namespace App\Http\Controllers;

use Exception;
use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Chart;
use App\Models\Product;
use App\Models\Pemesanan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProductReseller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'alamat' => 'required|string',
            'pengiriman' => 'required|string',
        ]);

        $items = $request->items;
        $quantities = $request->qty; // Ambil qty dari request
        $selectedReseller = $request->selected_reseller;
        $isReseller = !empty($selectedReseller);
        $totalAmount = 0;

        DB::beginTransaction();
        try {
            $products = Product::whereIn('id', $items)->get()->keyBy('id');

            if ($products->count() !== count($items)) {
                return response()->json(['error' => 'Beberapa produk tidak ditemukan'], 400);
            }

            $productResellers = $isReseller
                ? ProductReseller::whereIn('product_id', $items)
                    ->where('id', $selectedReseller)
                    ->get()
                    ->keyBy('product_id')
                : collect();

            foreach ($items as $index => $item) {
                $product = $products[$item] ?? null;
                $qty = $quantities[$index] ?? 1; // Ambil qty dari array, default 1

                if (!$product) {
                    return response()->json(['error' => "Produk dengan ID $item tidak ditemukan"], 400);
                }

                if ($product->stock < $qty) {
                    return response()->json(['error' => "Stok untuk produk {$product->name} tidak mencukupi"], 400);
                }

                $price = optional($productResellers->get($item))->price_reseller ?? $product->price;
                $totalAmount += $price * $qty; // Perhitungan harga sesuai qty
            }

            // Konfigurasi Midtrans
            Config::$serverKey = env('MIDTRANS_SERVER_KEY');
            Config::$isProduction = env('MIDTRANS_IS_PRODUCTION');
            Config::$isSanitized = true;
            Config::$is3ds = true;


            $order_id = Str::uuid();
            $params = [
                'transaction_details' => [
                    'order_id' => $order_id,
                    'gross_amount' => $totalAmount,
                ],
                'item_details' => array_map(function ($index) use ($products, $productResellers, $isReseller, $quantities, $items) {
                    $product = $products[$items[$index]];
                    $price = optional($productResellers->get($items[$index]))->price_reseller ?? $product->price;
                    $qty = $quantities[$index] ?? 1; // Ambil qty

                    return [
                        'id' => $product->id,
                        'price' => $price,
                        'quantity' => $qty, // Gunakan qty di item details
                        'name' => $product->name,
                    ];
                }, array_keys($items)),
                'expiry' => [
                    "unit" => "days",
                    "duration" => 20,
                ],
            ];

            $snapToken = Snap::getSnapToken($params);

            $pemesanan = Pemesanan::create([
                'gross_amount' => $totalAmount,
                'pengiriman' => $request->pengiriman,
                'status_pemesanan' => 'pending',
                'status_pembayaran' => 'pending',
                'alamat' => $request->alamat,
                'user_id' => Auth::id(),
                'slug' => Str::slug(implode('-', $items) . '-' . now()->timestamp),
                'products_reseller_id' => $isReseller && $productResellers->isNotEmpty() ? $productResellers->first()->id : null,
                'snap_token' => $snapToken ?? null,
                'order_id' => $order_id,
            ]);

            // Simpan produk ke dalam pemesanan dengan qty
            $syncData = [];
            foreach ($items as $index => $item) {
                $syncData[$item] = ['qty' => $quantities[$index] ?? 1];
            }


            $pemesanan->products()->sync($syncData);

            Chart::whereIn('product_id', $items)->delete();

            DB::commit();
            return response()->json(['success' => 'Produk berhasil diproses', 'data' => $pemesanan, 'snap_token' => $snapToken]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }

    }
}
