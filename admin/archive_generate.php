<?php
	include 'includes/session.php';

	function generateRow($month,$year,$branch,$conn){
		$contents = '';
	 	$branch = $branch;
		$sql = "SELECT * from pay_slip_archive where MONTH(month) = $month AND YEAR(month) = $year AND $branch = '$branch'";
   
		$query = $conn->query($sql);
		for($i = 0; $i < 16;$i++) $total[$i] = 0;

		while($row = $query->fetch_assoc()){
	        $gt = 	$row['gross_amount'] + $row['meal_fund'] + $row['transport_fund'] + $row['Position_fund'] + $row['Insentive_fund'] + $row['Overtime'] + $row['Extra_fund'] - $row['late_deduction'] - $row['BPJS'] - $row['uniform_deduction'] - $row['cash_advance']; 
			$contents .= '
			<tr>
				<td>'.$row['employee_id'].'</td>
				<td>'.$row['full_name'].'</td>
				<td>'.$row['position'].'</td>
                <td>'.$row['num_of_day'].'</td>
                <td>'.$row['Sick_leave'].'</td>
                <td>'.$row['Paid_leave'].'</td>
                <td>'.$row['Alpha_leave'].'</td>
                <td align="right">'.number_format($row['gross_amount'], 2).'</td>
                <td align="right">'.number_format($row['meal_fund'], 2).'</td>
                <td align="right">'.number_format($row['transport_fund'], 2).'</td>
                <td align="right">'.number_format($row['Position_fund'], 2).'</td>
                <td align="right">'.number_format($row['Insentive_fund'], 2).'</td>
                <td align="right">'.number_format($row['Overtime'], 2).'</td>
                <td align="right">'.number_format($row['Extra_fund'], 2).'</td>
                <td align="right">'.number_format($row['late_deduction'], 2).'</td>
                <td align="right">'.number_format($row['uniform_deduction'], 2).'</td>
                <td align="right">'.number_format($row['BPJS'], 2).'</td>
                <td align="right">'.number_format($row['cash_advance'], 2).'</td>
                <td align="right">'.number_format($gt, 2).'</td>
                            
            </tr>
			';
			$total[0] = $total[0] + $row['num_of_day'];
            $total[1] = $total[1] + $row['Sick_leave'];
            $total[2] = $total[2] + $row['Paid_leave'];
            $total[3] = $total[3] + $row['Alpha_leave'];
            $total[4] = $total[4] + $row['gross_amount'];
            $total[5] = $total[5] + $row['meal_fund'];
            $total[6] = $total[6] + $row['transport_fund'];
            $total[7] = $total[7] + $row['Position_fund'];
            $total[8] = $total[8] + $row['Insentive_fund'];
            $total[9] = $total[9] + $row['Overtime'];
            $total[10] = $total[10] + $row['Extra_fund'];
            $total[11] = $total[11] + $row['late_deduction'];
            $total[12] = $total[12] + $row['uniform_deduction'];
            $total[13] = $total[13] + $row['BPJS'];
            $total[14] = $total[14] + $row['cash_advance'];
            $total[15] = $total[15] + $gt;
        }

		$contents .= '
			<tr>
				<td colspan="3" align="right"><b>Total</b></td>
				<td align="right"><b>'.number_format($total[0], 2).'</b></td>
                <td align="right"><b>'.number_format($total[1], 2).'</b></td>
                <td align="right"><b>'.number_format($total[2], 2).'</b></td>
                <td align="right"><b>'.number_format($total[3], 2).'</b></td>
                <td align="right"><b>'.number_format($total[4], 2).'</b></td>
                <td align="right"><b>'.number_format($total[5], 2).'</b></td>
                <td align="right"><b>'.number_format($total[6], 2).'</b></td>
                <td align="right"><b>'.number_format($total[7], 2).'</b></td>
                <td align="right"><b>'.number_format($total[8], 2).'</b></td>
                <td align="right"><b>'.number_format($total[9], 2).'</b></td>
                <td align="right"><b>'.number_format($total[10], 2).'</b></td>
                <td align="right"><b>'.number_format($total[11], 2).'</b></td>
                <td align="right"><b>'.number_format($total[12], 2).'</b></td>
                <td align="right"><b>'.number_format($total[13], 2).'</b></td>
                <td align="right"><b>'.number_format($total[14], 2).'</b></td>
                <td align="right"><b>'.number_format($total[15], 2).'</b></td>
			</tr>
		';
		return $contents;
	}
		
	$d_str = $_POST['month'];
    $s_str = explode("-", $d_str);
    $year = $s_str[0];
    $month = $s_str[1];
	$branch = $_POST['branch'];
	
	require_once('../tcpdf/tcpdf.php');  
    $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
    $pdf->SetCreator(PDF_CREATOR);  
    $pdf->SetTitle('Monthpy Report of PT3S');  
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
      	<h2 align="center">3s Monthly Report</h2>
      	<table border="1" cellspacing="0" cellpadding="3" id="test">  
           <tr>  

                <td>Employee ID</td>
                <td>Name</td>
                <td>Position</td>
                <td>Total Day</td>
                <td>S</td>
                <td>I</td>
                <td>A</td>
                <td>Gapok</td>
                <td>UM</td>
                <td>Transport</td>
                <td>Insentive</td>
                <td>TJ</td>
                <td>Lembur</td>
                <td>Total</td>
                <td>POT telat</td>
                <td>POT</td>
                <td>BPJS</td>
                <td>KASBON</td>
                <td>G.Total</td>
           </tr>  
      ';  
    $content .= generateRow($month,$year,$branch,$conn);  
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

exportTableToExcel('test','monthly report');
window.location.href = "archive.php";
</script>
