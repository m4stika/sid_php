<?php 
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Daftar_typerumah extends Reportpdf
{	
	public function __construct()
	{
		parent::__construct();		
		$this->load->model('report_model');
		
	}
	
	public function index() {
		$this->report_model->table = 'typerumah';
		$this->report_model->column_select = 'noid, typerumah, keterangan, hargajual, bookingfee';
		$this->report_model->column_index = 'noid';
		$list = $this->report_model->find_all();
		$parameter = $this->report_model->get_parameter();

		//Get Record Item
		$data = '';
		foreach ($list as $value) {
	        $data .= 
	        '<tr>
				<td class="number">'.$value->noid.'</td>
				<td>'.$value->typerumah.'</td>
				<td>'.$value->keterangan.'</td>
				<td class="number">'.$this->sidlib->my_format($value->hargajual).'</td>
				<td class="number">'.$this->sidlib->my_format($value->bookingfee).'</td>
			</tr>';
        }

        //Generate HTML Output
		$html = $this->style.
			'<h1 class="title">Daftar <i>Type Rumah</i></h1>
			<div class="address">
				<strong>'.$parameter->company.'</strong><br/>
				'.$parameter->address.'<br/>
				'.$parameter->city.'
			</div>
			<table cellspacing="0" cellpadding="2" border="1">
				<tr>
        			<th width="5%">#ID</th>
            		<th width="20%">Type Rumah</th>
            		<th width="35%">Keterangan</th>
            		<th width="20%" class="number">Harga Jual</th>
            		<th width="20%" class="number">Booking Fee</th>
        		</tr>'.$data.'
        	</table>';

        //Generate PDF file
		$this->pdf->AddPage();
		$this->generatePdf($html, 'typerumah.pdf');
	}	
}
?>