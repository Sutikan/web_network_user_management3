<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<body>

	<div class="nav flex-column navbar-light my-3 mx-2" style="min-height: 100vh;">
		<a href="<?php echo "admin_index.php?id=$id" ?>" class="nav-link text-center mt-4 "><span class="badge badge-primary px-3 pt-2"><h2 class="font-weight-bold">IT</h2></span></a>
		<a href="<?php echo "admin_index.php?id=$id" ?>" class="nav-link text-center navbar-brand text-secondary"><h4 class="font-weight-bold">CTC <span class="text-primary text-uppercase">Network</span></h4></a>
		<hr class="text-center" width="100">
		<a href="<?php echo "admin_index.php?id=$id" ?>" class="nav-link text-secondary"><i class="bi bi-clipboard-data pr-2"></i> Dashboard</a>
		<a href="<?php echo "admin_profile.php?id=$id" ?>" class="nav-link text-secondary"><i class="bi bi-person-circle pr-2"></i> Profile</a>
		<a href="<?php echo "admin_GenG.php?id=$id" ?>" class="nav-link text-secondary"><i class="bi bi-journal-plus pr-2"></i> Generate Group</a>
		<a href="<?php echo "admin_GenU.php?id=$id" ?>" class="nav-link text-secondary"><i class="bi bi-person-plus pr-2"></i> Generate Users</a>
		<a href="<?php echo "admin_NetworkTime.php?id=$id" ?>" class="nav-link text-secondary"><i class="bi bi-bar-chart pr-2"></i> Network & Time</a>
		<hr class="text-center" width="100%">
		<button class="btn btn-outline-danger border-0 btn-block btn-sm font-weight-bold" type="button" data-toggle="modal" data-target="#logout"><i class="bi bi-box-arrow-in-right pr-1"></i> Log Out</button>
	</div>

</body>
</html>