<?php
	include 'includes/session.php';

	if(isset($_POST['edit'])){
		$id = $_POST['id'];
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

		$sql = "UPDATE position SET description = '$title', branch_id = $branch, rate = '$rate', lunch_fund = $lunch, transport_fund = $transport,  insentive_fund = $insentive, position_fund = $position, late_cut = $late_cut, part_rate = '$part_rate', part_lunch_fund = $part_lunch, part_transport_fund = $part_transport,  part_insentive_fund = $part_insentive, part_position_fund = $part_position, part_late_cut = $part_late_cut, part_overtime = $part_overtime, overtime = $overtime  WHERE id = '$id'";
		if($conn->query($sql)){
			$_SESSION['success'] = 'Position updated successfully';
		}
		else{
			$_SESSION['error'] = $sql;
		}
	}
	else{
		$_SESSION['error'] = 'Fill up edit form first';
	}

	header('location:position.php');

?>