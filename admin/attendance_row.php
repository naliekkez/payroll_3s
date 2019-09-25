<?php 
	include 'includes/session.php';

	if(isset($_POST['id'])){
		$id = $_POST['id'];
		$branch = $_SESSION['branch'];
		$sql = "SELECT *, attendance.id as attid FROM attendance, employees WHERE employees.id=attendance.employee_id AND attendance.id = '$id' AND (employees.branch_id = '$branch' or '0' = '$branch')";
		$query = $conn->query($sql);
		$row = $query->fetch_assoc();

			echo json_encode($row);
	}
?>