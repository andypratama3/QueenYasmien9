@extends('layouts.user')

@section('title', 'Detail')
@section('content')
<section id="latest-blog">
    <div class="container-fluid">
      <div class="row">
        <div class="section-header d-flex align-items-center justify-content-between my-5">
          <h2 class="section-title">{{ $catalog->name }}</h2>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 ">
          <article class="post-item card border-0 shadow-sm p-3">
            <div class="image-holder zoom-effect text-center">
              <a href="#">
                <img src="{{ asset('storage/catalog/'.$catalog->foto) }}" alt="post" class="card-img-top img-fluid w-50">
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
                    {!! $catalog->desc  !!}
                </p>
              </div>

            </div>
          </article>
        </div>
      </div>
    </div>
  </section>

@endsection


