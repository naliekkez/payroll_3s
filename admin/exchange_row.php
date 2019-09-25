<?php 
	include 'includes/session.php';

	if(isset($_POST['id'])){
		$id = $_POST['id'];
		$sql = "SELECT *, exchange.id as attid FROM exchange, employees WHERE employees.id=exchange.employee_id AND exchange.id = '$id'";
		$query = $conn->query($sql);
		$row = $query->fetch_assoc();

			echo json_encode($row);
	}
?>