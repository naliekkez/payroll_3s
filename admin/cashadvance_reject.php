<?php
	include 'includes/session.php';

	if(isset($_POST['reject'])){
		var_dump($_POST);
		$attid = $_POST['attid_id'];
		$username = $_SESSION['username'];
		
		$sql = "UPDATE cashadvance set approved = 2, authorized_by = '$username'  WHERE id = '$attid'";
		if($conn->query($sql)){
			$_SESSION['success'] = 'Request Rejected successfully';
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