@extends('layouts.dashboard')

@section('title', 'Detail Produk')

@section('content')
<h1 class="h3 mb-3"><strong>Detail</strong> Produk</h1>

<div class="row">
    <div class="col-xl-12 col-xxl-8 d-flex">
        <div class="w-100">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <h5 class="mb-2">Nama Produk</h5>
                                    <p>{{ $product->name }}</p>
                                </div>

                                <div class="col-md-12 mt-2">
                                    <h5 class="mb-2">Kategori</h5>
                                    <p>{{ $product->category ? $product->category->name : 'Tidak ada kategori' }}</p>
                                </div>

                                <div class="col-md-12 mt-2">
                                    <h5 class="mb-2">Stok</h5>
                                    <p>{{ $product->stock }}</p>
                                </div>

                                <div class="col-md-12 mt-2">
                                    <h5 class="mb-2">Gambar</h5>
                                    @if($product->foto)
                                        <img src="{{ asset('storage/product/' . $product->foto) }}" class="img-fluid" style="border-radius: 10px; max-width: 100%; height: auto;">
                                    @else
                                        <p>Tidak ada gambar</p>
                                    @endif
                                </div>

                                <div class="col-md-12 mt-2">
                                    <h5 class="mb-2">Deskripsi</h5>
                                    <p>{!! $product->desc !!}</p>
                                </div>
                            </div>
                            <div class="col-md-12 mt-4">
                                <a href="{{ route('dashboard.product.index') }}" class="btn btn-sm btn-danger">Kembali</a>
                                <a href="{{ route('dashboard.product.edit', $product->id) }}" class="btn btn-sm btn-primary">Edit</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
