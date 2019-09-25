<?php
	include 'includes/session.php';
	$password = $_POST['password'];
	$cpassword = $_POST['confirm_password'];
	if($password != $password) {
		$_SESSION['error'] = 'Please check your password';
	}
	else if(isset($_POST['add'])){
		$username = $_POST['username'];
		$firstname = $_POST['firstname'];
		$branch = $_POST['branch'];
		$lastname = $_POST['lastname'];
		$last_edited = $_SESSION['username'];
		$r_pass = password_hash($password, PASSWORD_DEFAULT);
		
		//creating employeeid
		
		$sql = "INSERT INTO admin (firstname,lastname,username,password,privileges,branch_id,photo,last_edited) VALUES ('$firstname','$lastname','$username','$r_pass','2','$branch','untitled.jpg','$last_edited')";
		if($conn->query($sql)){
			$_SESSION['success'] = 'Leader added successfully';
		}
		else{
			$_SESSION['error'] = $conn->error;
		}

	}
	else{
		$_SESSION['error'] = 'Fill up add form first';
	}

	header('location: leader.php');
?>