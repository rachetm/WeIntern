<?php
session_start();
require_once 'include/db.php';
date_default_timezone_set('Asia/Kolkata');

function changestatus($con,$status)
{
	$stmt = $con->prepare("UPDATE `login` SET `status` = ? WHERE `username` = ?");
	$stmt->bind_param("is", $status,$username);
	$username = $_SESSION['username'];
	$stmt->execute();
}

function checkin($con)
{
	$stmt = $con->prepare("SELECT `checkin` FROM `log` WHERE `username`=? AND `date`=?");
	$stmt->bind_param("ss", $username,$date);
	$username = $_SESSION['username'];
	$date = date('Y-m-d');
	$stmt->execute();
	$result = $stmt->get_result();
	
	$row = $result->fetch_assoc();

	if($row['checkin']==NULL)
	{
		changestatus($con,1);
		$stmt = $con->prepare("INSERT INTO `log` (`username`, `date`, `checkin`) values(?,?,?) ");
		$stmt->bind_param("sss", $username,$date,$time);
		$username = $_SESSION['username'];
		$date = date('Y-m-d');
		$time = date('H:i:s');
		$stmt->execute();
	}
	else
	{
		changestatus($con,1);
		$stmt = $con->prepare("UPDATE `log` SET `temp` = ? WHERE `username` = ? AND `date` = ?");
		$stmt->bind_param("sss",$time,$username,$date);
		$username = $_SESSION['username'];
		$date = date('Y-m-d');
		$time = date('H:i:s');
		$stmt->execute();
	}

	$stmt = $con->prepare("INSERT INTO `notification`(`time`, `content`) VALUES (?,?)");
	$stmt->bind_param("ss", $time,$content);
	$time = date('H:i:s');
	$content = $_SESSION['name']." checked in at ";
	$stmt->execute();
}

function checkout($con)
{
	$stmt = $con->prepare("SELECT `temp` FROM `log` WHERE `username`=? AND `date`=?");
	$stmt->bind_param("ss", $username,$date);
	$username = $_SESSION['username'];
	$date = date('Y-m-d');
	$stmt->execute();
	$result = $stmt->get_result();
	
	$row = $result->fetch_assoc();

	if($row['temp']==NULL){
		changestatus($con,0);

		$stmt = $con->prepare("SELECT `checkin` FROM `log` WHERE `username`=? AND `date`=?");
		$stmt->bind_param("ss", $username,$date);
		$username = $_SESSION['username'];
		$date = date('Y-m-d');
		$stmt->execute();
		$result = $stmt->get_result();
		
		$row = $result->fetch_assoc();
		$time = date('H:i:s');	
		$start = strtotime($row['checkin']);
		$stop = strtotime($time);

		$total_hrs = gmdate("H:i:s", ($stop - $start));

		$stmt = $con->prepare("UPDATE `log` SET `checkout` = ?, `total_hrs` = ? WHERE `username` = ? AND `date` = ?");
		$stmt->bind_param("ssss",$time,$total_hrs,$username,$date);
		$username = $_SESSION['username'];
		$date = date('Y-m-d');		
		$stmt->execute();
	}
	else
	{
		changestatus($con,0);
		$stmt = $con->prepare("SELECT `temp`,`total_hrs` FROM `log` WHERE `username`=? AND `date`=?");
		$stmt->bind_param("ss", $username,$date);
		$username = $_SESSION['username'];
		$date = date('Y-m-d');
		$stmt->execute();
		$result = $stmt->get_result();
		
		$row = $result->fetch_assoc();
		$time = date('H:i:s');	
		$start = strtotime($row['temp']);
		$stop = strtotime($time);

		$diff_sec =  ($stop - $start);
		$diff = gmdate("H:i:s", $diff_sec);

		sscanf($row['total_hrs'], "%d:%d:%d", $hours, $minutes, $seconds);

		$time_seconds = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;

		$total_hrs =  gmdate("H:i:s",$time_seconds + $diff_sec);

		$stmt = $con->prepare("UPDATE `log` SET `checkout` = ?, `total_hrs` = ? WHERE `username` = ? AND `date` = ?");
		$stmt->bind_param("ssss",$time,$total_hrs,$username,$date);
		$username = $_SESSION['username'];
		$date = date('Y-m-d');

		$stmt->execute();
	}
	$stmt = $con->prepare("INSERT INTO `notification`(`time`, `content`) VALUES (?,?)");
	$stmt->bind_param("ss", $time,$content);
	$time = date('H:i:s');
	$content = $_SESSION['name']." checked out at ";
	$stmt->execute();
}


if (isset($_SESSION['logged_in'])) {
	
	$stmt = $con->prepare("SELECT status FROM `login` WHERE `username` = ?");
	$stmt->bind_param("s", $username);
	$username = $_SESSION['username'];
	$stmt->execute();
	$result = $stmt->get_result();
	$row = $result->fetch_assoc();
	if($row['status'] == 0)
		checkin($con);
	else
		checkout($con);
	
	header("Location: ./af_log.php");
}
else
{
	$_SESSION['message'] = "You are logged out. Please login to continue!";
    $_SESSION['type'] = 'danger';
    header('Location: ./index.php');
}	