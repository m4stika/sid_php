<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sar_masterkavling_prn extends MX_Controller {

	public function __construct()
	{
		parent::__construct();		
		$this->load->library('Sidlib','sidlib');
		$this->load->model('Pemasaran_model','report_model');
	}

	public function index() {
		$masterkavling = $this->report_model->get_Sar_Masterkavling();
		$parameter = $this->report_model->get_parameter();
		$dataheader = $this->sidlib->setHeader_prn($parameter);
		$caption = 'Master Kavling';
		$orientation = 'A4';
		
		$data = "<h1 class='title'>{$caption}</h1>";
		$data .= "<table class='{$orientation}'>
				<thead> <tr>
        			<th width='5%' rowspan='2'>ID</th>
            		<th width='15%' rowspan='2'>Blok</th>
            		<th width='10%' rowspan='2'>No. Kavling</th>
            		<th width='10%' rowspan='2'>Status</th>
            		<th width='10%' rowspan='2'>LB (m2)</th>
            		<th width='10%' rowspan='2'>LT (m2)</th>
            		<th width='10%' rowspan='2'>KLT (m2)</th>
            		<th width='30%' colspan='3'>Posisi</th>
        		</tr>
        		<tr>
        			<th>Sudut</th>
            		<th>Hadap Jalan</th>
            		<th>Fasum</th>
            	</tr>
            	</thead>";
       
        $data .= "<tbody>";
	        foreach($masterkavling as $value) {
		        $data .=
		        	"<tr>
		        		<td>{$value->noid}</td>
		        		<td>{$value->blok}</td>
		        		<td>{$value->nokavling}</td>
		        		<td>{$this->sidlib->StatusBookingName($value->statusbooking)}</td>
		        		<td class='number'>{$this->sidlib->my_format($value->luasbangunan)}</td>
		        		<td class='number'>{$this->sidlib->my_format($value->luastanah)}</td>
		        		<td class='number'>{$this->sidlib->my_format($value->kelebihantanah)}</td>
		        		<td class='number'>".($value->sudut==1 ? 'Y':'T')."</td>
		        		<td class='number'>".($value->hadapjalan==1 ? 'Y':'T')."</td>
		        		<td class='number'>".($value->kelebihantanah==1 ? 'Y':'T')."</td>
		        	</tr>";
	    	}
    	$data .= "</tbody></table>";
    	$data = array('title'		=> $caption,
					  'record'		=> $data,
					  'header'=>$dataheader,
					  'orientation' => $orientation
					  );
		$this->load->view('Report/laporan_print',$data);
    }
}	
?>