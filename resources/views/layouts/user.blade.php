<!DOCTYPE html>
<html lang="en">
  <head>
    @include('layouts.user_partial.head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.5/css/lightbox.css" integrity="sha512-DKdRaC0QGJ/kjx0U0TtJNCamKnN4l+wsMdION3GG0WVK6hIoJ1UPHRHeXNiGsXdrmq19JJxgIubb/Z7Og2qJww==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  </head>
  <body>

    <div class="preloader-wrapper">
      <div class="preloader">
      </div>
    </div>

    @auth
    <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasCart" aria-labelledby="My Cart">
      <div class="offcanvas-header justify-content-end mr-3">
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <div class="order-md-last">
          <h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-primary">Keranjang</span>
            <span class="badge bg-primary rounded-pill">{{ $charts->count() }}</span>
          </h4>
          <ul class="list-group mb-3">
            @foreach ($charts as $chart)
            <li class="list-group-item d-flex justify-content-between lh-sm">
              <div>
                <h6 class="my-0">{{ $chart->product->name }}</h6>
                <small class="text-body-secondary">Jumlah: {{ $chart->qty }}</small>
              </div>
              @if ($chart->price > 0)
                <span class="text-body-secondary">
                    {{ 'Rp. ' . number_format((float) $chart->price, 0, ',', '.') }}
                </span>
            @elseif (!empty($chart->product_reseller) && $chart->product_reseller->isNotEmpty())
                <span class="text-body-secondary">
                    {{ 'Rp. ' . number_format((float) $chart->product_reseller->first()->price_reseller, 0, ',', '.') }}
                </span>
            @endif

            </li>
            @endforeach
            <li class="list-group-item d-flex justify-content-between lh-sm mt-5">
              <div>
                <h6 class="my-0">Sub Total</h6>
                <small class="text-body-secondary">Jumlah: {{ $charts->sum('qty') }}</small>
              </div>
              <span class="text-body-secondary"><strong>  {{ 'Rp. ' . number_format($totalPrice, 0, ',', '.') }}</strong></span>
            </li>

          </ul>

          <a class="w-100 btn btn-primary btn-lg" href="{{ route('cart.index') }}">Checkout</a>
        </div>
      </div>
    </div>
    @else

    @endauth


    <header>
        @include('layouts.user_partial.header')
    </header>

    @yield('content')

    @include('layouts.user_partial.footer')


    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.5/js/lightbox.min.js" integrity="sha512-KbRFbjA5bwNan6DvPl1ODUolvTTZ/vckssnFhka5cG80JVa5zSlRPCr055xSgU/q6oMIGhZWLhcbgIC0fyw3RQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('assets/js/plugins.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('js_user')
  </body>
</html>
