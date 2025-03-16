@extends('layouts.dashboard')

@section('title', 'Detail Katalog')

@section('content')
<h1 class="h3 mb-3"><strong>Detail </strong> Katalog</h1>

<div class="row">
    <div class="col-xl-12 col-xxl-8 d-flex">
        <div class="w-100">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <p class="form-control-plaintext">{{ $catalog->name }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Gambar</label><br>
                        <img src="{{ asset('storage/catalog/' . $catalog->foto) }}" class="img-fluid" style="max-width: 200px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <div class="border p-3">{!! $catalog->desc !!}</div>
                    </div>
                    <a href="{{ route('dashboard.catalog.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
