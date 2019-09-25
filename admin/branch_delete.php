<?php
	include 'includes/session.php';

	if(isset($_POST['delete'])){
		$bid = $_POST['id'];
		$status = $_POST['status'];
		if($status == 0) $status = 1;
		else $status = 0;
		$sql = "UPDATE branch SET status = '$status' where  branch_id = '$bid'";
		if($conn->query($sql)){
			$_SESSION['success'] = 'Branch Status Updated successfully';
			echo $branch_name;
		}
		else{
			$_SESSION['error'] = $conn->error;

		}
	}
	else{
		$_SESSION['error'] = 'Select Branch to edit first';
	}

	header('location: branch.php');
?>