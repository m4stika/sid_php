<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/

class Sar_kwitansiformated extends MY_Controller {

	public function __construct()
	{
		parent::__construct();		
		$this->load->library('Pdf','pdf');
		$this->load->library('Sidlib','sidlib');
		$this->load->model('Pemasaran_model','report_model');
	}

	public function index() {
		//(595.276, 420.945) // = (8.27, 5.845) in // = (210, 148.5) mm
		//$pageformat = array(210, 148.5); // = (8.27, 5.845) in // = (210, 148.5) mm
		$pdf = new Pdf('L', 'mm', 'A5');//, false, 'ISO-8859-1', false);
		//PDF initialize
		$pdf->initializeReport();	
		$pdf->setPrintHeader(false); 
		
		$pdf->SetMargins(10, PDF_MARGIN_TOP, 10, true);  
		$pdf->SetFooterMargin(2);  
		$pdf->SetHeaderMargin(2);
		$pdf->resetPageWidth();
		
		// Generate Report Title
		$pdf->SetTitle('SID | Kwitansi');
		$pdf->AddPage();
		
		// Generate Report Header
		$pdf->setCellPaddings(0,0,0,0);
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->SetXY($x+40, $pdf->GetY()-25);
		$pdf->SetFont('helveticaB','',20);
		$pdf->Cell(100,20,'',0,0,'L',false,'',4);
		$pdf->SetXY($x,$y-8);
        $pdf->SetFontSize(8);
		$pdf->Cell(28,10,'',0,0,'C',false);
		$pdf->Ln();
		$pdf->SetFont('','',9);
        
//Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='M')
//MultiCell($w, $h, $txt, $border=0, $align='J', $fill=false, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0, $valign='T', $fitcell=false)
        
        $kwitansi = $this->report_model->get_Printkwitansi();
        
        $pdf->setCellPaddings(2,0,2,0);
        $pdf->SetLineStyle(sidlib::lineStyle('grey','2,2'));
        $pdf->SetTextColorArray(sidlib::rgbColor('black'));
	    $h = 4.5;
	    $fontsize = 8;
	    $fill = 0;
        $DataItem = array(
        					"width" =>array(20,20,15,20,20),
	        				"align" =>array('L'),
	        				"style" =>array('','B','','','B'),
	        				"border" =>array('')
	        				);
        $printText = function($data, $value, $he=0, $fz=0) use ($pdf, $h, $fontsize) {
        	if ($he==0) $he = $h;
        	if ($fz==0) $fz = $fontsize;
        	$pdf->CreateGroupText($value, $ln=0, $data['width'], $he, $fz, $data['style'], $data['align'], $data['border']);
        };

        $printText($DataItem,array('', $kwitansi->nokwitansi,'','', date_format(date_create($kwitansi->tglbayar), "d-M-Y")));
        $pdf->Cell(0,0,'',0,1,'L');
        $DataItem['width'] = array(20,75);
        $printText($DataItem,array('', $kwitansi->namapemesan));
        $printText($DataItem,array('', $kwitansi->alamatpemesan));
        $printText($DataItem,array('', ''));

        $pdf->Cell((20/100)*$pdf->PageWidth,10,'',0,0);
		$pdf->MultiCell((70/100)*$pdf->PageWidth, 11, '// '.$this->sidlib->terbilang($kwitansi->totalbayar).' Rupiah //',0,'L', $fill=false, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=11, $valign='M', $fitcell=false);
		$printText($DataItem,array('', $kwitansi->keterangan));
		$printText($DataItem,array('', ''));
		$printText($DataItem,array('', ''));
		$printText($DataItem,array('', $kwitansi->bank));
		$printText($DataItem,array('', ''));

		$pdf->setEqualColumns(2);
		$pdf->Cell((20/100)*$pdf->PageWidth,10,'',0,0);
		$pdf->SetFont('','I',$fontsize);
		$pdf->Text($pdf->GetX()+2, $pdf->GetY()+4, 'Rp. '.$this->sidlib->my_format($kwitansi->totalbayar).',-');
		$pdf->SetFont('','',$fontsize);

		$pdf->selectColumn(1);
		$pdf->Cell(50,$h,'',0,0,'C');
		$pdf->Cell(30,$h,'',0,0,'C');
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Cell(50,$h,'',0,0,'C');
		$pdf->Cell(30,$h,'( '.$kwitansi->namapemesan.' )','',0,'C');
		$pdf->resetColumns();
        
		//Generate PDF file
		ob_clean();
		$pdf->Output('Sar_kwitansiformated.pdf', 'I');
		ob_end_clean();
    }
}
?>