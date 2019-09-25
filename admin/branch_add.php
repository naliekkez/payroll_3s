<?php
	include 'includes/session.php';

	if(isset($_POST['add'])){
		$branch_name = $_POST['branch_name'];
		$branch_date = $_POST['branch_date'];
		
		$sql = "INSERT INTO branch (name,day_month) VALUES ('$branch_name','$branch_date')";
		if($conn->query($sql)){
			$_SESSION['success'] = 'Branch added successfully';
			
		}
		else{
			$_SESSION['error'] = $conn->error;

		}

	}
	else{
		$_SESSION['error'] = 'Fill up add form first';
	}

	header('location: branch.php');
?>