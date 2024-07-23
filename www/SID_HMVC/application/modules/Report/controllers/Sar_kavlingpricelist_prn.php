<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sar_kavlingpricelist_prn extends MX_Controller {

	public function __construct()
	{
		parent::__construct();		
		$this->load->library('Sidlib','sidlib');
		$this->load->model('Pemasaran_model','report_model');
	}

	public function index() {
		$masterkavling = $this->report_model->get_Sar_Kavlingpricelist();
		$parameter = $this->report_model->get_parameter();
		$dataheader = $this->sidlib->setHeader_prn($parameter);
		$caption = 'Kavling Price List';
		$orientation = 'A4 landscape';
		$data = "<h1 class='title'>{$caption}</h1>";

		$DataItem = array(	"value" => array('ID', 'Status', 'Blok/Kavling','Hrg Dasar', 'Diskon','Hrg KLT','Hrg Sudut', 'Hrg Hadap Jln','Hrg Fasum','Total Harga','Booking Fee','Uang Muka'),
        					"width" =>array(3, 8, 8, 9, 9, 9, 9, 9, 9, 9, 9, 9),
	        				"classname" =>array('','','','number','number','number','number','number','number','number','number','number')
	        			);
		$data .= "<table class='{$orientation}'> 
				<thead>
					<tr>";
						for ($i=0; $i < count($DataItem['value']) ; $i++) { 
							$data .= "<th width='{$DataItem['width'][$i]}%'>{$DataItem['value'][$i]}</th>";
						}
		$data .= "	</tr>
				</thead>";
		
		$data .= "<tbody> <tr>";
	        foreach($masterkavling as $value) {
		        $DataItem['value'] = array($value->noid, STATUS_BOOKING[$value->statusbooking], $value->blok.' - '.$value->nokavling,  $this->sidlib->my_format($value->hargajual), $this->sidlib->my_format($value->diskon), $this->sidlib->my_format($value->hargakltm2), $this->sidlib->my_format($value->hargasudut), $this->sidlib->my_format($value->hargahadapjalan), $this->sidlib->my_format($value->hargafasum), $this->sidlib->my_format($value->totalharga), $this->sidlib->my_format($value->bookingfee), $this->sidlib->my_format($value->uangmuka));
		        for ($i=0; $i < count($DataItem['value']) ; $i++) { 
					$data .= "<td class='{$DataItem['classname'][$i]}'>{$DataItem['value'][$i]}</td>";
				}
				$data .= "</tr>";
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