<?php

session_start();
require_once 'include/db.php';
	
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
	if(!empty($_POST['username']))
	{
		if ($_POST['userstatus'] == 1) 
		{
			    $stmt = $con->prepare("UPDATE `login` SET `user_status`=? WHERE `username`=?");
			    $stmt->bind_param("is", $_POST['userstatus'],$_POST['username']);
			    $stmt->execute();
			    $_SESSION['message'] = "User has been activated";
		        $_SESSION['type'] = "success";
		        header("Location: ./admin.php");
		}
		else
		{
			$stmt = $con->prepare("UPDATE `login` SET `user_status`=? WHERE `username`=?");
		    $stmt->bind_param("is", $_POST['userstatus'],$_POST['username']);
		    $stmt->execute();
		    $_SESSION['message'] = "User has been deactivated";
	        $_SESSION['type'] = "warning";
	        header("Location: ./admin.php");
		}
	}
	else
	{
		$_SESSION['message'] = "Operation failed as user not selected!";
        $_SESSION['type'] = "danger";
        header("Location: ./admin.php");
	}
}
?>