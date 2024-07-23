<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sar_suratpemesanan_prn extends MX_Controller {

	public function __construct()
	{
		parent::__construct();		
		$this->load->library('Sidlib','sidlib');
		$this->load->model('Pemasaran_model','report_model');
	}

	public function index() {
		$kontrak = $this->report_model->get_kontrak($this->input->post('linkid'));
		$parameter = $this->report_model->get_parameter();
		$dataheader = $this->sidlib->setHeader_prn($parameter);
		$caption = 'Surat Pemesanan';
		$orientation = 'A4';

		$printText = function($caption=array('classname'=>'col-2', 'value'=>''), 
							  $value=array('classname'=>'col-2', 'value'=>''),
							  $headerclass='col-12') use ($kontrak) {
			$text = "<div class='{$headerclass}'>
						<div class='{$caption['classname']}'>
							<span class='caption'>{$caption['value']}</span>
							<span class='pull-right'>:</span> 
						</div>
						<div class='value  {$value['classname']}'> {$value['value']}</div>";
						if (count($caption) > 2) {
							$text .="	
								<div class='{$caption['classname']}'>
									<span class='caption'>{$caption['value1']}</span>
									<span class='pull-right'>:</span> 
								</div>
								<div class='value  {$value['classname']}'> {$value['value1']}</div>";
						}

			$text .= "</div>";

			return $text;
		};


		$data = "<h3 class='title'>{$caption}</h3>";
		$data .= "<div class='row'><div class='col-12'>
					<span class='col-6'><strong>DATA PRIBADI KONSUMEN</strong></span>
					<span class='col-6 number'>{$kontrak->namapemesan}</span>
				</div></div>
				<div class='divider'></div>".
				$printText(array('classname'=>'col-2', 'value'=>'No. Pesanan'),array('classname'=>'col-9', 'value'=>$kontrak->nopesanan))
				.$printText(array('classname'=>'col-2', 'value'=>'Nama Pemesan'),array('classname'=>'col-9', 'value'=>$kontrak->namapemesan))
				.$printText(array('classname'=>'col-2', 'value'=>'Alamat'),array('classname'=>'col-9', 'value'=>$kontrak->alamatpemesan))
				.$printText(array('classname'=>'col-3', 'value'=>'RT/RW'),array('classname'=>'col-9', 'value'=>$kontrak->rtrwpemesan), 'col-offset-2 col-10')
				.$printText(array('classname'=>'col-3', 'value'=>'Desa/Kelurahan'),array('classname'=>'col-9', 'value'=>$kontrak->kelurahanpemesan), 'col-offset-2 col-10')
				.$printText(array('classname'=>'col-3', 'value'=>'Kecamatan'),array('classname'=>'col-9', 'value'=>$kontrak->kecamatanpemesan), 'col-offset-2 col-10')
				.$printText(array('classname'=>'col-3', 'value'=>'Kabupaten/Kota'),array('classname'=>'col-9', 'value'=>$kontrak->kabupatenpemesan), 'col-offset-2 col-10')
				.$printText(array('classname'=>'col-2', 'value'=>'No. HP'),array('classname'=>'col-9', 'value'=>''))
				.$printText(array('classname'=>'col-3', 'value'=>'Rumah'),array('classname'=>'col-9', 'value'=>$kontrak->telprumahpemesan), 'col-offset-2 col-10')
				.$printText(array('classname'=>'col-3', 'value'=>'Kantor'),array('classname'=>'col-9', 'value'=>$kontrak->telpkantorpemesan), 'col-offset-2 col-10')
				.$printText(array('classname'=>'col-3', 'value'=>'HP #1'),array('classname'=>'col-9', 'value'=>$kontrak->hp1pemesan), 'col-offset-2 col-10')

				."<hr>"
				.$printText(array('classname'=>'col-2', 'value'=>'Nama pasangan'),array('classname'=>'col-9', 'value'=>$kontrak->namapasangan))
				.$printText(array('classname'=>'col-2', 'value'=>'Alamat'),array('classname'=>'col-9', 'value'=>$kontrak->alamatpasangan))
				.$printText(array('classname'=>'col-3', 'value'=>'RT/RW'),array('classname'=>'col-9', 'value'=>$kontrak->rtrwpasangan), 'col-offset-2 col-10')
				.$printText(array('classname'=>'col-3', 'value'=>'Desa/Kelurahan'),array('classname'=>'col-9', 'value'=>$kontrak->kelurahanpasangan), 'col-offset-2 col-10')
				.$printText(array('classname'=>'col-3', 'value'=>'Kecamatan'),array('classname'=>'col-9', 'value'=>$kontrak->kecamatanpasangan), 'col-offset-2 col-10')
				.$printText(array('classname'=>'col-3', 'value'=>'Kabupaten/Kota'),array('classname'=>'col-9', 'value'=>$kontrak->kabupatenpasangan), 'col-offset-2 col-10')
				.$printText(array('classname'=>'col-2', 'value'=>'No. HP'),array('classname'=>'col-9', 'value'=>''))
				.$printText(array('classname'=>'col-3', 'value'=>'Rumah'),array('classname'=>'col-9', 'value'=>$kontrak->telprumahpasangan), 'col-offset-2 col-10')
				.$printText(array('classname'=>'col-3', 'value'=>'Kantor'),array('classname'=>'col-9', 'value'=>$kontrak->telpkantorpasangan), 'col-offset-2 col-10')
				.$printText(array('classname'=>'col-3', 'value'=>'HP #1'),array('classname'=>'col-9', 'value'=>$kontrak->hp1pasangan), 'col-offset-2 col-10')
				."
				<div class='row'>
					<div class='group col-12'><strong>UNIT RUMAH/RUKO YANG DIPESAN</strong></div>
				</div>
				<div class='divider'></div>"
				.$printText(array('classname'=>'col-3', 'value'=>'Type Rumah'),array('classname'=>'col-9', 'value'=>$kontrak->typerumah))
		       	.$printText(array('classname'=>'col-3', 'value'=>'Blok/No.Kavling'),array('classname'=>'col-9', 'value'=>$kontrak->blok.' - '.$kontrak->nokavling))
		       	.$printText(array('classname'=>'col-3', 'value'=>'Luas Bangunan Standard'),array('classname'=>'col-9', 'value'=>$kontrak->luasbangunan))
		       	.$printText(array('classname'=>'col-3', 'value'=>'Luas Tanah Standard'),array('classname'=>'col-9', 'value'=>$kontrak->luastanah))
		       	.$printText(array('classname'=>'col-3', 'value'=>'Luas Kelebihan Tanah'),array('classname'=>'col-9', 'value'=>$kontrak->kelebihantanah))
		       	.$printText(array('classname'=>'col-3', 'value'=>'Posisi Sudut'),array('classname'=>'col-9', 'value'=>($kontrak->sudut==1 ? "Ya" : "Tidak")))
		       	.$printText(array('classname'=>'col-3', 'value'=>'Hadap Jalan Utama'),array('classname'=>'col-9', 'value'=>($kontrak->hadapjalan==1 ? "Ya" : "Tidak")))
		       	.$printText(array('classname'=>'col-3', 'value'=>'Hadap Fasos/Fasum'),array('classname'=>'col-9', 'value'=>$kontrak->fasum==1 ? "Ya" : "Tidak"))
		       	.$printText(array('classname'=>'col-3', 'value'=>'Redesign Bangunan'),array('classname'=>'col-9', 'value'=>$kontrak->redesignbangunan==1 ? "Ya" : "Tidak"))
		       	.$printText(array('classname'=>'col-3', 'value'=>'Tambah Kwalitas'),array('classname'=>'col-9', 'value'=>$kontrak->tambahkwalitas==1 ? "Ya" : "Tidak"))
		       	.$printText(array('classname'=>'col-3', 'value'=>'Pekerjaan Tambah'),array('classname'=>'col-9', 'value'=>$kontrak->pekerjaantambah==1 ? "Ya" : "Tidak"))
       	."
				<div class='row'>
					<div class='group col-12'><strong>BIAYA-BIAYA YANG HARUS DIBAYARKAN</strong></div>
				</div>
				<div class='divider'></div>"
				.$printText(array('classname'=>'col-3', 'value'=>'Harga Jual Rumah/Ruko'),array('classname'=>'col-9', 'value'=>$this->sidlib->my_format($kontrak->hargajual)))
		       	.$printText(array('classname'=>'col-3', 'value'=>'Potongan/Diskon'),array('classname'=>'col-9', 'value'=>$this->sidlib->my_format($kontrak->diskon)))
		       	.$printText(array('classname'=>'col-3', 'value'=>'Biaya Kelebihan Tanah'),array('classname'=>'col-9', 'value'=>$this->sidlib->my_format($kontrak->hargaklt)))
		       	.$printText(array('classname'=>'col-3', 'value'=>'Biaya Posisi Sudut'),array('classname'=>'col-9', 'value'=>$this->sidlib->my_format($kontrak->hargasudut)))
		       	.$printText(array('classname'=>'col-3', 'value'=>'Biaya Hadap Jalan Utama'),array('classname'=>'col-9', 'value'=>$this->sidlib->my_format($kontrak->hargahadapjalan)))
		       	.$printText(array('classname'=>'col-3', 'value'=>'Biaya Hadap Fasos/Fasum'),array('classname'=>'col-9', 'value'=>$this->sidlib->my_format($kontrak->hargafasum)))
		       	.$printText(array('classname'=>'col-3', 'value'=>'Biaya Redesign Bangunan'),array('classname'=>'col-9', 'value'=>$this->sidlib->my_format($kontrak->hargaredesign)))
		       	.$printText(array('classname'=>'col-3', 'value'=>'Biaya Tambah Kwalitas'),array('classname'=>'col-9', 'value'=>$this->sidlib->my_format($kontrak->hargatambahkwalitas)))
		       	.$printText(array('classname'=>'col-3', 'value'=>'Biaya Pekerjaan Tambah'),array('classname'=>'col-9', 'value'=>$this->sidlib->my_format($kontrak->hargapekerjaantambah)))
		       	.$printText(array('classname'=>'col-3', 'value'=>'Uang Muka'),array('classname'=>'col-9', 'value'=>$this->sidlib->my_format($kontrak->totaluangmuka)))
				."<div class='row'>
					<div class='group col-12'><strong>POLA PEMBAYARAN</strong></div>
				</div>
				<div class='divider'></div>"
				.$printText(array('classname'=>'col-6', 'value'=>'KPR/Tunai Keras/Tunai Bertahap'),array('classname'=>'col-6', 'value'=>POLA_BAYAR[$kontrak->polapembayaran]))
				.$printText(array('classname'=>'col-3', 'value'=>'Booking Fee','value1'=>'Tanggal'),array('classname'=>'col-3', 'value'=>$this->sidlib->my_format($kontrak->bookingfee), 'value1'=>''))
				.$printText(array('classname'=>'col-3', 'value'=>'Biaya Kelebihan Tanah','value1'=>'Tanggal'),array('classname'=>'col-3', 'value'=>$this->sidlib->my_format($kontrak->hargakltbyr), 'value1'=>''))
		       	.$printText(array('classname'=>'col-3', 'value'=>'Biaya Posisi Sudut','value1'=>'Tanggal'),array('classname'=>'col-3', 'value'=>$this->sidlib->my_format($kontrak->hargasudutbyr), 'value1'=>''))
		       	.$printText(array('classname'=>'col-3', 'value'=>'Biaya Hadap Jalan Utama','value1'=>'Tanggal'),array('classname'=>'col-3', 'value'=>$this->sidlib->my_format($kontrak->hargahadapjalanbyr), 'value1'=>''))
		       	.$printText(array('classname'=>'col-3', 'value'=>'Biaya Hadap Fasos/Fasum','value1'=>'Tanggal'),array('classname'=>'col-3', 'value'=>$this->sidlib->my_format($kontrak->hargafasumbyr), 'value1'=>''))
		       	.$printText(array('classname'=>'col-3', 'value'=>'Biaya Redesign Bangunan','value1'=>'Tanggal'),array('classname'=>'col-3', 'value'=>$this->sidlib->my_format($kontrak->hargaredesignbyr), 'value1'=>''))
		       	.$printText(array('classname'=>'col-3', 'value'=>'Biaya Tambah Kwalitas','value1'=>'Tanggal'),array('classname'=>'col-3', 'value'=>$this->sidlib->my_format($kontrak->hargatambahkwbyr), 'value1'=>''))
		       	.$printText(array('classname'=>'col-3', 'value'=>'Biaya Pekerjaan Tambah','value1'=>'Tanggal'),array('classname'=>'col-3', 'value'=>$this->sidlib->my_format($kontrak->hargakerjatambahbyr), 'value1'=>''))
		       	."<div class='row'>
					<div class='group col-12'><strong>POLA KPR</strong></div>
				</div>"
		       	.$printText(array('classname'=>'col-3', 'value'=>'Angsuran Uang Muka I','value1'=>'Tanggal'),array('classname'=>'col-3', 'value'=>$this->sidlib->my_format($kontrak->lunasuangmuka), 'value1'=>''))
		       	.$printText(array('classname'=>'col-3', 'value'=>'Angsuran Uang Muka II','value1'=>'Tanggal'),array('classname'=>'col-3', 'value'=>$this->sidlib->my_format($kontrak->lunasuangmuka), 'value1'=>''))
		       	.$printText(array('classname'=>'col-3', 'value'=>'Angsuran Uang Muka III','value1'=>'Tanggal'),array('classname'=>'col-3', 'value'=>$this->sidlib->my_format($kontrak->lunasuangmuka), 'value1'=>''))
		       	.$printText(array('classname'=>'col-3', 'value'=>'Nilai KPR','value1'=>'Tanggal'),array('classname'=>'col-3', 'value'=>$this->sidlib->my_format($kontrak->plafonkpr), 'value1'=>''))
		       	."<div class='row'>
					<div class='group col-12'><strong>POLA TUNAI KERAS</strong></div>
				</div>"
		       	.$printText(array('classname'=>'col-3', 'value'=>'Pembayaran Tunai Keras','value1'=>'Tanggal'),array('classname'=>'col-3', 'value'=>$this->sidlib->my_format($kontrak->totalhargabyr), 'value1'=>''))
		       	."<div class='row'>
					<div class='group col-12'><strong>POLA TUNAI BERTAHAP</strong></div>
				</div>"
		       	.$printText(array('classname'=>'col-3', 'value'=>'Angsuran I','value1'=>'Tanggal'),array('classname'=>'col-3', 'value'=>0, 'value1'=>''))
		       	.$printText(array('classname'=>'col-3', 'value'=>'Angsuran II','value1'=>'Tanggal'),array('classname'=>'col-3', 'value'=>0, 'value1'=>''))
		       	.$printText(array('classname'=>'col-3', 'value'=>'Angsuran III','value1'=>'Tanggal'),array('classname'=>'col-3', 'value'=>0, 'value1'=>''))
		       	.$printText(array('classname'=>'col-3', 'value'=>'Angsuran IV','value1'=>'Tanggal'),array('classname'=>'col-3', 'value'=>0, 'value1'=>''))
		       	.$printText(array('classname'=>'col-3', 'value'=>'Angsuran V','value1'=>'Tanggal'),array('classname'=>'col-3', 'value'=>0, 'value1'=>''))
		       	.$printText(array('classname'=>'col-3', 'value'=>'Angsuran VI','value1'=>'Tanggal'),array('classname'=>'col-3', 'value'=>0, 'value1'=>''))
		       	."<div class='row'>
					<div class='col-12'>Pembayaran ini duluar proses KPR, pajak-pajak (jika ada) dan biaya lain sesuai brosur yang berlaku</div>
				</div>
				<div class='row'>
					<div class='group col-12'><strong>DOKUMEN UNTUK PROSES KREDIT</strong></div>
				</div>
				<div class='divider'></div>
				<div class='col-12'>Fotocopy Aplikasi KPR</div>
		       	<div class='col-12'>Fotocopy KTP Suami/Istri</div>
		       	<div class='col-12'>Fotocopy Kartu Keluarga</div>
		       	<div class='col-12'>Fotocopy Surat Nikah</div>
				<table class='{$orientation} compress'>
					<thead>
					<tr>
						<th width='33' class='nobgcolor'>Pegawai</th>
						<th width='33' class='nobgcolor'>Profesional</th>
						<th width='33' class='nobgcolor'>Wiraswasta</th>
					</tr>
					</thead>
					<tbody>
					<tr><td>Slip Gaji/Keterangan Pegawai</td><td>Ijin Praktek Profesional</td><td>SIUP/TDP/NPWP Perusahaan</td></tr>
					<tr><td>Rekening Tabungan 3 Bulan Terakhir</td><td>Rekening Tabungan 3 Bulan Terakhir</td><td>Rekening Tabungan 3 Bulan Terakhir</td></tr>
					<tr><td>NPWP pribadi untuk KPR > Rp. 50 jt</td><td>NPWP pribadi untuk KPR > Rp. 50 jt</td><td>NPWP pribadi untuk KPR > Rp. 50 jt</td></tr>
					<tr><td>Surat Ket. Belum Memiliki Rumah *)</td><td>Surat Ket. Belum Memiliki Rumah *)</td><td>Surat Ket. Belum Memiliki Rumah *)</td></tr>
					<tr><td>Rekomendasi dari bagian personalia</td><td>Surat Keterangan Penghasilan (omset usaha)</td><td>Surat Keterangan Penghasilan (lap.keuangan)</td></tr>
					<tr><td>a. Pengurusan PUMP Jamsostek</td><td></td><td></td></tr>
					<tr><td>b. SKPG ke Bank BTN</td><td></td><td></td></tr>
					<tr><td>*) Untuk fasilitas KPR subsidi</td><td></td><td></td></tr>
					</tbody>
				</table>
				
    		<div class='assign col-6'>
				<div class='date'>{$parameter->city}, ".date_format(date_create(), " d-M-Y")."</div>
				<div class=''>{$parameter->company}</div>
				<div class='footer'>Bagian Pemasaran</div>
			</div>
			";

    	
    	$data = array('title'		=> $caption,
					  'record'		=> $data,
					  'header'=>$dataheader,
					  'orientation' => $orientation
					  );
		$this->load->view('Report/laporan_print',$data);
    }
}	
?>