<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Sar_daftarkaryawan extends MY_Controller {

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
		
		// Generate Report Title
		$pdf->SetTitle('SID | Daftar Karyawan');
		$pdf->AddPage();
		
		// Generate Report Header
		$pdf->setCellPaddings(0,1,0,1);
		$pdf->reportHeader('Daftar Karyawan', 'C', 'B', sidlib::rgbColor(TITLE_COLOR), 16, 4, 'B');

        // column titles & width
        $header = array('ID', 'Nama','Alamat');
        $width = array(5, 30, 65);

//Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='M')
//MultiCell($w, $h, $txt, $border=0, $align='J', $fill=false, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0, $valign='T', $fitcell=false)
        
        //Loop Report Data Header
	    $pdf->setCellPaddings(2,1,2,0);
	    $pdf->SetFont('', 'B',10);
	    $pdf->SetFillColorArray(sidlib::rgbColor(HEADER_COLOR));
        $pdf->SetTextColorArray(sidlib::rgbColor(HEADER_TEXT_COLOR));
        $pdf->SetLineStyle(sidlib::lineStyle());
	    $h = 5;
	    $fill = 0;
	    $num_headers = count($header);
        for($i = 0; $i < $num_headers; ++$i) {
    		$pdf->Cell($width[$i]/100*$pdf->PageWidth, 10, $header[$i], 1, 0, 'C',1);
        }
        $pdf->Ln();
        $pdf->SetTextColorArray(sidlib::rgbColor(TEXT_COLOR));
        $pdf->SetFont('', '',8);
        $daftarkaryawan = $this->report_model->get_Sar_DaftarKaryawan();
        foreach($daftarkaryawan as $value) {
	        $i++;
	        $pdf->Cell($width[0]/100 * $pdf->PageWidth, $h, $value->noid, 'LR', 0, 'R');
	        $pdf->Cell($width[1]/100 * $pdf->PageWidth, $h, $value->nama, 'R', 0, 'L');
			$pdf->Cell($width[2]/100 * $pdf->PageWidth, $h, $value->alamat, 'R', 1, 'L');
    	}
    	$pdf->Cell(0, 0, '', 'T');
        
		//Generate PDF file
		ob_clean();
		$pdf->Output('Sar_daftarkaryawan.pdf', 'I');
		ob_end_clean();
    }
}
?>