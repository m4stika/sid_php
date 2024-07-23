<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Sar_suratpemesanan extends MY_Controller {

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
		//$pdf->setCellHeightRatio(1.8);

		// Generate Report Title
		$pdf->SetTitle('SID | Surat Pemesanan');
		$pdf->AddPage();
		
		// Generate Report Header
		$pdf->setCellPaddings(0,1,0,1);
		$pdf->SetTextColorArray(sidlib::rgbColor(TITLE_COLOR));
		$pdf->SetFont('', 'B',15);
		$pdf->Cell(0, 0, 'Surat Pemesanan', '', 1, 'C');
	
		//Generate Table
        $kontrak = $this->report_model->get_kontrak($this->input->post('linkid'));

//Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='M')
//MultiCell($w, $h, $txt, $border=0, $align='J', $fill=false, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0, $valign='T', $fitcell=false)
        
        //Data
	    $pdf->setCellPaddings(2,1,2,0);
        $pdf->SetTextColorArray(sidlib::rgbColor(TEXT_COLOR));
        $pdf->SetLineStyle(sidlib::linestyle('navy'));

        //Data Pribadi Konsumen
        $h = 6;
        $fontsize = 8;
        $pdf->SetFont('', '',10);
        $pdf->Cell(50/100*$pdf->PageWidth, $h, 'DATA PRIBADI KONSUMEN', 'B', 0, 'L');
        $pdf->Cell(50/100*$pdf->PageWidth, $h, $kontrak->namamarketing, 'B', 1, 'R');
        $DataItem = array("width" =>array(30, 3, 60),
	        			"align" =>array('L'),
	        			"style" =>array('','','B'),
	        			"border" =>array(0)
	        			);
	        				  
        $printText = function($data, $value) use ($pdf, $h, $fontsize) {
        	$pdf->CreateGroupText($value, $ln=0, $data['width'], $h, $fontsize, $data['style'], $data['align']);
        };
        //$pdf->CreateGroupText($DataItem['value'], $ln=0, $DataItem['width'], $h, $fontsize, $DataItem['style'], $DataItem['align']);

        $printText($DataItem,array('No Pemesanan', ':',$kontrak->nopesanan));
        $printText($DataItem,array('Nama Konsumen',':',$kontrak->namapemesan));
        $printText($DataItem,array('Alamat',':',$kontrak->alamatpemesan));

       	$DataItem['width'] = array(33,30,3,30);
       	$printText($DataItem,array('','RT/RW',':',$kontrak->rtrwpemesan));
       	$printText($DataItem,array('','Desa/Kelurahan',':',$kontrak->kelurahanpemesan));
       	$printText($DataItem,array('','Kecamatana',':',$kontrak->kecamatanpemesan));
       	$printText($DataItem,array('','Kabupaten/Kota',':',$kontrak->kabupatenpemesan));
       	$pdf->Ln();
       	$printText($DataItem,array('Telpon','Rumah',':',$kontrak->telprumahpemesan));
       	$printText($DataItem,array('','kantor',':',$kontrak->telpkantorpemesan));
       	$printText($DataItem,array('','HP #1',':',$kontrak->hp1pemesan));
       	$pdf->SetLineStyle(sidlib::linestyle());
       	$pdf->Cell(0,0, '', 'T', 1);

       	//Data Pasangan
       	$DataItem['width'] = array(30,3,30);
       	$printText($DataItem,array('Nama Pasangan',':',$kontrak->namapasangan));
       	$printText($DataItem,array('Alamat',':',$kontrak->alamatpasangan));
       	$DataItem['width'] = array(33,30,3,30);
       	$printText($DataItem,array('','RT/RW',':',$kontrak->rtrwpasangan));
       	$printText($DataItem,array('','Desa/Kelurahan',':',$kontrak->kelurahanpasangan));
       	$printText($DataItem,array('','Kecamatana',':',$kontrak->kecamatanpasangan));
       	$printText($DataItem,array('','Kabupaten/Kota',':',$kontrak->kabupatenpasangan));
       	$pdf->Ln();
       	$printText($DataItem,array('Telpon','Rumah',':',$kontrak->telprumahpasangan));
       	$printText($DataItem,array('','kantor',':',$kontrak->telpkantorpasangan));
       	$printText($DataItem,array('','HP #1',':',$kontrak->hp1pasangan));

       	//Unit Rumah yang di pesan
       	$pdf->Ln();
       	$pdf->SetLineStyle(sidlib::linestyle('navy'));
       	$pdf->Cell(0, $h, 'UNIT RUMAH/RUKO YANG DIPESAN', 'B', 1, 'L');
       	$DataItem['width'] = array(30,3,30);
       	$printText($DataItem,array('Type Rumah',':',$kontrak->typerumah));
       	$printText($DataItem,array('Blok/No.Kavling',':',$kontrak->blok.' - '.$kontrak->nokavling));
       	$printText($DataItem,array('Luas Bangunan Standard',':',$kontrak->luasbangunan));
       	$printText($DataItem,array('Luas Tanah Standard',':',$kontrak->luastanah));
       	$printText($DataItem,array('Luas Kelebihan Tanah',':',$kontrak->kelebihantanah));
       	$printText($DataItem,array('Posisi Sudut',':',($kontrak->sudut==1 ? "Ya" : "Tidak")));
       	$printText($DataItem,array('Hadap Jalan Utama',':',($kontrak->hadapjalan==1 ? "Ya" : "Tidak")));
       	$printText($DataItem,array('Hadap Fasos/Fasum',':',$kontrak->fasum==1 ? "Ya" : "Tidak"));
       	$printText($DataItem,array('Redesign Bangunan',':',$kontrak->redesignbangunan==1 ? "Ya" : "Tidak"));
       	$printText($DataItem,array('Tambah Kwalitas',':',$kontrak->tambahkwalitas==1 ? "Ya" : "Tidak"));
       	$printText($DataItem,array('Pekerjaan Tambah',':',$kontrak->pekerjaantambah==1 ? "Ya" : "Tidak"));

       	//Biaya-biaya yang harus dibayarkan
       	$pdf->AddPage();
       	$pdf->Cell(0, $h, 'BIAYA-BIAYA YANG HARUS DIBAYARKAN', 'B', 1, 'L');
       	$DataItem['align'] = array('L','L','R');
       	$DataItem['width'] = array(30,3,20);
       	$printText($DataItem,array('Harga Jual Rumah/Ruko',':',$this->sidlib->my_format($kontrak->hargajual)));
       	$printText($DataItem,array('Potongan/Diskon',':',$this->sidlib->my_format($kontrak->diskon)));
       	$printText($DataItem,array('Biaya Kelebihan Tanah',':',$this->sidlib->my_format($kontrak->hargaklt)));
       	$printText($DataItem,array('Biaya Posisi Sudut',':',$this->sidlib->my_format($kontrak->hargasudut)));
       	$printText($DataItem,array('Biaya Hadap Jalan Utama',':',$this->sidlib->my_format($kontrak->hargahadapjalan)));
       	$printText($DataItem,array('Biaya Hadap Fasos/Fasum',':',$this->sidlib->my_format($kontrak->hargafasum)));
       	$printText($DataItem,array('Biaya Redesign Bangunan',':',$this->sidlib->my_format($kontrak->hargaredesign)));
       	$printText($DataItem,array('Biaya Tambah Kwalitas',':',$this->sidlib->my_format($kontrak->hargatambahkwalitas)));
       	$printText($DataItem,array('Biaya Pekerjaan Tambah',':',$this->sidlib->my_format($kontrak->hargapekerjaantambah)));
       	$printText($DataItem,array('Uang Muka',':',$this->sidlib->my_format($kontrak->totaluangmuka)));

       	//Pola Pembayaran
       	$pdf->Ln();
       	$pdf->Cell(0, $h, 'POLA PEMBAYARAN', 'B', 1, 'L');
       	$DataItem['align'] = array('L','L','R','L');
       	$DataItem['width'] = array(30,3,20,20,3,20);
       	$printText($DataItem,array('KPR/Tunai Keras/Tunai Bertahap',':',POLA_BAYAR[$kontrak->polapembayaran]));
       	$printText($DataItem,array('Booking Fee',':',$this->sidlib->my_format($kontrak->bookingfee), 'Tanggal',':'));
       	$printText($DataItem,array('Biaya Kelebihan Tanah',':',$this->sidlib->my_format($kontrak->hargakltbyr), 'Tanggal',':'));
       	$printText($DataItem,array('Biaya Posisi Sudut',':',$this->sidlib->my_format($kontrak->hargasudutbyr), 'Tanggal',':'));
       	$printText($DataItem,array('Biaya Hadap Jalan Utama',':',$this->sidlib->my_format($kontrak->hargahadapjalanbyr), 'Tanggal',':'));
       	$printText($DataItem,array('Biaya Hadap Fasos/Fasum',':',$this->sidlib->my_format($kontrak->hargafasumbyr), 'Tanggal',':'));
       	$printText($DataItem,array('Biaya Redesign Bangunan',':',$this->sidlib->my_format($kontrak->hargaredesignbyr), 'Tanggal',':'));
       	$printText($DataItem,array('Biaya Tambah Kwalitas',':',$this->sidlib->my_format($kontrak->hargatambahkwbyr), 'Tanggal',':'));
       	$printText($DataItem,array('Biaya Pekerjaan Tambah',':',$this->sidlib->my_format($kontrak->hargakerjatambahbyr), 'Tanggal',':'));
       	$pdf->Cell(0, $h, 'POLA KPR', '', 1, 'L');
       	$printText($DataItem,array('Angsuran Uang Muka I',':',$this->sidlib->my_format($kontrak->lunasuangmuka), 'Tanggal',':'));
       	$printText($DataItem,array('Angsuran Uang Muka II',':',$this->sidlib->my_format($kontrak->lunasuangmuka), 'Tanggal',':'));
       	$printText($DataItem,array('Angsuran Uang Muka III',':',$this->sidlib->my_format($kontrak->lunasuangmuka), 'Tanggal',':'));
       	$printText($DataItem,array('Nilai KPR',':',$this->sidlib->my_format($kontrak->plafonkpr)));
       	$pdf->Cell(0, $h, 'POLA TUNAI KERAS', '', 1, 'L');
       	$printText($DataItem,array('Pembayaran Tunai Keras',':',$this->sidlib->my_format($kontrak->totalhargabyr), 'Tanggal',':'));
       	$pdf->Cell(0, $h, 'POLA TUNAI BERTAHAP', '', 1, 'L');
       	$printText($DataItem,array('Angsuran I',':',0,'Tanggal',':'));
       	$printText($DataItem,array('Angsuran II',':',0,'Tanggal',':'));
       	$printText($DataItem,array('Angsuran III',':',0,'Tanggal',':'));
       	$printText($DataItem,array('Angsuran IV',':',0,'Tanggal',':'));
       	$printText($DataItem,array('Angsuran V',':',0,'Tanggal',':'));
       	$printText($DataItem,array('Angsuran VI',':',0,'Tanggal',':'));
       	$pdf->SetFont('', '',8);
       	$pdf->Cell(0, $h, 'Pembayaran ini duluar proses KPR, pajak-pajak (jika ada) dan biaya lain sesuai brosur yang berlaku', '', 1, 'L');

       	//DOKUMEN UNTUK PROSES KREDIT
       	$pdf->AddPage();
       	$x = $pdf->GetX();
       	$pdf->SetFont('', 'B',8);
       	$pdf->Cell(0, $h, 'DOKUMEN UNTUK PROSES KREDIT', 'B', 1, 'L');
       	$pdf->SetFont('', '',8);
       	$pdf->Cell(0, $h, 'Fotocopy Aplikasi KPR', '', 1, 'L');
       	$pdf->Cell(0, $h, 'Fotocopy KTP Suami/Istri', '', 1, 'L');
       	$pdf->Cell(0, $h, 'Fotocopy Kartu Keluarga', '', 1, 'L');
       	$pdf->Cell(0, $h, 'Fotocopy Surat Nikah', '', 1, 'L');
       	$pdf->setEqualColumns(3);
       	$pdf->SetLineStyle(sidlib::linestyle());
       	$pdf->Cell(0, $h, 'Pegawai', 1, 1, 'C');
       	$text = 'Slip Gaji/ Keterangan Pegawai'."\n".'Rekening Tabungan 3 Bulan'."\n".'Terakhir
NPWP pribadi untuk KPR > Rp. 50 jt'."\n".'Surat Ket. Belum Memiliki Rumah *)'."\n".'Rekomendasi dari bagian personalia'."\n".'a. Pengurusan PUMP Jamsostek'."\n".'b. SKPG ke Bank BTN'."\n".'*) Untuk fasilitas KPR subsidi';
        $pdf->MultiCell(0, 0, $text , 1, 'L');
        $pdf->selectColumn(1);
        $text = 'Ijin Praktek Profesional'."\n".'Rekening Tabungan 3 Bulan'."\n".'Terakhir
NPWP pribadi untuk KPR > Rp. 50 jt'."\n".'Surat Ket. Belum Memiliki Rumah *)'."\n".'Surat Keterangan Penghasilan
(omset usaha)'."\n\n\n";
		$pdf->Cell(0, $h, 'Profesional', 1, 1, 'C');
        $pdf->MultiCell(0, 0, $text , 1, 'L');
        $pdf->selectColumn(2);
        $text = 'SIUP/TDP/NPWP Perusahaan'."\n".'Rekening Tabungan 3 Bulan'."\n".'Terakhir
NPWP pribadi untuk KPR > Rp. 50 jt'."\n".'Surat Ket. Belum Memiliki Rumah *)'."\n".'Surat Keterangan Penghasilan (lap.
keuangan)'."\n\n\n";
        $pdf->Cell(0, $h, 'Wiraswasta', 1, 1, 'C');
        $pdf->MultiCell(0, 0, $text , 1, 'L');
        $pdf->resetColumns();
        $pdf->SetX($x);
        $pdf->Cell(0, $h, 'Dokumen untuk proses KPR paling lambat diterima oleh pengembang tanggal :', 1, 1, 'L');

        //Print Footer
    	$parameter = $this->report_model->get_parameter();
    	$pdf->FooterAssignSingle($parameter, 9,'Bagian Penjualan');
        

		//Generate PDF file
		ob_clean();
		$pdf->Output('Sar_suratpemesanan.pdf', 'I');
		ob_end_clean();
    }
}
?>