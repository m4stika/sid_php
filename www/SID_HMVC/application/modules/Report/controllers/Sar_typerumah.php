<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Sar_typerumah extends MY_Controller {

	public function __construct()
	{
		parent::__construct();		
		$this->load->library('Pdf','pdf');
		$this->load->library('Sidlib','sidlib');
		$this->load->model('Pemasaran_model','report_model');
	}

	public function index() {
		$pdf = new Pdf('P', 'mm', 'A4', false, 'ISO-8859-1', false);
		//PDF initialize
		$pdf->initializeReport();	
		$pdf->SetMargins(5, PDF_MARGIN_TOP, 5, true);  
		$pdf->resetPageWidth();
		//$pdf->setCellHeightRatio(1.8);

		// Generate Report Title
		$pdf->SetTitle('SID | Daftar Type Rumah');
		$pdf->AddPage();
		
		// Generate Report Header
		$pdf->setCellPaddings(0,1,0,1);
		$pdf->reportHeader('Daftar Type Rumah', 'C', 'B', sidlib::rgbColor(TITLE_COLOR), 16, 4, 'B');

		//Generate Table
        // column titles & width
        $header = array('ID', 'Type Rumah','Keterangan','Harga Jual', 'Booking Fee');
        $width = array(10, 15, 35, 20, 20);

        //Loop Report Data Header
	    $pdf->setCellPaddings(2,1,2,0);
	    $pdf->SetFont('', 'B',10);
	    $pdf->SetFillColorArray(sidlib::rgbColor(HEADER_COLOR));
        $pdf->SetTextColorArray(sidlib::rgbColor(HEADER_TEXT_COLOR));
        $pdf->SetLineStyle(sidlib::linestyle());
	    $h = 5;
	    $fill = 0;
	    $num_headers = count($header);
        for($i = 0; $i < $num_headers; ++$i) {
        	if ($i > 6) {
        		if ($i == 7) {
	        		$x = $pdf->GetX();
	        		$pdf->Cell(($width[$i] + $width[$i+1] + $width[$i+2])/100*$pdf->PageWidth, 6, 'Posisi', 1, 1, 'C',1);
	        		$pdf->SetX($x);
	        	}
        		$pdf->Cell($width[$i]/100*$pdf->PageWidth, 6, $header[$i], 1, 0, 'C',1);
        	} else {
        		$pdf->Cell($width[$i]/100*$pdf->PageWidth, 13, $header[$i], 1, 0, 'C',1);
        	}

        }
        $pdf->Ln();
        $pdf->SetTextColorArray(sidlib::rgbColor(TEXT_COLOR));
        //$pdf->SetLineStyle($linestyle);
        $pdf->SetFont('', '',8);
        $typerumah = $this->report_model->get_Sar_Typerumah();
        foreach($typerumah as $value) {
	        $i++;
	        $pdf->Cell($width[0]/100 * $pdf->PageWidth, $h, $value->noid, 'LR', 0, 'R');
	        $pdf->Cell($width[1]/100 * $pdf->PageWidth, $h, $value->typerumah, 'R', 0, 'L');
	        $pdf->Cell($width[2]/100 * $pdf->PageWidth, $h, $value->keterangan, 'R', 0, 'L');
	        $pdf->Cell($width[3]/100 * $pdf->PageWidth, $h, $this->sidlib->my_format($value->hargajual), 'R', 0, 'R');
	        $pdf->Cell($width[4]/100 * $pdf->PageWidth, $h, $this->sidlib->my_format($value->bookingfee), 'R', 1, 'R');
    	}
    	$pdf->Cell(0, 0, '', 'T');

		//Generate PDF file
		ob_clean();
		$pdf->Output('Sar_typerumah.pdf', 'I');
		ob_end_clean();
    }
}
?>