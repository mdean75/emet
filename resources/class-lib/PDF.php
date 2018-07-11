<?php //pdf.php

require_once ($_SERVER['DOCUMENT_ROOT'].'/resources/vendor/fpdf/fpdf.php');

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

	function createOvertimeReport ($get_updated_ot) {
		$this->ADDPage();
		$this->SetTitle('NJCAD Mandatory Overtime List');
		$this->SetFont('arial', 'B', 24);

		$this->SetFillColor(102, 153, 255);
		$this->SetX(45);
		$this->Image($_SERVER['DOCUMENT_ROOT'].'/images/logo.png', 12,13,25,25);
		$this->SetXY(45, 15);
		$this->Cell(150, 20, 'NJCAD Mandatory Overtime List', 1, 1, 'C', true);
		$this->SetFont('arial', '', 18);
		$this->SetXY(25, 50);
		$this->Cell(20, 10, 'Crew', 'B', 0, 'C');
		$this->SetX(55);
		$this->Cell(50, 10, 'Name', 'B', 0, 'C');
		$this->SetX(115);
		$this->Cell(35, 10, 'Date', 'B', 0, 'C');
		$this->SetX(160);
		$this->Cell(25, 10, 'Shift', 'B', 1, 'C');
		$this->Ln();

		$this->SetFont('arial', '', 14);

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

				$this->Ln();
				$this->SetX(25);
				$this->Cell(20, 10, $shift_test, 0, 0, 'C');
				$this->Ln();
			} // end if shift_test

			$this->SetX(55);
			$this->Cell(60, 10, $fname.' '.$lname, 0, 0, 'L');
			$this->SetX(115);
			$this->Cell(50, 10, $date, 0, 0, 'L');
			$this->SetX(160);
			$this->Cell(20, 10, $shift, 0, 1, 'L');

		} // end foreach

		$this->Ln();
		$this->Ln();


		$this->Ln();
		$this->Ln();
		$this->Ln();
		$this->close();

		$this->output('f', ($_SERVER['DOCUMENT_ROOT'].'/mandatory-overtime.pdf'));


	}

	function getReport() {
		return $this->output();
	}
}