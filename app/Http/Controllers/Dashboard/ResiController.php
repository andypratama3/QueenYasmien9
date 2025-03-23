<?php

namespace App\Http\Controllers\Dashboard;

use PDF;
use App\Models\Pemesanan;
use Illuminate\Http\Request;
use BaconQrCode\Encoder\QrCode;
use App\Http\Controllers\Controller;

class ResiController extends Controller
{
    public function cetakResi($slug)
    {
        $pemesanan = Pemesanan::where('slug', $slug)->with('products')->firstOrFail();
        $qrCode = route('pesanan.detail', $pemesanan->order_id);

        // Load tampilan resi
        return view('dashboard.pemesanan.resi', compact('pemesanan','qrCode'));

        // Atur ukuran kertas & orientasi
        // $pdf->setPaper('A4', 'portrait');

        // return $pdf->stream('resi-pengiriman-'.$pemesanan->order_id.'.pdf');
    }
}
