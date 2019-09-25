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
		$lastname = $_POST['lastname'];
		$r_pass = password_hash($password, PASSWORD_DEFAULT);;
		
		//creating employeeid
		
		$sql = "INSERT INTO admin (firstname,lastname,username,password,privileges,branch_id,photo) VALUES ('$firstname','$lastname','$username','$r_pass','1','0','untitled.jpg')";
		if($conn->query($sql)){
			$_SESSION['success'] = 'HR added successfully';
		}
		else{
			$_SESSION['error'] = $conn->error;
		}

	}
	else{
		$_SESSION['error'] = 'Fill up add form first';
	}

	header('location: hr.php');
?>