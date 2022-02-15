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
								<h3 class="mt-2 text-light"><i class="bi bi-bar-chart"></i> Network & Time</h3>
							</div>
							<div class="card-body">
								<div class="nav nav-pills">
									<a href="#network" class="nav-link rounded font-weight-bold active" data-toggle="pill"><i class="bi bi-server pr-1"></i> Network</a>
									<a href="#time" class="nav-link rounded font-weight-bold" data-toggle="pill"><i class="bi bi-clock pr-1"></i> Time</a>
								</div>
							</div>
						</div>
						<div class=" card border-0 mb-3">
							<div class="tab-content">
								<div class="tab-pane fade show active" id="network">
									<div class="card-header bg-primary text-light">
										<h4 class="mt-2">Network <small class="text-white-50">Report.</small></h4>
									</div>
									<div class="card-body">
										<div class="table-responsive-lg">
											<table class="table table-bordered text-center">
												<thead class="table-secondary">
													<th>ID</th>
													<th>Username</th>
													<th>Name</th>
													<th>Lastname</th>
													<th>Group</th>
													<th>IP Address</th>
													<th>Start</th>
													<th>Stop</th>
													<th>Note</th>
												</thead>
												<tbody>
													<?php
														$showdata = mysqli_query($con, "SELECT * FROM radcheck, member, radacct WHERE radcheck.username = member.username AND radcheck.username = radacct.username AND attribute = 'Cleartext-Password' AND radcheck.username!='$username'");
														while ($show = mysqli_fetch_assoc($showdata)) { 
															$show_username = $show['username']; ?>
															<tr>
																<td><?php echo $show['id']; ?></td>
																<td><?php echo $show['username']; ?></td>
																<td><?php echo $show['m_name']; ?></td>
																<td><?php echo $show['m_lastname']; ?></td>
																<td><?php 
																	$showgroup = mysqli_query($con, "SELECT * FROM radusergroup WHERE username = '$show_username'");
																	$showG = mysqli_fetch_assoc($showgroup);
																	if ($showG) {
																		echo $showG['groupname'];
																	} else {
																		echo " - ";
																	}
																 ?></td>
																<td><?php echo $show['framedipaddress']; ?></td>
																<td><?php echo $show['acctstarttime']; ?></td>
																<td><?php echo $show['acctstoptime']; ?></td>
																<td><?php echo $show['acctterminatecause']; ?></td>
															</tr>
													<?php	} ?>
												</tbody>
											</table>
										</div>
									</div>
								</div>

								<div class="tab-pane fade" id="time">
									<div class="card-header bg-secondary text-light">
										<h4 class="mt-2">Time <small class="text-white-50">Report.</small></h4>
									</div>
									<div class="card-body">
										<div class="table-responsive-lg">
											<table class="table table-bordered text-center">
												<thead class="table-secondary">
													<th>ID</th>
													<th>Username</th>
													<th>Name</th>
													<th>Lastname</th>
													<th>Group</th>
													<th>Start</th>
													<th>Stop</th>
													<th>Update</th>
													<th>Update By</th>
												</thead>
												<tbody>
													<?php
														$showdata = mysqli_query($con, "SELECT * FROM radcheck, member, radacct WHERE radcheck.username = member.username AND radcheck.username = radacct.username AND attribute = 'Cleartext-Password' AND radcheck.username!='$username'");
														while ($show = mysqli_fetch_assoc($showdata)) {
														$show_username = $show['username']; ?>
															<tr>
																<td><?php echo $show['id']; ?></td>
																<td><?php echo $show['username']; ?></td>
																<td><?php echo $show['m_name']; ?></td>
																<td><?php echo $show['m_lastname']; ?></td>
																<td><?php 
																	$showgroup = mysqli_query($con, "SELECT * FROM radusergroup WHERE username = '$show_username'");
																	$showG = mysqli_fetch_assoc($showgroup);
																	if ($showG) {
																		echo $showG['groupname'];
																	} else {
																		echo " - ";
																	}
																 ?></td>
																<td><?php echo $show['acctstarttime']; ?></td>
																<td><?php echo $show['acctstoptime']; ?></td>
																<td><?php echo $show['m_update']; ?></td>
																<td><?php echo $show['m_who']; ?></td>
															</tr>
													<?php	} ?>
												</tbody>
											</table>
										</div>
									</div>
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