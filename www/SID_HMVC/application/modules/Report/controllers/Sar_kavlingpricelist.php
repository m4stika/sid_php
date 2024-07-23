<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
require_once(APPPATH.'config/report_constants'.EXT);
class Sar_kavlingpricelist extends MY_Controller {

	public function __construct()
	{
		parent::__construct();		
		$this->load->library('Pdf','pdf');
		$this->load->library('Sidlib','sidlib');
		$this->load->model('Pemasaran_model','report_model');
	}

	public function index() {
		$pdf = new Pdf('L', 'mm', 'A4', false, 'ISO-8859-1', false);

		//PDF initialize
		$pdf->initializeReport();	
		$pdf->SetMargins(5, PDF_MARGIN_TOP, 5, true);  
		$pdf->resetPageWidth();
		
		// Generate Report Title
		$pdf->SetTitle('SID | Kavling Price List');
		$pdf->AddPage();
		
		// Generate Report Header
		$pdf->setCellPaddings(0,1,0,1);
		$pdf->reportHeader('Kavling Price List', 'C', 'B', sidlib::rgbColor(TITLE_COLOR), 16, 4, 'B');
		

		//Generate Table
        // column titles & width
        $header = array('ID', 'Blok','No. Kavling', 'Status', 'LB (m2)', 'LT (m2)','KLT (m2)','Sudut', 'Hadap Jalan','Fasum');
        $width = array(5, 10, 10, 15, 10, 10, 10, 10, 10, 10);

        
//Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='M')
//MultiCell($w, $h, $txt, $border=0, $align='J', $fill=false, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0, $valign='T', $fitcell=false)
        
        $kavlingpricelist = $this->report_model->get_Sar_Kavlingpricelist();
        $pdf->SetLineStyle(sidlib::lineStyle());
	    $h = 5;
	    $fill = 0;
        $DataItem = array(
        					"width" =>array(3, 8, 8, 9, 9, 9, 9, 9, 9, 9, 9, 9),
	        				"align" =>array('C'),
	        				"style" =>array(''),
	        				"border" =>array('LR','R')
	        				);

        $pdf->SetFillColorArray(sidlib::rgbColor(HEADER_COLOR));
        $printHeader = function($DataArray) use ($pdf) {
	        $pdf->SetFont('', 'B',8);
	        $pdf->setCellPaddings(2,1,2,0);
		    
	        $num_headers = count($DataArray['width']);
	        for($i = 0; $i < $num_headers; ++$i) {
	        	$pdf->Cell(($DataArray['width'][$i]/100)*$pdf->PageWidth, 10, $DataArray['value'][$i], 1, 0, 'C',1);
	        }
	        $pdf->Ln();
	    };

	    //Print Data	
        $pagestart = 1;		  
        foreach($kavlingpricelist as $value) {
	        
	        if ($pagestart==1) {//Print Header
	        	$pdf->SetTextColorArray(sidlib::rgbColor(HEADER_TEXT_COLOR));
	        	$DataItem['value']=array('ID', 'Status', 'Blok/Kavling','Hrg Dasar', 'Diskon','Hrg KLT','Hrg Sudut', 'Hrg Hadap Jln','Hrg Fasum','Total Harga','Booking Fee','Uang Muka');
	        	$printHeader($DataItem);

	        }

	        //Print Detil
	        $pdf->SetFont('', '',8);	
        	$pdf->SetTextColorArray(sidlib::rgbColor(TEXT_COLOR));
        	$DataItem['align'] = array('C','L','L','R');
        	$DataItem['style'] = array('','','','','','','','','','B','','');
	        $DataItem['value']=array($value->noid, STATUS_BOOKING[$value->statusbooking], $value->blok.' - '.$value->nokavling,  $this->sidlib->my_format($value->hargajual), $this->sidlib->my_format($value->diskon), $this->sidlib->my_format($value->hargakltm2), $this->sidlib->my_format($value->hargasudut), $this->sidlib->my_format($value->hargahadapjalan), $this->sidlib->my_format($value->hargafasum), $this->sidlib->my_format($value->totalharga), $this->sidlib->my_format($value->bookingfee), $this->sidlib->my_format($value->uangmuka));
	        $DataItem['border'] = $pagestart==1 ? array('TRL','TR') : array('RL','R');
	        $pdf->CreateGroupText($DataItem['value'], $ln=0, $DataItem['width'], $h=6, 8, $DataItem['style'], $DataItem['align'], $DataItem['border'], 1, $fill=0);
	        $pagestart = 0;

	        //ke halaman baru jika panjang mencukupi
	        if ($pdf->PageHeight < $pdf->GetY()) {
	        	$pdf->Cell(0, 0, '', 'T',1);
	        	$pagestart = 1;
	        	$pdf->AddPage();
	        }
    	}
    	//print footer
    	$pdf->Cell(0, 0, '', 'T');
        
		//Generate PDF file
		ob_clean();
		$pdf->Output('Sar_kavlingpricelist.pdf', 'I');
		ob_end_clean();
    }
}
?>