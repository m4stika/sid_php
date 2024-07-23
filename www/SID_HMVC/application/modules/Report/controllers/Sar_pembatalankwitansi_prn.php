<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sar_pembatalankwitansi_prn extends MX_Controller {

	public function __construct()
	{
		parent::__construct();		
		$this->load->library('Sidlib','sidlib');
		$this->load->model('Pemasaran_model','report_model');
	}

	public function index() {
		//$header = array('ID', 'Type','Harga Jual', 'Booking Fee', 'Diskon', 'Uang Muka','Plafon KPR','Sudut', 'Hadap Jalan','Fasum');
		$recordobject = $this->report_model->get_LapPembatalanKwitansi();
		$parameter = $this->report_model->get_parameter();
		$dataheader = $this->sidlib->setHeader_prn($parameter);
		$caption = 'Laporan Pembatalan Kwitansi';
		$orientation = 'A4';
		
		$data = "<div class='title underline'>{$caption}</div>
				<div class='subtitle'>".date_format(date_create($this->input->post('periode')), "d-M-Y").' s/d '.date_format(date_create($this->input->post('periode1')), "d-M-Y")."</div>";
				
		$data .= "<table class='{$orientation}'>
				<thead>
				<tr>
	        		<th width='20%'>Tgl Batal</th>
	    			<th width='15%'>Kwitansi</th>
	    			<th width='15%'>No. Pesanan</th>
	    			<th width='35%'>Konsumen</th>
	    			<th width='15%'>Jumlah</th>
	    		</tr>
            	</thead>";

        $grandtotal=0;	
        $data .= "<tbody>";
        foreach($recordobject as $value) {
	        $grandtotal += $value->totaltransaksi;
	        $data .= 
	        	"<tr>
				<td>".date_format(date_create($value->tglbatal), "d-M-Y")."</td>
				<td>{$value->nokwitansi}</td>
				<td>{$value->nopesanan}</td>
				<td>{$value->namapemesan}</td>
				<td class='text-right'>".$this->sidlib->my_format($value->totaltransaksi)."</td>	
			</tr>";
    	}
    	$data .= "</tbody>";
    	$data .= 
    		"<tfoot>
    			<tr>
    				<td colspan='4' class='text-right'>TOTAL</td>
    				<td class='text-right'>".$this->sidlib->my_format($grandtotal)."</td>
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