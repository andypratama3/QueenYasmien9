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
                                    <p>{{ optional($product->category)->name ?? 'Tidak ada kategori' }}</p>
                                </div>

                                <div class="col-md-12 mt-2">
                                    <h5 class="mb-2">Stok</h5>
                                    <p>{{ $product->stock }}</p>
                                </div>

                                <div class="col-md-12 mt-2">
                                    <h5 class="mb-2">Harga</h5>
                                    <p>{{ 'Rp. ' . number_format((float) ($product->price ?? 0), 0, ',', '.') }}</p>
                                </div>

                                @if(optional($product->category)->name === 'Paket Reseller')
                                <div class="col-md-12 mt-2" id="category_reseller">
                                    <table class="table table-bordered" id="table_packet">
                                        <tr>
                                            <th class="w-25">Nama Paket</th>
                                            <th class="w-25">Jumlah</th>
                                            <th class="w-25">Harga</th>
                                            <th class="w-25">Aksi</th>
                                        </tr>

                                        @foreach($resellerPackages as $index => $package)
                                        <tr>
                                            <td>
                                                <input type="text" class="form-control" name="name_packet[]" value="{{ $package->name }}">
                                            </td>
                                            <td style="width: 20%;">
                                                <input type="number" class="form-control" name="jumlah[]" value="{{ $package->jumlah }}">
                                            </td>
                                            <td style="width: 20%;">
                                                <input type="text" class="form-control price-input" name="price_reseller[]" value="{{ number_format($package->price_reseller, 0, ',', '.') }}">
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-danger btn-sm btn-delete">-</button>
                                                @if($loop->last)
                                                    <button type="button" class="btn btn-primary btn-sm btn-add">+</button>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </table>
                                </div>
                                @endif

                                <div class="col-md-12 mt-2">
                                    <h5 class="mb-2">Gambar</h5>
                                    @if($product->foto && file_exists(public_path('storage/product/' . $product->foto)))
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
                                <a href="{{ route('dashboard.product.edit', $product->slug) }}" class="btn btn-sm btn-primary">Edit</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
