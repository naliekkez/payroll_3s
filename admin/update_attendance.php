<?php
	include 'includes/session.php';

	if(isset($_POST['status'])){
		$empid = $_POST['empid'];
		$day = sprintf('%02d',  $_POST['day']); 
        $month =sprintf('%02d',  $_POST['month']); 
        $year = (string)  $_POST['year'];
        $status = $_POST['status'];

        $branch = $_POST['branch'];
        $date = (string)$year.'-'.(string)$month.'-'. (string)$day;
        if($status[0]  == 'H') $temp_stat = 'MASUK';
	    else if($status == 'S') $temp_stat = 'SAKIT';
	    else if($status == 'I') $temp_stat = 'IZIN';
	    else if($status == 'C') $temp_stat = 'CUTI';
	    else if($status == 'PI') $temp_stat = 'PERBANTUAN IN';
	    else if($status == 'PO') $temp_stat = 'PERBANTUAN OUT';
	    else if($status == 'T') $temp_stat = 'TELAT';
	    else if($status == 'A') $temp_stat = 'ALPHA';
	    else  $temp_stat = '-';

	    if($temp_stat != '-'){

			
			$sql = "SELECT * FROM attendance,employees WHERE employees.employee_id = '$empid' AND attendance.employee_id = employees.id AND date = '$date'";
			$query = $conn->query($sql);
			//echo $sql . "<br/>";
			$row = $query->fetch_assoc() ; 
			if($row){
				$num_hr;
				$usql;
				if(strlen($status) > 1){
					$num_hr = $status[1];
				}
				$short_emp_id = $row['id'];
				if(strlen($status) > 1){

					$usql = "UPDATE attendance set status = '$temp_stat',num_hr = '$num_hr' WHERE employee_id = '$short_emp_id' AND  date = '$date'";	
					echo $usql;
				}
				else $usql = "UPDATE attendance set status = '$temp_stat' WHERE employee_id = '$short_emp_id' AND  date = '$date'";	
				$query = $conn->query($usql);
			}
			else{
				
				$esql = "SELECT * FROM employees WHERE employee_id = '$empid' ";
				$query = $conn->query($esql);
				$row = $query->fetch_assoc();
				$position = $row['position_id'];
				$short_emp_id = $row['id'];
				$num_hr = 0;
				if(strlen($status) > 1){
					$num_hr = $status[1];
				}
				$isql = "INSERT INTO attendance(employee_id,branch_id,date,time_in,status,position_id,time_out,num_hr) VALUES('$short_emp_id','$branch','$date','08:00:00','$temp_stat','$position','17:00:00','$num_hr')";
				$query = $conn->query($isql);
			}
			
		}
		else {
			$sql = "SELECT * FROM attendance,employees WHERE employees.employee_id = '$empid' AND attendance.employee_id = employees.id AND date = '$date'";
			$query = $conn->query($sql);
			//echo $sql . "<br/>";
			$row = $query->fetch_assoc() ; 
			if($row){
				$short_emp_id = $row['id'];
				$usql = "DELETE FROM attendance WHERE employee_id = '$short_emp_id' AND  date = '$date'";	
				$query = $conn->query($usql);
			}
		}
		
	}
	else{
		$_SESSION['error'] = 'Fill up edit form first';
	}


?>