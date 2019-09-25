<?php
	include 'includes/session.php';

	if(isset($_POST['edit'])){
		$bid = $_POST['id'];
		$name = $_POST['edit_branch_name'];
		$sql = "UPDATE branch SET name = '$name' where  branch_id = '$bid'";
		if($conn->query($sql)){
			$_SESSION['success'] = 'Branch Updated successfully';
			
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