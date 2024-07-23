<?php 
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Rekap_penerimaanuang extends Reportpdf {

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

		$periode = date_create($this->input->post('periode'));
		$periode1 = date_create($this->input->post('periode1'));
				

		$parameter = $this->report_model->get_parameter();
		
		$this->pdf->setCellHeightRatio(1.8);
		$this->pdf->SetTitle('SID | Rekapitulasi Penerimaan Uang');
		$this->pdf->AddPage();

		// Judul Laporan
		$texthtml = $this->style.
		'<div> 
			<h1 class="title underline">Laporan Penjualan
				<span>'.date_format($periode, "d-M-Y").' s/d '.$this->input->post('periode1').'</span>
			</h1>
		 	
		</div>';
		$this->pdf->SetFont('','B',16);
		$this->pdf->SetTextColor(0,44,163);
		$this->pdf->Cell(50, 0,''); //267
		$this->pdf->Cell(80, 0, 'Rekapitulasi Penerimaan Uang', 'B', $ln=1, 'C', 0, '', 4, false, 'C', 'B');
		$this->pdf->SetFont('','',10);
		$this->pdf->SetTextColor(0,0,0);
		$this->pdf->Cell(50, 0,'');
		$this->pdf->Cell(80, 0, date_format($periode, "d-M-Y").' s/d '.date_format($periode1, "d-M-Y"), '', $ln=1, 'C', 0, '', 0, false, 'T', 'T');

		//Generate Table Data
		$groupby = $this->input->post('groupby'); //0=jenispenerimaan, 1=tglbayar
		$order = $groupby == 0 ? 'jenispenerimaan, tglbayar' : 'tglbayar, jenispenerimaan';
		$record = $this->report_model->get_RekapPenerimaanUang($order);
		$data = '';
		$flagGroupby = '';
		$no = 0;
		$totalbayar = 0;
		$grandtotal = 0;

		foreach ($record as $value) {
			$tglbayar = date_create($value->tglbayar);
			$classname = 'none';
			$groupbyname = $groupby == 0 ? $value->jenispenerimaan : $value->tglbayar;
			$datacol1 = $groupby == 0 ? $value->namapenerimaan : date_format($tglbayar, "d-M-Y");
			$datacol2 = $groupby == 1 ? $value->namapenerimaan : date_format($tglbayar, "d-M-Y");
			//($groupby == 0 ? ($flagGroupby == $value->jenispenerimaan ? "none" : "none") : ($flagGroupby == $value->tglbayar ? "none" : "none"));

			//Group Total
			if ($no != 0 &&  $flagGroupby != $groupbyname) {
				$data .= 
				'<tr>
					<td class="nonebuttom"></td>
					<td class="nonebuttom" colspan="2"></td>
					<td class="number"><b>'.$this->sidlib->my_format($totalbayar).'</b></td>
				</tr>';
				$no=0;
				$totalbayar = 0;
			}

			$data .= 		
	        '<tr>
				<td class="'.$classname.'">'.($flagGroupby == $groupbyname ? "" : $datacol1).'</td>
				<td>'.$datacol2.'</td>
				<td class="number">'.$this->sidlib->my_format($value->qty).'</td>
				<td class="number">'.$this->sidlib->my_format($value->jumlahbayar).'</td>
			</tr>';
			$flagGroupby = $groupbyname;
			$totalbayar += $value->jumlahbayar;
			$grandtotal += $value->jumlahbayar;
			$no++;
		}

		//Group Total && Grand Total
		if ($no > 0) {
			$data .= 
			'<tr>
				<td class="nonebuttom"></td>
				<td class="nonebuttom" colspan="2"></td>
				<td class="number"><b>'.$this->sidlib->my_format($totalbayar).'</b></td>
			</tr>';

			//Grand Total
			$data .= 
			'<tr>
				<td class="nonebuttom footer" colspan="4" >GRAND TOTAL : '.$this->sidlib->my_format($grandtotal).'</td>
			</tr>';
		}

		//Generate Table Header
		$headercol1 = $groupby == 0 ? 'Jenis Penerimaan' : 'Tanggal';
		$headercol2 = $groupby == 1 ? 'Jenis Penerimaan' : 'Tanggal';
		$texthtml = $this->style.
		'<table cellspacing="0" cellpadding="2" border="1">
    		<tr>
    			<th width="35%" class="vcenter">'.$headercol1.'</th>
    			<th width="35%" class="vcenter">'.$headercol2.'</th>
    			<th width="10%" class="vcenter">Qty</th>
    			<th width="20%" class="vcenter">Total Bayar</th>
    		</tr> '.$data.
    	'</table>';
    	$this->pdf->Ln(2);
    	$this->pdf->writeHTML($texthtml, true, true, true, true);//, false, true, 'R', true);

		//Generate PDF file
		ob_end_clean();
		$this->pdf->Output('Rekap_penerimaanuang.pdf', 'I');		


	}
}
?>