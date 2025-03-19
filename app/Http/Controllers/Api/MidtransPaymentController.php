<?php

namespace App\Http\Controllers\Api;

use App\Models\Pemesanan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MidtransPaymentController extends Controller
{
    public function callback(Request $request)
    {
        // retrun response oke for receive midtrans notification

        if ($request->isMethod('GET')) {
            return response()->json(['message' => 'OK'], 200);
        }


        try {
            $midtransResponse = $request->all();

            // if (isset($midtransResponse['status_code']) && in_array($midtransResponse['status_code'], ['202', '300', '401', '405'])) {
            //     DB::table('error_log')->insert([
            //         'status_code' => $midtransResponse['status_code'],
            //         'error' => $midtransResponse['status_message'] ?? 'Unknown error',
            //         'created_at' => now(),
            //         'updated_at' => now(),
            //     ]);
            // }

            if (!isset($midtransResponse['order_id'])) {
                return response()->json(['message' => 'Invalid request, order_id not found'], 400);
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

            $pesanan = Pemesanan::where('order_id', $midtransResponse['order_id'])->first();

            if (!$pesanan) {
                return response()->json(['message' => 'Pesanan Tidak Ada'], 404);
            }

            if (in_array($data['transaction_status'], ['settlement', 'capture'])) {
                $data['transaction_status'] = 'selesai';
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
