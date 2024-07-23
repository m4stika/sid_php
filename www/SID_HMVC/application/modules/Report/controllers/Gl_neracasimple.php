<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Gl_neracasimple extends MY_Controller {

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
		$ColoredTable = function() use ($pdf) {
	        $Neraca = $this->report_model->get_GLNeraca();

	        $current = strtotime($this->input->post('bulan').'/01/'.$this->input->post('tahun'));
			$prevbulantahun = date("M - Y", strtotime("-1 month", $current));
			$bulantahun = date("M - Y", $current);

	        // column titles & width
	        $header = array('ACTIVA', 'PASIVA');
	        $width = array(35,15,35,15);

	        // Colors, line width and bold font
	        $pdf->SetFillColorArray(sidlib::rgbColor(HEADER_COLOR));
		    $pdf->SetTextColorArray(sidlib::rgbColor(HEADER_TEXT_COLOR));
	        $pdf->SetLineStyle(sidlib::lineStyle());

	        // Header
	        $pdf->setCellPaddings(5,0,5,0);
	        $pdf->Ln();
	        
	        // $pdf->setEqualColumns(2);
	        // $pdf->Cell(0, 10, 'ACTIVA', 'TBL', 0, 'L', 1);
	        // $pdf->selectColumn(1);
	        // $pdf->Cell(0, 10, 'PASIVA', 'TRB', 0, 'R', 1);
	        
	        $pdf->SetFont('', 'B',12);
	        $pdf->Cell(0.5*$pdf->PageWidth, 10, 'ACTIVA', 'TBL', 0, 'C', 1);
	        $x = $pdf->GetX();
	        $pdf->Cell(0.5*$pdf->PageWidth, 10, 'PASIVA', 'TRB', 0, 'C', 1);
	        $pdf->Ln();
	        $y = $pdf->GetY();
	        

	        // Color and font restoration
	        //$pdf->SetFillColor(247, 231, 168);
	        //$pdf->SetFillColor(42, 180, 192); //green-sharp
	        $pdf->SetFillColorArray(sidlib::rgbColor(FOOTER_COLOR));
	        $pdf->SetTextColorArray(sidlib::rgbColor(FOOTER_TEXT_COLOR));
	        

//Cell($pdf->PageWidth, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='M')
//Write($h, $txt, $link='', $fill=false, $align='', $ln=false, $stretch=0, $firstline=false, $firstblock=false, $maxh=0, $wadj=0, $margin='')
	        //Loop Neraca Header
	        $pdf->setCellPaddings(2,0,2,0);
	        $first2ndColumn = true;
	        
	        foreach($Neraca as $value) { 
	        	//Generate Table Detil
        		$value->classacc==0 ? $pdf->SetFont('', 'B',8) : $pdf->SetFont('', '',8);
        		if ($value->flaggrandtotal==2) $pdf->SetFont('', 'B',9);
        		$fill = $value->flaggrandtotal == 2;
        		$h = $value->flaggrandtotal == 2 ? 8 : 6;
        		$pdf->setCellPaddings(2 * ($value->levelacc == 0) ? 1 : $value->levelacc+1,0,2,0);

        		if (substr($value->accountno,0,1) == '1') {
	            	$pdf->Cell($width[0]/100*$pdf->PageWidth, $h, $value->description, 'L', 0, 'L',$fill);
	            	$pdf->setCellPaddings(2,0,2,0);
		            $pdf->Cell($width[1]/100*$pdf->PageWidth, $h, $this->sidlib->my_format($value->dueamount), '', 0, '',$fill);
		        } else {
		        	if ($first2ndColumn == true) {
		        		$pdf->SetXY($x, $y);
		        	} else $pdf->SetX($x);
	            	$pdf->Cell($width[2]/100*$pdf->PageWidth, $h,$value->description, '', 0, 'L',$fill);
	            	$pdf->setCellPaddings(2,0,2,0);
		            $pdf->Cell($width[3]/100*$pdf->PageWidth, $h, $this->sidlib->my_format($value->dueamount), 'R', 0, 'R',$fill);
		            $first2ndColumn = false;
		        }
		        $pdf->Ln();
	        }
	        //Draw Last Top Line
	       // $pdf->Cell(array_sum($width) / 100 * $pdf->PageWidth, 0, '', 'T');
	    };


		//PDF initialize
		$pdf->initializeReport();
		
		// Generate Report Title
		$pdf->SetMargins(5, PDF_MARGIN_TOP, 5, true);  
		$pdf->setCellHeightRatio(1.8);
		$pdf->resetPageWidth();
		$pdf->SetTitle('SID | Balance Sheet');
		$pdf->AddPage();
		
		// Generate Report Header
		$pdf->setCellPaddings(0,1,0,1);
		$pdf->reportHeader('Neraca ( Balance Sheet )', 'C', 'B', sidlib::rgbColor(TITLE_COLOR), 20, 4, 'B');
		$pdf->reportHeader($this->input->post('bulanname').' - '.$this->input->post('tahun'), 'C', 0, sidlib::rgbColor(TEXT_COLOR), 10, 0);

		// print colored table
		$ColoredTable();

		//Generate PDF file
		ob_clean();
		$pdf->Output('Gl_neracasimple.pdf', 'I');
		ob_end_clean();
    }
}
?>