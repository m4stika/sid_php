<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Gl_fixedasset extends MY_Controller {

	public function __construct()
	{
		parent::__construct();		
		$this->load->library('Pdf','pdf');
		$this->load->library('Sidlib','sidlib');
		$this->load->model('Accounting_model','report_model');
	}

	public function index() {
		$pdf = new Pdf('L', 'mm', 'A4', false, 'ISO-8859-1', false);

		//PDF initialize
		$pdf->initializeReport();
		$pdf->SetMargins(5, PDF_MARGIN_TOP, 5, true);  
		$pdf->resetPageWidth();

		// Generate Report Title
		$pdf->SetTitle('SID | Fixed Asset');
		$pdf->AddPage();
		
		// Generate Report Header
		$pdf->reportHeader('Aktiva Tetap ( Fixed Asset )', 'C', 'B', sidlib::rgbColor(TITLE_COLOR), 16, 4, 'B');

		//Generate Table
        $fixedasset = $this->report_model->get_GLfixedasset();

        if (count($fixedasset) > 0) {
	        // Print fixedasset Header
	        // Colors, line width and font
	        $pdf->SetFillColorArray(sidlib::rgbColor(HEADER_COLOR));
		    $pdf->SetTextColorArray(sidlib::rgbColor(HEADER_TEXT_COLOR));
	        $pdf->SetLineStyle(sidlib::lineStyle());

	        $pdf->setCellPaddings(0,0,0,0);
	        $pdf->SetFont('', '',8);
	        $pdf->Ln();
	        $DataItem = array("value"=>array('No', 'Nama','Bl-Th Perolehan', 'Usia', 'Peny. Bl-I', 'Peny. Bl-X',
	        								 'Mulai Susut','Nilai Aktiva', 'Akumulasi','Nilai Buku'),
	        				  "width" =>array(5, 20, 10, 5, 10, 10, 10, 10, 10, 10),
	        				  "align" =>array('C'),
	        				  "style" =>array('B'),
	        				  "border" =>array(1)
	        				);
	        $pdf->CreateGroupText($DataItem['value'], $ln=0, $DataItem['width'], '', '', $DataItem['style'], $DataItem['align'], $DataItem['border'], $Ln_LastCol=1, $fill=1);

	        $pdf->SetTextColorArray(sidlib::rgbColor(TEXT_COLOR));
	        $pdf->setCellPaddings(2,0,2,0);
	        $i = 0;
	        $total = array('totalharga'=>0, 'akumpenyusutan'=>0,'nilaibuku'=>0);

	        //Generate Table Detil
	        foreach($fixedasset as $value) { 
	        	$i++;
				$blthperolehan = date("M - Y", strtotime($value->bulanperolehan.'/01/'.$value->tahunperolehan));
				$blthpenyusutan = date("M - Y", strtotime($value->bulansusut.'/01/'.$value->tahunsusut));

	    		($value->nilaibuku <= 0) ? $pdf->SetTextColor(239,72,54) : $pdf->SetTextColor(47,53,59);

	    		$DataItem = array("value"=>array($i, $value->namaaktiva,$blthperolehan, $value->usiaekonomis.' bln', $this->sidlib->my_format($value->penyusutanbulan_I), $this->sidlib->my_format($value->penyusutanbulan_II), $blthpenyusutan, $this->sidlib->my_format($value->totalharga), $this->sidlib->my_format($value->akumpenyusutan), $this->sidlib->my_format($value->nilaibuku)),
	        				  "width" =>array(5, 20, 10, 5, 10, 10, 10, 10, 10, 10),
	        				  "align" =>array('C','L','C','R','R','R','C','R','R','R'),
	        				  "style" =>array(''),
	        				  "border" =>array('LR','R')
	        				);
	    		$pdf->CreateGroupText($DataItem['value'], $ln=0, $DataItem['width'], $h=6, 8, $DataItem['style'], $DataItem['align'], $DataItem['border'], 1, $fill=0);

	            $total['totalharga'] += $value->totalharga;
	            $total['akumpenyusutan'] += $value->akumpenyusutan;
	            $total['nilaibuku'] += $value->nilaibuku;
	        }
	        
	        //Draw Footer
	        $pdf->SetFillColorArray(sidlib::rgbColor(FOOTER_COLOR));
	        $DataItem = array("value" => array('Total',$this->sidlib->my_format($total['totalharga']), $this->sidlib->my_format($total['akumpenyusutan']), $this->sidlib->my_format($total['nilaibuku'])),
	        				  "width" =>array(70, 10, 10, 10),
	        				  "align" =>array('R'),
	        				  "style" =>array('B'),
	        				  "border" =>array(1)
	        				);
	        $pdf->CreateGroupText($DataItem['value'], $ln=0, $DataItem['width'], 8, 10, $DataItem['style'], $DataItem['align'], $DataItem['border'], 1, $fill=1);
	    }
	        
		//Generate PDF file
		ob_clean();
		$pdf->Output('Gl_fixedasset.pdf', 'I');
		ob_end_clean();
    }
}
?>