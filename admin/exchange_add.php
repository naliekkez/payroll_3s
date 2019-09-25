<?php
	include 'includes/session.php';

	if(isset($_POST['add'])){
		$employee = $_POST['employee'];
		$date = $_POST['date'];
		$position = $_POST['position'];
		$time_in = $_POST['time_in'];
		$time_in = date('H:i:s', strtotime($time_in));
		$time_out = $_POST['time_out'];
		$time_out = date('H:i:s', strtotime($time_out));
		$branch = $_SESSION['branch'];
		$username = $_SESSION['username'];
		$sql = "SELECT * FROM employees WHERE employee_id = '$employee' AND (branch_id != '$branch' or '0' = '$branch')";

		$query = $conn->query($sql);

		if($query->num_rows < 1){
			$_SESSION['error'] = $sql; //'Employee not found';
		}
		else{
			$row = $query->fetch_assoc();
			$emp = $row['id'];
			var_dump($row);
			$branch_origin = $row['branch_id'];
			$sql = "SELECT * FROM attendance,exchange WHERE employee_id = '$emp' AND date = '$date' AND exchange.employee_id = attendance.employee_id ";
			$query = $conn->query($sql);

			if($query->num_rows > 0){
				$_SESSION['error'] = 'Employee attendance for the day exist';
			}
			else{
				//updates
				
				$sched = $row['schedule_id'];
				$sql = "SELECT * FROM schedules WHERE id = '$sched'";
				$squery = $conn->query($sql);
				$scherow = $squery->fetch_assoc();
				$logstatus = ($time_in > $scherow['time_in']) ? 0 : 1;
				
				//
				$sql = "INSERT INTO exchange (employee_id, date, time_in, time_out, status,branch_id,branch_request_id,authorized_by,requested_by,position_id) VALUES ('$emp', '$date', '$time_in', '$time_out', '$logstatus',$branch_origin,'$branch','-','$username',$position)";
				if($conn->query($sql)){
					$_SESSION['success'] = 'Request added successfully';
					$id = $conn->insert_id;

					$sql = "SELECT * FROM employees,schedules WHERE schedules.id=employees.schedule_id AND  employees.id = '$emp'";
					$query = $conn->query($sql);
					$srow = $query->fetch_assoc();

					if($srow['time_in'] > $time_in){
						$time_in = $srow['time_in'];
					}

					if($srow['time_out'] < $time_out){
						$time_out = $srow['time_out'];
					}

					$time_in = new DateTime($time_in);
					$time_out = new DateTime($time_out);
					$interval = $time_in->diff($time_out);
					$hrs = $interval->format('%h');
					$mins = $interval->format('%i');
					$mins = $mins/60;
					$int = $hrs + $mins;
					if($int > 4){
						$int = $int - 1;
					}

					$sql = "UPDATE exchange SET num_hr = '$int' WHERE id = '$id'";
					$conn->query($sql);

				}
				else{
					$_SESSION['error'] = $conn->error;
				}
			}
		}
	}
	else{
		$_SESSION['error'] = 'Fill up add form first';
	}
	
	header('location: exchange.php');

?>