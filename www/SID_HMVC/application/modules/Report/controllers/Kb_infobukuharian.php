<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Kb_infobukuharian extends MY_Controller {

	public function __construct()
	{
		parent::__construct();		
		$this->load->library('Pdf','pdf');
		$this->load->library('Sidlib','sidlib');
		$this->load->model('Kasbank_model','report_model');
	}

	public function index() {
		$pdf = new Pdf('P', 'mm', 'A4', false, 'ISO-8859-1', false);
		$periode = date_create($this->input->post('periode'));
		$periode1 = date_create($this->input->post('periode1'));
	
		//Generate Table
		$ColoredTable = function() use ($pdf, $color) {
	        // column titles & width
	        $header = array('Kode', 'Perkiraan','Saldo Awal', 'Debet', 'Kredit', 'Saldo Akhir');
	        $width = array(10, 30, 15, 15, 15, 15);

	        // Header
	        $pdf->setCellPaddings(0,0,0,0);
	        $pdf->SetFont('', 'B',9);
	        $pdf->SetLineStyle(sidlib::lineStyle());
	        $pdf->SetFillColorArray(sidlib::rgbColor(HEADER_COLOR));
	        $pdf->SetTextColorArray(sidlib::rgbColor(HEADER_TEXT_COLOR));
	        $num_headers = count($header);
	        $pdf->Ln(3);
	        for($i = 0; $i < $num_headers; ++$i) {
	        	$pdf->Cell($width[$i]/100*$pdf->PageWidth, 8, $header[$i], 1, 0, 'C', 1);
	        }
	        $pdf->Ln();
		    
		    $h = 5;
		    $fill = 0;
		    $bukuharian = $this->report_model->get_infobukuharian();
	        foreach($bukuharian as $value) {
	        	if ($value->classacc == 0) {
	        		$pdf->SetFont('', 'B',9);
	        		$pdf->SetTextColorArray(sidlib::rgbColor('blue-chambray'));
	        		$pdf->setCellPaddings(2,1,2,0);
	        	} else {
	        		$pdf->SetFont('', '',8);
	        		$pdf->SetTextColorArray(sidlib::rgbColor(TEXT_COLOR));
	        		$pdf->setCellPaddings(5,1,2,0);
	        	}
		        $pdf->Cell($width[0]/100 * $pdf->PageWidth, $h, $value->accountno, 'LR', 0, 'R',$fill);
		        $pdf->Cell($width[1]/100 * $pdf->PageWidth, $h, $value->description, 'LR', 0, 'L',$fill);
				$pdf->Cell($width[2]/100 * $pdf->PageWidth, $h, $this->sidlib->my_format($value->saldoawal), 'LR', 0, 'R',$fill);
				$pdf->Cell($width[3]/100 * $pdf->PageWidth, $h, $this->sidlib->my_format($value->debet), 'LR', 0, 'R',$fill);
				$pdf->Cell($width[4]/100 * $pdf->PageWidth, $h, $this->sidlib->my_format($value->kredit), 'LR', 0, 'R',$fill);
				$pdf->Cell($width[5]/100 * $pdf->PageWidth, $h, $this->sidlib->my_format($value->saldoakhir), 'LR', 1, 'R',$fill);
        	}
        	$pdf->Cell(array_sum($width) / 100 * $pdf->PageWidth, 0, '', 'T');
	    };


		//PDF initialize
		$pdf->initializeReport();
		
		// Generate Report Title
		$pdf->SetMargins(5, PDF_MARGIN_TOP, 5, true);  
		$pdf->resetPageWidth();
		$pdf->SetTitle('SID | Informasi Buku Harian');
		$pdf->AddPage();
		
		// Generate Report Header
		$pdf->setCellPaddings(0,1,0,1);
		$pdf->reportHeader('Informasi Buku Harian', 'C', 'B', sidlib::rgbColor(TITLE_COLOR), 18, 4, 'B','C');
		$pdf->reportHeader(date_format($periode, "d-M-Y").' s/d '.date_format($periode1, "d-M-Y"), 'C', 0, sidlib::rgbColor(TEXT_COLOR), 10, 0, 'B','A');

		// print colored table
		$ColoredTable();

		//Generate PDF file
		ob_clean();
		$pdf->Output('Kb_infobukuharian.pdf', 'I');
		ob_end_clean();
    }
}
?>