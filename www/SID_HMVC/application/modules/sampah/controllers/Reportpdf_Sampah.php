<?php 
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Reportpdf extends Myreport
{	
	

	public function __construct()
	{
		parent::__construct();		
		$this->load->model('report_model');
		
	}
	
	public function lap_karyawan() {
		$this->report_model->table = 'karyawan';
		$this->report_model->column_select = 'noid, nama, alamat';
		$this->report_model->column_index = 'noid';
		$list = $this->report_model->find_all();
		$parameter = $this->get_parameter();
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
			<table>
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

	public function lap_typerumah() {
		$this->report_model->table = 'typerumah';
		$this->report_model->column_select = 'noid, typerumah, keterangan, hargajual, bookingfee';
		$this->report_model->column_index = 'noid';
		$list = $this->report_model->find_all();
		$parameter = $this->get_parameter();

		//Get Record Item
		$data = '';
		foreach ($list as $value) {
	        $data .= 
	        '<tr>
				<td class="number">'.$value->noid.'</td>
				<td>'.$value->typerumah.'</td>
				<td>'.$value->keterangan.'</td>
				<td class="number">'.number_format($value->hargajual,0,'.',',').'</td>
				<td class="number">'.number_format($value->bookingfee,0,'.',',').'</td>
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
			<table>
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

	public function lap_masterhargajual() {
		$this->report_model->table = 'typerumah';
		$this->report_model->column_select = 'noid, typerumah, hargajual, bookingfee, diskon, uangmuka, plafonkpr, hargasudut, hargahadapjalan, hargafasum';
		$this->report_model->column_index = 'noid';
		$list = $this->report_model->find_all();
		$parameter = $this->get_parameter();

		//Get Record Item
		$data = '';
		foreach ($list as $value) {
	        $data .= 
	        '<tr>
				<td class="number">'.$value->noid.'</td>
				<td>'.$value->typerumah.'</td>
				<td class="number">'.number_format($value->hargajual,0,'.',',').'</td>
				<td class="number">'.number_format($value->bookingfee,0,'.',',').'</td>
				<td class="number">'.number_format($value->diskon,0,'.',',').'</td>
				<td class="number">'.number_format($value->uangmuka,0,'.',',').'</td>
				<td class="number">'.number_format($value->plafonkpr,0,'.',',').'</td>
				<td class="number">'.number_format($value->hargasudut,0,'.',',').'</td>
				<td class="number">'.number_format($value->hargahadapjalan,0,'.',',').'</td>
				<td class="number">'.number_format($value->hargafasum,0,'.',',').'</td>
			</tr>';
        }

        //Generate HTML Output
		$html = $this->style.
			'<h1 class="title">Daftar <i>Harga</i></h1>
			<div class="address">
				<strong>'.$parameter->company.'</strong><br/>
				'.$parameter->address.'<br/>
				'.$parameter->city.'
			</div>
			<br/>
			<table>
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