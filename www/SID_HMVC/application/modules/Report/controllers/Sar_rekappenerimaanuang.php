<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Sar_rekappenerimaanuang extends MY_Controller {

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
		$pdf->SetMargins(15, PDF_MARGIN_TOP, 15, true);  
    $pdf->resetPageWidth();
		
		// Generate Report Title
		$pdf->SetTitle('SID | Rekapitulasi Penerimaan Uang');
		$pdf->AddPage();
		
		// Generate Report Header
    $pdf->reportHeader('Rekapitulasi Penerimaan Uang', 'C', 'B', sidlib::rgbColor(TITLE_COLOR), 16, 4, 'B','C');
    $pdf->reportHeader(date_format(date_create($this->input->post('periode')), "d-M-Y").' s/d '.date_format(date_create($this->input->post('periode1')), "d-M-Y"), 'C', 0, sidlib::rgbColor(TEXT_COLOR), 10, 0, 'B','A');

    //Generate Table
    $groupby = $this->input->post('groupby'); //0=jenispenerimaan, 1=tglbayar
    $order = $groupby == 0 ? 'jenispenerimaan, tglbayar' : 'tglbayar, jenispenerimaan';
    $penerimaanUang = $this->report_model->get_RekapPenerimaanUang($order);
    if (count($penerimaanUang) > 0) {
        $pdf->setCellPaddings(2,1,2,0);
        $pdf->SetFillColorArray(sidlib::rgbColor(HEADER_COLOR));
        $pdf->SetTextColorArray(sidlib::rgbColor(HEADER_TEXT_COLOR));
        $pdf->SetLineStyle(sidlib::linestyle());

        $fill = 1;
        $h = 10;
        $no = 0;
        $flagGroupby = '';

        //Print Header
        $DataItem = array("value"=>array(($groupby == 0 ? 'Jenis Penerimaan' : 'Tanggal'),($groupby == 1 ? 'Jenis Penerimaan' : 'Tanggal'),'Qty', 'Total Bayar'),
                          "width" =>array(50,20,10,20),
                          "align" =>array('L','C','C','R'),
                          "style" =>array('B'),
                          "border" =>array(1)
                        );
        $pdf->Ln();
        $pdf->CreateGroupText($DataItem['value'], $ln=0, $DataItem['width'], $h, 10, $DataItem['style'], $DataItem['align'], $DataItem['border'], 1, $fill);

        $h = 6;
        $fill = 0;
        $pdf->SetTextColorArray(sidlib::rgbColor(TEXT_COLOR));
	      foreach ($penerimaanUang as $value) {
            $groupbyname = $groupby == 0 ? $value->jenispenerimaan : $value->tglbayar;
            $datacol1 = $groupby == 0 ? $value->namapenerimaan : date_format(date_create($value->tglbayar), "d-M-Y");
            $datacol2 = $groupby == 1 ? $value->namapenerimaan : date_format(date_create($value->tglbayar), "d-M-Y");

            //Group Total
            if ($no != 0 &&  $flagGroupby != $groupbyname) {
                $DataItem = array("value"=>array('','Total', $this->sidlib->my_format($totalbayar)),
                          "width" =>array(50,30,20),
                          "align" =>array('L','R'),
                          "style" =>array('B'),
                          "border" =>array('RBL','RBL')
                        );
                $pdf->CreateGroupText($DataItem['value'], $ln=0, $DataItem['width'], $h, 8, $DataItem['style'], $DataItem['align'], $DataItem['border'], 1, $fill);
                $no=0;
                $totalbayar = 0;
                if ($pdf->PageHeight < $pdf->GetY()+10) $pdf->AddPage();
            }

            $DataItem = array("value"=>array(($flagGroupby == $groupbyname ? "" : $datacol1), $datacol2 ,$value->qty,$this->sidlib->my_format($value->jumlahbayar)),
                          "width" =>array(50,20,10,20),
                          "align" =>array('L','R'),
                          "style" =>array(''),
                          "border" =>array('LR','RBL')
                        );
            if ($pdf->PageHeight < $pdf->GetY()) $pdf->AddPage();
        $pdf->CreateGroupText($DataItem['value'], $ln=0, $DataItem['width'], $h, 8, $DataItem['style'], $DataItem['align'], $DataItem['border'], 1, $fill);

            $flagGroupby = $groupbyname;
            $totalbayar += $value->jumlahbayar;
            $grandtotal += $value->jumlahbayar;
            $no++;
      }
      $DataItem = array("value"=>array('','Total', $this->sidlib->my_format($totalbayar)),
                        "width" =>array(50,30,20),
                        "align" =>array('L','R'),
                        "style" =>array('B'),
                        "border" =>array('RBL','RBL')
                      );
      $pdf->CreateGroupText($DataItem['value'], $ln=0, $DataItem['width'], $h, 8, $DataItem['style'], $DataItem['align'], $DataItem['border'], 1, $fill);

      //Print Grand Total
      $h = 10;
      $pdf->SetTextColorArray(sidlib::rgbColor('navy'));
      $DataItem = array("value"=>array('Grand Total', $this->sidlib->my_format($grandtotal)),
                        "width" =>array(80,20),
                        "align" =>array('R'),
                        "style" =>array('B'),
                        "border" =>array('RBL')
                      );
      $pdf->CreateGroupText($DataItem['value'], $ln=0, $DataItem['width'], $h, 10, $DataItem['style'], $DataItem['align'], $DataItem['border'], 1, $fill);
  	}

		//Generate PDF file
		ob_clean();
		$pdf->Output('Sar_rekappenerimaanuang.pdf', 'I');
		ob_end_clean();
    }
}
?>