@extends('layouts.user')

@section('title', 'Beranda')

@section('content')

<section class="py-3" style="background: url('{{ asset('assets/images/bg-sec.jpg') }}') no-repeat center center/cover;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="banner-blocks">

                    <!-- Swiper Main Banner -->
                    <div class="banner-ad large bg-info block-1">
                        <div class="swiper main-swiper">
                            <div class="swiper-wrapper">

                                <!-- Slide 1 -->
                                <div class="swiper-slide">
                                    <div class="row banner-content p-5">
                                        <div class="col-md-12">
                                            <div class="categories my-3">Queen Yasmien9</div>
                                            <h5 class="fw-bold">Program Reseller</h5>
                                            <p class="text-black">
                                                <strong>PAKET SKINCARE LENGKAP</strong>
                                                <br>Harga Normal: <del>Rp300.000/paket</del>
                                                <br><br>
                                                <strong>Harga Reseller:</strong>
                                                <br>- 3 Paket: <strong>Rp290.000/paket</strong> | Total: Rp870.000
                                                <br>- 6 Paket: <strong>Rp280.000/paket</strong> | Total: Rp1.680.000
                                                <br>- 12 Paket: <strong>Rp270.000/paket</strong> | Total: Rp3.240.000
                                                <br>- 24 Paket: <strong>Rp260.000/paket</strong> | Total: Rp6.240.000
                                                <br>- 50 Paket (DIST): <strong>Rp250.000/paket</strong> | Total: Rp12.500.000
                                                <br>- 100 Paket: <strong>Rp240.000/paket</strong> | Total: Rp24.000.000
                                                <br>- 500 Paket (AO): <strong>Rp235.000/paket</strong> | Total: Rp117.500.000
                                            </p>
                                            <a href="#product" class="btn btn-outline-dark btn-lg text-uppercase fs-6 rounded-1 px-4 py-3 mt-3">Beli Sekarang</a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Slide 2 (PAKET RESELLER) -->
                                <div class="swiper-slide">
                                    <div class="row banner-content p-5">
                                        <div class="col-md-12">
                                            <div class="categories my-3">Paket Reseller (Min. Order 10 pcs)</div>
                                            <h5 class="fw-bold">Peluang Bisnis Menguntungkan!</h5>
                                            <p class="text-black">
                                                <strong>1️⃣ PAKET LENGKAP GLOW UP</strong><br>
                                                ✅ Harga Normal: Rp300.000/pcs<br>
                                                ✅ Harga Reseller: <strong>Rp250.000/pcs</strong> (Hemat Rp50.000/pcs!)<br>
                                                🔥 Keuntungan Reseller: Jual kembali Rp300.000 → Untung Rp50.000/pcs!<br><br>

                                                <strong>2️⃣ BODY MASK LUXURY 500gr</strong><br>
                                                ✅ Harga Normal: Rp200.000/pcs<br>
                                                ✅ Harga Reseller: <strong>Rp150.000/pcs</strong><br>
                                                🔥 Keuntungan: Rp50.000/pcs!<br><br>

                                                <strong>3️⃣ BODY MASK LUXURY 1000gr</strong><br>
                                                ✅ Harga Normal: Rp350.000/pcs<br>
                                                ✅ Harga Reseller: <strong>Rp300.000/pcs</strong><br>
                                                🔥 Keuntungan: Rp50.000/pcs!<br>
                                            </p>
                                            <a href="#product" class="btn btn-outline-dark btn-lg text-uppercase fs-6 rounded-1 px-4 py-3 mt-3">Gabung Sekarang</a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                    <!-- End Swiper Main Banner -->

                    <div class="banner-ad bg-success-subtle block-2">
                        <div class="row banner-content p-5">
                            <div class="col-md-7">
                                <h3 class="banner-title fw-bold text-black">Diskon Spesial untuk Reseller</h3>
                                <ul class="list-unstyled fw-bold text-black">
                                    <li class="text-black">🔥 <strong>Paket Lengkap Glow Up</strong> – Hemat Rp50.000/pcs!</li>
                                    <li class="text-black">✅ <strong>Body Mask Luxury 500gr</strong> – Hemat Rp50.000/pcs!</li>
                                    <li class="text-black">✅ <strong>Body Mask Luxury 1000gr</strong> – Hemat Rp50.000/pcs!</li>
                                </ul>
                                <a href="#" class="d-flex align-items-center nav-link text-black fw-bold">
                                    Daftar Sekarang <svg width="24" height="24"><use xlink:href="#arrow-right"></use></svg>
                                </a>
                            </div>
                        </div>
                    </div>

                </div> <!-- End Banner Blocks -->
            </div>
        </div>
    </div>
</section>


  <section class="py-5">
    <div class="container-fluid">

      <div class="row">
        <div class="col-md-12">

          <div class="bootstrap-tabs product-tabs" id="product">
            <div class="tabs-header d-flex justify-content-between border-bottom my-5">
              <h3>Produk</h3>
              <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                  <a href="#" class="nav-link text-uppercase fs-6 active" id="nav-all-tab" data-bs-toggle="tab" data-bs-target="#nav-all">All</a>
                  {{-- @foreach ($categorys as $category)
                    <a href="#" class="nav-link text-uppercase fs-6" id="nav-{{ $category->slug }}-tab" data-bs-toggle="tab" data-bs-target="#nav-{{ $category->slug }}">{{ $category->name }}</a>
                  @endforeach --}}
                </div>
              </nav>
            </div>
            <div class="tab-content" id="nav-tabContent">
              <div class="tab-pane fade show active" id="nav-all" role="tabpanel" aria-labelledby="nav-all-tab">

                <div class="product-grid row row-cols-1 row-cols-sm-4 row-cols-md-2 row-cols-lg-2 row-cols-xl-3">
                  @forelse ($products as $product)

                  <div class="col">
                    <div class="product-item">
                      {{-- <span class="badge bg-success position-absolute m-3">-30%</span> --}}

                      <figure>
                        <a href="{{ asset('storage/product/' . $product->foto ) }}" data-lightbox="product" title="{{ $product->name }}">
                          <img src="{{ asset('storage/product/'. $product->foto) }}"  class="tab-image">
                        </a>
                      </figure>
                      <h3>{{ \Str::limit($product->name, 20, '...') }}</h3>

                      <span class="qty">{{ $product->stock }} Unit</span>
                      {{-- <span class="rating"><svg width="24" height="24" class="text-primary"><use xlink:href="#star-solid"></use></svg> 4.5</span> --}}
                      <span class="price">
                        @if ($product->price)
                        <p>{{ 'Rp. ' . number_format((float) ($product->price ?? 0), 0, ',', '.') }}</p>
                        @elseif ($product->product_reseller->isNotEmpty())
                            {{ 'Rp. ' . number_format((float) $product->product_reseller->first()->price_reseller, 0, ',', '.') }}
                        @endif
                    </span>


                      <div class="d-flex align-items-center justify-content-between">
                        <div class="input-group product-qty">
                            <span class="input-group-btn">
                                <button type="button" class="quantity-left-minus btn btn-danger btn-number" data-type="minus">
                                    <i class="bx bx-minus"></i>
                                </button>
                            </span>
                            <input type="text" id="quantity" name="quantity" {{ $product->stock == 0 ? 'disabled' : '' }} class="form-control input-number" value="1">
                            <span class="input-group-btn">
                                <button type="button" class="quantity-right-plus btn btn-success btn-number" data-type="plus">
                                    <i class="bx bx-plus"></i>
                                </button>
                            </span>
                        </div>
                        <div class="d-flex flex-column gap-3">
                            <button class="btn btn-secondary btn-sm btn-show" data-id="{{ $product->id }}">
                                <i class="bx bx-info-circle me-2"></i> Lihat Detail Produk
                              </button>
                            <button  data-id="{{ $product->id }}" class="btn btn-primary btn-sm d-flex align-items-center cart">
                                <i class="bx bx-cart-download bx-md me-2"></i> Keranjang
                            </button>
                        </div>

                      </div>
                    </div>
                  </div>
                  @empty

                  @endforelse
                </div>
              </div>

              <div class="tab-pane fade" id="nav-fruits" role="tabpanel" aria-labelledby="nav-fruits-tab">


                <!-- / product-grid -->
              </div>


            </div>
          </div>

        </div>
      </div>
    </div>
  </section>

  <section class="py-5">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="banner-ad bg-danger mb-3" style="background: url('images/ad-image-3.png'); background-repeat: no-repeat; background-position: right bottom;">
                    <div class="banner-content p-5">

                        <!-- Live Streaming -->
                        <div class="d-flex align-items-center text-primary fs-3 fw-bold">
                            <i class='bx bxs-video-recording me-2'></i> Live Streaming
                        </div>

                        <!-- TikTok Username -->
                        <h3 class="banner-title d-flex align-items-center">
                            <i class='bx bxl-tiktok me-2'></i> @queenyasmine9
                        </h3>

                        <!-- Waktu Live -->
                        <p class="d-flex align-items-center text-black">
                            <i class='bx bx-time me-2'></i> Live akan dilakukan pada <strong class="ms-1">10:00 setiap hari</strong>
                        </p>

                        <!-- Tombol Gabung -->
                        <a href="https://www.tiktok.com/@queenyasmine9" target="_blank" class="btn btn-dark text-uppercase d-flex align-items-center">
                            <i class='bx bx-play-circle me-2'></i> Gabung Sekarang
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

  <section class="py-5 overflow-hidden">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">

          <div class="section-header d-flex flex-wrap justify-content-between my-5">

            <h2 class="section-title">Produk Terlaris</h2>

            <div class="d-flex align-items-center">
              <div class="swiper-buttons">
                <button class="swiper-prev products-carousel-prev btn btn-primary">❮</button>
                <button class="swiper-next products-carousel-next btn btn-primary">❯</button>
              </div>
            </div>
          </div>

        </div>
      </div>
      <div class="row">
        <div class="col-md-12">

          <div class="products-carousel swiper" id="product_best_seller">
            <div class="swiper-wrapper">
              @forelse ($products_best as $product)
              <div class="product-item swiper-slide">
                <figure>
                  <a href="{{ asset('storage/product/'.$product->foto) }}" title="{{ $product->name }}" data-lightbox="product-best" >
                    <img src="{{ asset('storage/product/'.$product->foto) }}"  class="tab-image img-fluid">
                  </a>
                </figure>
                <h3>{{ $product->name }}</h3>
                <span class="qty">{{ $product->stock }} Unit</span>
                <span class="price">
                    @if ($product->price != null)
                    <p>{{ 'Rp. ' . number_format((float) ($product->price ?? 0), 0, ',', '.') }}</p>
                    @elseif ($product->product_reseller->isNotEmpty())
                        {{ 'Rp. ' . number_format((float) $product->product_reseller->first()->price_reseller, 0, ',', '.') }}
                    @endif
                </span>
                <div class="d-flex align-items-center justify-content-between">
                    <div class="input-group product-qty">
                        <span class="input-group-btn">
                            <button type="button" class="quantity-left-minus btn btn-danger btn-number" data-type="minus">
                                <i class="bx bx-minus"></i>
                            </button>
                        </span>
                        <input type="text" id="quantity" name="quantity" {{ $product->stock == 0 ? 'disabled' : '' }} class="form-control input-number" value="1">
                        <span class="input-group-btn">
                            <button type="button" class="quantity-right-plus btn btn-success btn-number" data-type="plus">
                                <i class="bx bx-plus"></i>
                            </button>
                        </span>
                    </div>

                <button  data-id="{{ $product->id }}" class="btn btn-primary btn-sm d-flex align-items-center cart mt-2">
                    <i class="bx bx-cart-download bx-md me-2"></i> Keranjang
                </button>
              </div>

            </div>
              @empty

              @endforelse

          </div>
          <!-- / products-carousel -->

        </div>
      </div>
    </div>
  </section>

  <section class="py-5">
    <div class="container-fluid">
        <div class="bg-secondary py-5 my-5 rounded-5" style="background: url('images/bg-skincare-pattern.png') no-repeat;">
            <div class="container my-5">
                <div class="row">
                    <div class="col-md-6 p-5">
                        <div class="section-header">
                            <h2 class="section-title display-4">
                                <span class="text-primary">Gabung sebagai Reseller</span> & Mulai Bisnis Skincare Anda!
                            </h2>
                        </div>
                        <p>Jadilah reseller Queen Yasmien9 dan dapatkan harga spesial untuk Pembelian Produk Reseller Anda! Nikmati keuntungan eksklusif, dengan produk skincare berkualitas tinggi.</p>
                        <ul>
                            <li>🛍️ Harga spesial & keuntungan reseller</li>
                            <li>📦 Produk berkualitas dengan stok terjamin</li>
                        </ul>
                    </div>
                    <div class="col-md-6 p-5 d-flex flex-column justify-content-center text-center">
                        <div class="form-group">
                            <h2 class="fw-bold">Pesan Produk Reseller Sekarang!</h2>
                            <a href="#product" class="btn btn-dark btn-lg mt-3">Beli Paket Reseller</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>




  <section class="py-5 my-5">
    <div class="container-fluid">
        <div class="bg-warning py-5 rounded-5" style="background-image: url('images/bg-pattern-2.png') no-repeat;">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <img src="{{ asset('assets/images/phone1.png') }}" alt="website preview" class="image-float img-fluid">
                    </div>
                    <div class="col-md-8">
                        <h2 class="my-5">Belanja Lebih Mudah di Website Queen Yasmien9</h2>
                        <p>Nikmati kemudahan berbelanja produk skincare premium Queen Yasmien9 langsung dari website kami. Temukan berbagai produk berkualitas, promo menarik, serta informasi lengkap mengenai perawatan kulit hanya dengan beberapa klik.</p>
                        <a href="{{ url('/') }}" class="btn btn-primary mt-3">Kunjungi Sekarang</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

  <section class="py-5">
    <div class="container-fluid">
      <h2 class="my-5">People are also looking for</h2>
      <a href="#" class="btn btn-warning me-2 mb-2">Blue diamon almonds</a>
      <a href="#" class="btn btn-warning me-2 mb-2">Angie’s Boomchickapop Corn</a>
      <a href="#" class="btn btn-warning me-2 mb-2">Salty kettle Corn</a>
      <a href="#" class="btn btn-warning me-2 mb-2">Chobani Greek Yogurt</a>
      <a href="#" class="btn btn-warning me-2 mb-2">Sweet Vanilla Yogurt</a>
      <a href="#" class="btn btn-warning me-2 mb-2">Foster Farms Takeout Crispy wings</a>
      <a href="#" class="btn btn-warning me-2 mb-2">Warrior Blend Organic</a>
      <a href="#" class="btn btn-warning me-2 mb-2">Chao Cheese Creamy</a>
      <a href="#" class="btn btn-warning me-2 mb-2">Chicken meatballs</a>
      <a href="#" class="btn btn-warning me-2 mb-2">Blue diamon almonds</a>
      <a href="#" class="btn btn-warning me-2 mb-2">Angie’s Boomchickapop Corn</a>
      <a href="#" class="btn btn-warning me-2 mb-2">Salty kettle Corn</a>
      <a href="#" class="btn btn-warning me-2 mb-2">Chobani Greek Yogurt</a>
      <a href="#" class="btn btn-warning me-2 mb-2">Sweet Vanilla Yogurt</a>
      <a href="#" class="btn btn-warning me-2 mb-2">Foster Farms Takeout Crispy wings</a>
      <a href="#" class="btn btn-warning me-2 mb-2">Warrior Blend Organic</a>
      <a href="#" class="btn btn-warning me-2 mb-2">Chao Cheese Creamy</a>
      <a href="#" class="btn btn-warning me-2 mb-2">Chicken meatballs</a>
    </div>
  </section>

  <section class="py-5">
    <div class="container-fluid">
        <div class="row row-cols-1 row-cols-md-5 g-4">
            <div class="col">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <i class="bx bx-check-shield text-primary" style="font-size: 3rem;"></i>
                        <h5 class="card-title mt-3">Produk Berkualitas</h5>
                        <p class="card-text">Kami menyediakan produk pilihan dengan standar kualitas terbaik untuk memastikan kepuasan pelanggan.</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <i class="bx bxs-truck" style="font-size: 3rem;"></i>
                        <h5 class="card-title mt-3">Pengiriman Cepat</h5>
                        <p class="card-text">Pesanan Anda dikirim dengan layanan ekspedisi terpercaya agar sampai dengan aman dan tepat waktu.</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <i class="bx bx-money text-primary" style="font-size: 3rem;"></i>
                        <h5 class="card-title mt-3">Harga Terjangkau</h5>
                        <p class="card-text">Kami menawarkan harga kompetitif dengan kualitas unggulan, memastikan Anda mendapatkan nilai terbaik.</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <i class="bx bx-support" style="font-size: 3rem; color: red;"></i>
                        <h5 class="card-title mt-3">Layanan 24/7</h5>
                        <p class="card-text">Tim kami siap melayani Anda kapan saja, memberikan dukungan cepat dan responsif setiap saat.</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <i class="bx bx-lock-alt"  style="font-size: 3rem; color: #18469c;"></i>
                        <h5 class="card-title mt-3">Jaminan Keamanan</h5>
                        <p class="card-text">Setiap transaksi dijamin aman dengan sistem enkripsi canggih untuk melindungi data Anda.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </section>
  <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="productModalLabel">Produk </h5>
          <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-5 text-center">
              <img id="modalProductImage" src="" class="img-fluid rounded shadow mb-2" alt="Produk">
            </div>
            <div class="col-md-7">
              <h4 id="modalProductName" class="fw-bold mt-2"></h4>
              <p id="modalProductCategory" class="text-muted"></p>
              <p id="modalProductStock" class="text-muted"></p>
              <p id="modalProductSellCount" class="text-muted"></p>
              <h5 id="modalProductPrice" class="text-black"></h5>
              <h6 id="modalProductPriceReseller" class="text-success"></h6>
              <div class="form-group">
                <h6>Deskripsi</h6>
                <p id="modalProductDescription"></p>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


@push('js_user')
<script type="text/javascript">
    $(document).ready(function () {
        $('#product').on('click', '.btn-show', function () {
            let product_id = this.dataset.id; // Ambil ID produk dari dataset

            $.ajax({
                type: "GET",
                url: "{{ route('product.detail', ':id') }}".replace(':id', product_id),
                dataType: "json",
                success: function (response) {
                    if (response.status === 'success') {
                        let product = response.data;
                        let assetUrl = "{{ asset('storage/product/') }}";

                        // Set data ke modal
                        $('#modalProductImage').attr('src', `${assetUrl}/${product.foto}`);
                        $('#modalProductName').text(product.name);
                        $('#modalProductCategory').text(`Kategori: ${product.category_id}`);
                        $('#modalProductStock').text(`Stok: ${product.stock} Unit`);
                        $('#modalProductSellCount').text(`Terjual: ${product.sell_count ?? 0} Unit`);
                        $('#modalProductPrice').text(`Rp. ${new Intl.NumberFormat('id-ID').format(product.price)}`);

                        // Hilangkan harga reseller karena tidak ada dalam response
                        $('#modalProductPriceReseller').hide();

                        // Appenda data id ke button tambah ke keranjang

                        // Render deskripsi dengan HTML
                        $('#modalProductDescription').html(product.desc || "Tidak ada deskripsi.");

                        // Tampilkan modal
                        let modal = new bootstrap.Modal($('#productModal')[0]);
                        modal.show();
                    } else {
                        alert("Gagal mengambil data produk.");
                    }
                },
                error: function () {
                    alert("Terjadi kesalahan dalam mengambil data produk.");
                }
            });
        });
    });
</script>



<script>
    $(document).ready(function() {
        $('#product, #product_best_seller').on('click', '.cart', function () {
            const id = $(this).data('id');
            const qty = $(this).closest('.product-item').find('.input-number').val();


            $.ajax({
                url: "{{ route('cart.store') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    product_id: id,
                    qty: qty
                },
                success: function(response) {
                    if(response.status == 'error'){
                            Swal.fire({
                            title: "Error",
                            text: response.message,
                            icon: "error",
                            confirmButtonColor: '#f7a422'
                        });
                    } else {
                        Swal.fire({
                            title: "Success",
                            text: response.message,
                            icon: "success",
                            confirmButtonColor: '#f7a422'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });

                    }
                },
                error: function(xhr) {
                    if(xhr.status == 401){
                        Swal.fire({
                            title: "Error",
                            text: xhr.responseJSON.message,
                            icon: "error"
                        });
                        setInterval(() => {
                            window.location.href = '/login';
                        }, 4000);
                    }
                }
            });
        });
    });

</script>

@endpush

@endsection
