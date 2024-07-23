<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sar_pembatalan_prn extends MX_Controller {

	public function __construct()
	{
		parent::__construct();		
		$this->load->library('Sidlib','sidlib');
		$this->load->model('Pemasaran_model','report_model');
	}

	public function index() {
		//$header = array('ID', 'Type','Harga Jual', 'Booking Fee', 'Diskon', 'Uang Muka','Plafon KPR','Sudut', 'Hadap Jalan','Fasum');
		$recordobject = $this->report_model->get_LapPembatalan();
		$parameter = $this->report_model->get_parameter();
		$dataheader = $this->sidlib->setHeader_prn($parameter);
		$caption = 'Laporan Pembatalan';
		$orientation = 'A4 landscape';
		
		$data = "<div class='title underline'>{$caption}</div>
				<div class='subtitle'>".date_format(date_create($this->input->post('periode')), "d-M-Y").' s/d '.date_format(date_create($this->input->post('periode1')), "d-M-Y")."</div>";
				
		$data .= "<table class='{$orientation}'>
				<thead>
				<tr>
	        		<th rowspan='2' width='20%' class='text-left'>Tgl Batal <br/> No. Pesanan <br/> Konsumen</th>
	        		<th colspan='3' class='text-center' width='40%'>Penerimaan Uang</th>
	        		<th colspan='3' class='text-center' width='40%'>Pengembalian Uang</th>
	    		</tr>
	    		<tr>
	    			<th class='text-right'>Uang Muka<br/>KLT<br/>Sudut</th>
	    			<th class='text-right'>Hadap Jalan<br/>Fasum<br/>Redesign</th>
	    			<th class='text-right'>+Kwalitas<br/>+Kontruksi<br/><b>TOTAL</b></th>
	    			<th class='text-right'>Uang Muka<br/>KLT<br/>Sudut</th>
	    			<th class='text-right'>Hadap Jalan<br/>Fasum<br/>Redesign</th>
	    			<th class='text-right'>+Kwalitas<br/>+Kontruksi<br/><b>TOTAL</b></th>
	    		</tr>
            	</thead>";

        	$data .= "<tbody>";
        foreach($recordobject as $value) {
	        $data .= 
	        	"<tr>
				<td>".date_format(date_create($value->tglbatal), "d-M-Y")."<br/>".$value->nopesanan."<br/>".$value->namapemesan."</td>
				<td class='text-right'>".$this->sidlib->my_format($value->uangmukabyr)."<br/>".$this->sidlib->my_format($value->kltbyr)."<br/>".$this->sidlib->my_format($value->sudutbyr)."</td>
				<td class='text-right'>".$this->sidlib->my_format($value->hadapjalanbyr)."<br/>".$this->sidlib->my_format($value->fasumbyr)."<br/>".$this->sidlib->my_format($value->redesignbyr)."</td>
				<td class='text-right'>".$this->sidlib->my_format($value->tambahkwbyr)."<br/>".$this->sidlib->my_format($value->kerjatambahbyr)."<br/>".$this->sidlib->my_format($value->totalbayartitipan)."</td>
				<td class='text-right'>".$this->sidlib->my_format($value->uangmuka)."<br/>".$this->sidlib->my_format($value->klt)."<br/>".$this->sidlib->my_format($value->sudut)."</td>
				<td class='text-right'>".$this->sidlib->my_format($value->hadapjalan)."<br/>".$this->sidlib->my_format($value->fasum)."<br/>".$this->sidlib->my_format($value->redesign)."</td>
				<td class='text-right'>".$this->sidlib->my_format($value->tambahkw)."<br/>".$this->sidlib->my_format($value->kerjatambah)."<br/>".$this->sidlib->my_format($value->totalpengembalian)."</td>
			</tr>";
    	}
    	$data .= "</tbody>";
    	$data .= "</table>";
    	$data = array('title'		=> $caption,
					  'record'		=> $data,
					  'header'=>$dataheader,
					  'orientation' => $orientation
					  );
		$this->load->view('Report/laporan_print',$data);
    }
}	