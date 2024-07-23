<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Kb_bukuharian extends MY_Controller {

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
		$ColoredTable = function() use ($pdf) {
	        // column titles & width
	        $header = array('No. Bukti', 'Tanggal','Uraian', 'Penerimaan', 'Pengeluaran');
	        $width = array(15, 15, 40, 15, 15);

	        $pdf->SetLineStyle(sidlib::lineStyle());
	        $pdf->SetFillColorArray(sidlib::rgbColor(HEADER_COLOR)); //green-sharp

	        // Header
	        $pdf->setCellPaddings(0,0,0,0);
	        
	        //Print Group header
	        $pdf->SetFont('','B',10);
	        $pdf->SetTextColorArray(sidlib::rgbColor(TEXT_COLOR)); //green-sharp
			$pdf->Cell(0, 0, $this->input->post('item'), '', $ln=1, 'C', 0, '', 0, false, 'T', 'B');

			//Print Border Header
			$pdf->SetTextColorArray(sidlib::rgbColor(HEADER_TEXT_COLOR)); //green-sharp
			$x = $pdf->GetX();
			$pdf->Cell($pdf->PageWidth, 8, '', 1, 0, 'C', 1);
	        $num_headers = count($header);
	        $pdf->SetX($x);
	        for($i = 0; $i < $num_headers; ++$i) {
	        	$pdf->Cell($width[$i]/100*$pdf->PageWidth, 8, $header[$i], '', 0, 'C', 1);
	        }
	        $pdf->Ln();

	        // Color and font restoration
	        //$pdf->SetFillColorArray(247, 231, 168);
	        $pdf->SetFillColorArray(sidlib::rgbColor(FOOTER_COLOR));
	        $pdf->SetTextColorArray(sidlib::rgbColor(TEXT_COLOR));

//Cell($pdf->PageWidth, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='M')
//MultiCell($pdf->PageWidth, $h, $txt, $border=0, $align='J', $fill=false, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0, $valign='T', $fitcell=false)
	        //Loop Labarugi Header
	        $bukuharian = $this->report_model->get_lapbukuharianHeader($this->input->post('linkid'));
	        $totalPenerimaan = 0;
        	$totalPengeluaran = 0;
	        $total = array('totalharga'=>0, 'akumpenyusutan'=>0,'nilaibuku'=>0);
	        $pdf->setCellPaddings(2,1,2,0);
	        foreach($bukuharian as $valueH) { 
	        	$totalPenerimaan += $valueH->penerimaan;
        		$totalPengeluaran += $valueH->pengeluaran;

	        	$pdf->SetFont('', 'B',8);	
	        	$fill = 0; //$value->flaggrandtotal == 2;
        		$h = 5;
        		$x = $pdf->GetX(); $y = $pdf->GetY();
		    	$tglentry = date_create($valueH->tglentry);
		    	$pdf->Cell($width[0]/100 * $pdf->PageWidth, $h, $valueH->nokasbank, 'L', 0, 'L',$fill);
		    	$pdf->Cell($width[1]/100 * $pdf->PageWidth, $h, date_format($tglentry, "d-M-Y"), '', 0, 'C',$fill);
		    	$pdf->MultiCell($width[2]/100 * $pdf->PageWidth, 0, $valueH->uraian, '', $align='L', $fill, 0);
		    	$h = $pdf->getLastH();
		    	$pdf->Cell($width[3]/100 * $pdf->PageWidth, $h, $this->sidlib->my_format($valueH->penerimaan), '', 0, 'R',$fill, '', $stretch=0, false, $calign = 'T', $valign = 'T');
	            $pdf->Cell($width[4]/100 * $pdf->PageWidth, $h, $this->sidlib->my_format($valueH->pengeluaran), 'R', 0, 'R',$fill, '', $stretch=0, false, $calign = 'T', $valign = 'T');
	            //Create Left Line for multicell
	            $pdf->SetXY($x, $y);
	            $pdf->Cell(1, $h, '', 'L',1);
	            //$pdf->Ln();
	            $h = 5;

	            $bukuharianDetil = $this->report_model->get_lapbukuharianDetil($valueH->noid);
	            $pdf->SetFont('', 'I',8);
			    foreach ($bukuharianDetil as $value) {
			    	$debet = ($valueH->kasbanktype == 0 || $valueH->kasbanktype == 2) ? $this->sidlib->my_format($value->amount) : '';
			    	$kredit = ($valueH->kasbanktype == 1 || $valueH->kasbanktype == 3) ? $this->sidlib->my_format($value->amount) : '';
			    	$pdf->Cell(($width[0]+$width[1])/100 * $pdf->PageWidth, $h, $value->accountno, 'L', 0, 'R',$fill);
			    	$pdf->Cell($width[2]/100 * $pdf->PageWidth, $h, $value->remark, '', 0, 'L',$fill);
			    	$pdf->Cell($width[3]/100 * $pdf->PageWidth, $h, $debet, '', 0, 'R',$fill);
		            $pdf->Cell($width[4]/100 * $pdf->PageWidth, $h, $kredit, 'R', 1, 'R',$fill);
			    }
			    $pdf->Cell(array_sum($width) / 100 * $pdf->PageWidth, 0, '', 'BRL',1,'',false,'',0,false,'C','C');
	        }
	        $saldoawal = $this->report_model->get_SaldoawalKB($this->input->post('linkid'));
        	$saldoakhir = $saldoawal + $totalPenerimaan - $totalPengeluaran;
	        
	        //Draw Footer
	        $pdf->SetTextColorArray(sidlib::rgbColor('navy'));
	        $pdf->SetFont('', 'IB',10);
	        $pdf->Cell(array_sum(array_intersect_key($width, array_flip([0,1,2]))) / 100 * $pdf->PageWidth, 8, 'JUMLAH MUTASI', 'TL', 0, 'R');
	        $x = $pdf->GetX();
	        $pdf->Cell($width[3]/100 * $pdf->PageWidth, 8, $this->sidlib->my_format($totalPenerimaan), 'T', 0, 'R');
	        $pdf->Cell($width[4]/100 * $pdf->PageWidth, 8, $this->sidlib->my_format($totalPengeluaran), 'TR', 0, 'R');
	        $pdf->Line($x, $pdf->GetY()+8, $pdf->GetX()-1, $pdf->GetY()+8, $dashtyle);
	        $pdf->Ln();
	        $pdf->SetTextColorArray(sidlib::rgbColor(TEXT_COLOR));
	        $pdf->SetLineStyle(sidlib::lineStyle());
	        $pdf->Cell(array_sum(array_intersect_key($width, array_flip([0,1,2]))) / 100 * $pdf->PageWidth, 8, 'SALDO AWAL & SALDO AKHIR', 'BL', 0, 'R');
	        $pdf->Cell($width[3]/100 * $pdf->PageWidth, 8, $this->sidlib->my_format($saldoawal), 'B', 0, 'R');
	        $pdf->Cell($width[4]/100 * $pdf->PageWidth, 8, $this->sidlib->my_format($saldoakhir), 'BR', 0, 'R');

	        //Draw Footer Assign
	        $pdf->Ln();
	        $parameter = $this->report_model->get_parameter();
	        $pdf->FooterAssign($parameter);
	    };


		//PDF initialize
		$pdf->initializeReport();
		
		// Generate Report Title
		$pdf->SetMargins(5, PDF_MARGIN_TOP, 5, true);  
		$pdf->resetPageWidth();
		$pdf->setCellHeightRatio(1.8);
		$pdf->SetTitle('SID | Laporan Buku Harian');
		$pdf->AddPage();
		
		// Generate Report Header
		$pdf->setCellPaddings(0,1,0,1);
		$pdf->reportHeader('Laporan Buku Harian', 'C', 'B', sidlib::rgbColor(TITLE_COLOR), 18, 4, 'B','C');
		$pdf->reportHeader(date_format($periode, "d-M-Y").' s/d '.date_format($periode1, "d-M-Y"), 'C', 0, sidlib::rgbColor(TEXT_COLOR), 10, 0, 'B','A');

		// print colored table
		$ColoredTable();

		//Generate PDF file
		ob_clean();
		$pdf->Output('Kb_bukuharian.pdf', 'I');
		ob_end_clean();
    }
}
?>