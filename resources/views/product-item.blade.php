<div class="col">
    <div class="product-item">
        <figure>
            <a href="{{ asset('storage/product/' . $product->foto) }}" data-lightbox="product" title="{{ $product->name }}">
                <img src="{{ asset('storage/product/'. $product->foto) }}" class="tab-image">
            </a>
        </figure>
        <h3>{{ \Str::limit($product->name, 20, '...') }}</h3>
        <span class="qty">{{ $product->stock }} Unit</span>
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
            <button  data-id="{{ $product->id }}" class="btn btn-secondary btn-sm btn-show">
                    <i class="bx bx-info-circle me-2"></i> Lihat Detail Produk
                </button>
                <button data-id="{{ $product->id }}" class="btn btn-primary btn-sm d-flex align-items-center cart">
                    <i class="bx bx-cart-download bx-md me-2"></i> Keranjang
                </button>
            </div>
        </div>
    </div>
</div>
