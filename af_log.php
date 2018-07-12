<?php
session_start();

if (isset($_SESSION['logged_in']) && $_SESSION['username']!='admin') {
	include 'include/db.php';
	$stmt = $con->prepare("SELECT status FROM `login` WHERE `username` = ?");
	$stmt->bind_param("s", $username);
	$username = $_SESSION['username'];
	$stmt->execute();
	$result = $stmt->get_result();
	
	$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>User's Dash</title>
		<link rel="stylesheet" type="text/css" href="bootstrap.css">
		<link rel="stylesheet" type="text/css" href="af_log.css">
		<link href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,700,900" rel="stylesheet">
	</head>
	<body>
		<div class="container-fluid">
			<div class="row" style="justify-content: center;">
				<div class="col-sm-12 col-lg-6" style="justify-content: center;">
					<h1>Hi, <?= $_SESSION['name']?></h1>
					<hr>
					<div class="alert alert-info" style="text-align:center; font-family: Raleway; font-size: 17px; font-weight: 700; " ><?php echo "STATUS : "; if($row['status']==0) echo "Checked out"; else echo "Checked in"; ?></div>
					<div class="row allbtn" style="justify-content: center;">
						<div style="display:flex; justify-content: center;"><button onclick="window.location.href='process.php'" <?php if($row['status']==1) echo "disabled"; ?> class="btn btn-success">Check In</button></div>
					</div>
					<div class="row allbtn" style="justify-content: center;">
						<div style="display:flex; justify-content: center;"><button onclick="window.location.href='process.php'" <?php if($row['status']==0) echo "disabled" ?> class="btn btn-danger ">Check Out</button></div>
					</div>
					<div class="row allbtn" style="justify-content: center;">
						<a style="text-decoration: none; padding: 0.375rem 0.75rem;" href="logout.php" class="btn btn-primary">Log Out</a>
					</div>
				</div>
			</div>
			<div class="row" style="display:flex; justify-content: center; align-items: center;">
				<a class="pull-right" href="chgpwd.php">Change Password</a>
			</div>
		</body>
	</html>

	<?php
} else {
    $_SESSION['message'] = "You are logged out. Please login to continue!";
    $_SESSION['type'] = "danger";
    header('Location: ./index.php');
}

?>