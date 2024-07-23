<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Kb_rekapitulasikodeakun extends MY_Controller {

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
	        $header = array('No. Bukti', 'Tanggal','Uraian', 'Penerimaan', 'Pengeluaran');
	        $width = array(20, 20, 40, 20);

	        // Header
	        $pdf->setCellPaddings(0,0,0,0);
	        $pdf->Ln();

	        $pdf->SetFont('', '',8);
	        //Loop Report Data Header
			if ($this->input->post('linkid') == 'undefined') {
				$recordHeader = $this->report_model->get_AccountHeader();
				$haslinkid = 0;
			} else {
				$account = $this->report_model->get_Accountby_id($this->input->post('linkid'));
				$parentkey = ($account->classacc == 0) ? $account->keyvalue :  $account->parentkey;
				$recordHeader = $this->report_model->get_Accountby_keyvalue($parentkey);
				$haslinkid = ($account->classacc == 0) ? 0 :  1;
			}
			
			$totHeader = count($recordHeader);
			$counter = 0;
	        $pdf->setCellPaddings(2,1,2,0);
	        foreach($recordHeader as $valueH) { 
	        	// Color and font restoration
		        $pdf->SetLineStyle(sidlib::lineStyle());
		        $pdf->SetTextColorArray(sidlib::rgbColor(TEXT_COLOR));

	        	$counter++;
				$saldoperGroupheader = 0;
				$pdf->SetFont('','B',10);
				$pdf->Cell(0, 6, $valueH->description, '', 1, 'C');

				$dataHeader = $this->report_model->get_RekapKasbankHeader($valueH->keyvalue, $haslinkid);
				$newGroup = '';
				$subtotalpertype = 0;
				$subtotalgroup = array('penambahan'=>0, 'pengurangan'=>0);
				$banktype = -1;
				$saldoawal = 0;
				$h = 5;
				$fill = 0;
				foreach ($dataHeader as $groupH) {
					$pdf->SetFont('', '',8);
					$banktype = $subtotalpertype == 0 ? $groupH->kasbanktype : -1;
					$banktypedesc = ($groupH->kasbanktype == 0 || $groupH->kasbanktype == 2) ? 'PENERIMAAN' : 'PENGELUARAN';
					$banktypedesclower = ($groupH->kasbanktype == 0 || $groupH->kasbanktype == 2) ? 'Penerimaan' : 'Pengeluaran';
					$subtotal = 0;

					$dataDetil = $this->report_model->get_RekapPerkodeakunDetil($groupH->rekid, $groupH->kasbanktype);
					$hasrecord = 0;
					foreach ($dataDetil as $value) {
						if ($hasrecord == 0) {
							if ($banktype == $groupH->kasbanktype) {
								$saldoawal = $this->report_model->get_SaldoawalKB($groupH->rekid);
								$pdf->SetFont('','',10);
								$pdf->Cell($pdf->PageWidth, $h, '('.$groupH->accountno.') '.$groupH->description, 'LTR', 1, 'C');
								$pdf->SetFont('', '',8);
								$pdf->Cell(($width[0]+$width[1]+$width[2])/100 * $pdf->PageWidth, $h, 'Saldo Awal', 'LB', 0, 'R');
								$pdf->SetFont('', 'B',8);
								$pdf->Cell(($width[3])/100 * $pdf->PageWidth, $h, $this->sidlib->my_format($saldoawal), 'RB', 1, 'R');
							}
							$pdf->SetFont('', 'B',8);
							$pdf->Cell($pdf->PageWidth, $h, $banktypedesc, 'LR', 1, 'L');
						}
						$pdf->SetFont('', '',8);
						$subtotal += $value->amount;
						$pdf->Cell($width[0]/100 * $pdf->PageWidth, $h, $value->accountno, 'L', 0, 'R',$fill);
						$pdf->Cell(($width[1]+$width[2])/100 * $pdf->PageWidth, $h, $value->description, '', 0, 'L',$fill);
						$pdf->Cell($width[3]/100 * $pdf->PageWidth, $h, $this->sidlib->my_format($value->amount), 'R', 1, 'R',$fill);
			    		$hasrecord = 1;
					}

					$subtotalpertype += $subtotal;
					if ($groupH->kasbanktype == 0 || $groupH->kasbanktype == 2) {
						$subtotalgroup['penambahan'] +=  $subtotal;
					} else {
						$subtotalgroup['pengurangan'] += $subtotal;
					}

					if ($hasrecord == 1) {
						$pdf->Cell(($width[0]+$width[1]+$width[2])/100 * $pdf->PageWidth, $h, 'Total '.$banktypedesclower, 'TLB', 0, 'R');
						$pdf->SetFont('', 'B',8);
						$pdf->Cell(($width[3])/100 * $pdf->PageWidth, $h, $this->sidlib->my_format($subtotal), 'TRB', 1, 'R');
					}
					if ($subtotalpertype != 0 && $banktype != $groupH->kasbanktype) {
						$saldoperGroupheader += $saldoawal + $subtotalgroup['penambahan'] - $subtotalgroup['pengurangan'];
						$pdf->Cell(($width[0]+$width[1]+$width[2])/100 * $pdf->PageWidth, $h, 'Saldo Akhir '.$groupH->description, 'LB', 0, 'R');
						$pdf->SetFont('', 'B',8);
						$pdf->Cell(($width[3])/100 * $pdf->PageWidth, $h, $this->sidlib->my_format($saldoawal + $subtotalgroup['penambahan'] - $subtotalgroup['pengurangan']), 'RB', 1, 'R');
						$subtotalpertype = 0;
						$pdf->Ln();
					}
					$banktype = $groupH->kasbanktype;
				}
				$pdf->SetY($pdf->GetY());
				$pdf->SetFont('','B',14);
				$pdf->SetTextColorArray(sidlib::rgbColor(TITLE_COLOR));
		    	$pdf->Cell(($width[0]+$width[1]+$width[2])/100 * $pdf->PageWidth, 0,'');
		    	$pdf->SetLineStyle(sidlib::lineStyle());
		    	$x = $pdf->GetX();
		    	$pdf->Cell($width[3]/100 * $pdf->PageWidth, 0, $this->sidlib->my_format($saldoperGroupheader), '', $ln=1, 'R');
		    	$y = $pdf->GetY();
		    	$pdf->CreateDoubleLine($x, $y, $width[3]/100 * $pdf->PageWidth);

		    	if ($totHeader != $counter) {
		    		$pdf->AddPage();
		    	}
        	}
	    };


		//PDF initialize
		$pdf->initializeReport();
		
		// Generate Report Title
		$pdf->SetMargins(5, PDF_MARGIN_TOP, 5, true);  
		$pdf->resetPageWidth();
		$pdf->SetTitle('SID | Rekapitulasi Kas-Bank');
		$pdf->AddPage();
		
		// Generate Report Header
		$pdf->setCellPaddings(0,1,0,1);
		$pdf->reportHeader('Rekapitulasi per Kode Akun', 'C', 'B', sidlib::rgbColor(TITLE_COLOR), 18, 4, 'B','C');
		$pdf->reportHeader(date_format($periode, "d-M-Y").' s/d '.date_format($periode1, "d-M-Y"), 'C', 0, sidlib::rgbColor(TEXT_COLOR), 10, 0, 'B','A');

		// print colored table
		$ColoredTable();

		//Generate PDF file
		ob_clean();
		$pdf->Output('Kb_rekapitulasikodeakun.pdf', 'I');
		ob_end_clean();
    }
}
?>