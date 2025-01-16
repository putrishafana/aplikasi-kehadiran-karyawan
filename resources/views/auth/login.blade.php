<!doctype html>
<html lang="en">
  <head>
  	<title>E-Attandance</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" href="{{ asset('assetslogin/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">


	</head>
	<body>
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-7 col-lg-5">
					<div class="login-wrap p-4 p-md-5">
		      	<div class=" d-flex align-items-center justify-content-center">
		      		<img width="40%" height="40%" src="{{ asset('assets/img/attandance.png') }}">
		      	</div>

		      	<h2 class="text-center mb-4">Login</h3>

                  @php
                  $messagewarning = Session::get('warning');
                  @endphp

                  @if (Session::get('warning'))
                      <div class="alert alert-outline-danger mb-3">
                          {{ $messagewarning }}
                      </div>
                  @endif
						<form action="/gologin" method="POST" class="login-form">
                            @csrf
		      		<div class="form-group">
		      			<input type="email" name="email" id="email" class="form-control rounded-left" placeholder="Email" required>
		      		</div>
	            <div class="form-group d-flex">
	              <input type="password" name="password" id="password" class="form-control rounded-left" placeholder="Password" required>
	            </div>
	            <div class="form-group">
	            	<button type="submit" class="form-control btn btn-primary rounded submit px-3">Login</button>
	            </div>
	            <div class="form-group d-md-flex">
								<div class="w-50 text-md-left">
									<a href="#">Forgot Password</a>
								</div>
	            </div>
	          </form>
	        </div>
				</div>
			</div>
		</div>
	</section>

	<script src="{{ asset('assetslogin/js/jquery.min.js') }}"></script>
  <script src="{{ asset('assetslogin/js/popper.js') }}"></script>
  <script src="{{ asset('assetslogin/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assetslogin/js/main.js') }}"></script>

	</body>
</html>

