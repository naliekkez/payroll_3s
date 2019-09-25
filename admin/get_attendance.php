<?php 

	include 'includes/session.php';
	if(isset($_POST['branch']) && isset($_POST['month']) && isset($_POST['year']) ){
		$branch = $_SESSION['branch'];
		$month = $_POST['month'];
		$year = $_POST['year'];
		if($branch == 0) $branch = $_POST['branch'];
		$sql = "SELECT *,employees.employee_id as empid from employees, branch where (employees.branch_id = '$branch' ) AND employees.branch_id = branch.branch_id order by employees.employee_id ASC";
			
		$query = $conn->query($sql);
		$employees = array();
		$prev = 'none';
		$curr = 'none_1';
		$att_temp = array();
		$ctr = 0;
		while($row = $query->fetch_assoc()){
			$ctr++;
			$curr = $row['empid'];
			if($prev != $curr){
				if($prev != 'none'){

				 	$employees[$prev] = $att_temp;
					
				}
				for($i = 0; $i < 35; $i++) $att_temp[$i] = '-';
				$prev = $curr;

			}
			$att_temp[0] = $row['empid'];
			$att_temp[1] = $row['firstname'] . " " . $row['lastname'];
			$att_temp[2] = $row['emp_status'] == 0 ? 'FT' : 'PT';
			
			
			
		}
		$employees[$prev] = $att_temp;
		$sql = "SELECT *,DAY(date) as d, attendance.status as stat, employees.employee_id as empid from attendance,employees, branch where MONTH(date) = $month AND YEAR(date) = $year AND attendance.branch_id = branch.branch_id and (attendance.branch_id = '$branch' ) and employees.branch_id = branch.branch_id and attendance.employee_id = employees.id order by employees.employee_id ASC";
		$query = $conn->query($sql);
		$prev = 'none';
		$curr = 'none_1';
		$att_temp = array();
		
		while($row = $query->fetch_assoc()){
			$curr = $row['empid'];
			//echo $row['d'] . ' ' . $row['stat'] . '<br/>';
			if($row['stat'] == 'MASUK') $temp_stat = 'H';
			else if($row['stat'] == 'SAKIT') $temp_stat = 'S';
			else if($row['stat'] == 'IZIN') $temp_stat = 'I';
			else if($row['stat'] == 'CUTI') $temp_stat = 'C';
			else if($row['stat'] == 'PERBANTUAN IN') $temp_stat = 'PI';
			else if($row['stat'] == 'PERBANTUAN OUT') $temp_stat = 'PO';
			else if($row['stat'] == 'TELAT') $temp_stat = 'T';
			else if($row['stat'] == 'ALPHA') $temp_stat = 'A';
			else $temp_stat = '-';
			if($row['num_hr'] != 0) $temp_stat = $temp_stat . $row['num_hr'];
			$employees[$curr][$row['d']+2] =  $temp_stat;
			//var_dump($employees[$curr][$row['d']+2]);
			
		}
		echo json_encode(array_values($employees));
	}
?>