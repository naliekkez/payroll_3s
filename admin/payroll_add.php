<?php
	include 'includes/session.php';
	function generateRandomString($length = 20) {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return  "/pdf/payroll/" . $randomString . ".pdf";
	}
	if(isset($_POST['add'])){
		$to = $_POST['endDate'];
	    $from = $_POST['startDate'];

	    $empid = $_POST['employee_id'];
	    $uniform_fee = $_POST['uniform_fee'];
	    $bonus = $_POST['bonus'];
	    $uniform_fee_cut = $_POST['uniform_fee_cut'];
	    if($uniform_fee > $uniform_fee_cut) $final_uni_fee = $uniform_fee_cut;
		$cash_advance_cut = $_POST['cash_advance_cut'];
		$cash_advance = $_POST['cash_advance'];
		$sql = "select count(*) as 'check' from payroll_archive where ((DATE(start_duration) BETWEEN '$from' AND '$to') OR  (DATE(end_duration) BETWEEN '$from' AND '$to')) AND employee_id = '$empid' ";
		
		$query = $conn->query($sql);
		$row = $query->fetch_assoc();
		if($row['check'] != 0){
			$_SESSION['error'] = 'INVALID RANGE';
			echo $row['check'];
		}
		else if($cash_advance_cut > $cash_advance){
			$_SESSION['error'] = 'INVALID VALUE';
		}
		else {

			 $msql = "SELECT *,count(*) AS total_day,position.description as posdesc FROM attendance,position, employees WHERE employees.employee_id =  '$empid' AND  employees.id=attendance.employee_id AND position.id = attendance.position_id AND (date BETWEEN '$from' AND '$to') GROUP BY attendance.position_id";
	    	require_once('../tcpdf/tcpdf.php');  
		    $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
		    $pdf->SetCreator(PDF_CREATOR);  
		    $pdf->SetTitle('Payslip: '.$empid);  
		    $pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
		    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
		    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
		    $pdf->SetDefaultMonospacedFont('helvetica');  
		    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
		    $pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);  
		    $pdf->setPrintHeader(false);  
		    $pdf->setPrintFooter(false);  
		    $pdf->SetAutoPageBreak(TRUE, 10);  
		    $pdf->SetFont('helvetica', '', 11);  
		    $pdf->AddPage(); 
	    	$mquery = $conn->query($msql);
	    	$f_net = 0;
	    	$total_cut = 0;

		     $contents = '
				<h2 align="center">3S PaySlip</h2>
				<h4 align="center">'.$empid.'</h4>';
		    while($mrow = $mquery->fetch_assoc()){

			    $branch = $_SESSION['branch'];
			    $mpos = $mrow['posdesc'];
			    $sql = "SELECT *,count(*) AS total_day,position.description as posdesc,sum(num_hr) as total_overtime_hr FROM attendance,position, employees WHERE employees.employee_id = '$empid' AND  position.description = '$mpos' AND employees.id=attendance.employee_id AND position.id = attendance.position_id AND (date BETWEEN '$from' AND '$to') GROUP BY attendance.status";
			    
			    $query = $conn->query($sql);
			    $total = 0;
			    $full_name = "";
			    $hday = 0;
			    $gross = 0;
			    $normal_mult = 0;
			    $ifund_mult = 1;
			    $late_mult = 0;
			    $normal_r = 0;
			    $ifund = 0;
			    $sick_r = 0;
			    $hd_r = 0;
			    $leave_r = 0;
			    $rate = 0;
			    $emp_status = '';
			    $bpjs = 0;
			    $alpha_r = 0;
			    $ctr = 0;
			   	$over_time = 0;
				$f_gross = 0;
				$over_time_rate = 0; 
			    while($row = $query->fetch_assoc()){
			    	
			   		$emp_branch = $row['branch_id'];
			    	$gross = 0;
			    	if($row['emp_status'] == 1){
			    		$full_name = $row['firstname'] . " " . $row['lastname'];
				    	$ifund = $row['insentive_fund'];
				    	$tfund = $row['transport_fund'];
				    	$pfund = $row['position_fund'];
				    	$bpjs = $row['bpjs'];
				    	$emp_status = 'Full Time';
				    	$lfund = $row['lunch_fund'];
				    	$rate = $row['rate'];
				    	$late_rate = $row['late_cut']; 
				    	$over_time_rate =  $row['overtime'];

				    	if($row['status'] == 'MASUK'){
				    		$normal_mult = $normal_mult + $row['total_day'];
				    		$normal_r = $row['total_day'];
				    		$gross = $row['rate'] * $row['total_day'];
				    		$over_time = $over_time + $row['total_overtime_hr']; 
				    	}
				    	else if($row['status'] == 'HARI LIBUR'){
				    		$normal_mult = $normal_mult + $row['total_day'];
				    		$hd_r = $row['total_day'];
				    		$hday = $row['rate'] * $row['total_day'];
				    	}
				    	else if($row['status'] == 'TELAT'){
				    		$normal_mult = $normal_mult + $row['total_day'];
				    		$late_mult = $late_mult + $row['total_day'];
				    		
				    	}

				    	else if($row['status'] == 'OVERTIME'){
				    		$normal_mult = $normal_mult + $row['total_day'];
				    		$over_mult = $over_mult + $row['total_day'];
				    		
				    	}
				    	else if($row['status'] == 'ALPHA'){
				    		$alpha_r = $row['total_day'];
				    		$ifund_mult = 0;
				    	}
				    	else if($row['status'] == 'IZIN'){
				    		$leave_r = $row['total_day'];
				    	}
				    	else if($row['status'] == 'SAKIT'){
				    		$sick_r = $row['total_day'];
				    	}
				    }
			    	else {
			    		$full_name = $row['firstname'] . " " . $row['lastname'];
				    	$ifund = $row['part_insentive_fund'];
				    	$tfund = $row['part_transport_fund'];
				    	$pfund = $row['part_position_fund'];
				    	$lfund = $row['part_lunch_fund'];
				    	$bpjs = $row['bpjs'];
				    	$rate = $row['part_rate'];
				    	$emp_status = 'Part Time';
				    	$late_rate = $row['part_late_cut']; 
				    	$over_time_rate = $row['part_overtime'];

				    	if($row['status'] == 'MASUK'){
				    		$normal_mult = $normal_mult + $row['total_day'];
				    		$normal_r = $row['total_day'];
				    		$gross = $row['part_rate'] * $row['total_day'];
				    		$over_time = $over_time + $row['num_hr']; 
				    	}
				    	else if($row['status'] == 'HARI LIBUR'){
				    		$normal_mult = $normal_mult + $row['total_day'];
				    		$hd_r = $row['total_day'];
				    		$hday = $row['part_rate'] * $row['total_day'];
				    	}
				    	else if($row['status'] == 'TELAT'){
				    		$normal_mult = $normal_mult + $row['total_day'];
				    		$late_mult = $late_mult + $row['late_mult'];
				    		
				    	}
				    	else if($row['status'] == 'ALPHA'){
				    		$alpha_r = $row['total_day'];
				    		$ifund_mult = 0;
				    	}
				    	else if($row['status'] == 'IZIN'){
				    		$leave_r = $row['total_day'];
				    	}
				    	else if($row['status'] == 'SAKIT'){
				    		$sick_r = $row['total_day'];
				    	}
			    	}
			    	$f_gross = $f_gross + $gross;
			    	//echo $f_gross . "<br/>";
			    }
			    if($ifund_mult == 1) $ifund_mult = $normal_mult;
			    else $ifund_mult = 0;
			    $ifinal = $ifund * $ifund_mult;
			    $tfinal = $tfund * $normal_mult;
			    $pfinal = $pfund * $normal_mult;
			    $late_cut = $late_mult * $late_rate;
			    $lfinal = $lfund * $normal_mult;
			    $net = $f_gross + $hday + $ifinal + $tfinal + $pfinal + $lfinal + ($over_time_rate * $over_time)  + $bonus; 
			    $total_cut =  $final_uni_fee + $cash_advance_cut +  $late_cut + $bpjs ;
			    $f_net = $f_net + $net;
			    //echo $net . '<br/>';
			    
				$contents = $contents . '<table cellspacing="0" cellpadding="3">  
		    	       	<tr>  
		            		<td width="25%" align="right">Employee Name: </td>
		                 	<td width="25%"><b>'.$full_name.'</b></td>
		    	    	</tr>
		    	    	<tr>
		    	    		<td width="25%" align="right">Employee ID: </td>
						 	<td width="25%">'.$empid.'</td>   
		    	    	</tr>';
		 
			    	if($mrow['emp_status'] == 1) $emp_status = 'FULL TIME';
			    	else $emp_status = 'PART TIME';
			    	 $contents = $contents . '
		    	    	<tr>
		    	    		<td width="25%" align="right">Employement Status: </td>
						 	<td width="25%">'.$emp_status.'</td>   

						 	<td width="25%" align="right">Rate per Day: </td>
		                 	<td width="25%" align="right">'.number_format($mrow['rate'], 2).'</td>
		    	    	</tr>
		    	    	<tr>
		    	    		<td width="25%" align="right">Position Status: </td>
						 	<td width="25%">'.$mrow['posdesc'].'</td>   
		    	    	</tr>
		    	    	';
			    
			   
		    	$contents = $contents . '
		    			<tr>
		    	    		<td></td> 
		    	    		<td></td>    

						 	<td width="25%" align="right">Total Days: </td>
						 	<td width="25%" align="right">'.number_format($normal_mult, 2).'</td> 
		    	    	</tr>
		    	    	<tr>
		    	    		<td></td> 
		    	    		<td></td>    

						 	<td width="25%" align="right">Total extra hour: </td>
						 	<td width="25%" align="right">'.number_format($over_time, 2).'</td> 
		    	    	</tr>
		    	    	<tr>
		    	    		<td></td> 
		    	    		<td></td>    
						 	<td width="25%" align="right">Total Sick Days: </td>
						 	<td width="25%" align="right">'.number_format($sick_r, 2).'</td> 
		    	    	</tr>
		    	    	<tr>
		    	    		<td></td> 
		    	    		<td></td>    
						 	<td width="25%" align="right">Total Late Days: </td>
						 	<td width="25%" align="right">'.number_format($late_mult, 2).'</td> 
		    	    	</tr>
		    	    	<tr>
		    	    		<td></td> 
		    	    		<td></td>   
						 	<td width="25%" align="right">Total Leave Days: </td>
						 	<td width="25%" align="right">'.number_format($leave_r, 2).'</td> 
		    	    	</tr>
		    	    	<tr>
		    	    		<td></td> 
		    	    		<td></td>
						 	<td width="25%" align="right">Total Alpha Days: </td>
						 	<td width="25%" align="right">'.number_format($alpha_r, 2).'</td> 
		    	    	</tr>
		    	    	<tr>
		    	    		<td></td> 
		    	    		<td></td>
						 	<td width="25%" align="right">Total Extra Days: </td>
						 	<td width="25%" align="right">'.number_format($hd_r, 2).'</td> 
		    	    	</tr>
		    	    	<tr> 
		    	    		<td></td> 
		    	    		<td></td>
						 	<td width="25%" align="right"><b>Gross Pay: </b></td>
						 	<td width="25%" align="right"><b>'.number_format(($f_gross), 2).'</b></td> 
		    	    	</tr>
		    	    	<tr> 
		    	    		<td></td> 
		    	    		<td></td>
						 	<td width="25%" align="right"><b>Extra Hour Pay: </b></td>
						 	<td width="25%" align="right"><b>'.number_format(($over_time*$over_time_rate), 2).'</b></td> 
		    	    	</tr>
		    	    	<tr> 
		    	    		<td></td> 
		    	    		<td></td>
						 	<td width="25%" align="right"><b>Bonus Pay: </b></td>
						 	<td width="25%" align="right"><b>'.number_format(($bonus), 2).'</b></td> 
		    	    	</tr>
		    	    	<tr> 
		    	    		<td></td> 
		    	    		<td></td>
						 	<td width="25%" align="right"><b>Insentive Fund: </b></td>
						 	<td width="25%" align="right"><b>'.number_format(($ifinal), 2).'</b></td> 
		    	    	</tr>
		    	    	<tr> 
		    	    		<td></td> 
		    	    		<td></td>
						 	<td width="25%" align="right"><b>Transport Fund: </b></td>
						 	<td width="25%" align="right"><b>'.number_format(($tfinal), 2).'</b></td> 
		    	    	</tr>
		    	    	<tr> 
		    	    		<td></td> 
		    	    		<td></td>
						 	<td width="25%" align="right"><b>Lunch Fund: </b></td>
						 	<td width="25%" align="right"><b>'.number_format(($lfinal), 2).'</b></td> 
		    	    	</tr>
		    	    	<tr> 
		    	    		<td></td> 
		    	    		<td></td>
						 	<td width="25%" align="right"><b>Position Fund: </b></td>
						 	<td width="25%" align="right"><b>'.number_format(($pfinal), 2).'</b></td> 
		    	    	</tr>';
		    	    	$ofinal = $over_time*$over_time_rate;
		    	    	$sql = "INSERT INTO pay_slip_archive
		    	  (employee_id,full_name,branch_id,branch_text,month,position,num_of_day,Sick_leave,Paid_leave,Alpha_leave,gross_amount,meal_fund,transport_fund,Insentive_fund,Position_fund,Overtime,Extra_fund,late_deduction,uniform_deduction,BPJS,cash_advance) 
		    	   values('$empid','$full_name','$emp_branch','temp','$from','$mpos','$normal_mult','$sick_r','$leave_r','$alpha_r','$f_gross','$lfinal','$tfinal','$ifinal','$pfund','$ofinal','$bonus','$late_cut','$final_uni_fee','$bpjs','$cash_advance_cut')";
		    	   		echo $sql;
						$query = $conn->query($sql);
			}
			$f_net = $f_net - $total_cut;
			$contents = $contents . '
		    	    	<tr> 
		    	    		<td></td> 
		    	    		<td></td>
						 	<td width="25%" align="right"><b>Uniform_fee: </b></td>
						 	<td width="25%" align="right"><b>'.number_format($final_uni_fee, 2).'</b></td> 
		    	    	</tr>
		    	    	<tr> 
		    	    		<td></td> 
		    	    		<td></td>
						 	<td width="25%" align="right"><b>Cash Advance: </b></td>
						 	<td width="25%" align="right"><b>'.number_format($cash_advance_cut, 2).'</b></td> 
		    	    	</tr>
		    	    	<tr> 
		    	    		<td></td> 
		    	    		<td></td>
						 	<td width="25%" align="right"><b>Late Cut: </b></td>
						 	<td width="25%" align="right"><b>'.number_format($late_cut, 2).'</b></td> 
		    	    	</tr>
		    	    	<tr> 
		    	    		<td></td> 
		    	    		<td></td>
						 	<td width="25%" align="right"><b>BPJS: </b></td>
						 	<td width="25%" align="right"><b>'.number_format($bpjs, 2).'</b></td> 
		    	    	</tr>
		    	    	<tr> 
		    	    		<td></td> 
		    	    		<td></td>
						 	<td width="25%" align="right"><b>Total Deduction:</b></td>
						 	<td width="25%" align="right"><b>'.number_format($total_cut, 2).'</b></td> 
		    	    	</tr>
		    	    	<tr> 
		    	    		<td></td> 
		    	    		<td></td>
						 	<td width="25%" align="right"><b>Net Pay:</b></td>
						 	<td width="25%" align="right"><b>'.number_format($f_net, 2).'</b></td> 
		    	    	</tr>
		    	    </table>
		    	    <br><hr>
				';
		    $pdf->writeHTML($contents);  
		    $fname = generateRandomString();
		    $pdf->Output(getcwd() . $fname, 'F');

		    $fname = 'http://'. $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']) . $fname;
		    $sql = "UPDATE employees set uniform_fee = uniform_fee - $final_uni_fee, cashadvance = cashadvance - $cash_advance_cut where employee_id = '$empid'";
		    $query = $conn->query($sql);
		    $sql = "INSERT INTO payroll_archive(employee_id,start_duration,end_duration,filename,amount) values('$empid','$from','$to','$fname','$f_net')";
		    $query = $conn->query($sql);
		}
			
	    
	    	/*
	      $empid = $row['empid'];
	      
	      $casql = "SELECT *, SUM(amount) AS cashamount FROM cashadvance WHERE employee_id='$empid' AND date_advance BETWEEN '$from' AND '$to'";
	      
	      $caquery = $conn->query($casql);
	      $carow = $caquery->fetch_assoc();
	      $cashadvance = $carow['cashamount'];
	      $branch_emp = $row['branch_id'];
	      
	      date_default_timezone_set('Asia/Jakarta');  // you are required to set a timezone

	      $date1 = new DateTime($row['date']);
	      $date2 = new DateTime('now');
	      
	      $diff = $date1->diff($date2);

	      //echo (($diff->format('%y') * 12) + $diff->format('%m')) . " full months difference";

	      $casql = "DELETE from cashadvance WHERE employee_id='$empid' AND date_advance BETWEEN '$from' AND '$to'";
	      $caquery = $conn->query($casql);

	      $dsql = "SELECT *, SUM(amount) as total_amount FROM deductions where branch = $branch_emp";

	      $dquery = $conn->query($dsql);
	      $drow = $dquery->fetch_assoc();
	      $deduction = $drow['total_amount'];
	      $gross = $row['rate'] * $row['total_day'];
	      $total_deduction = $deduction + $cashadvance + $row['bpjs'] + ($row['uniform_fee']/3);
	      $net = $gross - $total_deduction;
	      $last_uni_fee = 0;
	      if($row['uniform_fee'] > 0)
	        $last_uni_fee = $row['uniform_fee'] - 100;
	      $usql = "UPDATE employees set uniform_fee = $last_uni_fee WHERE id='$empid'";
	      
	      $conn->query($usql);
	      */
	}	
	else{
		$_SESSION['error'] = 'Fill up add form first';
	}
	
	//header('location: payroll.php');

?>