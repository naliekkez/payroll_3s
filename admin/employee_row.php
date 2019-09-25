<?php 
	include 'includes/session.php';
	
	if(isset($_POST['id'])){
		$id = $_POST['id'];
		$branch = $_SESSION['branch'];
		$sql = "SELECT *, employees.id as empid FROM employees, position WHERE position.id=employees.position_id AND employees.id = '$id' AND (employees.branch_id = '$branch' or 0 = '$branch')";
		$query = $conn->query($sql);
		$row = $query->fetch_assoc();

		echo json_encode($row);
	}
?>