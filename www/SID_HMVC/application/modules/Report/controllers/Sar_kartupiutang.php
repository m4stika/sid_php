<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Sar_kartupiutang extends MY_Controller {

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
		$pdf->SetMargins(10, PDF_MARGIN_TOP, 10, true);  
        $pdf->resetPageWidth();

		// Generate Report Title
		$pdf->SetTitle('SID | Kewajiban Keuangan dan Dokumen KPR');
		$pdf->AddPage();
		
		// Generate Report Header
		$pdf->setCellPaddings(0,1,0,1);
		$pdf->SetTextColorArray(sidlib::rgbColor(TITLE_COLOR));
		$pdf->SetFont('', 'B',15);
		$pdf->Cell(0, 0, 'Kewajiban Keuangan dan Dokumen KPR', '', 1, 'C');
	
		//Generate Table
        $kontrak = $this->report_model->get_kontrak($this->input->post('linkid'));

        

//Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='M')
//MultiCell($w, $h, $txt, $border=0, $align='J', $fill=false, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0, $valign='T', $fitcell=false)
        
        //Loop Report Data Header
	    $pdf->setCellPaddings(2,1,2,0);
	    $pdf->SetFont('', 'B',10);
	    //$pdf->SetFillColorArray(sidlib::rgbColor(HEADER_COLOR));
        //$pdf->SetDrawColorArray($color['navy']);
        $pdf->SetTextColorArray(sidlib::rgbColor(TEXT_COLOR));
        $pdf->SetLineStyle(sidlib::linestyle('navy'));

        $pdf->Cell(50/100*$pdf->PageWidth, 6, 'DATA PRIBADI KONSUMEN', 'B', 0, 'L');
        $pdf->Cell(50/100*$pdf->PageWidth, 6, $kontrak->namapemesan, 'B', 1, 'R');

        $DataItem = array("value"=>array('No. Pesanan',':',$kontrak->nopesanan),
        				  "width" =>array(20, 2, 50),
        				  "align" =>array('L','L','L'),
        				  "style" =>array('','','B')
        				);
        $h = 6;
        $pdf->Ln();
        $pdf->CreateGroupText($DataItem['value'], $ln=0, $DataItem['width'], $h, 9, $DataItem['style'], $DataItem['align']);
       	$DataItem['value'] = array('Nama',':',$kontrak->namapemesan);
       	$pdf->CreateGroupText($DataItem['value'], $ln=0, $DataItem['width'], $h, 9, $DataItem['style'], $DataItem['align']);
       	$DataItem['value'] = array('Alamat',':',$kontrak->alamatpemesan);
       	$pdf->CreateGroupText($DataItem['value'], $ln=0, $DataItem['width'], $h, 9, $DataItem['style'], $DataItem['align']);
        
        $DataItem = array("value"=>array('','RT/RW',':',$kontrak->rtrwpemesan), "width" =>array(22,20, 2, 30),
        				  "align" =>array('L','L','L','L'), "style" =>array('','','','B')
        				);
        $pdf->CreateGroupText($DataItem['value'], $ln=0, $DataItem['width'], $h, 9, $DataItem['style'], $DataItem['align']);
       	
       	$DataItem['value'] = array('','Desa/Kelurahan',':',$kontrak->kelurahanpemesan);
       	$pdf->CreateGroupText($DataItem['value'], $ln=0, $DataItem['width'], $h, 9, $DataItem['style'], $DataItem['align']);
       	$DataItem['value'] = array('','Kecamatana',':',$kontrak->kecamatanpemesan);
       	$pdf->CreateGroupText($DataItem['value'], $ln=0, $DataItem['width'], $h, 9, $DataItem['style'], $DataItem['align']);
       	$DataItem['value'] = array('','Kabupaten/Kota',':',$kontrak->kabupatenpemesan);
       	$pdf->CreateGroupText($DataItem['value'], $ln=0, $DataItem['width'], $h, 9, $DataItem['style'], $DataItem['align']);
       	$pdf->CreateGroupText(array('No. HP',':',$kontrak->hp1pemesan), $ln=0, array(20, 2, 50), $h, 9, array('','','B'), array('L'));

        $pdf->Ln();
        $pdf->Cell(0, 6, 'UNIT RUMAH / RUKO YANG DI PESAN', 'B', 1, 'L');
        $DataItem = array("value"=>array('Type Rumah',':',$kontrak->typerumah,'Blok/No.Kavling',':',$kontrak->blok.' - '.$kontrak->nokavling),
        				  "width" =>array(20, 2, 20, 15, 2, 15),
        				  "align" =>array('L'),
        				  "style" =>array('','','B','','','B')
        				);
        $pdf->CreateGroupText($DataItem['value'], $ln=0, $DataItem['width'], $h, 9, $DataItem['style'], $DataItem['align']);
        $DataItem = array("value"=>array('Posisi Sudut',':',($kontrak->sudut == 1 ? 'Ya':'Tidak'),'Hadap Jalan',':',($kontrak->hadapjalan == 1 ? 'Ya':'Tidak'),'Fasos/Fasum',':',($kontrak->fasum == 1 ? 'Ya':'Tidak')),
        				  "width" =>array(20, 2, 20, 15, 2, 15, 15, 2, 15),
        				  "align" =>array('L'),
        				  "style" =>array('','','B','','','B','','','B')
        				);
        
        $pdf->CreateGroupText($DataItem['value'], $ln=0, $DataItem['width'], $h, 9, $DataItem['style'], $DataItem['align']);

        $DataItem['value'] = array('Redesign Bangunan',':',($kontrak->redesignbangunan == 1 ? 'Ya':'Tidak'),'+ Kwalitas',':', ($kontrak->tambahkwalitas == 1 ? 'Ya':'Tidak'),'+ Kontruksi',':',($kontrak->pekerjaantambah==1 ? 'Ya':'Tidak'));
        $pdf->CreateGroupText($DataItem['value'], $ln=0, $DataItem['width'], $h, 9, $DataItem['style'], $DataItem['align']);

        //$DataItem['value'] = array('L','L','L','L','L','L','L','L','R');
        $DataItem['value'] = array('Pola Pembayaran',':',$kontrak->polapembayaran,'','','','Plafon KPR',':',$this->sidlib->my_format($kontrak->plafonkpr));
        $pdf->CreateGroupText($DataItem['value'], $ln=0, $DataItem['width'], $h, 9, $DataItem['style'], $DataItem['align']);

        $pdf->Ln();
        $pdf->Cell(0, 6, 'BIAYA-BIAYA YANG HARUS DIBAYARKAN', 'B', 1, 'L');
        $DataItem = array("value"=>array('Harga Jual Rumah/Ruko',':',$this->sidlib->my_format($kontrak->hargajual),'By. Hadap Jalan Utama',':',$this->sidlib->my_format($kontrak->hargahadapjalan)),
        				  "width" =>array(20, 2, 15, 45, 2, 16),
        				  "align" =>array('L','L','R','R','L','R'),
        				  "style" =>array('','','B','','','B')
        				);
        $pdf->CreateGroupText($DataItem['value'], $ln=0, $DataItem['width'], $h, 9, $DataItem['style'], $DataItem['align']);

        $DataItem['value'] = array('By. Kelebihan Tanah',':',$this->sidlib->my_format($kontrak->hargaklt),'By. Hadap Fasos/Fasum',':',$this->sidlib->my_format($kontrak->hargafasum));
        $pdf->CreateGroupText($DataItem['value'], $ln=0, $DataItem['width'], $h, 9, $DataItem['style'], $DataItem['align']);

        $DataItem['value'] = array('By. Posisi Sudut',':',$this->sidlib->my_format($kontrak->hargasudut),'By. Redesign Bangunan',':',$this->sidlib->my_format($kontrak->hargaredesign));
        $pdf->CreateGroupText($DataItem['value'], $ln=0, $DataItem['width'], $h, 9, $DataItem['style'], $DataItem['align']);

        $DataItem['value'] = array('Diskon',':',$this->sidlib->my_format($kontrak->diskon),'By. Tambah Kwalitas',':',$this->sidlib->my_format($kontrak->hargatambahkwalitas));
        $pdf->CreateGroupText($DataItem['value'], $ln=0, $DataItem['width'], $h, 9, $DataItem['style'], $DataItem['align']);

        $DataItem['value'] = array('Alasan Diskon',':',$this->sidlib->my_format($kontrak->alasandiskon),'By. Pekerjaan Tambah',':',$this->sidlib->my_format($kontrak->hargapekerjaantambah));
        $pdf->CreateGroupText($DataItem['value'], $ln=0, $DataItem['width'], $h, 9, $DataItem['style'], $DataItem['align']);

        $DataItem['value'] = array('','','','Booking Fee',':',$this->sidlib->my_format($kontrak->bookingfee));
        $pdf->CreateGroupText($DataItem['value'], $ln=0, $DataItem['width'], $h, 9, $DataItem['style'], $DataItem['align']);

        $DataItem['value'] = array('Uang Muka',':',$this->sidlib->my_format($kontrak->totaluangmuka),'Total Harga Jual',':',$this->sidlib->my_format($kontrak->totalharga));
        $pdf->CreateGroupText($DataItem['value'], $ln=0, $DataItem['width'], $h, 9, $DataItem['style'], $DataItem['align']);

        $pdf->Ln();
        $DataItem = array("value"=>array('RINCIAN PENERIMAAN UANG KONSUMEN','Total Kewajiban Di luar KPR',$this->sidlib->my_format($kontrak->totalhutang)),
        				  "width" =>array(50, 35, 15),
        				  "align" =>array('L','R','R'),
        				  "style" =>array('B')
        				);
        $pdf->CreateGroupText($DataItem['value'], $ln=0, $DataItem['width'], $h, 9, $DataItem['style'], $DataItem['align']);

        $pdf->SetLineStyle(sidlib::linestyle(LINESTYLE_GREY));
        $kwitansi = $this->report_model->get_kwitansi($this->input->post('linkid'));
        if (count($kwitansi) > 0) {
        	//Print Header
        	$pdf->SetLineStyle(sidlib::linestyle());
        	$DataItem = array("value"=>array('Tanggal','Kwitansi','Keterangan','Bank','Jumlah'),
        				  "width" =>array(10, 15, 35, 25, 15),
        				  "align" =>array('C'),
        				  "style" =>array('B')
        				);
        	$pdf->CreateGroupText($DataItem['value'], $ln=0, $DataItem['width'], 8, 9, $DataItem['style'], $DataItem['align'], array(1));

        	$DataItem['align'] = array('C','L','L','L','R');
        	$DataItem['style'] = array('');
        	foreach ($kwitansi as $value) {
		        $date = date_create($value->tglbayar);
		        $DataItem['value'] =  array(date_format($date, "d-M-Y"),$value->nokwitansi,$value->keterangan,$value->bank,$this->sidlib->my_format($value->totalbayar,0,'.',','));
		        $pdf->CreateGroupText($DataItem['value'], $ln=0, $DataItem['width'], $h, 8, $DataItem['style'], $DataItem['align'], array(1));
	        }
	        //Print Total
	        $DataItem = array("value"=>array('Total Pembayaran',$this->sidlib->my_format($kontrak->totalbayaronp+$kontrak->totalbayartitipan)),
        				  "width" =>array(85, 15),
        				  "align" =>array('R'),
        				  "style" =>array('B')
        				);
	        $pdf->CreateGroupText($DataItem['value'], $ln=0, $DataItem['width'], 8, 9, $DataItem['style'], $DataItem['align'], array(1));
	        $DataItem['value']=array('Kewajiban yang belum dibayar',$this->sidlib->my_format($kontrak->totalhutang - ($kontrak->totalbayaronp+$kontrak->totalbayartitipan)));
	        $pdf->CreateGroupText($DataItem['value'], $ln=0, $DataItem['width'], 8, 9, $DataItem['style'], $DataItem['align'], array(1));
        }

        if ($pdf->getPage() == 1) $pdf->AddPage();
        $pdf->Ln();
    	$dokumen = $this->report_model->get_dokumenpemesanan($this->input->post('linkid'));
    	if (count($dokumen) > 0) {
			$pdf->Cell(0, 6, 'PENERIMAAN DOKUMEN', '', 1, 'L');
			$DataItem = array("value"=>array('No','Dokumen','Status','Tanggal'),
				        				  "width" =>array(10, 50, 15, 25),
				        				  "align" =>array('C'),
				        				  "style" =>array('B')
				        				);
			$pdf->CreateGroupText($DataItem['value'], $ln=0, $DataItem['width'], 8, 9, $DataItem['style'], $DataItem['align'], array(1));
    		$no = 0;
    		$DataItem['align'] = array('C','L');
        	$DataItem['style'] = array('');
			foreach ($dokumen as $value) {
		        //$date = date_create($value->tglpenyerahan);
		        $no++;
		        $DataItem['value'] =  array($no, $value->namadokumen, ($value->status == 1 ? 'OK' : ''), date_format(date_create($value->tglpenyerahan), "d-M-Y"));
		        $pdf->CreateGroupText($DataItem['value'], $ln=0, $DataItem['width'], $h, 8, $DataItem['style'], $DataItem['align'], array(1));
	        }
    	}

    	$pdf->Ln();
    	$progreskpr = $this->report_model->get_progreskpr($this->input->post('linkid'));
    	if (count($progreskpr) > 0) {
			$pdf->Cell(0, 6, 'PROGRESS REPORT KPR', '', 1, 'L');
			$DataItem = array("value"=>array('No','Progress','Status','Tanggal'),
				        				  "width" =>array(10, 50, 15, 25),
				        				  "align" =>array('C'),
				        				  "style" =>array('B')
				        				);
			$pdf->CreateGroupText($DataItem['value'], $ln=0, $DataItem['width'], 8, 9, $DataItem['style'], $DataItem['align'], array(1));
    		$no = 0;
    		$DataItem['align'] = array('C','L');
        	$DataItem['style'] = array('');
			foreach ($progreskpr as $value) {
		        //$date = date_create($value->tglpenyerahan);
		        $no++;
		        $DataItem['value'] =  array($no, $value->namaprogres, ($value->kelengkapan == 1 ? 'OK' : ''), date_format(date_create($value->tglprogres), "d-M-Y"));
		        $pdf->CreateGroupText($DataItem['value'], $ln=0, $DataItem['width'], $h, 8, $DataItem['style'], $DataItem['align'], array(1));
	        }
    	}
    	$parameter = $this->report_model->get_parameter();
    	$pdf->FooterAssignSingle($parameter, 9,'Bagian Pemasaran');
        

		//Generate PDF file
		ob_clean();
		$pdf->Output('Sar_kartupiutang.pdf', 'I');
		ob_end_clean();
    }
}
?>