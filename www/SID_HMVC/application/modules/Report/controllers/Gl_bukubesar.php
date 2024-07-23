<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
*
*/
class Gl_bukubesar extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Pdf','pdf');
		$this->load->library('Sidlib','sidlib');
		$this->load->model('Accounting_model','report_model');
	}

	public function index() {
		$pdf = new Pdf('P', 'mm', 'A4', false, 'ISO-8859-1', false);`

		//Generate Table
		$ColoredTable = function($header, $width) use ($pdf) {
				$perkiraan = $this->report_model->get_Accountby_id($this->input->post('linkid'));
	      $bukubesar = $this->report_model->get_GLbukubesar($perkiraan->keyvalue);

	        // Colors, line width and bold font
	        $pdf->SetLineStyle(sidlib::lineStyle());
		    $pdf->SetTextColorArray(sidlib::rgbColor(TEXT_COLOR));
	        $pdf->Ln();

	        $groupaccount = '';
	        $keyvalue = '';
	        $total = array("Debit"=>0,"Credit"=>0,"Detil"=>0);

	        $generateDetailHeader = function($value) use ($pdf, $width) {
	        	$pdf->SetFont('', 'I',10);
            	//$pdf->Cell($pdf->PageWidth, 0, $value->accountno.' ('.$value->description.')', 'LTR', 1, 'L',false,'',0,false,'T','B');
            	$pdf->Cell(($width[0]+$width[1]+$width[2]) / 100 * $pdf->PageWidth, 12, $value->accountno.' ('.$value->description.')', 'TL', 0, 'L',false,'',0,false);
            	//$pdf->Cell(($width[0]+$width[1]+$width[2]) / 100 * $pdf->PageWidth, 12, '', 'TLB');
            	$pdf->Cell(($width[3]+$width[4]) / 100 * $pdf->PageWidth, 12, 'Saldo Awal', 'TB',0,'R');
            	$pdf->SetFont('', 'B',10);
            	$pdf->Cell($width[5]/100 * $pdf->PageWidth, 12, $this->sidlib->my_format($value->saldoawal), 'TRB', 1, 'R');
	        };

	        $generateDetailTotal = function($value, $total) use ($pdf, $width) {
	        	$pdf->SetFont('', 'I',8);
        		$pdf->Cell(($width[0]+$width[1]+$width[2]) / 100 * $pdf->PageWidth, 10, 'Sub Total', 'BL',0, 'R');
        		$pdf->SetFont('', 'B',8);
            	$pdf->Cell($width[3]/100 * $pdf->PageWidth, 10, $this->sidlib->my_format($total['Debit']), 'TB', 0, 'R');
            	$pdf->Cell($width[4]/100 * $pdf->PageWidth, 10, $this->sidlib->my_format($total['Credit']), 'TB', 0, 'R');
            	$pdf->Cell($width[5]/100 * $pdf->PageWidth, 10, $this->sidlib->my_format($total['Detil']), 'TBR', 1, 'R');
	        };

	        //Generate Firs Record
	        if (count($bukubesar) > 0) {
	        	//Generate Total and Header
	        	$pdf->reportHeader($bukubesar[0]->parentdescription, 'C', '', sidlib::rgbColor(TEXT_COLOR), 11, 0, 'B');
	        	$generateDetailHeader($bukubesar[0]);

	        	//Reset Variable
	        	$groupaccount = $bukubesar[0]->parentaccountno;
	        	$keyvalue = $bukubesar[0]->keyvalue;
	        	$total = array("Debit"=>0,"Credit"=>0,"Detil"=>$bukubesar[0]->saldoawal);
	        }

	        //Loop bukubesar Header
	        foreach($bukubesar as $value) {
	            if ($groupaccount != $value->parentaccountno) {
	            	//Generate Total and Header
	            	$generateDetailTotal($value, $total);
	            	$pdf->ln();
	            	$pdf->reportHeader($value->parentdescription, 'C', '', sidlib::rgbColor(TEXT_COLOR), 11, 0, 'B');
	            	$generateDetailHeader($value);

	            	//Reset Variable
	            	$keyvalue = $value->keyvalue;
	            	$groupaccount = $value->parentaccountno;
	            	$total = array("Debit"=>0,"Credit"=>0,"Detil"=>$bukubesar[0]->saldoawal);
	            }

	            if ($keyvalue != $value->keyvalue) {
            		//Generate Sub Total
            		$generateDetailTotal($value, $total);
	            	$generateDetailHeader($value);
	            	$total = array("Debit"=>0,"Credit"=>0,"Detil"=>$value->saldoawal);
	            }

	            $total['Debit'] += $value->debit;
	            $total['Credit'] += $value->credit;
	            $total['Detil'] += ($value->debitacc == 1 ? $value->debit - $value->credit : $value->credit - $value->debit);

	        	//Generate Table Detil
	        	$pdf->SetFont('', '',8);
	            $pdf->Cell($width[0]/100 * $pdf->PageWidth, 6, date_format(date_create($value->journaldate), "d-M-Y"), 'L', 0, 'L');
	            $pdf->Cell($width[1]/100 * $pdf->PageWidth, 6, $value->journalno, '', 0, 'L');
	            $pdf->Cell($width[2]/100 * $pdf->PageWidth, 6, $value->remark, '', 0, 'L');
	            $pdf->Cell($width[3]/100 * $pdf->PageWidth, 6, $this->sidlib->my_format($value->debit), '', 0, 'R');
	            $pdf->Cell($width[4]/100 * $pdf->PageWidth, 6, $this->sidlib->my_format($value->credit), '', 0, 'R');
	            $pdf->Cell($width[5]/100 * $pdf->PageWidth, 6, $this->sidlib->my_format($total['Detil']), 'R', 0, 'R');
	            $pdf->Ln();

		        $keyvalue = $value->keyvalue;
	            $groupaccount = $value->parentaccountno;
	        }
	        $generateDetailTotal($value, $total);
	    };

		//PDF initialize
		$pdf->initializeReport();

		// Generate Report Title
		$pdf->SetMargins(5, PDF_MARGIN_TOP, 5, true);
		$pdf->setCellHeightRatio(1.8);
		$pdf->resetPageWidth();
		$pdf->SetTitle('SID | Buku Besar');
		$pdf->AddPage();

		// Generate Report Header
		$pdf->reportHeader('Buku Besar', 'C', 'B', sidlib::rgbColor(TITLE_COLOR), 20, 4, 'B');
		$pdf->reportHeader($this->input->post('bulanname').' - '.$this->input->post('tahun'), 'C', 0, sidlib::rgbColor(TEXT_COLOR), 10, 0);

		// column titles & width
		$header = array('Tanggal', 'Journal No.', 'Keterangan', 'Debet', 'Kredit', 'Ballance Due');
		//$fieldname = array('journaldate', 'journalno', 'remark', 'debit', 'credit', 'saldoakhir');
		$width = array(10, 10, 35, 15, 15, 15);

		// print colored table
		$ColoredTable($header, $width);

		//Generate PDF file
		ob_clean();
		$pdf->Output('Gl_bukubesar.pdf', 'I');
		ob_end_clean();
    }
}
?>