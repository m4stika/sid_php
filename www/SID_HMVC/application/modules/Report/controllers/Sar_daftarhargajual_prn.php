<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sar_daftarhargajual_prn extends MX_Controller {

	public function __construct()
	{
		parent::__construct();		
		$this->load->library('Sidlib','sidlib');
		$this->load->model('Pemasaran_model','report_model');
	}

	public function index() {
		//$header = array('ID', 'Type','Harga Jual', 'Booking Fee', 'Diskon', 'Uang Muka','Plafon KPR','Sudut', 'Hadap Jalan','Fasum');
		$recordobject = $this->report_model->get_Sar_Hargajual();
		$parameter = $this->report_model->get_parameter();
		$dataheader = $this->sidlib->setHeader_prn($parameter);
		$caption = 'Daftar Harga Jual';
		$orientation = 'A4 landscape';
		
		$data = "<h1 class='title'>{$caption}</h1>";
		$data .= "<table class='{$orientation}'>
				<thead> <tr>
        			<th width='5%' rowspan='2'>ID</th>
            		<th width='15%' rowspan='2'>Type</th>
            		<th width='10%' rowspan='2'>Harga Jual</th>
            		<th width='10%' rowspan='2'>Booking Fee</th>
            		<th width='10%' rowspan='2'>Diskon</th>
            		<th width='10%' rowspan='2'>Uang Muka</th>
            		<th width='10%' rowspan='2'>Plafon KPR</th>
            		<th width='30%' colspan='3'>Posisi</th>
        		</tr>
        		<tr>
        			<th>Sudut</th>
            		<th>Hadap Jalan</th>
            		<th>Fasum</th>
            	</tr> 
            	</thead>
            	<tbody>";

        foreach($recordobject as $value) {
	        $data .= 
	        	"<tr>
	        		<td>{$value->noid}</td>
	        		<td>{$value->typerumah}</td>
	        		<td class='number'>{$this->sidlib->my_format($value->hargajual)}</td>
	        		<td class='number'>{$this->sidlib->my_format($value->bookingfee)}</td>
	        		<td class='number'>{$this->sidlib->my_format($value->diskon)}</td>
	        		<td class='number'>{$this->sidlib->my_format($value->uangmuka)}</td>
	        		<td class='number'>{$this->sidlib->my_format($value->plafonkpr)}</td>
	        		<td class='number'>{$this->sidlib->my_format($value->hargasudut)}</td>
	        		<td class='number'>{$this->sidlib->my_format($value->hargahadapjalan)}</td>
	        		<td class='number'>{$this->sidlib->my_format($value->hargafasum)}</td>
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