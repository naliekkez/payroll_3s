<?php
	include 'includes/session.php';

	if(isset($_POST['approve'])){
		$id = $_POST['id'];
		
		$sql = "UPDATE exchange set approved = 2 WHERE id = '$id'";
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

	header('location: exchange_incoming.php');
	
?>