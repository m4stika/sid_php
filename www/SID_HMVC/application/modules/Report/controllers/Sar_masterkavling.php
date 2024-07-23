<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/

class Sar_masterkavling extends MY_Controller {

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
		$pdf->SetTitle('SID | Master Kavling');
		$pdf->AddPage();
		
		// Generate Report Header
		$pdf->setCellPaddings(0,1,0,1);
		$pdf->reportHeader('Master Kavling', 'C', 'B', sidlib::rgbColor(TITLE_COLOR), 16, 4, 'B');
		

		//Generate Table
        // column titles & width
        $header = array('ID', 'Blok','No. Kavling', 'Status', 'LB (m2)', 'LT (m2)','KLT (m2)','Sudut', 'Hadap Jalan','Fasum');
        $width = array(5, 10, 10, 15, 10, 10, 10, 10, 10, 10);

        
//Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='M')
//MultiCell($w, $h, $txt, $border=0, $align='J', $fill=false, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0, $valign='T', $fitcell=false)
        
        $masterkavling = $this->report_model->get_Sar_Masterkavling();
        $pdf->SetLineStyle(sidlib::linestyle());
	    $h = 5;
	    $fill = 0;
        $DataItem = array(
        					"width" =>array(5, 10, 10, 15, 10, 10, 10, 10, 10, 10),
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
	        	if ($i > 6) {
	        		if ($i == 7) {
		        		$x = $pdf->GetX();
		        		$pdf->Cell(($DataArray['width'][$i] + $DataArray['width'][$i+1] + $DataArray['width'][$i+2])/100*$pdf->PageWidth, 6, 'Posisi', 1, 1, 'C',1);
		        		$pdf->SetXY($x, $pdf->GetY());
		        	}
	        		$pdf->Cell($DataArray['width'][$i]/100*$pdf->PageWidth, 7, $DataArray['value'][$i], 'RL', 0, 'C',1);
	        	} else {
	        		$pdf->Cell(($DataArray['width'][$i]/100)*$pdf->PageWidth, 13, $DataArray['value'][$i], 1, 0, 'C',1);
	        	}

	        }
	        $pdf->Ln();
	    };
	    
	    //Print Detil	
        $pagestart = 1;		  
        foreach($masterkavling as $value) {
	        if ($pagestart==1) {
	        	$pdf->SetTextColorArray(sidlib::rgbColor(HEADER_TEXT_COLOR));
	        	$DataItem['value']=array('ID', 'Blok','No. Kavling', 'Status', 'LB (m2)', 'LT (m2)','KLT (m2)','Sudut', 'Hadap Jalan','Fasum');
	        	$printHeader($DataItem);

	        }
	        $pdf->SetFont('', '',8);	
        	$pdf->SetTextColorArray(sidlib::rgbColor(TEXT_COLOR));
	        $DataItem['value']=array($value->noid, $value->blok,$value->nokavling, $this->sidlib->StatusBookingName($value->statusbooking), $value->luasbangunan, $value->luastanah, $value->kelebihantanah, $value->sudut==1 ? 'Y':'T', $value->hadapjalan==1 ? 'Y':'T', $value->kelebihantanah==1 ? 'Y':'T');
	        $DataItem['border'] = $pagestart==1 ? array('TRL','TR') : array('RL','R');
	        $pdf->CreateGroupText($DataItem['value'], $ln=0, $DataItem['width'], $h=6, 8, $DataItem['style'], $DataItem['align'], $DataItem['border'], 1, $fill=0);
	        $pagestart = 0;
	        if ($pdf->PageHeight < $pdf->GetY()) {
	        	$pdf->Cell(0, 0, '', 'T',1);
	        	$pagestart = 1;
	        	$pdf->AddPage();
	        }
    	}
    	$pdf->Cell(0, 0, '', 'T');
        
		//Generate PDF file
		ob_clean();
		$pdf->Output('Sar_masterkavling.pdf', 'I');
		ob_end_clean();
    }
}
?>