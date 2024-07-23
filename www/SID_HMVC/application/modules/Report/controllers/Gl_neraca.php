<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Gl_neraca extends MY_Controller {

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
	        $labarugi = $this->report_model->get_GLNeraca();

	        $current = strtotime($this->input->post('bulan').'/01/'.$this->input->post('tahun'));
			$prevbulantahun = date("M - Y", strtotime("-1 month", $current));
			$bulantahun = date("M - Y", $current);

	        // column titles & width
	        $header = array('Description', $bulantahun, $prevbulantahun);
	        $width = array(60, 20, 20);

	        // Colors, line width and bold font
	        $pdf->SetFillColorArray(sidlib::rgbColor(HEADER_COLOR));
		    $pdf->SetTextColorArray(sidlib::rgbColor(HEADER_TEXT_COLOR));
	        $pdf->SetLineStyle(sidlib::lineStyle());
	        $pdf->SetFont('', 'B',10);

	        // Header
	        $pdf->setCellPaddings(0,0,0,0);
	        $pdf->Ln();
	        $num_headers = count($header);
	        for($i = 0; $i < $num_headers; ++$i) {
	        	$pdf->Cell($width[$i]/100*$pdf->PageWidth, 10, $header[$i], 'TRBL', 0, 'C', 1);
	        }
	        $pdf->Ln();

	        // Color and font restoration
	        $pdf->SetFillColorArray(sidlib::rgbColor('yellow-light'));
	        $pdf->SetTextColorArray(sidlib::rgbColor(TEXT_COLOR));

//Cell($pdf->PageWidth, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='M')

	        //Loop Labarugi Header
	        $pdf->setCellPaddings(2,0,2,0);
	        foreach($labarugi as $value) { 
	        	//Generate Table Detil
        		$value->classacc==0 ? $pdf->SetFont('', 'B',8) : $pdf->SetFont('', '',8);
        		if ($value->flaggrandtotal==2) $pdf->SetFont('', 'B',9);

        		$fill = $value->flaggrandtotal == 2;
        		$h = $value->flaggrandtotal == 2 ? 8 : 6;
        		$pdf->setCellPaddings(2 * ($value->levelacc == 0) ? 1 : $value->levelacc+1,0,2,0);
            	$pdf->Cell($width[0]/100 * $pdf->PageWidth, $h, $value->description, 'L', 0, 'L',$fill);
            	$pdf->setCellPaddings(2,0,2,0);
	            $pdf->Cell($width[1]/100 * $pdf->PageWidth, $h, $this->sidlib->my_format($value->dueamount), '', 0, 'R',$fill);
	            $pdf->Cell($width[2]/100 * $pdf->PageWidth, $h, $this->sidlib->my_format($value->duekomparatif1), 'R', 0, 'R',$fill);
	            $pdf->Ln();
	        }
	        //Draw Last Top Line
	        $pdf->Cell(array_sum($width) / 100 * $pdf->PageWidth, 0, '', 'T');
	        //Draw Footer
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
		$pdf->Output('Gl_neraca.pdf', 'I');
		ob_end_clean();
    }
}
?>