<?php
/* Reset your password form, sends reset.php password link */

include 'include/sendmailbasic.php';

require_once 'include/db.php';
session_start();

// Check if form submitted with method="post"
if ( $_SERVER['REQUEST_METHOD'] == 'POST' )
{
    
    $stmt=$con->prepare("SELECT * FROM `login` WHERE `email` = ?");
    $stmt->bind_param("s",$email);
    $email = $_POST['email'];
    $stmt->execute();
    $result= $stmt->get_result();
    if (  $result->num_rows == 0 ) // User doesn't exist
    {
        $_SESSION['message'] = "User with that email doesn't exist!";
        $_SESSION['type'] = 'danger';
        
    }
    else { // User exists (num_rows != 0)
    

        $user = $result->fetch_assoc(); // $user becomes array with user data

        $email = $user['email'];
        $username = $user['username'];
        $hash=$user['hash'];

        // Send Password Link confirmation link (reset.php)

        $to      = $email;
        $subject = 'Password Reset Link [WeProj]';
        $message_body = '
        Hello '.$username.',

        You have requested to reset your password.

        Please click on the following link to reset -

        https://weintern.000webhost.com/resetpwd.php?email='.$email.'&hash='.$hash;

        if(email_std($to, $subject, $message_body))
        {
            $_SESSION['message'] = "Password reset link has been sent to your email!";
			$_SESSION['type'] = 'success';
            header('Location: ./index.php');
            exit();
        }

    }
}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Reset Password</title>
		<link rel="stylesheet" type="text/css" href="bootstrap.css">
		<link rel="stylesheet" type="text/css" href="index.css">
		<link href="https://fonts.googleapis.com/css?family=Titillium+Web:400,300,600" rel="stylesheet" type="text/css">
		<link href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,700,900" rel="stylesheet">
	</head>
	<body>
		<div class="container">
			<div class="row" id="card" style="justify-content: center;">
				<div class="col-sm-12 col-lg-6">
					<p style="text-align: center; margin-top: 100px; font-family: Raleway">Please enter your registered email below</p>
					<hr style="margin-bottom: 80px;">
					<?php
						if (isset($_SESSION['message']) and !empty($_SESSION['message'])) 
						{
    						echo "<div class='alert alert-".$_SESSION['type']."'>".$_SESSION['message']."</div>";
    						unset($_SESSION['message']);
    					}
					?>
					<form action="frgtpwd.php" method="post">
						<div class="form-group">
							<input type="email" class="form-control field" name="email"  placeholder="Email" required>
						</div>
						<div class="row allbtn" style="justify-content: center; margin-top: 60px;">
							<button type="submit"  class="btn btn-success" style="font-family: Raleway;">RESET</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>