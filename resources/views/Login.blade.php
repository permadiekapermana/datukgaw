<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>DATUKGAW | {{ $title }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<!-- core:css -->
	<link rel="stylesheet" href="{{ asset('assets/vendors/core/core.css') }}">
	<!-- endinject -->
  <!-- plugin css for this page -->
	<!-- end plugin css for this page -->
	<!-- inject:css -->
	<link rel="stylesheet" href="{{ asset('assets/fonts/feather-font/css/iconfont.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/vendors/flag-icon-css/css/flag-icon.min.css') }}">
	<!-- endinject -->
  <!-- Layout styles -->  
    <link rel="stylesheet" href="{{ asset('assets/css/demo_1/app.css') }}">
  <!-- End layout styles -->
  <link rel="shortcut icon" href="../../../assets/images/favicon.png" />
  {{-- sweet alert custom style --}}
  <link rel="stylesheet" href="{{ asset('sweetalert/style.css') }}">
</head>
<body>
	<div class="main-wrapper">
		<div class="page-wrapper full-page">
			<div class="page-content d-flex align-items-center justify-content-center">
				<div class="row w-100 mx-0 auth-page">
					<div class="col-md-8 col-xl-6 mx-auto">
						<div class="card">
							<div class="row">
                <div class="col-md-12">
                  <div class="auth-form-wrapper px-4 py-5">
                    <div class="d-flex flex-column align-items-center">
                      <div>
                        <img src="../../../assets/images/datuk-gaw.png" class="wd-500 mb-5">
                      </div>
                    </div>
                    <a href="#" class="noble-ui-logo d-block mb-2"><span>Dashboard Dokumen Audit Tata Usaha dan Keuangan (DATUk) GAW Bukit Kototabang</span></a>
                    <h5 class="text-muted font-weight-normal mb-4">Selamat datang! Silahkan login dengan akun anda.</h5>
                    {{-- <form class="forms-sample"> --}}
                      <div class="form-group">
                        <label for="exampleInputEmail1">Email</label>
                        <input id="email" autofocus type="text" class="form-control" placeholder="Masukan Email">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input id="password" type="password" class="form-control" placeholder="Masukan Password">
                      </div>
                      <div class="mt-3">
                        <button class="btn btn-primary mr-2 mb-2 mb-md-0 text-white" style="width: 100%;" onclick="login()">Login</button>
                      </div>
                    {{-- </form> --}}
                  </div>
                </div>
              </div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>

	<!-- core:js -->
	<script src="{{ asset('assets/vendors/core/core.js') }}"></script>
	<!-- endinject -->
  <!-- plugin js for this page -->
	<!-- end plugin js for this page -->
	<!-- inject:js -->
	<script src="{{ asset('assets/vendors/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/template.js') }}"></script>
	<!-- endinject -->
  <!-- custom js for this page -->
	<!-- end custom js for this page -->
    {{-- SweetAlert --}}
    <script src="{{ asset('sweetalert/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('jquery/header.js') }}"></script>
    <script src="{{ asset('js/common.js') }}"></script>
    <script src="{{ asset('js/commonAPI.js') }}"></script>
    <!-- JQUERY -->
    <script src="{{ asset('jquery/login.js') }}"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
</body>
</html>