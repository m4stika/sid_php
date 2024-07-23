<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Gl_neracalajur extends MY_Controller {

	public function __construct()
	{
		parent::__construct();		
		$this->load->library('Pdf','pdf');
		$this->load->library('Sidlib','sidlib');
		$this->load->model('Accounting_model','report_model');
	}

	public function index() {
		$pdf = new Pdf('L', 'mm', 'A4', false, 'ISO-8859-1', false);

		//Generate Table
		$ColoredTable = function() use ($pdf) {
	        $neracalajur = $this->report_model->get_GLNeracaLajur();

	        // column titles & width
	        $headerspan = array('Neraca Saldo', 'Penyesuaian', 'Laba(Rugi)', 'Neraca');
	        $widthspan = array(16, 16, 16, 16);
			$header = array('Account #', 'Description', 'Debit', 'Credit', 'Debit', 'Credit', 'Debit', 'Credit', 'Debit', 'Credit');
			$width = array(10, 26, 8, 8, 8, 8, 8, 8, 8, 8);

	        // Colors, line width and bold font
	        $pdf->SetFillColorArray(sidlib::rgbColor(HEADER_COLOR));
		    $pdf->SetTextColorArray(sidlib::rgbColor(HEADER_TEXT_COLOR));
	        $pdf->SetLineStyle(sidlib::lineStyle());
	        $pdf->SetFont('', 'B',10);


	        // Header
	        $pdf->setCellPaddings(0,0,0,0);
	        $pdf->Cell($width[0]/100*$pdf->PageWidth, 16, $header[0], 1, 0, 'C', 1);
	        $pdf->Cell($width[1]/100*$pdf->PageWidth, 16, $header[1], 1, 0, 'C', 1);
	        $x = $pdf->GetX();
	        $num_headerspan = count($headerspan);
	        for($i = 0; $i < $num_headerspan; ++$i) {
	            $pdf->Cell($widthspan[$i]/100*$pdf->PageWidth, 8, $headerspan[$i], 1, 0, 'C', 1);
	        }
	        $pdf->Ln();
	        $y = $pdf->GetY();
	        $pdf->SetXY($x, $y);
	        $num_headers = count($header);
	        for($i = 2; $i < $num_headers; ++$i) {
	        	$pdf->Cell($width[$i]/100*$pdf->PageWidth, 8, $header[$i], 'RBL', 0, 'C', 1);
	            
	        }
	        
	        $pdf->Ln();

	        // Color and font restoration
	        $pdf->SetFillColorArray(sidlib::rgbColor('blue-light'));
	        $pdf->SetTextColorArray(sidlib::rgbColor(TEXT_COLOR));

	        $total = array("Debit"=>0,"Credit"=>0,
	        			   "debetadjust"=>0,"kreditadjust"=>0,
	        			   "debetlabarugi"=>0,"kreditlabarugi"=>0,
	        			   "debetneraca"=>0,"kreditneraca"=>0,
	        			);
	        //Loop Neraca Saldo Header
	        $pdf->setCellPaddings(2,0,2,0);
	        foreach($neracalajur as $value) { 
	        	//Generate Table Detil
	        	if ($value->classacc==0) {
	        		$pdf->SetFont('', 'B',9);
	        		$pdf->Cell($pdf->PageWidth, 8, $value->description, 'LR', 0, 'L',1);
	        	} else {
	        		$pdf->SetFont('', '',8);
		            $pdf->Cell($width[0]/100 * $pdf->PageWidth, 6, $value->accountno, 'LR', 0, 'L');
		            $pdf->Cell($width[1]/100 * $pdf->PageWidth, 6, $value->description, 'R', 0, 'L');
		            $pdf->Cell($width[2]/100 * $pdf->PageWidth, 6, $this->sidlib->my_format($value->debit), 'R', 0, 'R');
		            $pdf->Cell($width[3]/100 * $pdf->PageWidth, 6, $this->sidlib->my_format($value->credit), 'R', 0, 'R');
		            $pdf->Cell($width[4]/100 * $pdf->PageWidth, 6, $this->sidlib->my_format($value->debetadjust), 'R', 0, 'R');
		            $pdf->Cell($width[5]/100 * $pdf->PageWidth, 6, $this->sidlib->my_format($value->kreditadjust), 'R', 0, 'R');
		            $pdf->Cell($width[6]/100 * $pdf->PageWidth, 6, $this->sidlib->my_format($value->debetlabarugi), 'R', 0, 'R');
		            $pdf->Cell($width[7]/100 * $pdf->PageWidth, 6, $this->sidlib->my_format($value->kreditlabarugi), 'R', 0, 'R');
		            $pdf->Cell($width[8]/100 * $pdf->PageWidth, 6, $this->sidlib->my_format($value->debetneraca), 'R', 0, 'R');
		            $pdf->Cell($width[9]/100 * $pdf->PageWidth, 6, $this->sidlib->my_format($value->kreditneraca), 'R', 0, 'R');
	        	}
	        	$total['Debit'] += $value->debit;
	            $total['Credit'] += $value->credit;
	            $total['debetadjust'] += $value->debetadjust;
	            $total['kreditadjust'] += $value->kreditadjust;
	            $total['debetlabarugi'] += $value->debetlabarugi;
	            $total['kreditlabarugi'] += $value->kreditlabarugi;
	            $total['debetneraca'] += $value->debetneraca;
	            $total['kreditneraca'] += $value->kreditneraca;
	        	
	            $pdf->Ln();
	        }
	        
	        //Draw Footer
	        $pdf->SetFillColorArray(sidlib::rgbColor(FOOTER_COLOR));
	        $pdf->SetTextColorArray(sidlib::rgbColor(FOOTER_TEXT_COLOR));
	        $pdf->Cell(($width[0]+$width[1]) / 100 * $pdf->PageWidth, 10, 'TOTAL', 1,0,'R',1);
	        $pdf->SetFont('', 'B',10);
	        $pdf->Cell($width[2]/100 * $pdf->PageWidth, 10, $this->sidlib->my_format($total['Debit']), 'TRB', 0, 'R',1);
		    $pdf->Cell($width[3]/100 * $pdf->PageWidth, 10, $this->sidlib->my_format($total['Credit']), 'TRB', 0, 'R',1);
		    $pdf->Cell($width[2]/100 * $pdf->PageWidth, 10, $this->sidlib->my_format($total['debetadjust']), 'TRB', 0, 'R',1);
		    $pdf->Cell($width[3]/100 * $pdf->PageWidth, 10, $this->sidlib->my_format($total['kreditadjust']), 'TRB', 0, 'R',1);
		    $pdf->Cell($width[2]/100 * $pdf->PageWidth, 10, $this->sidlib->my_format($total['debetlabarugi']), 'TRB', 0, 'R',1);
		    $pdf->Cell($width[3]/100 * $pdf->PageWidth, 10, $this->sidlib->my_format($total['kreditlabarugi']), 'TRB', 0, 'R',1);
		    $pdf->Cell($width[2]/100 * $pdf->PageWidth, 10, $this->sidlib->my_format($total['debetneraca']), 'TRB', 0, 'R',1);
		    $pdf->Cell($width[3]/100 * $pdf->PageWidth, 10, $this->sidlib->my_format($total['kreditneraca']), 'TRB', 0, 'R',1);

	    };

		//PDF initialize
		$pdf->initializeReport();
		
		// Generate Report Title
		$pdf->SetMargins(5, PDF_MARGIN_TOP, 5, true);  
		$pdf->setCellHeightRatio(1.8);
		$pdf->resetPageWidth();
		$pdf->SetTitle('SID | Work Sheet');
		$pdf->AddPage();
		
		// Generate Report Header
		$pdf->setCellPaddings(0,1,0,1);
		$pdf->reportHeader('Neraca Lajur (Work Sheet)', 'C', 'B', sidlib::rgbColor(TITLE_COLOR), 16, 4, 'B');
		$pdf->reportHeader($this->input->post('bulanname').' - '.$this->input->post('tahun'), 'C', 0, sidlib::rgbColor(TEXT_COLOR), 10, 0);

		// print colored table
		$ColoredTable();

		//Generate PDF file
		ob_clean();
		$pdf->Output('Gl_neracalajur.pdf', 'I');
		ob_end_clean();
    }
}
?>