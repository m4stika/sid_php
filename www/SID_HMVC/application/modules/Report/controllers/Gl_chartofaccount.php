<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Gl_chartofaccount extends MY_Controller {

	public function __construct()
	{
		parent::__construct();		
		$this->load->library('Pdf','pdf');
		$this->load->library('Sidlib','sidlib');
		$this->load->model('Accounting_model','report_model');
	}

	public function index() {
		$pdf = new Pdf('P', 'mm', 'A4', false, 'ISO-8859-1', false);

		//Generate Table
		$ColoredTable = function($header, $width, $data, $fieldname) use ($pdf) {
	        // Colors, line width and bold font
		    $pdf->SetFillColorArray(sidlib::rgbColor(HEADER_COLOR));
		    $pdf->SetTextColorArray(sidlib::rgbColor(HEADER_TEXT_COLOR));
	        $pdf->SetLineStyle(sidlib::lineStyle());
	        $pdf->SetFont('', 'B',10);

	        // Header
	        $num_headers = count($header);
	        for($i = 0; $i < $num_headers; ++$i) {
	            $pdf->Cell($width[$i], 10, $header[$i], 'TB', 0, 'C', 1);
	        }
	        $pdf->Ln();
	        // Color and font restoration
	        $pdf->SetFillColorArray(sidlib::rgbColor('blue-light'));
		    $pdf->SetTextColorArray(sidlib::rgbColor(TEXT_COLOR));
	        
	        // Data
	        $fill = 0;
	        foreach($data as $row) {
	           // $fill = (!$row->classacc == 0);
	            ($row->classacc == 0) ? $pdf->SetFont('','B',9) : $pdf->SetFont('','I',8);
	            $pdf->Cell($width[0], 6, $row->$fieldname[0], 'L', 0, 'R', $fill);
	            //($row->classacc == 0) ? $pdf->setCellPaddings(2) : $pdf->setCellPaddings(5);
	            //$pdf->setCellPaddings($row->levelacc+1);
	            $desc = str_pad($row->description, strlen($row->description)+(1*$row->levelacc)," ",STR_PAD_LEFT);
	            $pdf->Cell($width[1], 6, $desc, '', 0, 'L', $fill);
	            $pdf->Cell($width[2], 6, $this->sidlib->my_format($row->$fieldname[2]), '', 0, '', $fill);
	            $pdf->Cell($width[3], 6, $this->sidlib->my_format($row->$fieldname[3]), '', 0, 'R', $fill);
	            $pdf->Cell($width[4], 6, $this->sidlib->my_format($row->$fieldname[4]), '', 0, 'R', $fill);
	            $pdf->Cell($width[5], 6, $this->sidlib->my_format($row->$fieldname[5]), 'R', 0, 'R', $fill);
	            $pdf->Ln();
	            //$fill=!$fill;
	        }
	        $pdf->Cell(array_sum($width), 0, '', 'T');
	    };

		$pdf->initializeReport();
		$periode = date_create($this->input->post('periode'));
		$periode1 = date_create($this->input->post('periode1'));
		
		// Generate Report Title
		$pdf->SetMargins(5, PDF_MARGIN_TOP, 5, true);  
		$pdf->setCellHeightRatio(1.8);
		$pdf->resetPageWidth();
		$pdf->SetTitle('SID | Chart Of Account');
		$pdf->AddPage();
		
		// Generate Report Header
//reportHeader($text, $align='C', $border=0, $color = array(0), $fontsize = 12, $stretch = 0,  $valign = 'B', $calign='C')		
		$pdf->reportHeader('Chart Of Account', 'C', 'B', sidlib::rgbColor(TITLE_COLOR), 20, 4, 'B');
		
		//Get Data Record from Database
		$perkiraan = $this->report_model->get_chartofaccount();//100, 0);
		
		// column titles & width
		$header = array('Account', 'Description', 'Opening', 'Debit', 'Credit', 'Ballance Due');
		$fieldname = array('accountno', 'description', 'openingbalance', 'debet', 'kredit', 'balancedue');
		$width = array(25, 70, 25, 25, 25, 25);

		// print colored table
		$ColoredTable($header, $width, $perkiraan, $fieldname);

		//Generate PDF file
		ob_clean();
		$pdf->Output('Gl_chartofaccount.pdf', 'I');
		ob_end_clean();
    }
}
?>