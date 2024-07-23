<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kb_infobukuharian_prn extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Sidlib','sidlib');
		$this->load->model('Kasbank_model','report_model');
	}

	public function index() {
		//$header = array('ID', 'Type','Harga Jual', 'Booking Fee', 'Diskon', 'Uang Muka','Plafon KPR','Sudut', 'Hadap Jalan','Fasum');
		$recordobject = $this->report_model->get_infobukuharian();
		// echo json_encode($recordobject);
		$parameter = $this->report_model->get_parameter();
		$dataheader = $this->sidlib->setHeader_prn($parameter);
		$caption = 'Informasi Buku Harian';
		$orientation = 'A4';

		$data = "<div class='title underline'>{$caption}</div>
				<div class='subtitle'>".date_format(date_create($this->input->post('periode')), "d-M-Y").' s/d '.date_format(date_create($this->input->post('periode1')), "d-M-Y")."</div>";

		$data .= "<table class='{$orientation}'>
				<thead>
				<tr>
        			<th width='10%'>Kode</th>
        			<th width='30%'>Perkiraan</th>
        			<th width='15%'>Saldo Awal</th>
        			<th width='15%'>Debet</th>
        			<th width='15%'>Kredit</th>
        			<th width='15%'>Saldo Akhir</th>
        		</tr>
            	</thead>";

        	$data .= "<tbody>";
        foreach($recordobject as $value) {
	        $classname = ($value->classacc == 0) ? 'strong' : '';
	        $classdesc = ($value->classacc == 0) ? '' : 'padding-left-10';
	        $data .=
	        	"<tr>
	        		<td class='text-right {$classname}'>{$value->accountno}</td>
	        		<td class='{$classname} {$classdesc}'>{$value->description}</td>
	        		<td class='text-right {$classname}'>".$this->sidlib->my_format($value->saldoawal)."</td>
	        		<td class='text-right {$classname}'>".$this->sidlib->my_format($value->debet)."</td>
	        		<td class='text-right {$classname}'>".$this->sidlib->my_format($value->kredit)."</td>
	        		<td class='text-right {$classname}'>".$this->sidlib->my_format($value->saldoakhir)."</td>
	        	</tr>";
    	}
    	$data .= "</tbody>";
    	$data .= "</table>";
    	$data = array('title'		=> $caption,
					  'record'		=> $data,
					  'header'=>$dataheader,
					  'orientation' => $orientation
					  );
		$this->load->view('Report/laporan_print',$data);
    }
}