<?php
	require_once 'include/db.php';
	$stmt = $con->prepare("SELECT * FROM `notification` WHERE date = ?");
	$stmt->bind_param("s",$date);
	$date = date('Y-m-d');
	$stmt->execute();
	$result = $stmt->get_result();

	$notifications = mysqli_fetch_all($result, MYSQLI_ASSOC);

	echo json_encode($notifications);
?>