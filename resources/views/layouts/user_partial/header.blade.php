
<div class="container-fluid">
    <div class="row py-3 border-bottom">

      <div class="col-sm-6 col-lg-3 text-center text-sm-start">
        <div class="main-logo">
          <a href="{{ route('home') }}">
            <img src="{{ asset('assets/images/logo-width.png') }}" alt="logo" class="img-fluid" style="width: 80%;">
          </a>
        </div>
      </div>

      <div class="col-sm-4 offset-sm-2 offset-md-0 col-lg-5 d-none d-lg-block">
        <div class="search-bar row p-2 my-2 rounded-4">
        </div>
      </div>

      <div class="col-sm-8 col-lg-4 d-flex justify-content-end gap-5 align-items-center mt-4 mt-sm-0 justify-content-center justify-content-sm-end">

        <div class="support-box text-end d-none d-xl-block">
            <span class="fs-6 text-muted">For Support?</span>
            <a href="" class="btn btn-primary btn-sm"><i class="bi bi-whatsapp"></i>+980-34984089</a><p class="mb-0"></p>
          </div>
        <ul class="d-flex justify-content-end list-unstyled m-0">
          <li>
            <a href="#" class="rounded-circle bg-light p-2 mx-1">
                <i class='bx bx-user-circle'></i>
            </a>
          </li>
          <li>
            <a href="#" class="rounded-circle bg-light p-2 mx-1">
              <svg width="24" height="24" viewBox="0 0 24 24"><use xlink:href="#heart"></use></svg>
            </a>
          </li>
          @auth
          <li class="d-lg-none">
              <a href="#" class="rounded-circle bg-light p-2 mx-1" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart" aria-controls="offcanvasCart">
                  <i class='bx bxs-cart' ></i>
                </a>
            </li>
            @endauth
        </ul>

        @auth

        <div class="cart text-end d-none d-lg-block dropdown">
          <button class="border-0 bg-transparent d-flex flex-column gap-2 lh-1" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart" aria-controls="offcanvasCart">
            <span class="fs-6 text-muted dropdown-toggle">Keranjang</span>
            <span class="cart-total fs-8 fw-bold">
                {{ 'Rp. ' . number_format($totalPrice, 0, ',', '.') }}
            </span>

          </button>
        </div>
        @endauth

      </div>

    </div>
  </div>
  <div class="container-fluid">
    <div class="row py-3">
      <div class="d-flex  justify-content-center justify-content-sm-between align-items-center">
        <nav class="main-menu d-flex navbar navbar-expand-lg">

          <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
            aria-controls="offcanvasNavbar">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">

            <div class="offcanvas-header justify-content-center">
              <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>

            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-end menu-list list-unstyled d-flex gap-md-3 mb-0">
                    <li class="nav-item active">
                        <a href="/" class="nav-link active">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ Request::routeIs('home') ? '#product' : url('/#product') }}" class="nav-link">Produk</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="{{ Request::routeIs('home') ? '#men' : url('/#men') }}" class="nav-link">Tentang</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('catalog.index') }}" class="nav-link {{ Route::currentRouteName() == 'catalog.index' ? 'active' : '' }}">Katalog</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ Request::routeIs('home') ? '#blog' : url('/#blog') }}" class="nav-link">Testimonial</a>
                    </li>
                </ul>
            </div>

          </div>
      </div>
    </div>
  </div>
