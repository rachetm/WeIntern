<?php

	session_start();
	require_once 'include/db.php';
	if (isset($_SESSION['logged_in']))
	{
		if ( $_SESSION['username']=='admin')
		{

			function display($con)
			{	
				$stmt = $con->prepare("SELECT * FROM `login` WHERE `username` != 'admin'");
				$stmt->execute();
				$result = $stmt->get_result();
				while($row = $result->fetch_assoc())
				{
					echo "<tr> 
							<td>".$row['name']."</td> <td><a class='btn btn-outline-light' style='text-decoration: none' href='details.php?username=".$row['username']."'>View</a></td> 
							</tr>";
				}
			}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Admin Console</title>
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
				<thead class="thead-dark">
					<tr>
						<th>Name</th>
						<th>Details</th>
					</tr>
				</thead>
				<tbody>
						<?php
							display($con);
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
else
{
	$_SESSION['message'] = "Forbidden";
    $_SESSION['type'] = 'danger';
    header('Location: ./index.php');
}
} 
else 
{
    $_SESSION['message'] = "You are logged out. Please login to continue!";
    $_SESSION['type'] = 'danger';
    header('Location: ./index.php');
}