<?php 
	function add_month($date_str, $months)
	{
	    $date = new DateTime($date_str);

	    // We extract the day of the month as $start_day
	    $start_day = $date->format('j');

	    // We add 1 month to the given date
	    $date->modify("+{$months} month");

	    // We extract the day of the month again so we can compare
	    $end_day = $date->format('j');

	    if ($start_day != $end_day)
	    {
	        // The day of the month isn't the same anymore, so we correct the date
	        $date->modify('last day of last month');
	    }

	    return $date->format('Y-m-d');
	}
	function add_day($date_str, $day)
	{
	    $date = new DateTime($date_str);

	    // We extract the day of the month as $start_day
	    $start_day = $date->format('M');

	    // We add 1 month to the given date
	    $date->modify("+{$day} day");

	    // We extract the day of the month again so we can compare
	    $end_day = $date->format('M');

	    if ($start_day != $end_day)
	    {
	        // The day of the month isn't the same anymore, so we correct the date
	        $date->modify('last day of last month');
	    }

	    return $date->format('Y-m-d');
	}
	function updateDate($dateString){
	    $suppliedDate = new \DateTime($dateString);
	    $currentYear = (int)(new \DateTime())->format('Y');
	    $date = (new \DateTime())->setDate($currentYear, (int)$suppliedDate->format('m'), (int)$suppliedDate->format('d'));

	    return $date->format('Y-m-d');
	}
	include 'includes/session.php';

	if(isset($_POST['id'])){
		$id = $_POST['id'];
		$sql = "SELECT *, employees.id as empid FROM employees, position, schedules,branch WHERE position.id=employees.position_id AND schedules.id=employees.schedule_id AND employees.employee_id = '$id' AND branch.branch_id = employees.branch_id ";
		
		$query = $conn->query($sql);
		$row = $query->fetch_assoc();
		$row['day_start'] = updateDate($row['day_month']);
		$row['day_end'] = add_month($row['day_month'],1);
		//echo $row['day_end'];
		$row['day_start'] = add_day($row['day_start'],1);

		echo json_encode($row);
	}

?>