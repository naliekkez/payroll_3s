<?php 
	include 'includes/session.php';

	if(isset($_POST['id'])){
		$id = $_POST['id'];
		$branch = $_SESSION['branch'];
		$sql = "SELECT * FROM schedules WHERE id = '$id'  AND branch_id = '$branch' OR '0' = '$branch'";
		$query = $conn->query($sql);
		$row = $query->fetch_assoc();

		echo json_encode($row);
	}
?>