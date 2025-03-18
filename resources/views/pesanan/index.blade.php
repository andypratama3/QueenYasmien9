@extends('layouts.user')

@section('title', 'Pesanan')

@push('css_user')
    <style>
        .pesanan-card {
            background: #fff;
            padding: 1rem;
            margin-bottom: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .pesanan-header {
            font-weight: bold;
            font-size: 16px;
            border-bottom: 2px solid #ddd;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }

        .product-block {
            display: grid;
            grid-template-columns: 100px 1fr 150px;
            align-items: center;
            background: #f9f9f9;
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 8px;
        }

        .product-block img {
            width: 75px;
            height: 75px;
            border-radius: 8px;
            object-fit: cover;
        }

        .product-block .details {
            display: flex;
            flex-direction: column;
        }

        .product-block h2 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }

        .product-block p {
            margin: 5px 0 0;
            font-size: 14px;
            color: #555;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
        }

        .status-pending {
            background-color: #f7b731;
            color: white;
        }

        .status-success {
            background-color: #2ecc71;
            color: white;
        }

        .status-failed {
            background-color: #e74c3c;
            color: white;
        }
        .status-pengiriman {
            background-color: #0062da;
            color: white;
        }
        .status-proses {
            background-color: #daa400;
            color: white;
        }
    </style>
@endpush

@section('content')
<section class="py-5 overflow-hidden">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="section-header d-flex flex-wrap justify-content-between mb-5">
                    <h2 class="section-title">Pesanan Saya</h2>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="card">
                <div class="card-body">
                    <h4>Daftar Pesanan
                        <a href="{{ route('home') }}" class="btn btn-primary btn-sm float-end">Pesan Lagi</a>
                    </h4>

                    <div class="row mt-4">
                        @forelse ($pesanans as $pesanan)
                            <div class="pesanan-card">
                                <div class="pesanan-header">
                                    Pesanan #{{ $pesanan->id }}
                                </div>

                                @forelse($pesanan->products as $product)
                                    <div class="product-block">
                                        <img src="{{ $product->foto ? asset('storage/product/'.$product->foto) : asset('placeholder.png') }}" alt="Gambar {{ $product->name }}">

                                        <div class="details">
                                            <h2>{{ $product->name }}</h2>
                                            <p>{{ $product->product_reseller->first()->name ?? '-' }}</p>
                                            <p>Jumlah: {{ $product->pivot->qty ?? 1 }}</p>
                                            <p>Harga Satuan: Rp {{ number_format($product->product_reseller->where('id', $pesanan->products_reseller_id)->first()->price_reseller ?? $product->price, 0, ',', '.') }}</p>
                                        </div>

                                        <p><strong>Total: Rp
                                            {{ number_format(
                                                ($product->product_reseller->where('id', $pesanan->products_reseller_id)->first()->price_reseller ?? $product->price)
                                                * ($product->pivot->qty ?? 1), 0, ',', '.'
                                            ) }}
                                        </strong></p>



                                    </div>
                                @empty
                                    <p class="text-center">Pesanan ini belum memiliki produk.</p>
                                @endforelse

                                <div class="status-container">
                                    <p><strong>Status Pesanan:</strong>
                                        @php
                                            $statusPemesananClass = match(strtolower($pesanan->status_pemesanan)) {
                                                'pending' => 'status-pending',
                                                'selesai' => 'status-success',
                                                'proses' => 'status-proses',
                                                'pengiriman', 'status-pengiriman', 
                                                'batal' => 'status-failed',
                                                default => 'status-default',
                                            };
                                        @endphp
                                        <span class="status-badge {{ $statusPemesananClass }}">
                                            {{ ucwords($pesanan->status_pemesanan) }}
                                        </span>
                                    </p>
                                
                                    <p><strong>Status Pembayaran:</strong>
                                        @php
                                            $statusPembayaranClass = match(true) {
                                                in_array(strtolower($pesanan->status_pembayaran), ['settlement', 'capture']) => 'status-success',
                                                in_array(strtolower($pesanan->status_pembayaran), ['expired', 'cancel', 'deny']) => 'status-failed',
                                                strtolower($pesanan->status_pembayaran) === 'pending' => 'status-pending',
                                                default => 'status-default',
                                            };
                                        @endphp
                                        <span class="status-badge {{ $statusPembayaranClass }}">
                                            {{ ucwords($pesanan->status_pembayaran) }}
                                        </span>
                                    </p>
                                </div>
                                
                                
                            </div>
                        @empty
                            <p class="text-center">Belum ada pesanan.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
