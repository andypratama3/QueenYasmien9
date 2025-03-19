<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Pemesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class PemesananController extends Controller
{
    public function index()
    {
        return view('dashboard.pemesanan.index');
    }


    public function data_table(Request $request)
    {

        $pemesanan = Pemesanan::with('user')->orderBy('created_at','asc')->where('created_at', '>=', Carbon::now()->subDays(30));

        if ($request->date) {
            $dates = explode(' : ', $request->date);
            $startDate = Carbon::createFromFormat('d-m-Y', trim($dates[0]))->format('Y-m-d');
            $endDate = Carbon::createFromFormat('d-m-Y', trim($dates[1]))->format('Y-m-d');

            $pemesanan = Pemesanan::whereBetween(DB::raw('date(created_at)'), [$startDate, $endDate]);
        }

        if($request->status_pembayaran) {
            $pemesanan = $pemesanan->where('status_pembayaran', $request->status_pembayaran);
        }

        if($request->status_pemesanan) {
            $pemesanan = $pemesanan->where('status_pemesanan', $request->status_pemesanan);
        }

        return DataTables::of($pemesanan)
        ->addColumn('user', function ($row) {
            return $row->user->name;
        })
        ->addColumn('status_pemesanan', function ($row) {
            if($row->status_pemesanan == 'pending'){
                return '<span class="badge bg-warning">Pending</span>';
            } elseif($row->status_pemesanan == 'selesai'){
                return '<span class="badge bg-success">Selesai</span>';
            } elseif($row->status_pemesanan == 'batal'){
                return '<span class="badge bg-danger">Batal</span>';
            } elseif($row->status_pemesanan == 'pengiriman') {
                return '<span class="badge bg-secondary">Pengiriman</span>';
            } elseif($row->status_pemesanan = 'proses') {
                return '<span class="badge bg-primary">Proses</span>';

            }
        })
        ->addColumn('status_pembayaran', function($row) {
            if($row->status_pembayaran == 'pending' || $row->status_pembayaran == 'pending'){
                return '<span class="badge bg-warning">Pending</span>';
            } elseif($row->status_pembayaran == 'capture' || $row->status_pembayaran == 'settlement'){
                return '<span class="badge bg-success">Selesai</span>';
            } elseif($row->status_pembayaran == 'batal' || $row->status_pembayaran == 'expire' || $row->status_pembayaran == 'cancel' || $row->status_pembayaran == 'deny'){
                return '<span class="badge bg-danger">Batal</span>';
            }
        })
        ->addColumn('gross_amount', function ($row) {
            return 'Rp. ' . number_format((float) ($row->gross_amount ?? 0), 0, ',', '.');
        })
        ->addColumn('action' , function($row){
            $actions = '';
            $actions .= '<a href="' . route('dashboard.pesanan.show', $row->slug) . '" class="btn btn-sm btn-secondary me-2 "><i class="bx bxs-show"></i></a>';
            $actions .= '<a href="' . route('dashboard.pesanan.edit', $row->slug) . '" class="btn btn-sm btn-primary me-2 "><i class="bx bxs-edit"></i></a>';
            $actions .= '<button data-id="'.$row['slug'].'" class="btn btn-sm btn-danger btn-delete me-2"><i class="bx bxs-trash"></i></button>';
            return $actions;
        })
        ->rawColumns([
            'status_pemesanan',
            'status_pembayaran',
            'action',
        ])
        ->addIndexColumn()
        ->make(true);
    }

    public function show($slug)
    {
        $pemesanan = Pemesanan::where('slug', $slug)->firstOrFail();

        return view('dashboard.pemesanan.show', compact('pemesanan'));
    }

    public function edit($slug)
    {
        $pemesanan = Pemesanan::where('slug', $slug)->firstOrFail();

        return view('dashboard.pemesanan.edit', compact('pemesanan'));
    }

    public function update(Request $request, $slug)
    {
        $pemesanan = Pemesanan::where('slug', $slug)->firstOrFail();
        $pemesanan->update([
            'status_pemesanan' => $request->status_pemesanan,
        ]);

        return redirect()->route('dashboard.pesanan.index')->with('success', 'Berhasil Mengubah Data');
    }

    public function destroy($slug)
    {
        $pemesanan = Pemesanan::where('slug', $slug)->firstOrFail();
        $actions = $pemesanan->delete();

        if($actions) {
            return response()->json(['status' => 'success','message' => 'Berhasil Menghapus Data']);
        } else {
            return response()->json(['status' => 'error','message' => 'Gagal Menghapus Data']);

        }
    }
}

