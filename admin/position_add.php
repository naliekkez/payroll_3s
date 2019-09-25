<?php
	include 'includes/session.php';

	if(isset($_POST['add'])){
		$title = $_POST['title'];
		$rate = $_POST['rate'];
		$lunch = $_POST['lunch'];
		$transport = $_POST['transport'];
		$insentive = $_POST['insentive'];
		$position = $_POST['position'];
		$late_cut = $_POST['late'];
		$branch = $_POST['branch'];
		$overtime = $_POST['overtime'];


		$part_rate = $_POST['part_rate'];
		$part_lunch = $_POST['part_lunch'];
		$part_transport = $_POST['part_transport'];
		$part_insentive = $_POST['part_insentive'];
		$part_position = $_POST['part_position'];
		$part_late_cut = $_POST['part_late'];
		$part_overtime = $_POST['part_overtime'];
		
		$sql = "INSERT INTO position (description,branch_id, rate,lunch_fund,transport_fund,insentive_fund,position_fund,late_cut,overtime part_rate,part_lunch_fund,part_transport_fund,part_insentive_fund,part_position_fund,part_late_cut,part_overtime) VALUES ('$title', $branch,'$rate',$lunch,$transport,$insentive,$position,$late_cut,$overtime,'$part_rate',$part_lunch,$part_transport,$part_insentive,$part_position,$part_late_cut,$part_overtime)";
		if($conn->query($sql)){
			$_SESSION['success'] = 'Position added successfully';
		}
		else{
			$_SESSION['error'] = $sql;
		}
	}	
	else{
		$_SESSION['error'] = 'Fill up add form first';
	}

	header('location: position.php');

?>