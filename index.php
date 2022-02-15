<?php
	@session_start();
	include 'connect.php';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>CTC NETWORK</title>
	<link rel="stylesheet" type="text/css" href="bootstrap-4.6.1-dist/css/bootstrap.css">
	<script type="text/javascript" src="jquery/jquery-3.6.0.min.js"></script>
	<script type="text/javascript" src="bootstrap-4.6.1-dist/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="bootstrap-icons-1.7.2/bootstrap-icons.css">
</head>
<body style="background-color: #e5e5e6; min-height: 100vh;" class="d-flex justify-content-center align-items-center">

	<div class="card border-0 bg-light">
		<div class="card-header bg-primary">
			<div class="nav nav-tabs card-header-tabs">
				<a href="#login" class="nav-link active font-weight-bold" data-toggle="tab">Log In</a>
				<a href="#signup" class="nav-link font-weight-bold" data-toggle="tab">Sign Up</a>
			</div>
		</div>
		<div class="card-body my-3">
			<div class="tab-content my-3 mx-3">
				<div class="tab-pane fade show active" id="login">
					<h3 class="text-primary font-weight-bold text-center">CTC NETWORK</h3>
					<h5 class="font-weight-bold text-secondary text-center text-uppercase">User Login</h5>
					<br>
					<form method="post">
						<input type="text" name="l_username" class="form-control border-top-0 border-bottom-0 border-right-0 border-left border-primary mb-2" placeholder="Username" required>
						<input type="password" name="l_pass" class="form-control border-top-0 border-bottom-0 border-right-0 border-left border-primary mb-2" placeholder="Password" required>
						<button class="btn btn-primary btn-block btn-sm font-weight-bold mt-3" type="submit" name="btn_login">Log In</button>
					</form>
					<?php
						if (isset($_POST['btn_login'])) {
							$login = mysqli_query($con, "SELECT * FROM radcheck WHERE username = '".trim($_POST['l_username'])."' AND value = '".trim($_POST['l_pass'])."'");
							$data = mysqli_fetch_assoc($login);
							if ($data) {
								if ($data['attribute'] === 'Cleartext-Password') {
									$id = $data['id'];
									$_SESSION['id'] = $data['id'];
									$_SESSION['username'] = $data['username'];
									if ($data['username'] === 'admin') {
										echo "<script>window.location.href='admin_index.php?id=$id'</script>";
									} else {
										echo "<script>window.location.href='user_index.php?id=$id'</script>";
									}
								} else {
									echo "<script>alert('This username has been suspened.')</script>";
									echo "<script>window.location.href='index.php'</script>";
								}
							} else {
								echo "<script>alert('Username or Password is not correct, Please check')</script>";
								echo "<script>window.location.href='index.php'</script>";
							}
						}
					?>
				</div>
				<div class="tab-pane fade" id="signup">
					<h3 class="text-primary font-weight-bold text-center">CTC NETWORK</h3>
					<h5 class="font-weight-bold text-secondary text-center text-uppercase">User Signup</h5>
					<br>
					<form method="post">
						<div class="form-row">
							<div class="col">
								<input type="text" name="s_name" class="form-control border-top-0 border-bottom-0 border-right-0 border-left border-primary mb-2" placeholder="Name" required>
							</div>
							<div class="col">
								<input type="text" name="s_lastname" class="form-control border-top-0 border-bottom-0 border-right-0 border-left border-primary mb-2" placeholder="Lastname" required>
							</div>
						</div>
						<input type="text" name="s_username" class="form-control border-top-0 border-bottom-0 border-right-0 border-left border-primary mb-2" placeholder="Username" required>
						<input type="password" name="s_pass" class="form-control border-top-0 border-bottom-0 border-right-0 border-left border-primary mb-2" placeholder="Password" required>
						<button class="btn btn-primary btn-block btn-sm font-weight-bold mt-3" type="submit" name="btn_signup">Sign Up</button>
					</form>
					<?php
						if (isset($_POST['btn_signup'])) {
							$s_name = $_POST['s_name'];
							$s_lastname = $_POST['s_lastname'];
							$s_username = $_POST['s_username'];
							$s_pass = $_POST['s_pass'];

							$checkname = mysqli_query($con, "SELECT * FROM radcheck WHERE username = '$s_username'");
							$checkN = mysqli_num_rows($checkname);
							if ($checkN === 1) {
								echo "<script>alert('This username is already exist!')</script>";
								echo "<script>window.location.href='index.php'</script>";
							} else {
								$signup = mysqli_query($con, "INSERT INTO radcheck (username, attribute, op, value) VALUES ('$s_username', 'Password', ':=', '$s_pass')");
								$signup = mysqli_query($con, "INSERT INTO member (username, name, lastname) VALUES ('$s_username', '$s_name', '$s_lastname')");
								echo "<script>alert('Sign up successful, Please wait for approval')</script>";
								echo "<script>window.location.href='index.php'</script>";
							}
						}
					?>
				</div>
			</div>
		</div>
	</div>

</body>
</html>