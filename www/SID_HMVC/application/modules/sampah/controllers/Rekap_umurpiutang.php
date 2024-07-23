<?php 
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Rekap_umurpiutang extends Reportpdf {

	public function __construct()
	{
		parent::__construct();		
		$this->load->model('report_model');
	}

	public function index() {
		$periode = date_create($this->input->post('periode'));
		$periode1 = date_create($this->input->post('periode1'));
		$parameter = $this->report_model->get_parameter();
		
		// Generate Report Title
		$this->pdf->SetMargins(5, PDF_MARGIN_TOP, 5);  
		$this->pdf->setCellHeightRatio(1.8);
		$this->pdf->SetTitle('SID | Umur Piutang');
		$this->pdf->AddPage('L');
		
		// Generate Report Header
		$this->pdf->SetFont('','B',20);
		$this->pdf->SetTextColor(0,44,163);
		$this->pdf->Cell(90, 0,''); //267
		$this->pdf->Cell(80, 0, 'Rekapitulasi Umur Piutang', 'B', $ln=1, 'C', 0, '', 4, false, 'C', 'B');
		$this->pdf->SetFont('','',10);
		$this->pdf->SetTextColor(0,0,0);
		$this->pdf->Cell(90, 0,'');
		$this->pdf->Cell(80, 0, date_format($periode, "d-M-Y").' s/d '.date_format($periode1, "d-M-Y"), '', $ln=1, 'C', 0, '', 0, false, 'T', 'T');

		//Generate Table Header
		$tableHeader = 
			'<tr>
        		<th rowspan="2" width="15%" class="vcenter left"><br/>Pola Bayar <br/> Konsumen <br/> Kavling</th>
        		<th rowspan="2" class="vcenter" width="8%">Tgl Transaksi <br/> Status <br/> Tgl Akad</th>
        		<th colspan="4" class="vcenter" width="33%">Rincian Harga</th>
        		<th colspan="4" class="vcenter" width="33%">Rincian Pembayaran</th>
        		<th rowspan="2" class="vcenter number" width="10%">Piutang <br/> Terbayar <br/><b> Saldo</b></th>
    		</tr>
    		<tr>
    			<th class="vcenter">Harga Dasar<br/>Plafon KPR<br/>Uang Muka</th>
    			<th class="vcenter">Booking Fee<br/>KLT<br/>Sudut</th>
    			<th class="vcenter">Hadap Jalan<br/>Fasum<br/>Redesign</th>
    			<th class="vcenter">+Kwalitas<br/>+Kontruksi</th>
    			<th class="vcenter">Uang Muka<br/>Booking Fee<br/>KLT</th>
    			<th class="vcenter">Sudut<br/>Hadap Jalan<br/>Fasum</th>
    			<th class="vcenter">Redesign<br/>+Kwalitas<br/>+Kontruksi</th>
    			<th class="vcenter">Harga Dasar</th>
    		</tr>';

    	//Generate Table Data
    	$tableData = '';
    	$polapembayaran = array("KPR","Tunai Keras","Tunai Bertahap");
    	$grandtotal = array('hargajual'=>0, 'plafonkpr'=>0, 'totaluangmuka'=>0,
							'bookingfee'=>0, 'hargaklt'=>0, 'hargasudut'=>0,
							'hargahadapjalan'=>0, 'hargafasum'=>0, 'hargaredesign'=>0,
							'hargatambahkwalitas'=>0, 'hargapekerjaantambah'=>0,
							'lunasuangmuka'=>0, 'bookingfeebyr'=>0, 'hargakltbyr'=>0,
							'hargasudutbyr'=>0, 'hargahadapjalanbyr'=>0, 'hargafasumbyr'=>0,
							'hargaredesignbyr'=>0, 'hargatambahkwbyr'=>0, 'hargakerjatambahbyr'=>0,
							'totalhargabyr'=>0, 'totalbayar'=>0, 'totalbayartitipan'=>0, 'totalhutang'=>0
							);
    	$record = $this->report_model->get_RekapitulasiUmurpiutang();
    	foreach ($record as $value) {
    		$grandtotal['hargajual'] += $value->hargajual;
	        $grandtotal['plafonkpr'] += $value->plafonkpr;
	        $grandtotal['totaluangmuka'] += $value->totaluangmuka;

	        $grandtotal['bookingfee'] += $value->bookingfee;
	        $grandtotal['hargaklt'] += $value->hargaklt;
	        $grandtotal['hargasudut'] += $value->hargasudut;

	        $grandtotal['hargahadapjalan'] += $value->hargahadapjalan;
	        $grandtotal['hargafasum'] += $value->hargafasum;
	        $grandtotal['hargaredesign'] += $value->hargaredesign;

	        $grandtotal['hargatambahkwalitas'] += $value->hargatambahkwalitas;
	        $grandtotal['hargapekerjaantambah'] += $value->hargapekerjaantambah;
	        
	        $grandtotal['lunasuangmuka'] += $value->lunasuangmuka;
	        $grandtotal['bookingfeebyr'] += $value->bookingfeebyr;
	        $grandtotal['hargakltbyr'] += $value->hargakltbyr;

	        $grandtotal['hargasudutbyr'] += $value->hargasudutbyr;
	        $grandtotal['hargahadapjalanbyr'] += $value->hargahadapjalanbyr;
	        $grandtotal['hargafasumbyr'] += $value->hargafasumbyr;

	        $grandtotal['hargaredesignbyr'] += $value->hargaredesignbyr;
	        $grandtotal['hargatambahkwbyr'] += $value->hargatambahkwbyr;
	        $grandtotal['hargakerjatambahbyr'] += $value->hargakerjatambahbyr;

	        $grandtotal['totalhargabyr'] += $value->totalhargabyr;
	        $grandtotal['totalbayar'] += $value->totalbayar;
	        $grandtotal['totalbayartitipan'] += $value->totalbayartitipan;
	        $grandtotal['totalhutang'] += $value->totalhutang;

    		$tgltransaksi = date_create($value->tgltransaksi);
	        $tglakad = date_create($value->tglakadkredit);
	        $tableData .= 
	        '<tr>
				<td>'.$polapembayaran[$value->polapembayaran].'<br/>'.$value->namapemesan.'<br/>'.$value->blok.' - '.$value->nokavling.'</td>
				<td>'.date_format($tgltransaksi, "d-M-Y").'<br/><b>'.$value->ketstatusbooking.'</b><br/>'.date_format($tglakad, "d-M-Y").'</td>
				<td class="number">'.$this->sidlib->my_format($value->hargajual).'<br/>'.$this->sidlib->my_format($value->plafonkpr).'<br/>'.$this->sidlib->my_format($value->totaluangmuka).'</td>
				<td class="number">'.$this->sidlib->my_format($value->bookingfee).'<br/>'.$this->sidlib->my_format($value->hargaklt).'<br/>'.$this->sidlib->my_format($value->hargasudut).'</td>
				<td class="number">'.$this->sidlib->my_format($value->hargahadapjalan).'<br/>'.$this->sidlib->my_format($value->hargafasum).'<br/>'.$this->sidlib->my_format($value->hargaredesign).'</td>
				<td class="number">'.$this->sidlib->my_format($value->hargatambahkwalitas).'<br/>'.$this->sidlib->my_format($value->hargapekerjaantambah).'</td>

				<td class="number">'.$this->sidlib->my_format($value->lunasuangmuka).'<br/>'.$this->sidlib->my_format($value->bookingfeebyr).'<br/>'.$this->sidlib->my_format($value->hargakltbyr).'</td>
				<td class="number">'.$this->sidlib->my_format($value->hargasudutbyr).'<br/>'.$this->sidlib->my_format($value->hargahadapjalanbyr).'<br/>'.$this->sidlib->my_format($value->hargafasumbyr).'</td>
				<td class="number">'.$this->sidlib->my_format($value->hargaredesignbyr).'<br/>'.$this->sidlib->my_format($value->hargatambahkwbyr).'<br/>'.$this->sidlib->my_format($value->hargakerjatambahbyr).'</td>
				<td class="number">'.$this->sidlib->my_format($value->totalhargabyr).'</td>

				<td class="number">'.$this->sidlib->my_format($value->totalbayar).'<br/>'.$this->sidlib->my_format($value->totalbayartitipan).'<br/><b>'.$this->sidlib->my_format($value->totalhutang).'</b></td>
			</tr>';
    	}

    	//Generate Footer
    	$tableData .=
    		'<tr>
    			<td colspan="2" class="number footer"><br/><br/>TOTAL</td>
    			<td class="number bold">'.$this->sidlib->my_format($grandtotal['hargajual']).'<br/>'.$this->sidlib->my_format($grandtotal['plafonkpr']).'<br/>'.$this->sidlib->my_format($grandtotal['totaluangmuka']).'</td>
    			<td class="number bold"> '.$this->sidlib->my_format($grandtotal['bookingfee']).'<br/>'.$this->sidlib->my_format($grandtotal['hargaklt']).'<br/>'.$this->sidlib->my_format($grandtotal['hargasudut']).'</td>
    			<td class="number bold"> '.$this->sidlib->my_format($grandtotal['hargahadapjalan']).'<br/>'.$this->sidlib->my_format($grandtotal['hargafasum']).'<br/>'.$this->sidlib->my_format($grandtotal['hargaredesign']).'</td>
    			<td class="number bold"> '.$this->sidlib->my_format($grandtotal['hargatambahkwalitas']).'<br/>'.$this->sidlib->my_format($grandtotal['hargapekerjaantambah']).'</td>
    			<td class="number bold"> '.$this->sidlib->my_format($grandtotal['lunasuangmuka']).'<br/>'.$this->sidlib->my_format($grandtotal['bookingfeebyr']).'<br/>'.$this->sidlib->my_format($grandtotal['hargakltbyr']).'</td>
    			<td class="number bold"> '.$this->sidlib->my_format($grandtotal['hargasudutbyr']).'<br/>'.$this->sidlib->my_format($grandtotal['hargahadapjalanbyr']).'<br/>'.$this->sidlib->my_format($grandtotal['hargafasumbyr']).'</td>
    			<td class="number bold"> '.$this->sidlib->my_format($grandtotal['hargaredesignbyr']).'<br/>'.$this->sidlib->my_format($grandtotal['hargatambahkwbyr']).'<br/>'.$this->sidlib->my_format($grandtotal['hargakerjatambahbyr']).'</td>
    			<td class="number bold"> '.$this->sidlib->my_format($grandtotal['totalhargabyr']).'</td>
    			<td class="number bold"> '.$this->sidlib->my_format($grandtotal['totalbayar']).'<br/>'.$this->sidlib->my_format($grandtotal['totalbayartitipan']).'<br/>'.$this->sidlib->my_format($grandtotal['totalhutang']).'</td>
			</tr>';

    	//Generate Html Output
    	$texthtml = $this->style.
    		'<table cellspacing="0" cellpadding="2" border="1">'
    			.$tableHeader
    			.$tableData.
    		'</table>';

		$this->pdf->Ln(2);
    	$this->pdf->writeHTML($texthtml, true, true, true, true);//, false, true, 'R', true);

		//Generate PDF file
		ob_end_clean();
		$this->pdf->Output('Rekap_umurpiutang.pdf', 'I');	
	}
}
?>