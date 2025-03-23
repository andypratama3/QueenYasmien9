<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;

class PesananController extends Controller
{
    public function index()
    {
        $pesanans = Pemesanan::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();

        return view('pesanan.index', compact('pesanans'));
    }

    public function pay(Request $request)
    {
        $pesanan = Pemesanan::findOrFail($request->id);

        // Konfigurasi Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false); // Pastikan ada nilai default
        Config::$isSanitized = true;
        Config::$is3ds = true;


        if($pesanan->snap_token == null){
            $itemDetails = [];
            foreach ($pesanan->products as $product) {
                $itemDetails[] = [
                    'id' => $product->id,
                    'price' => $product->price,
                    'quantity' => $product->pivot->qty ?? 1,
                    'name' => $product->name,
                ];
            }

            $params = [
                'transaction_details' => [
                    'order_id' => $pesanan->order_id,
                    'gross_amount' => $pesanan->gross_amount,
                ],
                'item_details' => $itemDetails,
                'expiry' => [
                    'unit' => 'days',
                    'duration' => 20,
                ],
            ];

            // Generate Snap Token
            $snapToken = Snap::getSnapToken($params);
            // update order_id when new
            $pesanan->snap_token = $snapToken;
            $pesanan->save();
        } else {
            $snapToken = $pesanan->snap_token;
        }

        return response()->json(['snap_token' => $snapToken]); // Kembalikan token untuk digunakan di frontend
    }

    public function show($order_id)
    {
        if(Auth::check()) {
            // check order_id
            $pesanan = Pemesanan::where('order_id', $order_id)->where('user_id', Auth::id())->firstOrFail();

            return view('pesanan.show', compact('pesanan'));
        }
    }
}
