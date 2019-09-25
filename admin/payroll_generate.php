<?php
	include 'includes/session.php';

	function generateRow($from, $to, $conn,$br){
		$contents = '';
	 	$branch = $br;
		$sql = "SELECT * , employees.employee_id as empid from payroll_archive,employees where employees.employee_id = payroll_archive.employee_id AND ((start_duration BETWEEN '$from' AND '$to') OR (end_duration BETWEEN '$from' AND '$to'))";
		
		$query = $conn->query($sql);
		$total = 0;
		while($row = $query->fetch_assoc()){
			$empid = $row['empid'];
            
	      	
			$contents .= '
			<tr>
				<td>'.$row['empid'].'</td>
				<td>'.$row['lastname'].', '.$row['firstname'].'</td>
				<td>'.$row['bank_account_number'].'</td>
				<td align="right">'.number_format($row['amount'], 2).'</td>
			</tr>
			';
			$total = $total + $row['amount'];
		}

		$contents .= '
			<tr>
				<td colspan="3" align="right"><b>Total</b></td>
				<td align="right"><b>'.number_format($total, 2).'</b></td>
			</tr>
		';
		return $contents;
	}
		
	$range = $_POST['date_range'];

	$br = $_POST['branch'];
	$ex = explode(' - ', $range);
	$from = date('Y-m-d', strtotime($ex[0]));
	$to = date('Y-m-d', strtotime($ex[1]));


	$from_title = date('M d, Y', strtotime($ex[0]));
	$to_title = date('M d, Y', strtotime($ex[1]));

	require_once('../tcpdf/tcpdf.php');  
    $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
    $pdf->SetCreator(PDF_CREATOR);  
    $pdf->SetTitle('Payroll: '.$from_title.' - '.$to_title);  
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
    $content = '';  
    $content .= '
      	<h2 align="center">3s PayRoll</h2>
      	<h4 align="center">'.$from_title." - ".$to_title.'</h4>
      	<table border="1" cellspacing="0" cellpadding="3" id="test">  
           <tr>  

                <th width="25%" align="center"><b>Employee ID</b></th>
           		<th width="25%" align="center"><b>Employee Name</b></th>
                <th width="25%" align="center"><b>Bank Account Number</b></th>
				<th width="25%" align="center"><b>Net Pay</b></th> 
           </tr>  
      ';  
    $content .= generateRow($from, $to, $conn,$br);  
    $content .= '</table>';  
    //$pdf->writeHTML($content);  
    //$pdf->Output('payroll.pdf', 'I');
    echo $content;

?>

<script>
	function exportTableToExcel(tableID, filename = ''){
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
    
    // Specify file name
    filename = filename?filename+'.xls':'excel_data.xls';
    
    // Create download link element
    downloadLink = document.createElement("a");
    
    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['\ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
    
        // Setting the file name
        downloadLink.download = filename;
        
        //triggering the function
        downloadLink.click();
    }
}

exportTableToExcel('test','payroll');
window.location.href = "payslip.php";
</script>
