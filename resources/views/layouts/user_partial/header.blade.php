
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
            <span class="fs-6 text-muted">WhatsApp</span>
            <a href="https://wa.me/628123456789" class="btn btn-primary btn-sm"><i class="bi bi-whatsapp"></i>+628123456789</a><p class="mb-0"></p>
          </div>
          <ul class="d-flex align-items-center list-unstyled m-0 gap-2">
            <!-- User Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle rounded-circle bg-light p-2 mx-1 d-flex align-items-center justify-content-center" 
                   href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" 
                   style="width: 40px; height: 40px;">
                    <i class='bx bx-user-circle'></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    @auth
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-primary dropdown-item">Logout</button>
                            </form>
                        </li>
                    @else
                        <li><a class="dropdown-item" href="{{ route('login') }}">Login</a></li>
                        <li><a class="dropdown-item" href="{{ route('register') }}">Register</a></li>
                    @endauth
                </ul>
            </li>
    
            @auth
            <!-- Pesanan -->
            <li>
                <a href="{{ route('pesanan.index') }}" 
                   class="rounded-circle bg-light p-2 mx-1 d-flex align-items-center justify-content-center" 
                   style="width: 40px; height: 40px;">
                    <i class='bx bxs-package'></i>
                </a>
            </li>
    
            <!-- Cart (Tidak Diubah) -->
            <li>
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
                        <a href="{{ Request::routeIs('home') ? '#tentang' : url('/#tentang') }}" class="nav-link">Tentang</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('catalog.index') }}" class="nav-link {{ Route::currentRouteName() == 'catalog.index' ? 'active' : '' }}">Katalog</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ Request::routeIs('home') ? '#blog' : url('/#blog') }}" class="nav-link">Testimonial</a>
                    </li>
                    @auth
                    <li class="nav-item">
                        <a href="{{ route('pesanan.index') }}" class="nav-link {{ Route::currentRouteName() == 'pesanan.index' ? 'active' : '' }}">Pesanan</a>
                    </li>
                    @endauth
                </ul>
            </div>

          </div>
      </div>
    </div>
  </div>
