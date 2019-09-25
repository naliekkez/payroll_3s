<?php
	include 'includes/session.php';

	if(isset($_POST['approve'])){
		$attid = $_POST['attid_id'];
		$empid = $_POST['empid_id'];
		$amount = $_POST['amount_id'];
		$username = $_SESSION['username'];

		
		$sql = "UPDATE employees set cashadvance = cashadvance + $amount where employee_id = '$empid'";
		if($conn->query($sql)){
			$_SESSION['success'] = 'Request approved successfully';

			$sql = "UPDATE cashadvance set approved = 1, authorized_by = '$username'  WHERE id = '$attid'";
			if($conn->query($sql)){
				$_SESSION['success'] = 'Request approved successfully';
			}
			else{
				$_SESSION['error'] = $conn->error;
			}

		}
		else{
			$_SESSION['error'] = $conn->error;
		}
		
	}
	else{
		$_SESSION['error'] = 'Select item to Approve first';
	}

	header('location: cashadvance_incoming.php');
	
?>