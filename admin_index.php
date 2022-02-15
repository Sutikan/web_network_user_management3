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
						<h3 class="mt-2 text-light">Welcome <small class="text-white-50"><?php echo $username; ?></small></h3>
					</div>
					<div class="card-body">
						<div class="nav nav-pills">
							<a href="#approve" class="nav-link rounded font-weight-bold active" data-toggle="pill"><i class="bi bi-person-check pr-1"></i> Approve</a>
							<a href="#suspend" class="nav-link rounded font-weight-bold" data-toggle="pill"><i class="bi bi-person-x pr-1"></i> Suspend</a>
						</div>
					</div>
				</div>
				<div class=" card border-0 mb-3">
					<div class="tab-content">
						<div class="tab-pane fade show active" id="approve">
							<div class="card-header bg-primary text-light">
								<h4 class="mt-2">Approve Users <small class="text-white-50">They wait for approve.</small></h4>
							</div>
							<div class="card-body">
								<div class="table-responsive-lg">
									<table class="table table-hover text-center bg-white border">
										<thead class="bg-light">
											<th>ID</th>
											<th>Username</th>
											<th>Name</th>
											<th>Lastname</th>
											<th>Group</th>
											<th>Approval</th>
											<th colspan="2">Manage</th>
										</thead>
										<tbody>
											<?php
												$showdata = mysqli_query($con, "SELECT * FROM radcheck, member WHERE radcheck.username = member.username AND attribute != 'Cleartext-Password' AND radcheck.username != '$username'");
												while ($show = mysqli_fetch_assoc($showdata)) {
													$show_username = $show['username']; ?>
												<tr>
													<td><?php echo $show['id']; ?></td>
													<td><?php echo $show_username; ?></td>
													<td><?php echo $show['m_name']; ?></td>
													<td><?php echo $show['m_lastname']; ?></td>
													<td>
														<?php $sGroup = mysqli_query($con, "SELECT * FROM radusergroup WHERE username = '$show_username'");
														$show_group = mysqli_fetch_assoc($sGroup);
														if ($show_group) {
														 	echo $show_group['groupname'];
														 } else {
														 	echo "-";
														 } ?>
													</td>
													<td><button class="btn btn-outline-info btn-block rounded-pill btn-sm font-weight-bold" type="button" data-toggle="modal" data-target="#approveU<?php echo $show['username'] ?>"><i class="bi bi-check-circle pr-1"></i> Approve</button></td>
													<td><button class="btn btn-outline-warning text-secondary rounded-pill btn-sm font-weight-bold btn-block" type="button" data-toggle="modal" data-target="#editU<?php echo $show['username'] ?>"><i class="bi bi-pencil"></i></button></td>
													<td><button class="btn btn-outline-secondary rounded-pill btn-sm font-weight-bold btn-block" type="button" data-toggle="modal" data-target="#delU<?php echo $show['username'] ?>"><i class="bi bi-trash"></i></button></td>
												</tr>
												<div class="modal fade" id="approveU<?php echo $show['username'] ?>">
													<div class="modal-dialog modal-dialog-centered">
														<div class="modal-content">
															<form method="post">
																<div class="card-body text-center">
																	<div class="my-3">
																		<h1 class="text-info"><i class="bi bi-exclamation-diamond"></i></h1>
																		<h5 class="my-3 font-weight-bold">Are you sure</h5>
																		<span>Do you want to <span class="font-weight-bold text-info">approve</span> <b><?php echo $show['username'] ?></b>?</span>
																		<div class="mt-4 mr-2">
																			<div class="row">
																				<div class="col">
																					<button class="btn btn-outline-light btn-sm font-weight-bold text-secondary rounded-pill" type="button" data-dismiss="modal"">Cancel</button>
																				</div>
																				<div class="col">
																					<input type="hidden" name="approve_username" value="<?php echo $show['username'] ?>">
																					<button class="btn btn-outline-info btn-block btn-sm font-weight-bold rounded-pill" type="submit" name="btn_approve">Approve</button>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</form>
															<?php
																if (isset($_POST['btn_approve'])) {
																	$approve_username = $_POST['approve_username'];
																	$approveUser = mysqli_query($con, "UPDATE radcheck SET attribute = 'Cleartext-Password' WHERE username = '$approve_username'");
																	echo "<script>alert('Approve user successful!')</script>";
																	echo "<script>window.location.href='admin_index.php?id=$id'</script>";
																}
															?>
														</div>
													</div>
												</div>

												<div class="modal fade" id="editU<?php echo $show['username'] ?>">
													<div class="modal-dialog modal-dialog-centered">
														<div class="modal-content">
															<form method="post">
																<div class="card-body text-center">
																	<div class="my-3">
																		<div class="text-left">
																			<h5 class="font-weight-bold">Update User</h5>
																			<hr width="100%">
																			<div class="form-group">
																				<label>Username</label>
																				<input type="text" class="form-control rounded-pill" value="<?php echo $show_username; ?>" disabled>
																			</div>
																			<div class="form-row">
																				<div class="form-group col-6">
																					<label>Name</label>
																					<input type="text" name="e_name" class="form-control rounded-pill" placeholder="Name" value="<?php echo $show['m_name']; ?>" required>
																				</div>
																				<div class="form-group col-6">
																					<label>Lastname</label>
																					<input type="text" name="e_lastname" class="form-control rounded-pill" placeholder="Lastname" value="<?php echo $show['m_lastname']; ?>" required>
																				</div>
																			</div>
																			<div class="form-group">
																				<label>Group</label>
																				<select class="form-control rounded-pill" name="e_group">
																					<?php
																						if ($show_group) {
																					?>
																						<option value="<?php echo $show_group['groupname']; ?>"><?php echo $show_group['groupname']; ?></option>
																					<?php } ?>
																					<option value="Default">Default</option>
																					<?php
																						$selectG = mysqli_query($con, "SELECT DISTINCT groupname FROM radgroupcheck");
																						while($sG = mysqli_fetch_assoc($selectG)){ ?>
																							<option value="<?php echo $sG['groupname']; ?>"><?php echo $sG['groupname']; ?></option>
																					<?php	} ?>
																				</select>
																			</div>
																		</div>
																		<div class="mt-4 mr-2">
																			<div class="row">
																				<div class="col">
																					<button class="btn btn-outline-light btn-sm font-weight-bold text-secondary rounded-pill" type="button" data-dismiss="modal"">Cancel</button>
																				</div>
																				<div class="col">
																					<input type="hidden" name="edit_username" value="<?php echo $show['username'] ?>">
																					<button class="btn btn-outline-warning text-secondary btn-block btn-sm font-weight-bold rounded-pill" type="submit" name="btn_edit">Update</button>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</form>
															<?php
																if (isset($_POST['btn_edit'])) {
																	$edit_username = $_POST['edit_username'];
																	$e_name = $_POST['e_name'];
																	$e_lastname = $_POST['e_lastname'];
																	$e_group = $_POST['e_group'];

																	$editUser = mysqli_query($con, "UPDATE member SET m_name = '$e_name', m_lastname = '$e_lastname', m_update = NOW(), m_who = '$username' WHERE username = '$edit_username'");
																	if ($e_group === 'Default') {
																		$cG = mysqli_query($con, "DELETE FROM radusergroup WHERE username = '$edit_username'");
																		echo "<script>alert('Update user successful!')</script>";
																		echo "<script>window.location.href='admin_index.php?id=$id'</script>";
																	} else {
																		$checkUG = mysqli_query($con, "SELECT * FROM radusergroup WHERE username = '$edit_username'");
																		$checkUIG = mysqli_num_rows($checkUG);
																		if ($checkUIG === 1) {
																			$upUIG = mysqli_query($con, "UPDATE radusergroup SET groupname = '$e_group' WHERE username = '$edit_username'");
																			echo "<script>alert('Update user successful!')</script>";
																			echo "<script>window.location.href='admin_index.php?id=$id'</script>";
																		} else {
																			$adfUIG = mysqli_query($con, "INSERT INTO radusergroup (username, groupname, priority) VALUES ('$edit_username', '$e_group', '1')");
																			echo "<script>alert('Update user successful!')</script>";
																			echo "<script>window.location.href='admin_index.php?id=$id'</script>";
																		}
																	}
																	
																}
															?>
														</div>
													</div>
												</div>

												<div class="modal fade" id="delU<?php echo $show['username'] ?>">
													<div class="modal-dialog modal-dialog-centered">
														<div class="modal-content">
															<form method="post">
																<div class="card-body text-center">
																	<div class="my-3">
																		<h1 class="text-dark"><i class="bi bi-exclamation-diamond"></i></h1>
																		<h5 class="my-3 font-weight-bold">Are you sure</h5>
																		<span>Do you want to <span class="font-weight-bold text-secondary">Delete</span> <b><?php echo $show['username'] ?></b>?</span>
																		<div class="mt-4 mr-2">
																			<div class="row">
																				<div class="col">
																					<button class="btn btn-outline-light btn-sm font-weight-bold text-secondary rounded-pill" type="button" data-dismiss="modal"">Cancel</button>
																				</div>
																				<div class="col">
																					<input type="hidden" name="del_username" value="<?php echo $show['username'] ?>">
																					<button class="btn btn-outline-dark btn-block btn-sm font-weight-bold rounded-pill" type="submit" name="btn_del">Delete</button>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</form>
															<?php
																if (isset($_POST['btn_del'])) {
																	$del_username = $_POST['del_username'];
																	$delUser = mysqli_query($con, "DELETE FROM member WHERE username = '$del_username'");
																	$delUser = mysqli_query($con, "DELETE FROM radcheck WHERE username = '$del_username'");
																	$delUser = mysqli_query($con, "DELETE FROM radacct WHERE username = '$del_username'");
																	$delUser = mysqli_query($con, "DELETE FROM radpostauth WHERE username = '$del_username'");
																	$delUser = mysqli_query($con, "DELETE FROM radreply WHERE username = '$del_username'");
																	$delUser = mysqli_query($con, "DELETE FROM radusergroup WHERE username = '$del_username'");
																	echo "<script>alert('Delete user successful!')</script>";
																	echo "<script>window.location.href='admin_index.php?id=$id'</script>";
																}
															?>
														</div>
													</div>
												</div>
											<?php	} ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>

						<div class="tab-pane fade" id="suspend">
							<div class="card-header bg-secondary text-light">
								<h4 class="mt-2">Suspend Users <small class="text-white-50">Who do will to suspened.</small></h4>
							</div>
							<div class="card-body">
								<div class="table-responsive-lg">
									<table class="table table-hover text-center bg-white border">
										<thead class="bg-light">
											<th>ID</th>
											<th>Username</th>
											<th>Name</th>
											<th>Lastname</th>
											<th>Group</th>
											<th>Approval</th>
											<th colspan="2">Manage</th>
										</thead>
										<tbody>
											<?php
												$showdata = mysqli_query($con, "SELECT * FROM radcheck, member WHERE radcheck.username = member.username AND attribute = 'Cleartext-Password' AND radcheck.username != '$username'");
												while ($show = mysqli_fetch_assoc($showdata)) {
													$show_username = $show['username']; ?>
												<tr>
													<td><?php echo $show['id']; ?></td>
													<td><?php echo $show_username; ?></td>
													<td><?php echo $show['m_name']; ?></td>
													<td><?php echo $show['m_lastname']; ?></td>
													<td>
														<?php $sGroup = mysqli_query($con, "SELECT * FROM radusergroup WHERE username = '$show_username'");
														$show_group = mysqli_fetch_assoc($sGroup);
														if ($show_group) {
														 	echo $show_group['groupname'];
														 } else {
														 	echo "-";
														 } ?>
													</td>
													<td><button class="btn btn-outline-dark btn-block rounded-pill btn-sm font-weight-bold" type="button" data-toggle="modal" data-target="#suspendU<?php echo $show['username'] ?>"><i class="bi bi-x-circle pr-1"></i> Suspened</button></td>
													<td><button class="btn btn-outline-warning text-secondary rounded-pill btn-sm font-weight-bold btn-block" type="button" data-toggle="modal" data-target="#editU<?php echo $show['username'] ?>"><i class="bi bi-pencil"></i></button></td>
													<td><button class="btn btn-outline-secondary rounded-pill btn-sm font-weight-bold btn-block" type="button" data-toggle="modal" data-target="#delU<?php echo $show['username'] ?>"><i class="bi bi-trash"></i></button></td>
												</tr>
												<div class="modal fade" id="suspendU<?php echo $show['username'] ?>">
													<div class="modal-dialog modal-dialog-centered">
														<div class="modal-content">
															<form method="post">
																<div class="card-body text-center">
																	<div class="my-3">
																		<h1 class="text-secondary"><i class="bi bi-exclamation-diamond"></i></h1>
																		<h5 class="my-3 font-weight-bold">Are you sure</h5>
																		<span>Do you want to <span class="font-weight-bold text-secondary">approve</span> <b><?php echo $show['username'] ?></b>?</span>
																		<div class="mt-4 mr-2">
																			<div class="row">
																				<div class="col">
																					<button class="btn btn-outline-light btn-sm font-weight-bold text-secondary rounded-pill" type="button" data-dismiss="modal"">Cancel</button>
																				</div>
																				<div class="col">
																					<input type="hidden" name="suspend_username" value="<?php echo $show['username'] ?>">
																					<button class="btn btn-outline-secondary btn-block btn-sm font-weight-bold rounded-pill" type="submit" name="btn_suspened">Suspened</button>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</form>
															<?php
																if (isset($_POST['btn_suspened'])) {
																	$suspend_username = $_POST['suspend_username'];
																	$suspenedUser = mysqli_query($con, "UPDATE radcheck SET attribute = 'Password' WHERE username = '$suspend_username'");
																	echo "<script>alert('Approve user successful!')</script>";
																	echo "<script>window.location.href='admin_index.php?id=$id'</script>";
																}
															?>
														</div>
													</div>
												</div>

												<div class="modal fade" id="editU<?php echo $show['username'] ?>">
													<div class="modal-dialog modal-dialog-centered">
														<div class="modal-content">
															<form method="post">
																<div class="card-body text-center">
																	<div class="my-3">
																		<div class="text-left">
																			<h5 class="font-weight-bold">Update User</h5>
																			<hr width="100%">
																			<div class="form-group">
																				<label>Username</label>
																				<input type="text" class="form-control rounded-pill" value="<?php echo $show_username; ?>" disabled>
																			</div>
																			<div class="form-row">
																				<div class="form-group col-6">
																					<label>Name</label>
																					<input type="text" name="e_name" class="form-control rounded-pill" placeholder="Name" value="<?php echo $show['m_name']; ?>" required>
																				</div>
																				<div class="form-group col-6">
																					<label>Lastname</label>
																					<input type="text" name="e_lastname" class="form-control rounded-pill" placeholder="Lastname" value="<?php echo $show['m_lastname']; ?>" required>
																				</div>
																			</div>
																			<div class="form-group">
																				<label>Group</label>
																				<select class="form-control rounded-pill" name="e_group">
																					<?php
																						if ($show_group) {
																					?>
																						<option value="<?php echo $show_group['groupname']; ?>"><?php echo $show_group['groupname']; ?></option>
																					<?php } ?>
																					<option value="Default">Default</option>
																					<?php
																						$selectG = mysqli_query($con, "SELECT DISTINCT groupname FROM radgroupcheck");
																						while($sG = mysqli_fetch_assoc($selectG)){ ?>
																							<option value="<?php echo $sG['groupname']; ?>"><?php echo $sG['groupname']; ?></option>
																					<?php	} ?>
																				</select>
																			</div>
																		</div>
																		<div class="mt-4 mr-2">
																			<div class="row">
																				<div class="col">
																					<button class="btn btn-outline-light btn-sm font-weight-bold text-secondary rounded-pill" type="button" data-dismiss="modal"">Cancel</button>
																				</div>
																				<div class="col">
																					<input type="hidden" name="edit_username" value="<?php echo $show['username'] ?>">
																					<button class="btn btn-outline-warning text-secondary btn-block btn-sm font-weight-bold rounded-pill" type="submit" name="btn_edit">Update</button>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</form>
															<?php
																if (isset($_POST['btn_edit'])) {
																	$edit_username = $_POST['edit_username'];
																	$e_name = $_POST['e_name'];
																	$e_lastname = $_POST['e_lastname'];
																	$e_group = $_POST['e_group'];

																	$editUser = mysqli_query($con, "UPDATE member SET m_name = '$e_name', m_lastname = '$e_lastname', m_update = NOW(), m_who = '$username' WHERE username = '$edit_username'");
																	if ($e_group === 'Default') {
																		$cG = mysqli_query($con, "DELETE FROM radusergroup WHERE username = '$edit_username'");
																		echo "<script>alert('Update user successful!')</script>";
																		echo "<script>window.location.href='admin_index.php?id=$id'</script>";
																	} else {
																		$checkUG = mysqli_query($con, "SELECT * FROM radusergroup WHERE username = '$edit_username'");
																		$checkUIG = mysqli_num_rows($checkUG);
																		if ($checkUIG === 1) {
																			$upUIG = mysqli_query($con, "UPDATE radusergroup SET groupname = '$e_group' WHERE username = '$edit_username'");
																			echo "<script>alert('Update user successful!')</script>";
																			echo "<script>window.location.href='admin_index.php?id=$id'</script>";
																		} else {
																			$adfUIG = mysqli_query($con, "INSERT INTO radusergroup (username, groupname, priority) VALUES ('$edit_username', '$e_group', '1')");
																			echo "<script>alert('Update user successful!')</script>";
																			echo "<script>window.location.href='admin_index.php?id=$id'</script>";
																		}
																	}
																	
																}
															?>
														</div>
													</div>
												</div>

												<div class="modal fade" id="delU<?php echo $show['username'] ?>">
													<div class="modal-dialog modal-dialog-centered">
														<div class="modal-content">
															<form method="post">
																<div class="card-body text-center">
																	<div class="my-3">
																		<h1 class="text-dark"><i class="bi bi-exclamation-diamond"></i></h1>
																		<h5 class="my-3 font-weight-bold">Are you sure</h5>
																		<span>Do you want to <span class="font-weight-bold text-secondary">Delete</span> <b><?php echo $show['username'] ?></b>?</span>
																		<div class="mt-4 mr-2">
																			<div class="row">
																				<div class="col">
																					<button class="btn btn-outline-light btn-sm font-weight-bold text-secondary rounded-pill" type="button" data-dismiss="modal"">Cancel</button>
																				</div>
																				<div class="col">
																					<input type="hidden" name="del_username" value="<?php echo $show['username'] ?>">
																					<button class="btn btn-outline-dark btn-block btn-sm font-weight-bold rounded-pill" type="submit" name="btn_del">Delete</button>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</form>
															<?php
																if (isset($_POST['btn_del'])) {
																	$del_username = $_POST['del_username'];
																	$delUser = mysqli_query($con, "DELETE FROM member WHERE username = '$del_username'");
																	$delUser = mysqli_query($con, "DELETE FROM radcheck WHERE username = '$del_username'");
																	$delUser = mysqli_query($con, "DELETE FROM radacct WHERE username = '$del_username'");
																	$delUser = mysqli_query($con, "DELETE FROM radpostauth WHERE username = '$del_username'");
																	$delUser = mysqli_query($con, "DELETE FROM radreply WHERE username = '$del_username'");
																	$delUser = mysqli_query($con, "DELETE FROM radusergroup WHERE username = '$del_username'");
																	echo "<script>alert('Delete user successful!')</script>";
																	echo "<script>window.location.href='admin_index.php?id=$id'</script>";
																}
															?>
														</div>
													</div>
												</div>
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