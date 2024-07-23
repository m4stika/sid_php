<?php 
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Daftar_penerimaanuang extends Reportpdf {

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
		$this->pdf->SetTitle('SID | Rincian Penerimaan Uang');
		$this->pdf->AddPage();

		// Judul Laporan
		$this->pdf->SetFont('','B',16);
		$this->pdf->SetTextColor(0,44,163);
		$this->pdf->Cell(50, 0,''); //267
		$this->pdf->Cell(80, 0, 'Rincian Penerimaan Uang', 'B', $ln=1, 'C', 0, '', 4, false, 'C', 'B');
		$this->pdf->SetFont('','',10);
		$this->pdf->SetTextColor(0,0,0);
		$this->pdf->Cell(50, 0,'');
		$this->pdf->Cell(80, 0, date_format($periode, "d-M-Y").' s/d '.date_format($periode1, "d-M-Y"), '', $ln=1, 'C', 0, '', 0, false, 'T', 'T');

		//Generate Table Data
		$groupby = $this->input->post('groupby'); //0=jenispenerimaan, 1=tglbayar
		$order = $groupby == 0 ? 'r.jenispenerimaan, r.tglbayar' : 'r.tglbayar, r.jenispenerimaan';
		$record = $this->report_model->get_DaftarPenerimaanUang($order);
		$data = '';
		$flagGroupby = '';
		$no = 0;
		$totalbayar = 0;
		$grandtotal = 0;

		foreach ($record as $value) {
			$tglbayar = date_create($value->tglbayar);
			$classname = 'none';
			$groupbyname = $groupby == 0 ? $value->jenispenerimaan : $value->tglbayar;
			$datagroup = $groupby == 0 ? $value->namapenerimaan : date_format($tglbayar, "d-M-Y");
			$datacol1 = $groupby == 0 ? date_format($tglbayar, "d-M-Y") : $value->namapenerimaan;

			//Group Total
			if ($no != 0 &&  $flagGroupby != $groupbyname) {
				$data .= 
				'<tr>
					<td class="" colspan="4"></td>
					<td class="number"><b>'.$this->sidlib->my_format($totalbayar).'</b></td>
				</tr>';
				$no=0;
				$totalbayar = 0;
			}

			//Group Header
			if ($flagGroupby != $groupbyname) {
				$data .= 
				'<tr>
					<td class="" colspan="5">'.$datagroup.'</td>
				</tr>';
			}

			$data .= 		
	        '<tr>
				<td class="'.$classname.'">'.($flagGroupby == $groupbyname ? $datacol1 : $datacol1).'</td>
				<td class="none">'.$value->nokwitansi.'</td>
				<td class="none">'.$value->namapemesan.'</td>
				<td class="none">'.$value->description.'</td>
				<td class="none number">'.$this->sidlib->my_format($value->jumlahbayar).'</td>
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
				<td class="" colspan="4"></td>
				<td class="number"><b>'.$this->sidlib->my_format($totalbayar).'</b></td>
			</tr>';

			//Grand Total
			$data .= 
			'<tr>
				<td class="nonebuttom footer" colspan="5">GRAND TOTAL : '.$this->sidlib->my_format($grandtotal).'</td>
			</tr>';
		}

		

		//Generate Table Header
		$headercol1 = $groupby == 1 ? 'Jenis Penerimaan' : 'Tanggal';
		$texthtml = $this->style.
		'<table cellspacing="0" cellpadding="2" border="1">
    		<tr>
    			<th width="20%" class="vcenter">'.$headercol1.'</th>
    			<th width="15%" class="vcenter">Kwitansi</th>
    			<th width="20%" class="vcenter">Konsumen</th>
    			<th width="30%" class="vcenter">Keterangan</th>
    			<th width="15%" class="vcenter">Jumlah</th>
    		</tr> '.$data.
    	'</table>';
    	$this->pdf->Ln(2);
    	$this->pdf->writeHTML($texthtml, true, true, true, true);//, false, true, 'R', true);

		//Generate PDF file
		ob_end_clean();
		$this->pdf->Output('Daftar_penerimaanuang.pdf', 'I');		


	}
}
?>