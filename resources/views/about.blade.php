@extends('layouts.user')

@section('title', 'Tentang Queen Yasmien')

@section('content')
<section class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <h1 class="fw-bold text-primary">Tentang Queen Yasmien</h1>
                <p class="text-muted">Kami berkomitmen menghadirkan produk skincare berkualitas tinggi yang diformulasikan dengan bahan alami terbaik untuk merawat dan menjaga kesehatan kulit Anda.</p>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-4 text-center">
                <i class='bx bx-leaf bx-lg text-success'></i>
                <h3 class="mt-3">Bahan Alami</h3>
                <p>Menggunakan bahan-bahan alami yang aman dan terpercaya untuk kesehatan kulit Anda.</p>
            </div>
            <div class="col-md-4 text-center">
                <i class='bx bx-shield-plus bx-lg' style="color: yellow;"></i>
                <h3 class="mt-3">Teruji Dermatologis</h3>
                <p>Setiap produk telah melewati uji klinis untuk memastikan keamanan dan efektivitasnya.</p>
            </div>
            <div class="col-md-4 text-center">
                <i class='bx bx-happy bx-lg' style="color: #18469c;"></i>
                <h3 class="mt-3">Aman & Halal</h3>
                <p>Produk kami bersertifikat halal dan cocok untuk semua jenis kulit, termasuk kulit sensitif.</p>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="{{ url('/#product') }}" class="btn btn-primary">Lihat Produk Kami</a>
        </div>
    </div>
</section>
@endsection
