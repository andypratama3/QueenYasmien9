@extends('layouts.dashboard')

@section('title', 'Detail Pemesanan')

@section('content')
<h1 class="h3 mb-3"><strong>Detail</strong> Pemesanan</h1>

<div class="row">
    <div class="col-xl-12 col-xxl-8 d-flex">
        <div class="w-100">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 class="mb-2">Order ID</h5>
                                    <p>{{ $pemesanan->order_id }}</p>
                                </div>

                            </div>
                            <div class="col-md-12 mt-4">
                                <a href="{{ route('dashboard.pesanan.index') }}" class="btn btn-sm btn-danger">Kembali</a>
                                <a href="{{ route('dashboard.pesanan.edit', $pemesanan->id) }}" class="btn btn-sm btn-primary">Edit</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
