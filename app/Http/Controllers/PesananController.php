<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PesananController extends Controller
{
    public function index()
    {
        $pesanans = Pemesanan::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();

        return view('pesanan.index', compact('pesanans'));
    }
}
