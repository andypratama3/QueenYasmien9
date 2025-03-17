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
<li class="sidebar-item {{ request()->routeIs('dashboard.catalog.*') ? 'active' : '' }}">
    <a class="sidebar-link" href="{{ route('dashboard.catalog.index') }}">
        <i class="align-middle bx bx-news" data-feather="bx-news"></i> <span class="align-middle">Katalog</span>
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

<li class="sidebar-item ">
    <a class="sidebar-link {{ request()->routeIs('dashboard.settings.*') ? 'collapsed' : '' }}" href="#settingsDropDown" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="settingsDropDown">
        <i class="align-middle bx bx-cog"></i> <span class="align-middle">Pengaturan</span>
        <i class="align-middle float-end bx bx-chevron-right" data-feather="chevron-right"></i>
    </a>
    <ul class="collapse list-unstyled mx-4 {{ request()->routeIs('dashboard.settings.*') ? 'show' : '' }}" id="settingsDropDown">
        {{-- @canany(['role-view','role-manage','user-view','user-manage']) --}}
        <li class="sidebar-item {{ request()->routeIs('dashboard.settings.roles.*') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('dashboard.settings.roles.index') }}">
                <i class="align-middle" data-feather="list"></i><span class="align-middle">Role</span>
            </a>
        </li>
        <li class="sidebar-item {{ request()->routeIs('dashboard.settings.users.*') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('dashboard.settings.users.index') }}">
                <i class="align-middle" data-feather="users"></i><span class="align-middle">Pengguna</span>
            </a>
        </li>
        {{-- @endcanany --}}
    </ul>
</li>
