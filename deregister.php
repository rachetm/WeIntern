<?php
	session_start();

	require_once 'include/db.php';
	include 'include/sendmailbasic.php';

	if ($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		if(!empty($_POST['username']))
		{
			$stmt = $con->prepare("SELECT * FROM `login` WHERE `username`=?");
			$stmt->bind_param("s", $_POST['username']);
			$stmt->execute();
			$result = $stmt->get_result();
			$row = $result->fetch_assoc();

			$name = $row['name'];

			$stmt = $con->prepare("DELETE FROM `login` WHERE `username` = ?");
			$stmt->bind_param("s", $_POST['username']);

			if ($stmt->execute())
            {
                // Send registration confirmation link
                $to = $email;
                $subject = 'Account Deleted [WeIntern]';
                $message_body = '
                Hello ' . $name .','.'

                This is to inform you that your account with WeIntern has been deleted.
                Thankyou.';

                
                email_std($to, $subject, $message_body);
                $_SESSION['message'] = "User deleted successfully";
                $_SESSION['type'] = "warning";
                header("Location: ./admin.php");
            } 
            else 
            {
                $_SESSION['message'] = "Operation failed! Try again!";
                $_SESSION['type'] = "danger";
                header("Location: ./admin.php");
            }
        }
        else
        {
            $_SESSION['message'] = "Operation failed as user not selected!";
            $_SESSION['type'] = 'danger';
            header("Location: ./admin.php");
        }
	}
?>