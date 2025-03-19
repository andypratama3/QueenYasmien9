@extends('layouts.user')

@section('title', 'Keranjang')

@push('css_user')
<style>
    .card .img-chart {
        width: 100% !important;
        height: 250px !important;
        border-radius: 20px;
        object-fit: cover;
    }

    .btn-checkbox {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    @media (max-width: 768px) {
        .post-item {
            text-align: center;
        }
    }
</style>
@endpush

@section('content')

<section id="latest-blog">
    <div class="container-fluid">
        <div class="row">
            <div class="section-header d-flex align-items-center justify-content-between my-5">
                <h2 class="section-title">List Keranjang</h2>
            </div>
        </div>
        <div class="row mx-2">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <!-- Checkbox Pilih Semua -->
                        @if ($charts->count() > 0)
                        <div class="col-md-12 mb-3 d-flex align-items-center justify-content-end">
                            <input type="checkbox" id="select-all" class="me-2 d-none">
                            <button id="btn-select-all" class="mb-0 btn btn-primary">Pilih Semua</button>
                        </div>
                        @endif
                        @forelse ($charts as $chart)
                        <div class="col-md-12 mt-2">
                            <div class="product-item">
                                <div class="row align-items-center">
                                    <!-- Gambar -->
                                    <div class="col-sm-12 col-md-3 text-center">
                                        <a href="{{ asset('storage/product/'.$chart->product->foto) }}">
                                            <img src="{{ asset('storage/product/'.$chart->product->foto) }}" alt="post"
                                                class="img-fluid img-chart">
                                        </a>
                                    </div>

                                    <!-- Deskripsi -->
                                    <div class="col-sm-12 col-md-9">
                                        <div class="post-header">
                                            <h3 class="post-title">
                                                <a href="#" class="text-decoration-none">{{ $chart->product->name }}</a>
                                            </h3>

                                            <span class="qty">Jumlah: <span
                                                    class="qty-value">{{ $chart->qty }}</span> Unit</span><br>
                                                    <span class="price res">
                                                        Total: <span class="subtotal ">Rp.
                                                            @php
                                                                $price = $chart->product->price > 0
                                                                    ? $chart->product->price
                                                                    : ($chart->product->product_reseller->first()->price_reseller ?? 0);
                                                            @endphp
                                                            {{ number_format($price * $chart->qty, 0, ',', '.') }}
                                                        </span>
                                                    </span>
                                                    @if($chart->product->category->name != 'Paket Reseller')
                                                    {{-- Tampilan default untuk kategori selain "Product Reseller" --}}
                                                    <div class="d-flex align-items-center justify-content-between mt-3">
                                                        <div class="input-group product-qty">
                                                            <span class="input-group-btn">
                                                                <button type="button" class="quantity-left-minus btn btn-danger btn-number" data-type="minus">
                                                                    <i class="bx bx-minus"></i>
                                                                </button>
                                                            </span>
                                                            <input type="text" name="quantity"
                                                                class="form-control bg-none input-number qty-input"
                                                                data-price="{{ $chart->product->price }}"
                                                                data-id="{{ $chart->id }}" value="{{ $chart->qty }}">
                                                            <span class="input-group-btn">
                                                                <button type="button" class="quantity-right-plus btn btn-success btn-number" data-type="plus">
                                                                    <i class="bx bx-plus"></i>
                                                                </button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                @else

                                                    @if (optional($chart->product)->product_reseller->isNotEmpty())
                                                        <div class="mt-3">
                                                            <label for="resellerPackage">Pilih Paket Reseller:</label>
                                                            <select name="reseller_package" id="resellerPackage" class="form-control reseller-select">
                                                                <option value="">Pilih paket reseller...</option>
                                                                @foreach ($chart->product->product_reseller as $reseller)
                                                                    <option value="{{ $reseller->id }}" data-price="{{ $reseller->price_reseller }}">
                                                                        {{ $reseller->name }} - Rp. {{ number_format($reseller->price_reseller, 0, ',', '.') }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    @endif

                                                @endif

                                            <button
                                                data-id="{{ $chart->id }}" class="btn btn-primary product-delete mt-5 d-flex align-items-center">
                                                Hapus
                                            </button>

                                            <button
                                                class="btn btn-primary  d-flex align-items-center float-end chart btn-checkbox">
                                                Pilih
                                                <input type="checkbox" name="selected_items[]" class="select-item d-none"
                                                    value="{{ $chart->product->id }}">
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-md-12 mt-4 text-center">
                            <h6 class="text-center">Tidak Ada Produk</h6>
                            <a href="{{ route('home') }}" class="btn btn-primary text-center">Pilih Produk</a>
                        </div>
                        @endforelse


                        @if($charts->count() > 0)
                        <div class="card p-4">

                            <div class="card-header bg-primary" style="border-radius: 10px;">
                                <h6 class="">Detail Pengiriman</h6>
                            </div>

                            <div class="col-md-12 mt-2 m-2">
                                <label for="pengiriman" class="form-label">Jenis Pengiriman <code>*</code></label>
                                <input type="text" class="form-control" id="pengiriman" name="pengiriman" value="{{ old('pengiriman') }}">
                                <p>
                                    Pada Pengiriman
                                </p>
                            </div>

                            <div class="col-md-12 mt-2 m-2">
                                <label for="alamat" class="form-label">Alamat <code>*</code></label>
                                <textarea name="alamat" id="alamat" cols="10" rows="10" class="form-control"></textarea>
                            </div>
                            <div class="col-md-12 mt-4 mb-3">
                                <div class="post-item card border-0 shadow-sm p-3">
                                    <h4 id="card-detail">Subtotal: Rp. <span id="grand-total">0</span></h4>
                                </div>
                            </div>
                            <div class="mt-4 text-end">
                                <button id="process-selected" class="btn btn-primary">Lakukan Pembayaran</button>
                            </div>
                        </div>

                        @endif
                    </div>


                </div>
            </div>
        </div>
    </div>
</section>

@push('js_user')
<script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT') }}"></script>

<script type="text/javascript">
    $(document).ready(function () {


    });
</script>
<script>
    $(document).ready(function () {

        $('.product-item').on('click', '.product-delete', function () {
            let id = $(this).data('id');
            let url = "{{ route('cart.destroy', ':id') }}".replace(':id', id);
           // ajax setup
           $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });
            $.ajax({
                url: url,
                type: 'DELETE',
                success: function (response) {
                    location.reload();
                },
                error: function (xhr, status, error) {
                    console.log(error);
                }
            });
        });

    });

    document.addEventListener('DOMContentLoaded', function () {
    let selectAllCheckbox = document.getElementById('select-all');
    let selectAllButton = document.getElementById('btn-select-all');
    let checkboxes = document.querySelectorAll('.select-item');
    let grandTotal = document.getElementById('grand-total');

    function updateGrandTotal() {
        let total = 0;
        document.querySelectorAll('.select-item:checked').forEach(checkbox => {
            let row = checkbox.closest('.product-item');
            let subtotal = row.querySelector('.subtotal').textContent.replace(/[^\d]/g, '');
            total += parseInt(subtotal) || 0;
        });
        grandTotal.textContent = "Rp. " + total.toLocaleString('id-ID');
    }

    selectAllButton.addEventListener('click', function () {
        let allSelected = selectAllCheckbox.checked;
        checkboxes.forEach(checkbox => {
            checkbox.checked = !allSelected;
            updateButtonText(checkbox);
        });
        selectAllCheckbox.checked = !allSelected;
        selectAllButton.textContent = !allSelected ? "Batalkan Semua" : "Pilih Semua";
        updateGrandTotal();
    });

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            updateButtonText(checkbox);
            updateGrandTotal();
        });
    });

    function updateButtonText(checkbox) {
        let button = checkbox.closest('.btn-checkbox');
        if (checkbox.checked) {
            button.style.backgroundColor = "#007bff";
            button.childNodes[0].textContent = "Dipilih ";
        } else {
            button.style.backgroundColor = '';
            button.childNodes[0].textContent = "Pilih ";
        }
    }

    document.querySelectorAll('.btn-checkbox').forEach(button => {
        button.addEventListener('click', function (event) {
            event.preventDefault();
            let checkbox = this.querySelector('.select-item');
            checkbox.checked = !checkbox.checked;
            updateButtonText(checkbox);
            updateGrandTotal();
        });
    });

    document.querySelectorAll('.reseller-select').forEach(select => {
        select.addEventListener('change', function () {
            let selectedOption = this.options[this.selectedIndex];
            let resellerPrice = selectedOption?.getAttribute('data-price') || 0;
            let row = this.closest('.product-item');
            let priceDisplay = row.querySelector('.subtotal');
            let checkbox = row.querySelector('.select-item'); // Ambil checkbox

            // Hanya update subtotal jika item dipilih (checkbox checked)
            if (checkbox && checkbox.checked && priceDisplay) {
                priceDisplay.textContent = "Rp. " + parseInt(resellerPrice).toLocaleString('id-ID');
                updateGrandTotal(); // Perbarui total hanya jika item dipilih
            }
        });
    });



    document.querySelectorAll('.qty-input').forEach(input => {
        input.addEventListener('input', function () {
            let qty = parseInt(this.value) || 1;
            let price = parseInt(this.dataset.price) || 0;
            if (qty < 1 || isNaN(qty)) {
                qty = 1;
                this.value = 1;
            }
            let row = this.closest('.product-item');
            let subtotalElement = row.querySelector('.subtotal');
            let subtotal = qty * price;
            subtotalElement.textContent = "Rp. " + subtotal.toLocaleString('id-ID');
            updateGrandTotal();
        });
    });

    document.querySelectorAll('.quantity-left-minus, .quantity-right-plus').forEach(button => {
        button.addEventListener('click', function () {
            let input = this.closest('.product-qty').querySelector('.qty-input');
            let qty = parseInt(input.value) || 1;
            if (this.dataset.type === 'minus') {
                qty = Math.max(1, qty - 1);
            } else {
                qty += 1;
            }
            input.value = qty;
            input.dispatchEvent(new Event('input'));
        });
    });

    document.getElementById('process-selected').addEventListener('click', function () {
        let selectedItems = [];
        let selected_reseller = []
        let qtyItems = [];

        let pengiriman = document.getElementById('pengiriman').value;
        let alamat = document.getElementById('alamat').value;


        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                let row = checkbox.closest('.product-item');

                let resellerPackage = row.querySelector('.reseller-select');
                let quantity = row.querySelector('.qty-input');
                if (quantity && !quantity.value) {
                    quantity.value = 1;
                }


                if(resellerPackage && resellerPackage.value) {
                    selected_reseller.push(resellerPackage.value);
                }
                selectedItems.push(checkbox.value);
                qtyItems.push(quantity);
            }
        });




        if (selectedItems.length === 0) {
            Swal.fire({
                icon: 'warning',
                text: "Minimal 1 Produk",
                icon: "error"
            });
            return;
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('checkout') }}",
            type: 'POST',
            data: {
                items: selectedItems,
                selected_reseller: selected_reseller,
                qty: qtyItems,
                pengiriman: pengiriman,
                alamat: alamat
            },
            success: function (response) {
                let snapToken = response.snap_token;
                snap.pay(snapToken, {
                onSuccess: function (result) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Pembayaran Berhasil',
                        confirmButtonColor: '#f7a422',
                        confirmButtonText: 'OK',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '{{ route("pesanan.index") }}';
                        }
                    });

                },
                onPending: function (result) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Pembayaran Sedang Dalam Proses',
                        text: 'Silakan lakukan pembayaran pada menu pembayaran.',
                   }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '{{ route("pesanan.index") }}';
                        }
                    });
                },
                onError: function (result) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Pembayaran Gagal. Silakan coba lagi.',
                   }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '{{ route("pesanan.index") }}';
                        }
                    });
                }
            });
            },
            error: function (xhr, status, error) {
                console.log(error);
            }
        });
    });
});


</script>
@endpush

@endsection
