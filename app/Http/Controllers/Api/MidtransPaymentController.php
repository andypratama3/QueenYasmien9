<?php

namespace App\Http\Controllers\Api;

use App\Models\Pemesanan;
use App\Models\Product;
use App\Models\ProductReseller;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MidtransPaymentController extends Controller
{
    public function callback(Request $request)
    {
        if ($request->isMethod('GET')) {
            return response()->json(['message' => 'OK'], 200);
        }

        try {
            $midtransResponse = $request->all();

            if (!isset($midtransResponse['order_id'])) {
                return response()->json(['message' => 'Invalid request, order_id not found'], 400);
            }

            $pesanan = Pemesanan::where('order_id', $midtransResponse['order_id'])->first();

            if (!$pesanan) {
                return response()->json(['message' => 'Pesanan Tidak Ditemukan'], 404);
            }

            $data = [
                'transaction_status' => $midtransResponse['transaction_status'] ?? null,
                'transaction_id' => $midtransResponse['transaction_id'] ?? null,
                'transaction_time' => $midtransResponse['transaction_time'] ?? null,
                'fraud_status' => $midtransResponse['fraud_status'] ?? 'accept',
            ];

            if (isset($midtransResponse['payment_type'])) {
                switch ($midtransResponse['payment_type']) {
                    case 'bank_transfer':
                        $data['bank'] = $midtransResponse['va_numbers'][0]['bank'] ?? null;
                        $data['va_number'] = $midtransResponse['va_numbers'][0]['va_number'] ?? null;
                        break;
                    case 'credit_card':
                        $data['bank'] = $midtransResponse['bank'] ?? null;
                        break;
                    case 'qris':
                        $data['bank'] = $midtransResponse['acquirer'] ?? null;
                        break;
                    case 'gopay':
                    case 'shopeepay':
                        $data['bank'] = $midtransResponse['issuer'] ?? null;
                        break;
                    case 'cstore':
                        $data['bank'] = $midtransResponse['store'] ?? null;
                        $data['va_number'] = $midtransResponse['payment_code'] ?? null;
                        break;
                    default:
                        return response()->json(['message' => 'Unsupported payment type'], 400);
                }
            }

            if (in_array($data['transaction_status'], ['settlement', 'capture'])) {
                $data['transaction_status'] = 'settlement';
                $products = $pesanan->products;

                foreach ($products as $product) {
                    if (!$product) {
                        return response()->json(['message' => 'Produk tidak ditemukan'], 404);
                    }

                    if ($product->category->name == "Paket Reseller") {
                        $product_reseller = ProductReseller::where('product_id', $product->id)
                            ->where('id', $pesanan->products_reseller_id)
                            ->first();

                        if ($product_reseller) {
                            $product = Product::where('id', $product_reseller->product_id)->first();
                            $product->stock -= $pesanan->products->first()->pivot->qty;
                            $product->save();
                        }
                    }

                    $product->stock -= $pesanan->products->first()->pivot->qty;
                    $product->save();
                }
            }

            if (in_array($pesanan->transaction_status, ['expire', 'cancel'])) {
                $data['transaction_status'] = 'expire';
            }

            $pesanan->update([
                'status_pembayaran' => $data['transaction_status'],
                'status_pemesanan' => 'proses',
            ]);

            return response()->json(['message' => 'Payment data updated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }
}

