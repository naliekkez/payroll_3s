<?php
	include 'includes/session.php';

	if(isset($_POST['approve'])){
		$id = $_POST['id'];
		$sql = "INSERT INTO attendance(employee_id,branch_id,branch_request_id,date,time_in,status,time_out,num_hr,position_id)  select employee_id,branch_id,branch_request_id,date,time_in,'MASUK',time_out,num_hr,position_id from exchange where id = '$id'";
		if($conn->query($sql)){
			$_SESSION['success'] = 'Request approved successfully';

			$sql = "UPDATE exchange set approved = 1 WHERE id = '$id'";
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

	header('location: exchange_incoming.php');
	
?>