@extends('layouts.user')

@section('title', 'Pesanan')

@section('content')
<section class="py-5 overflow-hidden">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-header bg-primary text-white text-center py-3">
                        <h4 class="mb-0">Detail Pesanan</h4>
                        <small class="d-block mt-1">
                            <i class="bx bx-receipt"></i> Order ID: <strong>{{ $pesanan->order_id }}</strong>
                        </small>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold"><i class="bx bx-user"></i> Nama</label>
                                <p class="form-control-plaintext">{{ $pesanan->user->name }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold"><i class="bx bx-calendar"></i> Tanggal Pemesanan</label>
                                <p class="form-control-plaintext">{{ \Carbon\Carbon::parse($pesanan->created_at)->format('d F Y') }}</p>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold"><i class="bx bx-money"></i> Total Pembayaran</label>
                                <p class="form-control-plaintext text-success">
                                    Rp. {{ number_format($pesanan->gross_amount ?? 0, 0, ',', '.') }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold"><i class="bx bx-truck"></i> Pengiriman</label>
                                <p class="form-control-plaintext">{{ $pesanan->pengiriman }}</p>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-bold"><i class="bx bx-map"></i> Alamat</label>
                                <p class="form-control-plaintext">{{ $pesanan->alamat }}</p>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold"><i class="bx bx-list-check"></i> Status Pemesanan</label>
                                <p class="form-control-plaintext badge bg-warning text-dark py-2 px-3 rounded-pill">
                                    {{ ucfirst($pesanan->status_pemesanan) }}
                                </p>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold"><i class="bx bx-credit-card"></i> Status Pembayaran</label>
                                <p class="form-control-plaintext badge bg-{{ in_array($pesanan->status_pembayaran, ['capture', 'settlement']) ? 'success' : 'warning' }} text-dark py-2 px-3 rounded-pill">
                                    {{ in_array($pesanan->status_pembayaran, ['capture', 'settlement']) ? 'Selesai' : ucfirst($pesanan->status_pembayaran) }}
                                </p>
                            </div>

                            <div class="col-md-12 mt-4">
                                <h5 class="text-center mb-3"><i class="bx bx-box"></i> Daftar Produk</h5>
                                <table class="table table-hover table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th><i class="bx bx-cube"></i> Nama Produk</th>
                                            <th><i class="bx bx-package"></i> Paket Reseller</th>
                                            <th><i class="bx bx-layer"></i> Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($pesanan->products as $product)
                                        <tr>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->product_reseller->first()->name ?? '-' }}</td>
                                            <td>{{ $product->pivot->qty ?? 1 }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-muted">Tidak ada produk</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center bg-light">
                        <a href="{{ route('pesanan.index') }}" class="btn btn-outline-primary">
                            <i class="bx bx-arrow-back"></i> Kembali ke Daftar Pesanan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
