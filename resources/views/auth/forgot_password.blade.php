<!DOCTYPE html>
<html>
    
<head>
	<title>Lupa Password</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<link rel="icon" type="image/x-icon" href="/landpro.png" />
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
</head>
<style>
		body,
		html {
			margin: 0;
			padding: 0;
			height: 100%;
			background: #040189 !important;
		}
		.user_card {
			height: 400px;
			width: 350px;
			margin-top: auto;
			margin-bottom: auto;
			background: #FF7A00;
			position: relative;
			display: flex;
			justify-content: center;
			flex-direction: column;
			padding: 10px;
			box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
			-webkit-box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
			-moz-box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
			border-radius: 5px;

		}
		.brand_logo_container {
			position: absolute;
			height: 170px;
			width: 170px;
			top: -75px;
			border-radius: 10%;
			background: #fff;
			padding: 0px;
			text-align: center;
		}
		.brand_logo {
			height: 150px;
			width: 150px;
			border-radius: 10%;
			border: 0px;
		}
		.form_container {
			margin-top: 100px;
		}
		.login_btn {
			width: 100%;
			background: #040189 !important;
			color: white !important;
		}
		.login_btn:focus {
			box-shadow: none !important;
			outline: 0px !important;
		}
		.login_container {
			padding: 0 2rem;
		}
		.input-group-text {
			background: #040189 !important;
			color: white !important;
			border: 0 !important;
			border-radius: 0.25rem 0 0 0.25rem !important;
		}
		.input_user,
		.input_pass:focus {
			box-shadow: none !important;
			outline: 0px !important;
		}
</style>
<body>
	<div class="container h-100">
		<div class="d-flex justify-content-center h-100">
			<?php if(Session::has('sukses')) : ?>

			<div class="alert alert-success" role="alert">
				{{Session('sukses')}}
			</div>
			<?php endif; ?>
			<?php if(Session::has('error')) : ?>

			<div class="alert alert-danger" role="alert">
				{{Session('error')}}
			</div>
			<?php endif; ?>

			<div class="user_card">
				<div class="d-flex justify-content-center">
					<div class="brand_logo_container">
						<a href="/"><img src="/landpro.png" class="brand_logo" alt="Logo"></a>
					</div>
				</div>
				<div class="d-flex justify-content-center form_container">
					<form method="POST" action="/lupa-password">
                        @csrf
						<div class="input-group mb-2">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fas fa-phone"></i></span>
							</div>
							<input type="number" name="no_telp" class="form-control input_pass" required placeholder="nomor telepon">
						</div>
						<button type="submit" name="button" class="btn login_btn">Kirim Kode</button>
						
							<div class="d-flex justify-content-center mt-3 login_container">
							
							<a href="/login"><button type="button" name="button" class="btn login_btn">Kembali</button></a>
					 
				   </div>
					</form>
					
				</div>
			</div>
		
		</div>
	</div>
</body>
</html>
