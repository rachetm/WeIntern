<?php
	session_start();
	require_once 'include/db.php';
	if (isset($_SESSION['logged_in'])) 
	{
		if ( $_SESSION['username']=='admin')
		{
			function display($con)
			{
				$stmt = $con->prepare("SELECT * FROM `log` WHERE username = ?");
				$stmt->bind_param("s",$_GET['username']);
				$stmt->execute();
				$result = $stmt->get_result();
				global $total;
				while($row = $result->fetch_assoc())
				{
					echo "<tr>
							<td>".$row['date']."</td>
							<td>".$row['checkin']."</td>
							<td>".$row['checkout']."</td>
							<td>".$row['total_hrs']."</td>
						  </tr>";
					 
					sscanf($row['total_hrs'], "%d:%d:%d", $hours, $minutes, $seconds);
					$time_seconds = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
					$total += $time_seconds;
				}
				$seconds = $total;
				$H = floor($seconds / 3600);
				$i = ($seconds / 60) % 60;
				$s = $seconds % 60;
				$total = sprintf("%02d Hrs %02d Mins %02d Secs", $H, $i, $s);
			}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Details</title>
		<link rel="stylesheet" type="text/css" href="bootstrap.css">
		<link rel="stylesheet" type="text/css" href="admin.css">
		<link href="https://fonts.googleapis.com/css?family=Titillium+Web:400,300,600" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
		<link href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,600,700,900" rel="stylesheet">
	</head>
	<body>
		<?php include 'adduser.php'; ?>
		<div class="container" id="msgcon">
		<?php
			if (isset($_SESSION['message']) and !empty($_SESSION['message'])) {
			echo "<div class='alert alert-".$_SESSION['type']."'>".$_SESSION['message']."</div>";
			unset($_SESSION['message']);}
		?>
		</div>

		<div class="container table-responsive tablecon">
			<table class="table table-dark table-bordered table-striped">
				<tr>
					<th>User : <?php echo $_GET['username']; ?></th>
				</tr>
			</table>
			<table class="table table-dark table-bordered table-striped">
				<thead class="thead-dark">
					<tr>
						<th>Date</th>
						<th>In Time</th>
						<th>Out Time</th>
						<th>Total Hours</th>
					</tr>
				</thead>
				<tbody>
					<?php
						display($con);
						echo"<tr>
						<td></td>
						<td></td>
						<td>Total : </td>
						<td>".$total."</td>
					</tr>"
					?>
				</tbody>
			</table>
		</div>
		
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
	</body>
</html>

<?php
}
else{
	$_SESSION['message'] = "Forbidden";
    $_SESSION['type'] = 'danger';
    header('Location: index.php');
}
} else {
    $_SESSION['message'] = "Please login to continue!";
    $_SESSION['type'] = 'danger';
    header('Location: index.php');
}

?>