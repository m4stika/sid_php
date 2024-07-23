<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class sar_typerumah_prn extends MX_Controller {

	public function __construct()
	{
		parent::__construct();		
		$this->load->library('Sidlib','sidlib');
		$this->load->model('Pemasaran_model','report_model');
	}

	public function index() {
		$recordobject = $this->report_model->get_Sar_Typerumah();
		$parameter = $this->report_model->get_parameter();
		$dataheader = $this->sidlib->setHeader_prn($parameter);
		$caption = 'Daftar Type Rumah';
		$orientation = 'A4';

		$data = "<h1 class='title'>{$caption}</h1>";
		$data .= "<table class='{$orientation}'>
				<thead> <tr>
        			<th width='5%'>#ID</th>
            		<th width='20%'>Type</th>
            		<th width='30%'>Keterangan</th>
            		<th width='15%'>LT</th>
            		<th width='15%'>LB</th>
            		<th width='15%'>Hrg Jual</th>
        		</thead></tr>
				<tbody>
        		";
        		
        foreach($recordobject as $value) {
	        $data .= 
	        	"<tr>
	        		<td>{$value->noid}</td>
			        <td>{$value->typerumah}</td>
			        <td>{$value->keterangan}</td>
			        <td class='number'>{$value->luasbangunan}</td>
			        <td class='number'>{$value->luastanah}</td>
			        <td class='number'>{$this->sidlib->my_format($value->hargajual)}</td>
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