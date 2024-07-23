<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sar_kartupiutang_prn extends MX_Controller {

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
		$caption = 'Kewajiban Keuangan dan Dokumen KPR';
		$orientation = 'A4';
		$data = "<h3 class='title'>{$caption}</h3>";
		$data .= "<div class='row'><div class='col-12'>
					<span class='col-6'><strong>DATA PRIBADI KONSUMEN</strong></span>
					<span class='col-6 number'>{$kontrak->namapemesan}</span>
				</div></div>
				<div class='divider'></div>

				<div class='col-12'>
					<div class='col-2'>
						<span class='caption'>No. Pesanan</span>
						<span class='pull-right'>:</span> 
					</div>
					<div class='value col-9'>{$kontrak->nopesanan}</div>
				</div>
				<div class='col-12'>
					<div class='col-2'>
						<span class='caption'>Nama Pemesan</span>
						<span class='pull-right'>:</span> 
					</div>
					<span class='value col-9'>{$kontrak->namapemesan}</span>
				</div>
				<div class='col-12'>
					<div class='col-2'>
						<span class='caption'>Alamat</span>
						<span class='pull-right'>:</span> 
					</div>
					<span class='value col-9'>{$kontrak->alamatpemesan}</span>
				</div>
				<div class='col-offset-2 col-10'>
					<div class='col-3'>
						<span class='caption'>RT/RW</span>
						<span class='text-right'>:</span> 
					</div>
					<div class='value col-9'>{$kontrak->rtrwpemesan}</div>
					<div class='col-3'>
						<span class='caption'>Desa/Kelurahan</span>
						<span class='pull-right'>:</span> 
					</div>
					<div class='value col-9'>{$kontrak->kelurahanpemesan}</div>
					<div class='col-3'>
						<span class='caption'>Kecamatan</span>
						<span class='pull-right'>:</span> 
					</div>
					<div class='value col-9'>{$kontrak->kecamatanpemesan}</div>
					<div class='col-3'>
						<span class='caption'>Kabupaten/Kota</span>
						<span class='pull-right'>:</span> 
					</div>
					<div class='value col-9'>{$kontrak->kabupatenpemesan}</div>
				</div>
				<div class='col-12'>
					<div class='col-2'>
						<span class='caption'>No. HP</span>
						<span class='pull-right'>:</span> 
					</div>
					<span class='value col-6'>{$kontrak->hp1pemesan}</span>
				</div>
				<div class='row'>
					<div class='group col-12'><strong>DUNIT RUMAH / RUKO YANG DI PESAN</strong></div>
				</div>
				<div class='divider'></div>
				<div class='col-12'>
					<div class='col-2'>
						<span class='caption'>Type Rumah</span>
						<span class='pull-right'>:</span> 
					</div>
					<span class='value col-2'>{$kontrak->typerumah}</span>
					<div class='col-2'>
						<span class='caption'>Blok/No.Kavling</span>
						<span class='pull-right'>:</span> 
					</div>
					<span class='value col-2'>{$kontrak->blok}-{$kontrak->nokavling}</span>
				</div>
				<div class='col-12'>
					<div class='col-2'>
						<span class='caption'>Posisi Sudut</span>
						<span class='pull-right'>:</span> 
					</div>
					<span class='value col-2'>".($kontrak->sudut == 1 ? 'Ya':'Tidak')."</span>
					<div class='col-2'>
						<span class='caption'>Hadap Jalan</span>
						<span class='pull-right'>:</span> 
					</div>
					<span class='value col-2'>".($kontrak->hadapjalan == 1 ? 'Ya':'Tidak')."</span>
					<div class='col-2'>
						<span class='caption'>Fasos/Fasum</span>
						<span class='pull-right'>:</span> 
					</div>
					<span class='value col-2'>".($kontrak->fasum == 1 ? 'Ya':'Tidak')."</span>
				</div>
				<div class='col-12'>
					<div class='col-2'>
						<span class='caption'>Redesign</span>
						<span class='pull-right'>:</span> 
					</div>
					<span class='value col-2'>".($kontrak->redesignbangunan == 1 ? 'Ya':'Tidak')."</span>
					<div class='col-2'>
						<span class='caption'>+ Kwalitas</span>
						<span class='pull-right'>:</span> 
					</div>
					<span class='value col-2'>".($kontrak->tambahkwalitas == 1 ? 'Ya':'Tidak')."</span>
					<div class='col-2'>
						<span class='caption'>+ Kontruksi</span>
						<span class='pull-right'>:</span> 
					</div>
					<span class='value col-2'>".($kontrak->pekerjaantambah == 1 ? 'Ya':'Tidak')."</span>
				</div>
				<div class='col-12'>
					<div class='col-2'>
						<span class='caption'>Pola Bayar</span>
						<span class='pull-right'>:</span> 
					</div>
					<span class='value col-2'>".(POLA_BAYAR[$kontrak->polapembayaran])."</span>
					<div class='col-offset-4 col-2'>
						<span class='caption'>Plafon KPR</span>
						<span class='pull-right'>:</span> 
					</div>
					<span class='value col-2 number'>".$this->sidlib->my_format($kontrak->plafonkpr)."</span>
				</div>

				<div class='row'>
					<div class='group col-12'><strong>BIAYA-BIAYA YANG HARUS DIBAYARKAN</strong></div>
				</div>
				<div class='divider'></div>
				<div class='col-12'>
					<div class='col-3'>
						<span class='caption'>Harga Jual Rumah/Ruko</span>
						<span class='pull-right'>:</span> 
					</div>
					<span class='value col-2 number'>".$this->sidlib->my_format($kontrak->hargajual)."</span>
					<div class='col-offset-2 col-3'>
						<span class='caption'>By. Hadap Jalan Utama</span>
						<span class='pull-right'>:</span> 
					</div>
					<span class='value col-2 number'>".$this->sidlib->my_format($kontrak->hargahadapjalan)."</span>
				</div>
				<div class='col-12'>
					<div class='col-3'>
						<span class='caption'>By. Kelebihan Tanah</span>
						<span class='pull-right'>:</span> 
					</div>
					<span class='value col-2 number'>".$this->sidlib->my_format($kontrak->hargaklt)."</span>
					<div class='col-offset-2 col-3'>
						<span class='caption'>By. Hadap Fasos/Fasum</span>
						<span class='pull-right'>:</span> 
					</div>
					<span class='value col-2 number'>".$this->sidlib->my_format($kontrak->hargafasum)."</span>
				</div>
				<div class='col-12'>
					<div class='col-3'>
						<span class='caption'>Diskon</span>
						<span class='pull-right'>:</span> 
					</div>
					<span class='value col-2 number'>".$this->sidlib->my_format($kontrak->diskon)."</span>
					<div class='col-offset-2 col-3'>
						<span class='caption'>By. Tambah Kwalitas</span>
						<span class='pull-right'>:</span> 
					</div>
					<span class='value col-2 number'>".$this->sidlib->my_format($kontrak->hargatambahkwalitas)."</span>
				</div>
				<div class='col-12'>
					<div class='col-3'>
						<span class='caption'>Alasan Diskon</span>
						<span class='pull-right'>:</span> 
					</div>
					<span class='value col-4'>{$kontrak->alasandiskon}</span>
					<div class='col-3'>
						<span class='caption'>By. Pekerjaan Tambah</span>
						<span class='pull-right'>:</span> 
					</div>
					<span class='value col-2 number'>".$this->sidlib->my_format($kontrak->hargatambahkwalitas)."</span>
				</div>
				<div class='col-12'>
					<div class='col-offset-7 col-3'>
						<span class='caption'>Booking Fee</span>
						<span class='pull-right'>:</span> 
					</div>
					<span class='value col-2 number'>".$this->sidlib->my_format($kontrak->bookingfee)."</span>
				</div>
				<div class='col-12'>
					<div class='col-3'>
						<span class='caption'>Uang Muka</span>
						<span class='pull-right'>:</span> 
					</div>
					<span class='value col-2 number'>".$this->sidlib->my_format($kontrak->totaluangmuka)."</span>
					<div class='col-offset-2 col-3'>
						<span class='caption'>Total Harga Jual</span>
						<span class='pull-right'>:</span> 
					</div>
					<span class='value col-2 number'>".$this->sidlib->my_format($kontrak->totalharga)."</span>
				</div>
				";
		$kwitansi = $this->report_model->get_kwitansi($this->input->post('linkid'));
		
		$data .= "
				<div class='group col-12 strong'>
					<span class='col-6'>RINCIAN PENERIMAAN UANG KONSUMEN</span>
					<span class='col-4 text-right'>Total Kewajiban Di luar KPR</span>
					<span class='col-2 number'>{$this->sidlib->my_format($kontrak->totalhutang)}</span>
				</div>
				<table class='{$orientation}'>
					<thead>
					<tr>
						<th width='10' class='nobgcolor'>Tanggal</th>
						<th width='15' class='nobgcolor'>Kwitansi</th>
						<th width='35' class='nobgcolor'>Keterangan</th>
						<th width='25' class='nobgcolor'>Bank</th>
						<th width='15' class='nobgcolor'>Jumlah</th>
					</tr>
					</thead>
				";
				
				foreach ($kwitansi as $value) {
					$dataitem =  array(date_format(date_create($value->tglbayar), "d-M-Y"),$value->nokwitansi,$value->keterangan,$value->bank,$this->sidlib->my_format($value->totalbayar,0,'.',','));
					$data .= "<tbody><tr>";
					for ($i=0; $i < count($dataitem); $i++) { 
						$classname = ($i == count($dataitem)-1) ? 'number' : '';
						$data .= "<td class='{$classname}'>{$dataitem[$i]}</td>";
					}
					$data .= "</tr></tbody>";
				}
			$data .= "<tfoot>
					<tr>
						<td colspan='4' class='number'>Total Pembayaran</td>
						<td class='number'>{$this->sidlib->my_format($kontrak->totalbayaronp+$kontrak->totalbayartitipan)}</td>
					</tr>
					<tr>
						<td colspan='4' class='number strong'>Kewajiban yang belum dibayar</td>
						<td class='number strong'>{$this->sidlib->my_format($kontrak->totalhutang - ($kontrak->totalbayaronp+$kontrak->totalbayartitipan))}</td>
					</tr>
				</tfoot>";
		$data .= "</table>";

		$dokumen = $this->report_model->get_dokumenpemesanan($this->input->post('linkid'));
    	if (count($dokumen) > 0) {
			$data .= "<div class='group strong col-12'>
						<span class='col-6'>PENERIMAAN DOKUMEN</span>
					  </div>";
			$dataitem = array('No','Dokumen','Status','Tanggal');
				    //"width" =>array(10, 50, 15, 25),
			$data .= "
				<table class='{$orientation}'>
					<thead>
					<tr>
						<th width='10' class='nobgcolor'>No</th>
						<th width='50' class='nobgcolor'>Dokumen</th>
						<th width='15' class='nobgcolor'>Status</th>
						<th width='25' class='nobgcolor'>Tanggal</th>
					</tr>
					</thead>
				";
			$no=1;
			foreach ($dokumen as $value) {
		        $DataItem['value'] =  array($no, $value->namadokumen, ($value->status == 1 ? 'OK' : ''), date_format(date_create($value->tglpenyerahan), "d-M-Y"));
				$data .= "<tbody><tr>";
				for ($i=0; $i < count($dataitem); $i++) { 
					$data .= "<td>{$dataitem[$i]}</td>";
				}
				$data .= "</tr></tbody>";
		        $no++;
	        }
	        $data .= "</table>";
    	}

    	$progreskpr = $this->report_model->get_progreskpr($this->input->post('linkid'));
    	if (count($progreskpr) > 0) {
			$data .= "<div class='group strong col-12'>
						<span class='col-6'>PROGRESS REPORT KPR</span>
					  </div>";
			$dataitem = array('No','Progress','Status','Tanggal');
				    //"width" =>array(10, 50, 15, 25),
			$data .= "
				<table class='{$orientation}'>
					<thead>
					<tr>
						<th width='10' class='nobgcolor'>No</th>
						<th width='50' class='nobgcolor'>Progress</th>
						<th width='15' class='nobgcolor'>Status</th>
						<th width='25' class='nobgcolor'>Tanggal</th>
					</tr>
					</thead>
				";
			$no=1;
			foreach ($progreskpr as $value) {
		        $DataItem['value'] =  array($no, $value->namaprogres, ($value->kelengkapan == 1 ? 'OK' : ''), date_format(date_create($value->tglprogres), "d-M-Y"));
				$data .= "<tbody><tr>";
				for ($i=0; $i < count($dataitem); $i++) { 
					$data .= "<td>{$dataitem[$i]}</td>";
				}
				$data .= "</tr></tbody>";
		        $no++;
	        }
	        $data .= "</table>";
    	}

    	$data .= "
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