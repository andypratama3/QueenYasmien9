<li class="sidebar-header">
    Pages
</li>

<li class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
    <a class="sidebar-link" href="{{ route('dashboard') }}">
        <i class="align-middle" data-feather="sliders"></i> <span
            class="align-middle">Dashboard</span>
    </a>
</li>
<li class="sidebar-item {{ request()->routeIs('dashboard.category.*') ? 'active' : '' }}">
    <a class="sidebar-link" href="{{ route('dashboard.category.index') }}">
        <i class="align-middle bx bxs-category" data-feather="category"></i> <span class="align-middle">Kategori</span>
    </a>
</li>
<li class="sidebar-item {{ request()->routeIs('dashboard.product.*') ? 'active' : '' }}">
    <a class="sidebar-link" href="{{ route('dashboard.product.index') }}">
        <i class="align-middle bx bxl-product-hunt" data-feather="product"></i> <span class="align-middle">Produk</span>
    </a>
</li>


<li class="sidebar-header">
    Pemesanan
</li>
<li class="sidebar-item {{ request()->routeIs('dashboard.pesanan.*') ? 'active' : '' }}">
    <a class="sidebar-link" href="{{ route('dashboard.pesanan.index') }}">

        <i class="align-middle bx bx-cart-download"></i> <span class="align-middle">Pemesanan</span>
    </a>
</li>


{{--

<li class="sidebar-item ">
    <a class="sidebar-link {{ request()->routeIs('dashboard.data.center.*') || request()->routeIs('dashboard.category.data.center.*') ? 'collapsed' : '' }}" href="#dataCenterDropdown" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="dataCenterDropdown">
        <i class="align-middle" data-feather="database"></i> <span class="align-middle">Data Center</span>
        <i class="align-middle float-end" data-feather="chevron-right"></i>
    </a>
    <ul class="collapse list-unstyled mx-4 {{ request()->routeIs('dashboard.data.center.*') || request()->routeIs('dashboard.category.data.center.*') ? 'show' : '' }}" id="dataCenterDropdown">
        <li class="sidebar-item {{ request()->routeIs('dashboard.category.data.center.*') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('dashboard.category.data.center.index') }}">
                <i class="align-middle" data-feather="list"></i><span class="align-middle">Kategori Data</span>
            </a>
        </li>
        <li class="sidebar-item {{ request()->routeIs('dashboard.data.center.index') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('dashboard.data.center.index') }}">
                <i class="align-middle" data-feather="database"></i><span class="align-middle">Data Center</span>
            </a>
        </li>
    </ul>
</li> --}}
