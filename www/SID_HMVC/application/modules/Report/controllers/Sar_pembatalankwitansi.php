<?php 
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Sar_pembatalankwitansi extends Reportpdf {

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
		$this->pdf->SetTitle('SID | Lap Pembatalan Kwitansi');
		$this->pdf->AddPage();

		// Judul Laporan
		$this->pdf->SetFont('','B',16);
		$this->pdf->SetTextColor(sidlib::rgbColor(TITLE_COLOR));
		$this->pdf->Cell(50, 0,''); //267
		$this->pdf->Cell(80, 0, 'Pembatalan Kwitansi', 'B', $ln=1, 'C', 0, '', 4, false, 'C', 'B');
		$this->pdf->SetFont('','',10);
		$this->pdf->SetTextColor(sidlib::rgbColor(TEXT_COLOR));
		$this->pdf->Cell(50, 0,'');
		$this->pdf->Cell(80, 0, date_format($periode, "d-M-Y").' s/d '.date_format($periode1, "d-M-Y"), '', $ln=1, 'C', 0, '', 0, false, 'T', 'T');

		//Generate Data
		$record = $this->report_model->get_LapPembatalanKwitansi();
		$data = '';
		$grandtotal=0;
		foreach ($record as $value) {
			$tglbatal = date_create($value->tglbatal);
			$grandtotal += $value->totaltransaksi;
	        $data .= 
	        '<tr>
				<td>'.date_format($tglbatal, "d-M-Y").'</td>
				<td>'.$value->nokwitansi.'</td>
				<td>'.$value->nopesanan.'</td>
				<td>'.$value->namapemesan.'</td>
				<td class="number">'.$this->sidlib->my_format($value->totaltransaksi).'</td>				
			</tr>';
		}

		//Generate Table Header
		$texthtml = $this->style.
		'<table cellspacing="0" cellpadding="2" border="1">
    		<tr>
    			<th width="20%" class="vcenter">Tgl Batal</th>
    			<th width="15%" class="vcenter">Kwitansi</th>
    			<th width="15%" class="vcenter">No. Pesanan</th>
    			<th width="35%" class="vcenter">Konsumen</th>
    			<th width="15%" class="vcenter">Jumlah</th>
    		</tr>'.$data.' 
			<tr>
				<td class="footer" colspan="5">GRAND TOTAL : '.$this->sidlib->my_format($grandtotal).'</td>
			</tr>
    	</table>';
    	$this->pdf->Ln(2);
    	$this->pdf->writeHTML($texthtml, true, true, true, true);//, false, true, 'R', true);

		//Generate PDF file
		ob_end_clean();
		$this->pdf->Output('Sar_pembatalankwitansi.pdf', 'I');	
	}
}
?>	