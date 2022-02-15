<?php
	@session_start();
	include 'connect.php';
	$id = $_SESSION['id'];
	$username = $_SESSION['username'];
	if (!isset($_SESSION['id'])) {
		echo "<script>window.location.href='index.php'</script>";
	} else {
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
<body style="background-color: #f1f5f9;">

<div class="container-fluid h-100">
	<div class="row h-100">
		<div class="col-auto col-sm-auto col-md-auto bg-white d-none d-md-block"><?php include 'admin_menu.php'; ?></div>
		<div class="col col-sm col-md" style="padding: 0;">
			<?php include 'admin_Tmenu.php'; ?>

			<div class="container-fluid mt-2">
				<div class=" card border-0 mb-3">
					<div class="card-header bg-secondary">
						<h3 class="mt-2 text-light"><i class="bi bi-person-circle"></i> Profile</h3>
					</div>
				</div>
				<div class="card-deck mb-3">
					<div class="card border-0">
						<div class="card-body">
							<h4 class="font-weight-bold text-primary">Update Profile</h4>
							<hr width="100%">
							<?php
								$showpro = mysqli_query($con, "SELECT * FROM member WHERE username = '$username'");
								$pro = mysqli_fetch_assoc($showpro);
							?>
							<form method="post">
								<div class="form-row mb-2">
									<div class="col-2">
										<span class="text-secondary font-weight-bold form-text">Username</span>
									</div>
									<div class="col">
										<input class="form-control rounded-pill" value="<?php echo $username ?>" disabled>
									</div>
								</div>
								<div class="form-row mb-2">
									<div class="col-2">
										<span class="text-secondary font-weight-bold form-text">Name</span>
									</div>
									<div class="col">
										<div class="input-group">
											<input type="text" name="p_name" class="form-control rounded-pill mr-2" placeholder="Name" value="<?php echo $pro['m_name'] ?>" required>
											<input type="text" name="p_lastname" class="form-control rounded-pill" placeholder="Lastname" value="<?php echo $pro['m_lastname'] ?>" required>
										</div>
									</div>
								</div>
								<div class="text-right mt-4">
									<button class="btn btn-outline-primary btn-sm rounded-pill px-5 font-weight-bold" type="submit" name="up_pro">Update</button>
								</div>
							</form>
							<?php
								if (isset($_POST['up_pro'])) {
									$p_name = $_POST['p_name'];
									$p_lastname = $_POST['p_lastname'];

									$upUser = mysqli_query($con, "UPDATE member SET m_name = '$p_name', m_lastname = '$p_lastname', m_update = NOW(), m_who = '$username' WHERE username = '$username'");
										echo "<script>alert('Update profile successful!')</script>";
										echo "<script>window.location.href='admin_profile.php?id=$id'</script>";
								}
							?>
						</div>
					</div>

					<div class="card border-0">
						<div class="card-body">
							<h4 class="font-weight-bold text-primary">Change Password</h4>
							<hr width="100%">
							<form method="post">
								<div class="form-row mb-2">
									<div class="col-3">
										<span class="text-secondary font-weight-bold form-text">Old Passworrd</span>
									</div>
									<div class="col">
										<input type="password" name="c_oldpass" class="form-control rounded-pill mr-2" placeholder="Old Password" required>
									</div>
								</div>
								<div class="form-row mb-2">
									<div class="col-3">
										<span class="text-secondary font-weight-bold form-text">New Passworrd</span>
									</div>
									<div class="col">
										<input type="password" name="c_newpass" class="form-control rounded-pill mr-2" placeholder="New Password" required>
									</div>
								</div>
								<div class="form-row mb-2">
									<div class="col-3">
										<span class="text-secondary font-weight-bold form-text">Confirm Passworrd</span>
									</div>
									<div class="col">
										<input type="password" name="c_conpass" class="form-control rounded-pill mr-2" placeholder="Confirm Password" required>
									</div>
								</div>

								<div class="text-right mt-4">
									<button class="btn btn-outline-secondary text-dark btn-sm rounded-pill px-5 font-weight-bold" type="submit" name="up_pass">Change</button>
								</div>
							</form>
							<?php
								if (isset($_POST['up_pass'])) {
									$c_oldpass = $_POST['c_oldpass'];
									$c_newpass = $_POST['c_newpass'];
									$c_conpass = $_POST['c_conpass'];

									$checkop = mysqli_query($con, "SELECT * FROM radcheck WHERE value = '$c_oldpass' AND username = '$username'");
									$checkold = mysqli_num_rows($checkop);
										if ($checkold === 1) {
											if ($c_newpass === $c_conpass) {
												$upPass = mysqli_query($con, "UPDATE radcheck SET value = '$c_newpass' WHERE username = '$username'");
												$upPass = mysqli_query($con, "UPDATE member SET m_update = NOW(), m_who = '$username' WHERE username = '$username'");
												echo "<script>alert('Update password successful')</script>";
												echo "<script>window.location.href='admin_profile.php?id=$id'</script>";
											} else {
												echo "<script>alert('Password is not match!')</script>";
												echo "<script>window.location.href='admin_profile.php?id=$id'</script>";
											}
										} else {
											echo "<script>alert('Your old password is not correct!')</script>";
											echo "<script>window.location.href='admin_profile.php?id=$id'</script>";
										}

								}
							?>
						</div>
					</div>
				</div>
				
			</div>
		</div>
	</div>
</div>

</body>
</html>
<?php } ?>