<?php
	include 'includes/session.php';

	if(isset($_POST['edit'])){
		$empid = $_POST['id'];
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$address = $_POST['address'];
		$birthdate = $_POST['birthdate'];
		$contact = $_POST['contact'];
		$gender = $_POST['gender'];
		$status = $_POST['status'];
		$position = $_POST['position'];
		$bpjs = $_POST['bpjs'];
		$uni_fee = $_POST['uni_fee'];
		$bank_account_number = $_POST['bank_account_number'];
			
		$sql = "select position_id,branch_id,emp_status from employees where id = '$empid'";
		$res = $conn->query($sql);
		
		$row = $res->fetch_assoc();
		$sql = "UPDATE employees SET firstname = '$firstname', lastname = '$lastname', address = '$address', birthdate = '$birthdate', contact_info = '$contact', gender = '$gender', position_id = '$position', uniform_fee = $uni_fee,  emp_status = '$status', bank_account_number = '$bank_account_number', bpjs = '$bpjs' WHERE id = '$empid'";
		if($conn->query($sql)){
			$_SESSION['success'] = 'Employee updated successfully';
		}
		else{
			$_SESSION['error'] = $conn->error;
		}

		if($row["position_id"] != $position){
			$prev = $row["position_id"];
			$branch = $row["branch_id"];
			$sql = "INSERT INTO History (employee_id, prev_position, next_position,branch_id) VALUES ('$empid', '$prev', '$position',$branch);";
			$conn->query($sql);
			
		}
		if($row["emp_status"] != $status){
			$prev = $row["emp_status"];
			$branch = $row["branch_id"];
			$sql = "INSERT INTO History (employee_id, prev_position, next_position,branch_id) VALUES ('$empid', '$prev', '$status',$branch);";
			$conn->query($sql);
			
		}
		
	}
	else{
		$_SESSION['error'] = 'Select employee to edit first';
	}

	header('location: employee.php');
?>