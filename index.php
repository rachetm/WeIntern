<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>WeIntern • Log In</title>
		<link rel="stylesheet" type="text/css" href="bootstrap.css">
		<link rel="stylesheet" type="text/css" href="index.css">
		<link href="https://fonts.googleapis.com/css?family=Titillium+Web:400,300,600" rel="stylesheet" type="text/css">
		<link href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,700,900" rel="stylesheet">
	</head>
	<body>
		<div class="container">
			<div class="row" id="card">
				<div class="col-lg-4">
				</div>
				<div  class="col-sm-12 col-lg-4">
					<h1>Welcome</h1><hr>
					  <?php
						session_start();

						if (isset($_SESSION['message']) and !empty($_SESSION['message'])) {
						    echo "<div class='alert alert-".$_SESSION['type']."'>".$_SESSION['message']."</div>";
						    unset($_SESSION['message']);}

						?>
					<form action="login.php" method="post">
						<div class="row form-row container form-group">
							<input type="text" class="form-control field"  placeholder="Username" name="username" required>
						</div>
						<div class="row form-row container form-group">
							<input type="password" class=" field form-control" placeholder="Password" name="password" required>
						</div>
						
						<div class="row form-row logbtn">
							<div class="col">
								
							</div>
							<div class="col">
								<input class="btn btn-success" type="submit" name="submit" value="Log In">
							</div>
							<div class="col">
								
							</div>
						</div>
					</form>
					<a id="frgtpwd" href="frgtpwd.php">Forgot Password?</a>
				</div>
				<div class="col-lg-4"></div>
			</div>
		</div>
	</body>
</html>