<?php
	include 'includes/session.php';
	$password = $_POST['password'];
	$cpassword = $_POST['confirm_password'];
	if($password != $password) {
		$_SESSION['error'] = 'Please check your password';
	}
	if(isset($_POST['edit'])){
		$username = $_POST['username'];
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$branch = $_POST['branch'];
		$last_edited = $_SESSION['username'];
		$r_pass = password_hash($password, PASSWORD_DEFAULT);;
			
		
		$sql = "UPDATE admin SET firstname = '$firstname', lastname = '$lastname', password = '$r_pass', branch_id = $branch, last_edited = '$last_edited' where username = '$username'";
		echo $sql;
		if($conn->query($sql)){
			$_SESSION['success'] = 'HR updated successfully';
		}
		else{
			$_SESSION['error'] = $conn->error;
		}

		
	}
	else{
		$_SESSION['error'] = 'Select employee to edit first';
	}

	header('location: leader.php');
?>