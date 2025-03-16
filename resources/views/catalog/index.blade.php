@extends('layouts.user')

@section('title', 'Katalog')
@section('content')
<section id="latest-blog">
    <div class="container-fluid">
      <div class="row">
        <div class="section-header d-flex align-items-center justify-content-between my-5">
          <h2 class="section-title">Katalog</h2>
        </div>
      </div>
      <div class="row">
        @forelse ($catalogs as $catalog)
        <div class="col-md-4 mt-4">
          <article class="post-item card border-0 shadow-sm p-3">
            <div class="image-holder zoom-effect">
              <a href="{{ asset('storage/catalog/'.$catalog->foto) }}" data-lightbox="image" title="{{ $catalog->name }}">
                <img src="{{ asset('storage/catalog/'.$catalog->foto) }}" alt="post" class="card-img-top img-fluid">
              </a>
            </div>
            <div class="card-body">
              <div class="post-meta d-flex text-uppercase gap-3 my-2 align-items-center">
                <div class="meta-date"><svg width="16" height="16"><use xlink:href="#calendar"></use></svg>{{ $catalog->created_at->format('d M Y') }}</div>
              </div>
              <div class="post-header">
                <h3 class="post-title">
                  <a href="#" class="text-decoration-none">{{ $catalog->name }}</a>
                </h3>
                <p>
                    {!! Str::limit($catalog->desc, 150)  !!}
                </p>
              </div>
              <div class="col-md-12">
                <a href="{{ route('catalog.show', $catalog->slug) }}" class="btn btn-primary text-center">Lihat</a>
              </div>
            </div>
          </article>
        </div>
        @empty
        <div class="col-md-12 mt-4 text-center">
          <h6 class="text-center">Tidak Ada Data</h6>
          <a href="{{ route('home') }}" class="btn btn-primary text-center">Pilih Data</a>
        </div>
        @endforelse
      </div>
    </div>
  </section>

@endsection


