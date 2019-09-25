<?php
	include 'includes/session.php';

	if(isset($_POST['add'])){
		$username = $_SESSION['username'];
		$amount = $_POST['amount'];
		$branch = $_SESSION['branch'];
		
		$sql = "INSERT INTO cashadvance (employee_id, date_advance, amount,branch_id) VALUES ('$username', NOW(), '$amount',$branch)";
		if($conn->query($sql)){
			$_SESSION['success'] = 'Cash Advance added successfully';
		}
		else{
			$_SESSION['error'] = $conn->error;
		}
		
	}	
	else{
		$_SESSION['error'] = 'Fill up add form first';
	}

	header('location: cashadvance_request.php');

?>