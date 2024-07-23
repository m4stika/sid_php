<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Sar_daftarpenerimaanuang extends MY_Controller {

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
		$pdf->SetMargins(5, PDF_MARGIN_TOP, 5, true);  
    $pdf->resetPageWidth();

		// Generate Report Title
		$pdf->SetTitle('SID | Rincian Penerimaan Uang');
		$pdf->AddPage();
		
		// Generate Report Header
    $pdf->reportHeader('Rincian Penerimaan Uang', 'C', 'B', sidlib::rgbColor(TITLE_COLOR), 16, 4, 'B','C');
    $pdf->reportHeader(date_format(date_create($this->input->post('periode')), "d-M-Y").' s/d '.date_format(date_create($this->input->post('periode1')), "d-M-Y"), 'C', 0, sidlib::rgbColor(TEXT_COLOR), 10, 0, 'B','A');

//Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='M')
//MultiCell($w, $h, $txt, $border=0, $align='J', $fill=false, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0, $valign='T', $fitcell=false)

    //Generate Table
    $groupby = $this->input->post('groupby'); //0=jenispenerimaan, 1=tglbayar
    $order = $groupby == 0 ? 'jenispenerimaan, tglbayar' : 'tglbayar, jenispenerimaan';
    $penerimaanUang = $this->report_model->get_DaftarPenerimaanUang($order);
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
      $DataItem = array("value"=>array(($groupby == 1 ? 'Jenis Penerimaan' : 'Tanggal'),'Kwitansi','Konsumen','Keterangan', 'Jumlah'),
                        "width" =>array(20,15,25,25,15),
                        "align" =>array('L','L','L','L','R'),
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
          $datacol1 = $groupby == 1 ? $value->namapenerimaan : date_format(date_create($value->tglbayar), "d-M-Y");
          $datagroup = $groupby == 0 ? $value->namapenerimaan : date_format(date_create($value->tglbayar), "d-M-Y");

          //Group Total
          if ($no != 0 &&  $flagGroupby != $groupbyname) {
              $DataItem = array("value"=>array('Total', $this->sidlib->my_format($totalbayar)),
                        "width" =>array(85,15),
                        "align" =>array('R'),
                        "style" =>array('B'),
                        "border" =>array('TRBL')
                      );
              $pdf->CreateGroupText($DataItem['value'], $ln=0, $DataItem['width'], $h, 8, $DataItem['style'], $DataItem['align'], $DataItem['border'], 1, $fill);
              $no=0;
              $totalbayar = 0;
              if ($pdf->PageHeight < $pdf->GetY()+10) $pdf->AddPage();
          }

          //Group Header
          if ($flagGroupby != $groupbyname) {
            $pdf->SetFont('','B',8);
            $pdf->Cell(0,0,$datagroup,1,1);
          }

          //Detil Record
          $DataItem = array("value"=>array($datacol1, $value->nokwitansi,$value->namapemesan,$value->description,$this->sidlib->my_format($value->jumlahbayar)),
                        "width" =>array(20,15,25,25,15),
                        "align" =>array('L','L','L','L','R'),
                        "style" =>array(''),
                        "border" =>array('RL')
                      );
          if ($pdf->PageHeight < $pdf->GetY()) $pdf->AddPage();
          $pdf->CreateGroupText($DataItem['value'], $ln=0, $DataItem['width'], $h, 8, $DataItem['style'], $DataItem['align'], $DataItem['border'], 1, $fill);

          $flagGroupby = $groupbyname;
          $totalbayar += $value->jumlahbayar;
          $grandtotal += $value->jumlahbayar;
          $no++;
      }

      //Last Group Total
      $DataItem = array("value"=>array('Total', $this->sidlib->my_format($totalbayar)),
                        "width" =>array(85,15),
                        "align" =>array('R'),
                        "style" =>array('B'),
                        "border" =>array('TRBL')
                      );
      $pdf->CreateGroupText($DataItem['value'], $ln=0, $DataItem['width'], $h, 8, $DataItem['style'], $DataItem['align'], $DataItem['border'], 1, $fill);

      //Print Grand Total
      $h = 10;
      $pdf->SetTextColorArray(sidlib::rgbColor('navy'));
      $DataItem = array("value"=>array('Grand Total', $this->sidlib->my_format($grandtotal)),
                        "width" =>array(85,15),
                        "align" =>array('R'),
                        "style" =>array('B'),
                        "border" =>array('RBL')
                      );
      $pdf->CreateGroupText($DataItem['value'], $ln=0, $DataItem['width'], $h, 10, $DataItem['style'], $DataItem['align'], $DataItem['border'], 1, $fill);
    }

		//Generate PDF file
		ob_clean();
		$pdf->Output('Sar_daftarpenerimaanuang.pdf', 'I');
		ob_end_clean();
    }
}
?>