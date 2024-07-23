<?php 
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Daftar_hargajual extends Reportpdf
{	
	public function __construct()
	{
		parent::__construct();		
		$this->load->model('report_model');
		
	}
	
	public function index() {
		$this->report_model->table = 'typerumah';
		$this->report_model->column_select = 'noid, typerumah, hargajual, bookingfee, diskon, uangmuka, plafonkpr, hargasudut, hargahadapjalan, hargafasum';
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
				<td class="number">'.$this->sidlib->my_format($value->hargajual).'</td>
				<td class="number">'.$this->sidlib->my_format($value->bookingfee).'</td>
				<td class="number">'.$this->sidlib->my_format($value->diskon).'</td>
				<td class="number">'.$this->sidlib->my_format($value->uangmuka).'</td>
				<td class="number">'.$this->sidlib->my_format($value->plafonkpr).'</td>
				<td class="number">'.$this->sidlib->my_format($value->hargasudut).'</td>
				<td class="number">'.$this->sidlib->my_format($value->hargahadapjalan).'</td>
				<td class="number">'.$this->sidlib->my_format($value->hargafasum).'</td>
			</tr>';
        }

        //Generate HTML Output
		$html = $this->style.
			'<h1 class="title">Daftar <i>Harga Jual</i></h1>
			<div class="address">
				<strong>'.$parameter->company.'</strong><br/>
				'.$parameter->address.'<br/>
				'.$parameter->city.'
			</div>
			<br/>
			<table cellspacing="0" cellpadding="2" border="1">
				<tr>
        			<th rowspan = "2" class="vcenter">#ID</th>
            		<th rowspan = "2" class="vcenter">Type Rumah</th>
            		<th rowspan = "2" class="vcenter number">Harga Jual</th>
            		<th rowspan = "2" class="vcenter number">Booking Fee</th>
            		<th rowspan = "2" class="vcenter number">Diskon</th>
            		<th rowspan = "2" class="vcenter number">Uang Muka</th>
            		<th rowspan = "2" class="vcenter number">Plafon KPR</th>
            		<th colspan = "3" class="vtop">Posisi</th>
        		</tr>
        		<tr>
            		<th class="number">Sudut</th>
            		<th class="number">Hadap Jalan</th>
            		<th class="number">Fasum</th>
        		</tr>'.$data.'				
        	</table>';

        //Generate PDF file
        $this->pdf->AddPage($orientation='L');
		$this->generatePdf($html, 'masterhargajual.pdf');	
	}
}
?>