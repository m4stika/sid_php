<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/

class Sar_kwitansiblank extends MY_Controller {

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
		$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH);  
		
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
		$pdf->Cell(100,20,'PT HARMONI UNGGUL PERKASA',0,0,'L',false,'',4);
		$pdf->SetXY($x,$y-8);
		
		$pdf->SetFillColorArray(sidlib::rgbColor('blue'));
		$pdf->SetTextColorArray(sidlib::rgbColor('white'));
		// set general stretching (scaling) value
       // $pdf->setFontStretching(90);
        // set general spacing value
        $pdf->SetFontSize(8);
        //$pdf->setFontSpacing(-.254);
		$pdf->Cell(0,6,'',0,0,'C',true, '',1);
		$pdf->SetXY($x+($pdf->PageWidth/2)-10,$pdf->GetY()-2);
		$pdf->SetFontSize(18);
		$pdf->Cell(28,10,'KUITANSI',0,0,'C',false, '',4);
		//$pdf->reportHeader('PT HARMONY UNGGUL PERKASA', 'C', 'B', $color['navy'], 16, 4, 'B');
		$pdf->Ln();
		$pdf->SetFont('','',9);
        
//Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='M')
//MultiCell($w, $h, $txt, $border=0, $align='J', $fill=false, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0, $valign='T', $fitcell=false)
        
        $kwitansi = $this->report_model->get_Printkwitansi();
        
        $pdf->setCellPaddings(2,0,2,0);
        $pdf->SetLineStyle(sidlib::linestyle('grey', '2,2')); //dash line style
        $pdf->SetTextColorArray(sidlib::rgbColor('black'));
	    $h = 4.5;
	    $fontsize = 8;
	    $fill = 0;
        $DataItem = array(
        					"width" =>array(20,20,15,20,20),
	        				"align" =>array('L'),
	        				"style" =>array('','B','','','B'),
	        				"border" =>array('','B','','','B')
	        				);
        $printText = function($data, $value, $he=0, $fz=0) use ($pdf, $h, $fontsize) {
        	if ($he==0) $he = $h;
        	if ($fz==0) $fz = $fontsize;
        	$pdf->CreateGroupText($value, $ln=0, $data['width'], $he, $fz, $data['style'], $data['align'], $data['border']);
        };

        $printText($DataItem,array('Nomor', $kwitansi->nokwitansi,'','Tanggal', date_format(date_create($kwitansi->tglbayar), "d-M-Y")));
        $pdf->Cell(0,0,'Telah Terima Uang Dari',0,1,'L');
        $DataItem['width'] = array(20,75);
        $printText($DataItem,array('Nama', $kwitansi->namapemesan));
        $printText($DataItem,array('Alamat', $kwitansi->alamatpemesan));
        $printText($DataItem,array('', ''));

        $pdf->Cell((20/100)*$pdf->PageWidth,10,'Terbilang',0,0);
        $pdf->SetLineStyle(sidlib::linestyle());
        // Start Transformation
		$pdf->StartTransform();
		// skew 30 degrees along the x-axis centered by (125,110) which is the lower left corner of the rectangle
		$pdf->SkewX(30, $pdf->GetX(), $pdf->GetY());
		$pdf->Rect($pdf->GetX()+5, $pdf->GetY()+2, (70/100)*$pdf->PageWidth, 10, 'FD', $border_style=array('all'), array(230));
		//$pdf->Text($pdf->GetX()+7, $pdf->GetY()+7, '// Seratur Ribu Rupiah//');
		// Stop Transformation
		$pdf->StopTransform();
		$pdf->SetXY($pdf->GetX()+5, $pdf->GetY()+2);
		$pdf->SetFont('','I',$fontsize);
		$pdf->MultiCell((70/100)*$pdf->PageWidth, 11, '// '.$this->sidlib->terbilang($kwitansi->totalbayar).' Rupiah //',0,'L', $fill=false, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=11, $valign='M', $fitcell=false);
		$pdf->SetLineStyle(sidlib::linestyle('grey', '2,2')); //dash line style
		$printText($DataItem,array('Untuk Pembayaran', $kwitansi->keterangan));
		$printText($DataItem,array('', ''));
		$printText($DataItem,array('', ''));
		$printText($DataItem,array('Keterangan', $kwitansi->bank));
		$printText($DataItem,array('', ''));

		$pdf->setEqualColumns(2);
		$pdf->Cell((20/100)*$pdf->PageWidth,10,'Terbilang',0,0);
        $pdf->SetLineStyle(sidlib::linestyle()); 
        // Start Transformation
		$pdf->StartTransform();
		// skew 30 degrees along the x-axis centered by (125,110) which is the lower left corner of the rectangle
		$pdf->SkewX(30, $pdf->GetX(), $pdf->GetY()+3);
		$pdf->Rect($pdf->GetX(), $pdf->GetY()+3, (25/100)*$pdf->PageWidth, 6, 'FD', $border_style=array('all'), array(230));
		$pdf->Text($pdf->GetX()+2, $pdf->GetY()+4, 'Rp. '.$this->sidlib->my_format($kwitansi->totalbayar).',-');
		// Stop Transformation
		$pdf->StopTransform();
		$pdf->SetLineStyle(sidlib::linestyle('grey', '2,2')); //dash line style

		$pdf->selectColumn(1);
		$pdf->Cell(50,$h,'',0,0,'C');
		$pdf->Cell(30,$h,'Yang Menerima',0,0,'C');
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Cell(50,$h,'',0,0,'C');
		$pdf->Cell(30,$h,'( '.$kwitansi->namapemesan.' )','B',0,'C');
		$pdf->resetColumns();
		$pdf->Ln();
		$pdf->setCellPaddings(10,0,0,0);
		$h = 4;
		$fontsize = 7;
		$pdf->SetXY($pdf->GetX(), $pdf->GetY()+2);
		//$pdf->SetXY($x, $pdf->GetY()+2);
		$pdf->SetFillColorArray(sidlib::rgbColor('blue'));
		$pdf->SetTextColorArray(sidlib::rgbColor('white'));
		$x = $pdf->GetX();
		$pdf->Cell(0,18,'',0,0,'C',true, '',0);
		$pdf->SetXY($x, $pdf->GetY()+3);
		//$pdf->SetXY($pdf->GetX(), $pdf->GetY()+2);
		$DataItem['width'] = array(50,50);
		$DataItem['align'] = array('L','C');
		$DataItem['style'] = array('B');
		$DataItem['border'] = array('');
        $printText($DataItem,array('Kantor Proyek :', 'HARMONI GROUP'),$h,$fontsize);
        $DataItem['style'] = array('');
        $printText($DataItem,array('Jl. Prof Suharso Tembalang Kota Semarang', 'Kantor Pusat : Jl. Bukit Cinere, Komp. Perum Graha Bukit'),$h,$fontsize);
        $printText($DataItem,array('Telp. (024) 76581122, Fax. (024) 76581122', 'Kav. No.9 Cinere Kota Depok'),$h,$fontsize);
        $pdf->SetTextColorArray(sidlib::rgbColor('black'));
        $h = 3.5;
        $fontsize = 6;
        $pdf->Ln();
        $pdf->Cell(0,$h,'1. Lembar putih untuk konsumen',0,1,'L');
        $pdf->Cell(0,$h,'2. Lembar merah untuk keuangan',0,1,'L');
        $pdf->Cell(0,$h,'3. Lembar biru untuk pemasaran',0,1,'L');

        //print footer
    	//$pdf->Cell(0, 0, '', 'T');
        
		//Generate PDF file
		ob_clean();
		$pdf->Output('Sar_kwitansiblank.pdf', 'I');
		ob_end_clean();
    }
}
?>