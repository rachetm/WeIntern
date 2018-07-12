<?php

session_start();
if (isset($_SESSION['logged_in'])) 
{
	require_once 'include/db.php';

function unique_salt()
{
    return substr(sha1(mt_rand()), 0, 22);
}

if ( $_SERVER['REQUEST_METHOD'] == 'POST' )
{
	$stmt=$con->prepare("SELECT * FROM `login` WHERE `username` = ?");
	$stmt->bind_param("s",$_SESSION['username']);
	$stmt->execute();
    $result= $stmt->get_result();

    $row = $result->fetch_assoc();

    if (password_verify($_POST['currentpassword'], $row['password'])) 
    {
		    if ($_POST['newpassword'] == $_POST['confirmpassword']) 
		    {

		        // We get $_POST['email'] and $_POST['hash'] from the session variables

		        $stmt = $con->prepare("UPDATE `login` SET `password`=? , `hash` = ? WHERE `username`=?");
		        $stmt->bind_param("sss", $new_password, $new_hash, $_SESSION['username']);

		        $new_password = password_hash($_POST['newpassword'], PASSWORD_BCRYPT);
		        $new_hash = password_hash(unique_salt(), PASSWORD_BCRYPT);

		        if ($stmt->execute()) 
		        {
		            $_SESSION['message'] = "Your password has been reset successfully! Please login to continue!";
		            $_SESSION['type'] = 'success';
		            $_SESSION['logged_in'] = false;
		            header('Location: ./index.php');
		            exit();
		        }

    		} 
			else 
			{
			    $_SESSION['message'] = "Two passwords you entered don't match, try again!";
			    $_SESSION['type'] = 'danger';
			  	header("location : ./chgpwd.php");
			}
   }
   else
   {
    	$_SESSION['message'] = 'Current password is incorrect!';
    	$_SESSION['type'] = 'danger';
    	header("location : ./chgpwd.php");
   }
}

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Change Password</title>
		<link rel="stylesheet" type="text/css" href="bootstrap.css">
		<link rel="stylesheet" type="text/css" href="index.css">
		<link href="https://fonts.googleapis.com/css?family=Titillium+Web:400,300,600" rel="stylesheet" type="text/css">
		<link href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,700,900" rel="stylesheet">
	<script>
    //To check wether both the passwords are same
    function validate() {
      if (document.getElementById('password').value == document.getElementById('password2').value)
        return true;
      else {
        document.getElementById('errmsg').innerHTML = "<div class='alert alert-danger'>Passwords do not match!</div>";
        return false;
      }
    } 
  </script>
	</head>
	<body>
		<div class="container">
			<div class="row" id="card"  style="justify-content: center;">
				<div class="col-sm-12 col-lg-6">
					<div style="margin-top: 150px;" id="errmsg"></div>
					<form action="chgpwd.php" method="post" onsubmit="return validate();">
						<div class="form-group">
							<input type="password" class="form-control field"  placeholder="Current Password" name="currentpassword" required>
						</div>
						<div class="form-group">
							<input type="password" class="form-control field" id="password" name="newpassword" placeholder="New Password" required>
						</div>
						<div class="form-group">
							<input type="password" class="form-control field" id="password2" name="confirmpassword" placeholder="Re-Enter New Password" required>
						</div>
						<div class="row allbtn" style="justify-content: center; margin-top: 60px;">
							<button type="submit" class="btn btn-success">Submit</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
	</body>
</html>

	<?php
} else {
    $_SESSION['message'] = "You are logged out. Please login to continue!";
    $_SESSION['type'] = "danger";
    header('Location: ./index.php');
}

?>