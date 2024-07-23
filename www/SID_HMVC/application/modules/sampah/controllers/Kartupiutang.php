<?php 
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Kartupiutang extends Reportpdf {

	public function __construct()
	{
		parent::__construct();		
		$this->load->model('report_model');
	}

	public function index() {
		$htmlstyle = '
		<style type="text/css">
			.number {
			    text-align: right;
			}
		</style>';

		$parameter = $this->report_model->get_parameter();
		$kontrak = $this->report_model->get_kontrak($this->input->post('linkid'));
		$this->pdf->setCellHeightRatio(1.8);
		$this->pdf->SetTitle('SID | Kartu Piutang');
		$this->pdf->AddPage();
//writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='') 
		
		// Judul Laporan
		$texthtml = $this->style.'<h1 class="title">Kewajiban Keuangan dan Dokumen KPR</h1>';
		$this->pdf->writeHTML($texthtml, true, true, true, true, 'C');
		
		$this->pdf->Ln(2);
		$this->pdf->SetDrawColor(0,128,255);
		$this->pdf->writeHTMLCell(100, 0, '', '', 'DATA PRIBADI KONSUMEN', 'B', 0, false, true, 'L', true);
		$this->pdf->writeHTMLCell(80, 0, '', '', $kontrak->namapemesan, 'B', 1, false, true, 'R', true);
		$this->pdf->Ln(2);
		$texthtml = //<<<EOS
			'<table>
				<tr><td width="150">No. Pesanan</td><td width="10">:</td><td width="250"><b>'.$kontrak->nopesanan.'</b></td></tr>
				<tr><td width="150">Nama Pemesan</td><td width="10">:</td><td width="250"><b>'.$kontrak->namapemesan.'</b></td></tr>
				<tr><td width="150">Alamat</td><td width="10">:</td><td width="250"><b>'.$kontrak->alamatpemesan.'</b></td></tr>
				<tr>
					<td width="160"></td><td width="150">RT/RW</td><td width="10">:</td><td width="250"><b>'.$kontrak->rtrwpemesan.'</b></td>
				</tr>
				<tr>
					<td width="160"></td><td width="150">Desa/Kelurahan</td><td width="10">:</td><td width="250"><b>'.$kontrak->kelurahanpemesan.'</b></td>
				</tr>
				<tr>
					<td width="160"></td><td width="150">Kecamatan</td><td width="10">:</td><td width="250"><b>'.$kontrak->kecamatanpemesan.'</b></td>
				</tr>
				<tr>
					<td width="160"></td><td width="150">Kabupaten/Kota</td><td width="10">:</td><td width="250"><b>'.$kontrak->kabupatenpemesan.'</b></td>
				</tr>
				<tr><td width="150">No. HP</td><td width="10">:</td><td width="250"><b>'.$kontrak->hp1pemesan.'</b></td></tr>
			</table>';
		
		$this->pdf->writeHTML($texthtml, true, true, true, true);//, false, true, 'R', true);
		$this->pdf->Ln(5);
		$this->pdf->SetDrawColor(0,128,255);
		$this->pdf->writeHTMLCell(180, 0, '', '', 'UNIT RUMAH / RUKO YANG DI PESAN', 'B', 1, false, true, 'L', true);
		$this->pdf->Ln(2);
		$texthtml = 
			'<table>
				<tr>
					<td width="150">Type Rumah</td><td width="10">:</td><td width="100"><b>'.$kontrak->typerumah.'</b></td>
					<td width="100">Blok/No. Kavling</td><td width="10">:</td><td width="150"><b>'.$kontrak->blok.' - '.$kontrak->nokavling.'</b></td>
				</tr>
				<tr>
					<td width="90">Area</td><td width="60">LB</td><td width="10">:</td><td width="100"><b>'.$kontrak->luasbangunan.'</b></td>
					<td width="100">LT</td><td width="10">:</td><td width="100"><b>'.$kontrak->luastanah.'</b></td>
					<td width="80">KLT</td><td width="10">:</td><td width="150"><b>'.$kontrak->kelebihantanah.'</b></td>
				</tr>
				<tr>
					<td width="90">Posisi</td><td width="60">Sudut</td><td width="10">:</td><td width="100"><b>'.($kontrak->sudut==1 ? "Ya" :"Tidak").'</b></td>
					<td width="100">Hadap Jln</td><td width="10">:</td><td width="100"><b>'.($kontrak->hadapjalan==1 ? "Ya" :"Tidak").'</b></td>
					<td width="80">Fasum</td><td width="10">:</td><td width="150"><b>'.($kontrak->fasum==1 ? "Ya" :"Tidak").'</b></td>
				</tr>
				<tr>
					<td width="90">Penambahan</td><td width="60">Redesign</td><td width="10">:</td><td width="100"><b>'.($kontrak->redesignbangunan==1 ? "Ya" :"Tidak").'</b></td>
					<td width="100">+Kwalitas</td><td width="10">:</td><td width="100"><b>'.($kontrak->tambahkwalitas==1 ? "Ya" :"Tidak").'</b></td>
					<td width="80">Pekerjaan+</td><td width="10">:</td><td width="150"><b>'.($kontrak->pekerjaantambah==1 ? "Ya" :"Tidak").'</b></td>
				</tr>
				<tr>
					<td width="150">Pola Pembayaran</td><td width="10">:</td><td width="310"><b>'.$kontrak->polapembayaran.'</b></td>
					<td width="80">Plafon KPR</td><td width="10">:</td><td width="150" class="number"><b>'.'Rp. '.$this->sidlib->my_format($kontrak->plafonkpr).',-</b></td>
				</tr>
			</table>';
		$this->pdf->writeHTML($texthtml, true, true, true, true);//, false, true, 'R', true);
		$this->pdf->Ln(5);
		$this->pdf->SetDrawColor(0,128,255);
		$this->pdf->writeHTMLCell(180, 0, '', '', 'BIAYA-BIAYA YANG HARUS DIBAYARKAN', 'B', 1, false, true, 'L', true);
		$this->pdf->Ln(2);
		$texthtml = $htmlstyle.
			'<table>
				<tr>
					<td width="150">Harga Jual Rumah/Ruko</td><td width="10">:</td><td width="130" class="number"><b>'.'Rp. '.$this->sidlib->my_format($kontrak->hargajual).',-</b></td><td width="20"></td>
					<td width="150">By. Hadap Jalan Utama</td><td width="10">:</td><td width="150" class="number"><b>'.'Rp. '.$this->sidlib->my_format($kontrak->hargahadapjalan).',-</b></td>
				</tr>
				<tr>
					<td width="150">By. Kelebihan Tanah</td><td width="10">:</td><td width="130" class="number"><b>'.'Rp. '.$this->sidlib->my_format($kontrak->hargaklt).',-</b></td><td width="20"></td>
					<td width="150">By. Hadap Fasos/Fasum</td><td width="10">:</td><td width="150" class="number"><b>'.'Rp. '.$this->sidlib->my_format($kontrak->hargafasum).',-</b></td>
				</tr>
				<tr>
					<td width="150">By. Posisi Sudut</td><td width="10">:</td><td width="130" class="number"><b>'.'Rp. '.$this->sidlib->my_format($kontrak->hargasudut).',-</b></td><td width="20"></td>
					<td width="150">By. Redesign Bangunan</td><td width="10">:</td><td width="150" class="number"><b>'.'Rp. '.$this->sidlib->my_format($kontrak->hargaredesign).',-</b></td>
				</tr>
				<tr>
					<td width="150">Diskon</td><td width="10">:</td><td width="130" class="number"><b>'.'Rp. '.$this->sidlib->my_format($kontrak->diskon).',-</b></td><td width="20"></td>
					<td width="150">By. Tambah Kwalitas</td><td width="10">:</td><td width="150" class="number"><b>'.'Rp. '.$this->sidlib->my_format($kontrak->hargatambahkwalitas).',-</b></td>
				</tr>
				<tr>
					<td width="150">Alasan Diskon</td><td width="10">:</td><td width="150"><b>'.$kontrak->alasandiskon.'</b></td>
					<td width="150">By. Pekerjaan Tambah</td><td width="10">:</td><td width="150" class="number"><b>'.'Rp. '.$this->sidlib->my_format($kontrak->hargapekerjaantambah).',-</b></td>
				</tr>
				<tr>
					<td width="150"></td><td width="10"></td><td width="150"><b></b></td>
					<td width="150">Booking Fee</td><td width="10">:</td><td width="150" class="number"><b>'.'Rp. '.$this->sidlib->my_format($kontrak->bookingfee).',-</b></td>
				</tr>
				<tr>
					<td width="150">Uang Muka</td><td width="10">:</td><td width="130" class="number"><b>'.'Rp. '.$this->sidlib->my_format($kontrak->totaluangmuka).',-</b></td><td width="20"></td>
					<td width="150">Total Harga Jual</td><td width="10">:</td><td width="150" class="number"><b>'.'Rp. '.$this->sidlib->my_format($kontrak->totalharga).',-</b></td>
				</tr>
			</table>';
		$this->pdf->writeHTML($texthtml, true, true, true, true);//, false, true, 'R', true);
		$this->pdf->Ln(5);
		$this->pdf->writeHTMLCell(80, 0, '', '', 'RINCIAN PENERIMAAN UANG KONSUMEN', '', 0, false, true, 'L', true);
		$this->pdf->writeHTMLCell(50, 0, '', '','Total Kewajiban Di luar KPR', '', 0, false, true, 'R', true);
		$this->pdf->SetFont('','B');
		$this->pdf->writeHTMLCell(48, 0, '', '',' Rp. '.$this->sidlib->my_format($kontrak->totalhutang, 0, ',','.').',-', '', 1, false, true, 'R', true);
		$this->pdf->SetFont('','');
		//Get Record Item
		$data = '';
		$kwitansi = $this->report_model->get_kwitansi($this->input->post('linkid'));

		foreach ($kwitansi as $value) {
	        $date = date_create($value->tglbayar);
	        $data .= 
	        '<tr>
				<td>'.date_format($date, "d-M-Y").'</td>
				<td>'.$value->nokwitansi.'</td>
				<td>'.$value->keterangan.'</td>
				<td>'.$value->bank.'</td>
				<td class="number">'.$this->sidlib->my_format($value->totalbayar,0,'.',',').'</td>
			</tr>';
        }

		$texthtml = $this->style.
		'<table>
			<tr>
        		<th class="vcenter" width="12%">Tanggal</th>
        		<th class="vcenter" width="17%">Kwitansi</th>
        		<th class="vcenter" width="30%">Keterangan</th>
        		<th class="vcenter" width="20%">Bank</th>
        		<th class="vcenter number" width="20%">Jumlah</th>
    		</tr>'.$data.'
    		<tr>
    			<td colspan = "4" class="number">Total Pembayaran</td>
    			<td class="number"><b>'.$this->sidlib->my_format($kontrak->totalbayartitipan).'</b></td>
			</tr>
			<tr>
    			<td colspan = "4" class="number">Kewajiban Yang Belum Dibayar</td>
    			<td class="number"> <b>'.$this->sidlib->my_format($kontrak->totalhutang - $kontrak->totalbayartitipan).'</b></td>
			</tr>
    	</table>';
    	$this->pdf->writeHTML($texthtml, true, true, true, true);//, false, true, 'R', true);


		$this->pdf->AddPage();
		$this->pdf->writeHTMLCell(80, 0, '', '', 'PENERIMAAN DOKUMEN', '', 1, false, true, 'L', true);
		$data = '';
		$dokumen = $this->report_model->get_dokumenpemesanan($this->input->post('linkid'));
		$no = 1;
		foreach ($dokumen as $value) {
	        $date = date_create($value->tglpenyerahan);
	        $data .= 
	        '<tr>
				<td align="right">'.$no.'</td>
				<td>'.$value->namadokumen.'</td>
				<td align="center">'.($value->status == 1 ? 'OK' : '').'</td>
				<td>'.($value->status == 1 ? date_format($date, "d-M-Y") : '').'</td>
			</tr>';
			$no++;
        }
		$texthtml = $this->style.
		'<table>
			<tr>
        		<th class="vcenter" width="10%">No</th>
        		<th class="vcenter" width="50%">Dokumen</th>
        		<th class="vcenter" width="15%">Status</th>
        		<th class="vcenter" width="25%">Tanggal</th>
    		</tr>'.$data.'
    	</table>';
    	$this->pdf->writeHTML($texthtml, true, true, true, true);//, false, true, 'R', true);

    	$this->pdf->Ln(5);
    	$this->pdf->writeHTMLCell(80, 0, '', '', 'PROGRESS REPORT KPR', '', 1, false, true, 'L', true);
		$data = '';
		$progreskpr = $this->report_model->get_progreskpr($this->input->post('linkid'));
		$no = 1;
		foreach ($progreskpr as $value) {
	        $date = date_create($value->tglprogres);
	        $data .= 
	        '<tr>
				<td align="right">'.$no.'</td>
				<td>'.$value->namaprogres.'</td>
				<td align="center">'.($value->kelengkapan == 1 ? 'OK' : '').'</td>
				<td>'.($value->kelengkapan == 1 ? date_format($date, "d-M-Y") : '').'</td>
			</tr>';
			$no++;
        }
		$texthtml = $this->style.
		'<table>
			<tr>
        		<th class="vcenter" width="10%">No</th>
        		<th class="vcenter" width="50%">Progress</th>
        		<th class="vcenter" width="15%">Status</th>
        		<th class="vcenter" width="25%">Tanggal</th>
    		</tr>'.$data.'
    	</table>';
    	$this->pdf->writeHTML($texthtml, true, true, true, true);//, false, true, 'R', true);


    	$this->pdf->Ln(5);
    	$date = date_create();
		$this->pdf->writeHTMLCell(0, 0, '', '', 'Semarang, '.date_format($date, "d-M-Y"), '', 1, false, true, 'L', true);
		$this->pdf->writeHTMLCell(0, 0, '', '',$parameter->company, '', 1, false, true, 'L', true);
		$this->pdf->Ln(15);
		$this->pdf->writeHTMLCell(0, 0, '', '','Bagian Penjualan', '', 1, false, true, 'L', true);

			// $this->pdf->Cell($captionWidth, 0, 'No. Pesanan', '');
			// $this->pdf->Cell($dashWidth, 0, ':', '');
			// $this->pdf->SetFont('','B');
			// $this->pdf->Cell($valueWidth, 0, $kontrak->nopesanan, '',1);
			// $this->pdf->SetFont('','');

		//Generate PDF file
		ob_end_clean();
		$this->pdf->Output('kartupiutang.pdf', 'I');			
		//$this->generatePdf($html, 'kartupiutang.pdf');
	}
}