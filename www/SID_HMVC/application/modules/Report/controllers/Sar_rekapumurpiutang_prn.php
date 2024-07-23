<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sar_rekapumurpiutang_prn extends MX_Controller {

	public function __construct()
	{
		parent::__construct();		
		$this->load->library('Sidlib','sidlib');
		$this->load->model('Pemasaran_model','report_model');
	}

	public function index() {
		//$header = array('ID', 'Type','Harga Jual', 'Booking Fee', 'Diskon', 'Uang Muka','Plafon KPR','Sudut', 'Hadap Jalan','Fasum');
		$recordobject = $this->report_model->get_RekapitulasiUmurpiutang();
		$parameter = $this->report_model->get_parameter();
		$dataheader = $this->sidlib->setHeader_prn($parameter);
		$caption = 'Rekapitulasi Umur Piutang';
		$orientation = 'A4 landscape';
		
		$data = "<div class='title underline'>{$caption}</div>
				<div class='subtitle'>".date_format(date_create($this->input->post('periode')), "d-M-Y").' s/d '.date_format(date_create($this->input->post('periode1')), "d-M-Y")."</div>";
				
		$data .= "<table class='{$orientation}'>
				<thead>
				<tr>	
        			<th width='9%' rowspan='2'>Pola Pembayaran<br/>Konsumen<br/>Kavling</th>
        			<th width='9%' rowspan='2'>Tgl. Transaksi<br/>Status<br/>Tgl Akad</th>
        			<th width='36%' colspan='4'>Rincian Harga</th>
        			<th width='36%' colspan='4'>Rincian Pembayaran</th>
        			<th width='9%' rowspan='2'>Piutang<br/>Terbayar<br/>Saldo</th>
        		</tr>
        		<tr>
        			<th>Hrg Dasar<br/>Plafon KPR<br/>Uang Muka</th>
        			<th>Booking Fee<br/>KLT<br/>Sudut</th>
        			<th>Hadap Jalan<br/>Fasum<br/>Redesign</th>
        			<th>+ Kwalitas<br/>+Kontruksi</th>
        			<th>Uang Muka<br/>Booking Fee<br/>KLT</th>
        			<th>Sudut<br/>Hadap Jalan<br/>Fasum</th>
        			<th>Redesign<br/>+ Kwalitas<br/>+ Kontruksi</th>
        			<th>Harga Dasar</th>
            	</tr>
            	</thead>";

        	$data .= "<tbody>";
        foreach($recordobject as $value) {
	        $data .= 
	        	"<tr>
	        		<td class='border-bottom'>{$value->nopesanan}<br/>{$value->namapemesan}<br/>{$value->blok}-{$value->nokavling}</td>
	        		
	        		<td class='border-bottom'>".date_format(date_create($value->tgltransaksi), "d-M-Y")."<br/>{$value->ketstatusbooking}<br/>".date_format(date_create($value->tglakadkredit), "d-M-Y")."</td>
	        		<td class='border-bottom text-right'>".$this->sidlib->my_format($value->hargajual)."<br/>".$this->sidlib->my_format($value->plafonkpr)."<br/>".$this->sidlib->my_format($value->totaluangmuka)."</td>
	        		<td class='border-bottom text-right'>".$this->sidlib->my_format($value->bookingfee)."<br/>".$this->sidlib->my_format($value->hargaklt)."<br/>".$this->sidlib->my_format($value->hargasudut)."</td>
	        		<td class='border-bottom text-right'>".$this->sidlib->my_format($value->hargahadapjalan)."<br/>".$this->sidlib->my_format($value->hargafasum)."<br/>".$this->sidlib->my_format($value->hargaredesign)."</td>
	        		<td class='border-bottom text-right'>".$this->sidlib->my_format($value->hargatambahkwalitas)."<br/>".$this->sidlib->my_format($value->hargapekerjaantambah)."</td>
	        		<td class='border-bottom text-right'>".$this->sidlib->my_format($value->lunasuangmuka)."<br/>".$this->sidlib->my_format($value->bookingfeebyr)."<br/>".$this->sidlib->my_format($value->hargakltbyr)."</td>
	        		<td class='border-bottom text-right'>".$this->sidlib->my_format($value->hargasudutbyr)."<br/>".$this->sidlib->my_format($value->hargahadapjalanbyr)."<br/>".$this->sidlib->my_format($value->hargafasumbyr)."</td>
	        		<td class='border-bottom text-right'>".$this->sidlib->my_format($value->hargaredesignbyr)."<br/>".$this->sidlib->my_format($value->hargatambahkwbyr)."<br/>".$this->sidlib->my_format($value->hargakerjatambahbyr)."</td>
	        		<td class='border-bottom text-right'>".$this->sidlib->my_format($value->totalhargabyr)."</td>
	        		<td class='border-bottom text-right'>".$this->sidlib->my_format($value->totalbayar)."<br/>".$this->sidlib->my_format($value->totalbayartitipan)."<br/>".$this->sidlib->my_format($value->totalhutang)."</td>
	        	</tr>";
    	}
    	$data .= "</tbody>";

    	$arPenj = json_decode(json_encode($recordobject),TRUE);
    	$data .= 
    		"<tfoot>
    			<tr>
    				<td colspan='2' class='text-right'>TOTAL</td>
    				<td class='text-right'>".$this->sidlib->SumObject($arPenj, 'hargajual')."<br/>".$this->sidlib->SumObject($arPenj, 'plafonkpr')."<br/>".$this->sidlib->SumObject($arPenj, 'totaluangmuka')."</td>
    				<td class='text-right'>".$this->sidlib->SumObject($arPenj, 'bookingfee')."<br/>".$this->sidlib->SumObject($arPenj, 'hargaklt')."<br/>".$this->sidlib->SumObject($arPenj, 'hargasudut')."</td>
    				<td class='text-right'>".$this->sidlib->SumObject($arPenj, 'hargahadapjalan')."<br/>".$this->sidlib->SumObject($arPenj, 'hargafasum')."<br/>".$this->sidlib->SumObject($arPenj, 'hargaredesign')."</td>
    				<td class='text-right'>".$this->sidlib->SumObject($arPenj, 'hargatambahkwalitas')."<br/>".$this->sidlib->SumObject($arPenj, 'hargapekerjaantambah')."</td>
    				<td class='text-right'>".$this->sidlib->SumObject($arPenj, 'lunasuangmuka')."<br/>".$this->sidlib->SumObject($arPenj, 'bookingfeebyr')."<br/>".$this->sidlib->SumObject($arPenj, 'hargakltbyr')."</td>
    				<td class='text-right'>".$this->sidlib->SumObject($arPenj, 'hargasudutbyr')."<br/>".$this->sidlib->SumObject($arPenj, 'hargahadapjalanbyr')."<br/>".$this->sidlib->SumObject($arPenj, 'hargafasumbyr')."</td>
    				<td class='text-right'>".$this->sidlib->SumObject($arPenj, 'hargaredesignbyr')."<br/>".$this->sidlib->SumObject($arPenj, 'hargatambahkwbyr')."<br/>".$this->sidlib->SumObject($arPenj, 'hargakerjatambahbyr')."</td>
    				<td class='text-right'>".$this->sidlib->SumObject($arPenj, 'totalhargabyr')."</td>
    				<td class='text-right'>".$this->sidlib->SumObject($arPenj, 'totalbayar')."<br/>".$this->sidlib->SumObject($arPenj, 'totalbayartitipan')."<br/>".$this->sidlib->SumObject($arPenj, 'totalhutang')."</td>
				</tr>
    		</tfoot>";

    	$data .= "</table>";
    	$data = array('title'		=> $caption,
					  'record'		=> $data,
					  'header'=>$dataheader,
					  'orientation' => $orientation
					  );
		$this->load->view('Report/laporan_print',$data);
    }
}	