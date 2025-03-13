<!DOCTYPE html>
<html lang="en" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('layouts.dashboard.head')
</head>

<body>
    <div class="wrapper">
        <nav id="sidebar" class="sidebar js-sidebar">
            <div class="sidebar-content js-simplebar">
                <a class="sidebar-brand" href="{{ route('dashboard') }}">
                    <img src="{{ asset('assets/images/logo-width.png') }}" alt="" class="img-fluid">
                </a>

                <ul class="sidebar-nav">
                   @include('layouts.dashboard.sidebar')
                </ul>
            </div>
        </nav>

        <div class="main">
            <nav class="navbar navbar-expand navbar-light navbar-bg">
                @include('layouts.dashboard.navbar')
            </nav>

            <main class="content">
                <div class="container-fluid p-0">
                    @yield('content')
                </div>
            </main>

            <footer class="footer">
               @include('layouts.dashboard.footer')
            </footer>
        </div>
    </div>

    @include('layouts.dashboard.script')

</body>

</html>
