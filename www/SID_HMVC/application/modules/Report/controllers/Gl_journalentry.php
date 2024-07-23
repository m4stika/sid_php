<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Gl_journalentry extends MY_Controller {

	public function __construct()
	{
		parent::__construct();		
		$this->load->library('Pdf','pdf');
		$this->load->library('Sidlib','sidlib');
		$this->load->model('Accounting_model','report_model');
	}

	public function index() {
		$pdf = new Pdf('P', 'mm', 'A4', false, 'ISO-8859-1', false);

		//Generate Table
		$ColoredTable = function($header, $width, $data, $fieldname) use ($pdf) {
	        // Colors, line width and bold font
	        $pdf->SetFillColorArray(sidlib::rgbColor(HEADER_COLOR));
		    $pdf->SetTextColorArray(sidlib::rgbColor(HEADER_TEXT_COLOR));
	        $pdf->SetLineStyle(sidlib::lineStyle());
	        $pdf->SetFont('', 'B',10);


	        // Header
	        $num_headers = count($header);

	        //Create Border Header
	        $x = $pdf->GetX();
	        $pdf->Cell(array_sum($width) / 100 * $pdf->PageWidth, 10, '', 1);
	        $pdf->SetX($x);

	        //Header Caption
	        for($i = 0; $i < $num_headers; ++$i) {
	            $pdf->Cell($width[$i]/100 * $pdf->PageWidth, 10, $header[$i], '', 0, 'C', 1);
	        }
	        $pdf->Ln();

	        // Color and font restoration
	        $pdf->SetFillColor(240, 250, 250);
	        $pdf->SetTextColor(0);
//Cell($pdf->PageWidth, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='M')
	        // Data
	        $fill = 0;
	        $pdf->SetFont('', 'B',8);
	        $headerCount = count($data);
	        $loop = 0;
	        //Loop Data Header
	        foreach($data as $row) { 
	            $loop++;
	            //$pdf->setCellPaddings($row->levelacc+1);

	        	//Get first X,Y for set line if any multicell description
	            $x = $pdf->GetX(); $y = $pdf->GetY();
	            $pdf->Cell($width[0]/100 * $pdf->PageWidth, 6, date_format(date_create($row->$fieldname[0]), "d-M-Y"), 'L', 0, 'L', $fill);
	            $pdf->Cell($width[1]/100 * $pdf->PageWidth, 6, $row->$fieldname[1], '', 0, 'L', $fill);
	            $pdf->MultiCell($width[2]/100 * $pdf->PageWidth, 0, $row->$fieldname[2], '', 'L', $fill, 0);
	            $h = $pdf->getLastH();
	            $lasty = $pdf->GetY();
	            $pdf->Cell($width[3]/100 * $pdf->PageWidth, $h, '', '', 0, 'R', $fill);
	            $pdf->Cell($width[4]/100 * $pdf->PageWidth, $h, '', 'R', 0, 'R', $fill);
	            
	            //Create Left Line for multicell
	            $pdf->SetXY($x, $y);
	            $pdf->Cell(1, $h, '', 'L',1);
	           // $pdf->Ln();

	            //Get Data Detil
	            $journaldetil = $this->report_model->get_GLjournalDetil($row->journalid);
	            $debet = 0;
	            $kredit = 0;
	            $pdf->SetFont('', '',8);
	            foreach ($journaldetil as $value) { 
	            	$pdf->Cell($width[0]/100 * $pdf->PageWidth, 6, '','L');
	            	$pdf->Cell($width[1]/100 * $pdf->PageWidth, 6, $value->accountno, '', 0, 'R', $fill);
	            	$pdf->Cell($width[2]/100 * $pdf->PageWidth, 6, $value->description, '', 0, 'L', $fill);
	            	$pdf->Cell($width[3]/100 * $pdf->PageWidth, 6, $this->sidlib->my_format($value->debit), '', 0, 'R', $fill);
	            	$pdf->Cell($width[4]/100 * $pdf->PageWidth, 6, $this->sidlib->my_format($value->credit), 'R', 0, 'R', $fill);
	            	$pdf->Ln();
	            	$debet += $value->debit;
	            	$kredit += $value->credit;
	            }

	            //line for sub total
	            //$pdf->SetLineStyle(array('width' => 0.3, 'cap' => 'butt', 'join' => 'miter', 'dash' => 4, 'color' => array(255, 237, 239)));
	            $pdf->Cell(($width[0]+$width[1]+$width[2]) / 100 * $pdf->PageWidth, 0, '', 'L');
	            $pdf->Cell(($width[3]+$width[4]) / 100 * $pdf->PageWidth, 0, '', 'TR', 1);

	            //sub total
	            //$pdf->SetLineStyle(array('width' => 0.3, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(233, 237, 239)));
	            $pdf->SetFont('', 'B',9);
	            if ($debet != $kredit) {
	            	$pdf->SetTextColorArray(sidlib::rgbColor('red'));
	            } else $pdf->SetTextColorArray(sidlib::rgbColor(TEXT_COLOR));
	            $pdf->Cell(($width[0]+$width[1]+$width[2]) / 100 * $pdf->PageWidth, 0, '', 'L');
	            $pdf->Cell($width[3]/100 * $pdf->PageWidth, 6, $this->sidlib->my_format($debet), '', 0, 'R', $fill, '', 0, false, 'C', 'T');
	            $pdf->Cell($width[4]/100 * $pdf->PageWidth, 6, $this->sidlib->my_format($kredit), 'R', 1, 'R', $fill, '', 0, false, 'C', 'T');
	            $pdf->SetTextColorArray(sidlib::rgbColor(TEXT_COLOR));
	            if ($headerCount != $loop) {
	            	if ($pdf->PageHeight < $pdf->GetY()+10) {
	            		$pdf->Cell(array_sum($width) / 100 * $pdf->PageWidth, 0, '', 'T',1);
	            		$pdf->AddPage();
	            		$pdf->Cell(array_sum($width) / 100 * $pdf->PageWidth, 0, '', 'B',1);
	            	} else 
	            	$pdf->Cell(array_sum($width) / 100 * $pdf->PageWidth, 0, '', 'LTR',1);

	            	//$pdf->Ln();
	            }
	            $pdf->SetFont('', 'B',8);
	            
	            
	            //$fill=!$fill;
	        }
	        $pdf->Cell(array_sum($width) / 100 * $pdf->PageWidth, 0, '', 'T');
	    };

		//PDF initialize
		$pdf->initializeReport();
		
		// Generate Report Title
		$pdf->SetMargins(5, PDF_MARGIN_TOP, 5, true);  
		$pdf->setCellHeightRatio(1.8);
		$pdf->resetPageWidth();
		$pdf->SetTitle('SID | Journal Entry');
		$pdf->AddPage();
		
		// Generate Report Header
		$pdf->reportHeader('Journal Entry', 'C', 'B', sidlib::rgbColor(TITLE_COLOR), 20, 4, 'B');
		$pdf->reportHeader($this->input->post('bulanname').' - '.$this->input->post('tahun'), 'C', 0, sidlib::rgbColor(TEXT_COLOR), 10, 0);
		if ($this->input->post('groupby') >=0) {
			$pdf->CreateTextBox($this->input->post('groupdesc'), 1);
		}
		
		
		//Get Data Record from Database
		$journal = $this->report_model->get_GLjournalHeader();
		
		// column titles & width
		$header = array('Tanggal', 'Journal No.', 'Keterangan', 'Debet', 'Kredit');
		$fieldname = array('journaldate', 'journalno', 'journalremark', 'dueamount', 'dueamount');
		$width = array(15, 15, 40, 15, 15);

		// print colored table
		$ColoredTable($header, $width, $journal, $fieldname);

		//Generate PDF file
		ob_clean();
		$pdf->Output('Gl_journalentry.pdf', 'I');
		ob_end_clean();
    }
}
?>