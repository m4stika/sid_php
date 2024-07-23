<?php 
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Sar_pembatalan extends Reportpdf {

	public function __construct()
	{
		parent::__construct();		
		$this->load->model('Pemasaran_model','report_model');
	}

	public function index() {
		$htmlstyle = '
		<style type="text/css">
		</style>';

		$periode = date_create($this->input->post('periode'));
		$periode1 = date_create($this->input->post('periode1'));
				

		$this->pdf->setCellHeightRatio(1.8);
		$this->pdf->SetTitle('SID | Laporan Pembatalan');
		$this->pdf->AddPage('L');

		// Judul Laporan
		$this->pdf->SetFont('','B',16);
		$this->pdf->SetTextColor(sidlib::rgbColor(TITLE_COLOR));
		$this->pdf->Cell(90, 0,''); //267
		$this->pdf->Cell(80, 0, 'Laporan Pembatalan', 'B', $ln=1, 'C', 0, '', 4, false, 'C', 'B');
		$this->pdf->SetFont('','',10);
		$this->pdf->SetTextColor(sidlib::rgbColor(TEXT_COLOR));
		$this->pdf->Cell(90, 0,'');
		$this->pdf->Cell(80, 0, date_format($periode, "d-M-Y").' s/d '.date_format($periode1, "d-M-Y"), '', $ln=1, 'C', 0, '', 0, false, 'T', 'T');

		//Generate Data
		$record = $this->report_model->get_LapPembatalan();
		$data = '';
		foreach ($record as $value) {
			$tglbatal = date_create($value->tglbatal);
	        $data .= 
	        '<tr>
				<td>'.date_format($tglbatal, "d-M-Y").'<br/>'.$value->nopesanan.'<br/>'.$value->namapemesan.'</td>
				<td class="number">'.$this->sidlib->my_format($value->uangmukabyr).'<br/>'.$this->sidlib->my_format($value->kltbyr).'<br/>'.$this->sidlib->my_format($value->sudutbyr).'</td>
				<td class="number">'.$this->sidlib->my_format($value->hadapjalanbyr).'<br/>'.$this->sidlib->my_format($value->fasumbyr).'<br/>'.$this->sidlib->my_format($value->redesignbyr).'</td>
				<td class="number">'.$this->sidlib->my_format($value->tambahkwbyr).'<br/>'.$this->sidlib->my_format($value->kerjatambahbyr).'<br/>'.$this->sidlib->my_format($value->totalbayartitipan).'</td>
				<td class="number">'.$this->sidlib->my_format($value->uangmuka).'<br/>'.$this->sidlib->my_format($value->klt).'<br/>'.$this->sidlib->my_format($value->sudut).'</td>
				<td class="number">'.$this->sidlib->my_format($value->hadapjalan).'<br/>'.$this->sidlib->my_format($value->fasum).'<br/>'.$this->sidlib->my_format($value->redesign).'</td>
				<td class="number">'.$this->sidlib->my_format($value->tambahkw).'<br/>'.$this->sidlib->my_format($value->kerjatambah).'<br/>'.$this->sidlib->my_format($value->totalpengembalian).'</td>
			</tr>';
		}

		// Generate Table Header
		$texthtml = $this->style.
		'<table cellspacing="0" cellpadding="2" border="1">
			<tr>
        		<th rowspan="2" width="20%" class="left"><br/><br/>Tgl Batal <br/> No. Pesanan <br/> Konsumen</th>
        		<th colspan="3" class="vcenter" width="40%">Penerimaan Uang</th>
        		<th colspan="3" class="vcenter" width="40%">Pengembalian Uang</th>
    		</tr>
    		<tr>
    			<th class="number">Uang Muka<br/>KLT<br/>Sudut</th>
    			<th class="number">Hadap Jalan<br/>Fasum<br/>Redesign</th>
    			<th class="number">+Kwalitas<br/>+Kontruksi<br/><b>TOTAL</b></th>
    			<th class="number">Uang Muka<br/>KLT<br/>Sudut</th>
    			<th class="number">Hadap Jalan<br/>Fasum<br/>Redesign</th>
    			<th class="number">+Kwalitas<br/>+Kontruksi<br/><b>TOTAL</b></th>
    		</tr>'.$data.'
    	</table>';
    	$this->pdf->Ln(2);
    	$this->pdf->writeHTML($texthtml, true, true, true, true);//, false, true, 'R', true);

		//Generate PDF file
		ob_end_clean();
		$this->pdf->Output('Sar_pembatalan.pdf', 'I');		
	}
}
?>
