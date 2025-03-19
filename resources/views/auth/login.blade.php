<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">
<meta name="keywords" content="">
<meta name="csrf-token" content="{{ csrf_token() }}">

<link rel="preconnect" href="https://fonts.gstatic.com">
<link rel="shortcut icon" href="{{ asset('assets/images/logo-small.png') }}" />


<title>Login | Queen Yasmin </title>

{{-- Box Icons --}}
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

{{-- DataTable --}}
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">
{{-- Styles --}}
<link href="{{ asset('asset_dashboard/css/app.css') }}" rel="stylesheet">
{{-- Fonts --}}
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
	<main class="d-flex w-100">
		<div class="container d-flex flex-column">
			<div class="row vh-100">
				<div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
					<div class="d-table-cell align-middle">

						<div class="text-center mt-4">
                            <img class="" src="{{ asset('assets/images/logo-small.png') }}" class="img-fluid" alt="" style="width: 40%;">
							<p class="lead mt-2">
								Selamat Datang di Halaman Login Website Queen Yasmin
							</p>
						</div>

						<div class="card">
							<div class="card-body">
								<div class="m-sm-3">
									<form action="{{ route('login') }}" method="POST">
                                        @csrf
										<div class="mb-3">
											<label class="form-label">Email</label>
											<input class="form-control form-control-lg" type="email" name="email" placeholder="Enter your email" />
										</div>
										<div class="mb-3">
											<label class="form-label">Password</label>
											<input class="form-control form-control-lg" type="password" name="password" placeholder="Enter your password" />
										</div>

										<div class="d-grid gap-2 mt-3">
											<button class="btn btn-primary" type="submit">Login</button>
                                            <a href="{{ route('register') }}" class="btn btn-primary">Daftar Akun</a>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>

	<script src="{{ asset('asset_dashboard/js/app.js') }}"></script>

</body>

</html>
