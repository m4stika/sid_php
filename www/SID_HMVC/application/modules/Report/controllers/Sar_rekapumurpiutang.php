<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Sar_rekapumurpiutang extends MY_Controller {

	public function __construct()
	{
		parent::__construct();		
		$this->load->library('Pdf','pdf');
		$this->load->library('Sidlib','sidlib');
		$this->load->model('Pemasaran_model','report_model');
	}

	public function index() {
		$pdf = new Pdf('L', 'mm', 'A4', false, 'ISO-8859-1', false);
		//PDF initialize
		$pdf->initializeReport();	
		$pdf->SetMargins(5, PDF_MARGIN_TOP, 5, true);
        $pdf->resetPageWidth();  
		$pdf->setCellHeightRatio(1.8);

		// Generate Report Title
		$pdf->SetTitle('SID | Umur Piutang');
		$pdf->AddPage();
		
		// Generate Report Header
        $pdf->reportHeader('Rekapitulasi Umur Piutang', 'C', 'B', sidlib::rgbColor(TITLE_COLOR), 18, 4, 'B','C');
        $pdf->reportHeader(date_format(date_create($this->input->post('periode')), "d-M-Y").' s/d '.date_format(date_create($this->input->post('periode1')), "d-M-Y"), 'C', 0, sidlib::rgbColor(TEXT_COLOR), 10, 0, 'B','A');

	    $pdf->setCellPaddings(2,1,2,0);
	    $pdf->SetFont('', 'B',9);
	    $pdf->SetFillColorArray(sidlib::rgbColor(HEADER_COLOR));
        $pdf->SetTextColorArray(sidlib::rgbColor(HEADER_TEXT_COLOR));
        $pdf->SetLineStyle(sidlib::linestyle());

        //Load Record
        $umurpiutang = $this->report_model->get_RekapitulasiUmurpiutang();

        if (count($umurpiutang) > 0) {
			
            //Print Header
            $pdf->HeaderTablePemasaran('Pola Pembayaran');

            $pdf->SetTextColorArray(sidlib::rgbColor(TEXT_COLOR));
            $pdf->Ln();
            $h = 18;
            $polapembayaran = array("KPR","Tunai Keras","Tunai Bertahap");
            $DataItem = array("value"=>array(''),
	        				  "width" =>array(10, 10, 9),
	        				  "align" =>array('L','L','R'),
	        				  "style" =>array('')
	        				);
			foreach ($umurpiutang as $value) {
		        //$date = date_create($value->tglpenyerahan);
                $DataItem['value'] =  array($polapembayaran[$value->polapembayaran]."\n".$value->namapemesan."\n".$value->blok.' - '.$value->nokavling,
                                    date_format(date_create($value->tgltransaksi), "d-M-Y")."\n".$value->ketstatusbooking."\n".date_format(date_create($value->tglakadkredit), "d-M-Y"),
                                    $this->sidlib->my_format($value->hargajual)."\n".$this->sidlib->my_format($value->plafonkpr)."\n".$this->sidlib->my_format($value->totaluangmuka),
                                    $this->sidlib->my_format($value->bookingfee)."\n".$this->sidlib->my_format($value->hargaklt)."\n".$this->sidlib->my_format($value->hargasudut),
                                    $this->sidlib->my_format($value->hargahadapjalan)."\n".$this->sidlib->my_format($value->hargafasum)."\n".$this->sidlib->my_format($value->hargaredesign),
                                    $this->sidlib->my_format($value->hargatambahkwalitas)."\n".$this->sidlib->my_format($value->hargapekerjaantambah),
                                    $this->sidlib->my_format($value->lunasuangmuka)."\n".$this->sidlib->my_format($value->bookingfeebyr)."\n".$this->sidlib->my_format($value->hargakltbyr),
                                    $this->sidlib->my_format($value->hargasudutbyr)."\n".$this->sidlib->my_format($value->hargahadapjalanbyr)."\n".$this->sidlib->my_format($value->hargafasumbyr),
                                    $this->sidlib->my_format($value->hargaredesignbyr)."\n".$this->sidlib->my_format($value->hargatambahkwbyr)."\n".$this->sidlib->my_format($value->hargakerjatambahbyr),
                                    $this->sidlib->my_format($value->totalhargabyr),
                                    $this->sidlib->my_format($value->totalbayar)."\n".$this->sidlib->my_format($value->totalbayartitipan)."\n".$this->sidlib->my_format($value->totalhutang)

                                );
                if ($pdf->PageHeight < $pdf->GetY()) $pdf->AddPage();
		        $pdf->CreateGroupTextMulti($DataItem['value'], $ln=0, $DataItem['width'], $h, 8, $DataItem['style'], $DataItem['align'], array(1), 0, 1);
	        }
            //convert Object to Array & Sum all Total
            $arPenj = json_decode(json_encode($umurpiutang),TRUE);
            

            //Print Footer
            $pdf->SetFillColorArray(sidlib::rgbColor(FOOTER_COLOR));
            $pdf->SetTextColorArray(sidlib::rgbColor(FOOTER_TEXT_COLOR));
            $DataItem = array("value" => array('TOTAL',
                                    $this->sidlib->SumObject($arPenj, 'hargajual')."\n".$this->sidlib->SumObject($arPenj, 'plafonkpr')."\n".$this->sidlib->SumObject($arPenj, 'totaluangmuka'),
                                    $this->sidlib->SumObject($arPenj, 'bookingfee')."\n".$this->sidlib->SumObject($arPenj, 'hargaklt')."\n".$this->sidlib->SumObject($arPenj, 'hargasudut'),
                                    $this->sidlib->SumObject($arPenj, 'hargahadapjalan')."\n".$this->sidlib->SumObject($arPenj, 'hargafasum')."\n".$this->sidlib->SumObject($arPenj, 'hargaredesign'),
                                    $this->sidlib->SumObject($arPenj, 'hargatambahkwalitas')."\n".$this->sidlib->SumObject($arPenj, 'hargapekerjaantambah'),
                                    $this->sidlib->SumObject($arPenj, 'lunasuangmuka')."\n".$this->sidlib->SumObject($arPenj, 'bookingfeebyr')."\n".$this->sidlib->SumObject($arPenj, 'hargakltbyr'),
                                    $this->sidlib->SumObject($arPenj, 'hargasudutbyr')."\n".$this->sidlib->SumObject($arPenj, 'hargahadapjalanbyr')."\n".$this->sidlib->SumObject($arPenj, 'hargafasumbyr'),
                                    $this->sidlib->SumObject($arPenj, 'hargaredesignbyr')."\n".$this->sidlib->SumObject($arPenj, 'hargatambahkwbyr')."\n".$this->sidlib->SumObject($arPenj, 'hargakerjatambahbyr'),
                                    $this->sidlib->SumObject($arPenj, 'totalhargabyr'),
                                    $this->sidlib->SumObject($arPenj, 'totalbayar')."\n".$this->sidlib->SumObject($arPenj, 'totalbayartitipan')."\n".$this->sidlib->SumObject($arPenj, 'totalhutang'),
                                                            ),
                        "width" =>  array(20, 9),
                        "align" =>  array('R'),
                        "style" =>  array('B'));
            $pdf->CreateGroupTextMulti($DataItem['value'], $ln=0, $DataItem['width'], $h, 8, $DataItem['style'], $DataItem['align'], array(1), 1, 1);
    	}

		//Generate PDF file
		ob_clean();
		$pdf->Output('Sar_rekapumurpiutang.pdf', 'I');
		ob_end_clean();
    }
}
?>