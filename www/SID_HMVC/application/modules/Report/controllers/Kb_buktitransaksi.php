<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
*
*/
class Kb_buktitransaksi extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Pdf','pdf');
		$this->load->library('Sidlib','sidlib');
		$this->load->model('Kasbank_model','report_model');
	}

	public function index() {
		$pdf = new Pdf('P', 'mm', 'A4', false, 'ISO-8859-1', false);
		//PDF initialize
		$pdf->initializeReport();
		$pdf->SetHeaderData('',0,'','');
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->SetMargins(10, 10, 10);
		$pdf->resetPageWidth();

		$parameter = $this->report_model->get_parameter();
		$dataHeader = $this->report_model->get_KasbankHeader();

		//Generate Table
		$ColoredTable = function() use ($pdf, $color, $dataHeader) {
	        // column titles & width
	        $header = array('No', 'Uraian','Perkiraan', 'Nilai');
	        $width = array(10, 50, 20, 20);
	        $pdf->Ln();

	        //Loop Report Data Header
		    $pdf->setCellPaddings(2,1,2,0);
		    $pdf->SetFont('', '',10);
		    $h = 5;
		    $fill = 0;
		    $buktitransaksi = $this->report_model->get_Buktitransaksi_KB();
		    $pdf->Cell(0, 8,'Terima Dari :', 1, 1, 'L');
		    $pdf->MultiCell((70/100)*$pdf->PageWidth, 15,'Terbilang : // '.$this->sidlib->terbilang($dataHeader->totaltransaksi).' //', 'RBL', 'L', false, 0);
		    $pdf->SetFont('', 'B',10);
		    $pdf->Cell((30/100)*$pdf->PageWidth, 15,'Rp : '.$this->sidlib->my_format($dataHeader->totaltransaksi), 'RB', 1, 'R');

		    $pdf->SetFont('', '',10);
		    $num_headers = count($header);
	        for($i = 0; $i < $num_headers; ++$i) {
	        	$pdf->Cell($width[$i]/100*$pdf->PageWidth, 8, $header[$i], 1, 0, 'C');
	        }
	        $pdf->Ln();

	        $i = 0;
	        foreach($buktitransaksi as $value) {
		        $i++;
		        $pdf->Cell($width[0]/100 * $pdf->PageWidth, $h, $i, 'LR', 0, 'R');
		        $pdf->Cell($width[1]/100 * $pdf->PageWidth, $h, $value->remark, 'R', 0, 'L');
		        $pdf->Cell($width[2]/100 * $pdf->PageWidth, $h, $value->accountno, 'R', 0, 'L');
				$pdf->Cell($width[2]/100 * $pdf->PageWidth, $h, $this->sidlib->my_format($value->amount), 'R', 1, 'R');
        	}
        	$pdf->Cell(0, 0, '', 'T');

	    };

		// Generate Report Title
		$pdf->SetTitle('SID | Bukti Transaksi Kasbank');
		$pdf->AddPage();

		// Generate Report Header

		$judul = ($dataHeader->kasbanktype == 0 | $dataHeader->kasbanktype == 2) ? "BUKTI PENERIMAAN" : "BUKTI PENGELUARAN";

		//Bagi menjadi 3 kolom Header
		$pdf->setEqualColumns(3);

		//Data Column 1
		$pdf->setCellPaddings(0,1,0,1);
		$pdf->MultiCell(0, 0, $parameter->company."\n".$parameter->address."\n".$parameter->city, 0, 'L');

		//Data Column 2
        $pdf->selectColumn(1);
        $pdf->SetFont('', 'B',15);
        $pdf->SetLineStyle(sidlib::lineStyle());
        $pdf->SetTextColorArray(sidlib::rgbColor(TITLE_COLOR));
        $pdf->Cell(0, 0,$judul, 'B', 1, 'C', $fill=false, $link='', $stretch=1, $ignore_min_height=false, $calign='T', $valign='B');
        $pdf->SetFont('', 'B',10);
        $pdf->SetTextColorArray(sidlib::rgbColor(TEXT_COLOR));
        $pdf->Cell(0, 0, $dataHeader->namabank, 0, 1, 'C', $fill=false, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='B');

        //Data Column 3
        $pdf->selectColumn(2);
        $pdf->SetFont('', '',8);
        $pdf->SetX($pdf->GetX()+10);
        $pdf->Cell(0, 0,'No Bukti :', '', 0, 'L');
        $pdf->SetFont('', 'B',8);
        $pdf->Cell(0, 0,$dataHeader->nojurnal, '', 1, 'R');
        $pdf->Ln();
        $pdf->SetX($pdf->GetX()+10);
        $pdf->SetFont('', '',8);
        $pdf->Cell(0, 0,'No Cek :', '', 0, 'L');
        $pdf->SetFont('', 'B',8);
        //$pdf->Cell(0, 0,$dataHeader->nomorcek, '', 0, 'R');
        $pdf->Ln();
        $pdf->resetColumns();
        $pdf->SetY($pdf->GetY()-5);

        //Garis Bawah
        $pdf->Cell(0, 0, '', 'B', 1, 'L');

		// print table
		$ColoredTable();

		// Print Footer Penanda tangan
        $pdf->FooterAssign($parameter, 10);

		//Generate PDF file
		ob_clean();
		$pdf->Output('Kb_buktitransaksi.pdf', 'I');
		ob_end_clean();
    }
}
?>