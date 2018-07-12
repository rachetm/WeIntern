<?php
	require_once 'include/db.php';
	$stmt = $con->prepare("SELECT * FROM `notification`");
	$stmt->execute();
	$result = $stmt->get_result();

	$notifications = mysqli_fetch_all($result, MYSQLI_ASSOC);

	echo json_encode($notifications);
?>