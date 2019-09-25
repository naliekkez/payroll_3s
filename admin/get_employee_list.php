<?php 
	include 'includes/session.php';
	
	if(isset($_POST['branch'])){
		$branch = $_POST['branch'];
		$sql = "SELECT *, employees.id as empid FROM employees WHERE (employees.branch_id = '$branch' or 0 = '$branch')";
		$query = $conn->query($sql);
		$employees = array();
		$ctr = 0;

		while($row = $query->fetch_assoc()){
			$employees[$ctr]['name'] = $row['firstname'] . ' ' . $row['lastname'];
			$employees[$ctr]['empid'] = $row['employee_id'];
			$ctr++;
		}

		echo json_encode($employees);
	}
?>	