<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">
<meta name="keywords" content="">
<meta name="csrf-token" content="{{ csrf_token() }}">

<link rel="preconnect" href="https://fonts.gstatic.com">
<link rel="shortcut icon" href="{{ asset('assets/images/logo-small.png') }}" />


<title>@yield('title') | Queen Yasmin </title>

{{-- Box Icons --}}
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

{{-- DataTable --}}
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">
{{-- Styles --}}
<link href="{{ asset('asset_dashboard/css/app.css') }}" rel="stylesheet">
{{-- Fonts --}}
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
@stack('css')

{{-- <!-- Scripts -->
@vite(['resources/css/app.css', 'resources/js/app.js'])

<!-- Styles -->
@livewireStyles --}}
