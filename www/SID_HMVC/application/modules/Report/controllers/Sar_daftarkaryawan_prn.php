<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sar_daftarkaryawan_prn extends MX_Controller {

	public function __construct()
	{
		parent::__construct();		
		$this->load->library('Sidlib','sidlib');
		$this->load->model('Pemasaran_model','report_model');
	}

	public function index() {
		$recordobject = $this->report_model->get_Sar_DaftarKaryawan();
		$parameter = $this->report_model->get_parameter();
		$dataheader = $this->sidlib->setHeader_prn($parameter);
		$caption = 'Daftar Karyawan';
		$orientation = 'A4';
		
		$data = "<h1 class='title'>{$caption}</h1>";
		$data .= "<table class='{$orientation}'>
				<thead> <tr>
        			<th width='15%'>ID</th>
            		<th width='25%'>Nama</th>
            		<th width='40%'>Alamat</th>
        		</tr>
        		</thead
        		<tbody>";
        		
        foreach($recordobject as $value) {
	        $data .= 
	        	"<tr>
	        		<td>{$value->noid}</td>
	        		<td>{$value->nama}</td>
	        		<td>{$value->alamat}</td>
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