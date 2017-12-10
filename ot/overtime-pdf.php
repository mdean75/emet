<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/resources/autoloader.php');

require_once ($_SERVER['DOCUMENT_ROOT'].'/resources/vendor/fpdf/fpdf.php');

// full title to display on larger screens
$page_title = "Overtime Tracking - Overtime Report";
// shortened page title for mobile devices
$page_title_short = "Overtime Report";

$page_security = 1;

// retrieve most recent overtime date and shift worked for each employee

$sql = "SELECT fname, lname, users_assignment.assignment_name, DateLastWorkedOT, ShiftLastWorked 
		FROM users_profile 
		INNER JOIN users_assignment ON users_profile.assignment = users_assignment.id 
		WHERE assignment = '2' OR assignment = '3' OR assignment = '4' 
		GROUP BY assignment, DateLastWorkedOT, ShiftLastWorked, SecondDate, SecondShift, ThirdDate, ThirdShift, lname, fname ASC ";

$db = new database;

$db->query($sql);
$get_updated_ot = $db->resultset();


/* --------------------------------------------------------------------
	This section of code creates the PDF
	-------------------------------------------------------------------
*/

/* --------------------------------------------------------------------
	FPDF automatically calls the footer however the method is empty.
	This will define the footer for the pdf report to print the date 
	and time in the footer section.
   -------------------------------------------------------------------- */
class PDF extends FPDF
{
	function Footer()
	{
	    // Position at 1.5 cm from bottom
	    $this->SetY(-30);
	    // Arial italic 8
	    $this->SetFont('Arial','I',10);
	    // Page number
	    date_default_timezone_set('America/Chicago');
	    $timestamp=date('F j, Y  H:i');

		$this->Cell(20, 10, $timestamp, 0, 0, 'L');
		$this->SetX(98);
		$this->SetFont('Arial','I',12);
		$this->Cell(15, 10, 'Page '. $this->PageNo(), 0,0, 'C');
		$this->SetX(180);
		$this->SetFont('Arial','I',10);
		$this->Cell(20, 10, 'mandatory-overtime.pdf', 0, 1, 'R');
	    
	}
}
$pdf=new PDF();

$pdf->ADDPage();
$pdf->SetTitle('NJCAD Mandatory Overtime List');
$pdf->SetFont('arial', 'B', 24);

$pdf->SetFillColor(102, 153, 255);
$pdf->SetX(45);
$pdf->Image($_SERVER['DOCUMENT_ROOT'].'/images/logo.png', 12,13,25,25);
$pdf->SetXY(45, 15);
$pdf->Cell(150, 20, 'NJCAD Mandatory Overtime List', 1, 1, 'C', true);
$pdf->SetFont('arial', '', 18);
$pdf->SetXY(25, 50);
$pdf->Cell(20, 10, 'Crew', 'B', 0, 'C');
$pdf->SetX(55);
$pdf->Cell(50, 10, 'Name', 'B', 0, 'C');
$pdf->SetX(115);
$pdf->Cell(35, 10, 'Date', 'B', 0, 'C');
$pdf->SetX(160);
$pdf->Cell(25, 10, 'Shift', 'B', 1, 'C');
$pdf->Ln();

$pdf->SetFont('arial', '', 14);

/* -----------------------------------------------------------
	This section of code sets the array with employee data
	sorted by shift from the above query and the switch statement
	assigns a string value to display for the shift worked to make
	the output more user friendly
	----------------------------------------------------------
*/


$shift_test = '';
foreach ($get_updated_ot as $results){
	$fname = $results['fname'];
	$lname = $results['lname'];
	$date = $results['DateLastWorkedOT'];

	if ($date !=NULL){
			$date = date('n/j/Y', strtotime($date));
		}else{
			$date = '';
	} // end if .. else

	
	$shift = $results['ShiftLastWorked'];

	switch ($shift) {
		case '1':
			$shift='Day';
			break;
		case '2':
			$shift='Night';
			break;
		case '3':
			$shift='24 Hours';
			break;
		
		default:
			break;
	} // end switch

	if ($shift_test != $results['assignment_name']){
		$shift_test = $results['assignment_name'];

		$pdf->Ln();
		$pdf->SetX(25);
		$pdf->Cell(20, 10, $shift_test, 0, 0, 'C');
		$pdf->Ln();
	} // end if shift_test

	$pdf->SetX(55);
	$pdf->Cell(60, 10, $fname.' '.$lname, 0, 0, 'L');
	$pdf->SetX(115);
	$pdf->Cell(50, 10, $date, 0, 0, 'L');
	$pdf->SetX(160);
	$pdf->Cell(20, 10, $shift, 0, 1, 'L');

} // end foreach

$pdf->Ln();
$pdf->Ln();


$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->close();

$pdf->output('f', ($_SERVER['DOCUMENT_ROOT'].'/mandatory-overtime.pdf'));
$pdf->output();



?>
