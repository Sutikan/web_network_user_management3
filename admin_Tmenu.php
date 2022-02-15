<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<body>

	<div class="navbar bg-white navbar-light d-block">
		<div class="container-fluid">
			<a href="<?php echo "admin_index.php?id=$id" ?>" class="navbar-brand font-weight-bold text-secondary d-block d-md-none"><span class="badge badge-primary font-weight-bold px-2 py-1 mr-1">IT</span> CTC <span class="text-primary text-uppercase">Network</span></a>
			<button class="navbar-toggler d-block d-md-none" data-toggle="collapse" data-target="#menu"><span class="navbar-toggler-icon"></span></button>
			<div class="collapse navbar-collapse d-lg-none" id="menu">
				<a href="<?php echo "admin_index.php?id=$id" ?>" class="nav-link text-secondary"><i class="bi bi-clipboard-data pr-2"></i> Dashboard</a>
				<a href="<?php echo "admin_profile.php?id=$id" ?>" class="nav-link text-secondary"><i class="bi bi-person-circle pr-2"></i> Profile</a>
				<a href="<?php echo "admin_GenG.php?id=$id" ?>" class="nav-link text-secondary"><i class="bi bi-journal-plus pr-2"></i> Generate Group</a>
				<a href="<?php echo "admin_GenU.php?id=$id" ?>" class="nav-link text-secondary"><i class="bi bi-person-plus pr-2"></i> Generate Users</a>
				<a href="<?php echo "admin_NetworkTime.php?id=$id" ?>" class="nav-link text-secondary"><i class="bi bi-bar-chart pr-2"></i> Network & Time</a>
				<hr class="text-center" width="100%">
				<button class="btn btn-outline-danger border-0 btn-block btn-sm font-weight-bold" type="button" data-toggle="modal" data-target="#logout"><i class="bi bi-box-arrow-in-right pr-1"></i> Log Out</button>
			</div>
			<div class="ml-auto d-none d-md-block">
				<button class="btn btn-outline-danger border-0 btn-sm px-3 font-weight-bold" type="button" data-toggle="modal" data-target="#logout"><i class="bi bi-box-arrow-in-right pr-1"></i> Log Out</button>
			</div>
		</div>
	</div>

	<div class="modal fade" id="logout">
		<div class="modal-dialog modal-dialog-centered modal-sm">
			<div class="modal-content">
				<form method="post">
					<div class="modal-body">
						<div class="my-3 text-center">
							<h1 class="font-weight-bold text-danger"><i class="bi bi-exclamation-diamond"></i></h1>
							<h5 class="mt-3 mb-3">Are you sure</h5>
							<span>Do you want to <span class="text-danger font-weight-bold">log out</span> <?php echo $username ?>?</span>
							<div class="mt-4 mr-2 text-right">
								<div class="row">
									<div class="col">
										<button class="btn btn-outline-light btn-block btn-sm font-weight-bold text-secondary rounded-pill" type="button" data-dismiss="modal" style="text-decoration: none;">Cancel</button>
									</div>
									<div class="col">
										<button class="btn btn-outline-danger btn-block btn-sm ont-weight-bold rounded-pill" type="submit" name="btn_logout">Log Out</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</form>
				<?php
					if (isset($_POST['btn_logout'])) {
						session_destroy();
						echo "<script>window.location.href='index.php'</script>";
					}
				?>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

</body>
</html>