<?php 
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Daftar_karyawan extends Reportpdf
{		
	public function __construct()
	{
		parent::__construct();		
		$this->load->model('report_model');
		
	}
	
	public function index() {
		$this->report_model->table = 'karyawan';
		$this->report_model->column_select = 'noid, nama, alamat';
		$this->report_model->column_index = 'noid';
		$list = $this->report_model->find_all();
		$parameter = $this->report_model->get_parameter();
		//$search = $_REQUEST['item'];
		$search = $this->input->post('item');//.'-'.$this->input->post('tahun');
			
			//Get Record Item
			$data = '';
			foreach ($list as $value) {
		    	$data .= 
		    	'<tr>
		    		<td>'.$value->noid.'</td>
			        <td>'.$value->nama.'</td>
			        <td>'.$value->alamat.'</td>
			    </tr>';
			}

			//Generate HTML Output
			$html = $this->style.
			'<h1 class="title">Daftar <i>Karyawan </i>'.$search.'</h1>
			<div class="address">
				<strong>'.$parameter->company.'</strong><br/>
				'.$parameter->address.'<br/>
				'.$parameter->city.'
			</div>
			<table cellspacing="0" cellpadding="2" border="1">
				<tr>
					<th>Kode Pegawai</th>
			    	<th>Nama Pegawai</th>
			    	<th>Alamat</th>
				</tr>'.$data.
			'</table>';

			//Generate PDF file
			$this->pdf->AddPage();
			$this->generatePdf($html, 'karyawan.pdf');
	}
}