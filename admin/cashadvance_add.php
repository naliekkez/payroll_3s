<?php
	include 'includes/session.php';

	if(isset($_POST['add'])){
		$employee = $_POST['employee'];
		$amount = $_POST['amount'];
		$branch = $_SESSION['branch'];
		$sql = "SELECT * FROM employees WHERE employee_id = '$employee' AND ( branch_id = $branch OR $branch = 0)";
		$query = $conn->query($sql);
		if($query->num_rows < 1){
			$_SESSION['error'] = 'Employee not found';
		}
		else{
			$branch = $_SESSION['branch'];
			$row = $query->fetch_assoc();
			$employee_id = $row['id'];
			$sql = "INSERT INTO cashadvance (employee_id, date_advance, amount,branch_id) VALUES ('$employee_id', NOW(), '$amount',$branch)";
			if($conn->query($sql)){
				$_SESSION['success'] = 'Cash Advance added successfully';
			}
			else{
				$_SESSION['error'] = $conn->error;
			}
		}
	}	
	else{
		$_SESSION['error'] = 'Fill up add form first';
	}

	header('location: cashadvance.php');

?>