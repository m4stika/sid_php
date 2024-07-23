<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gl_chartofaccount_prn extends MX_Controller {

	public function __construct()
	{
		parent::__construct();		
		$this->load->library('Sidlib','sidlib');
		$this->load->model('Accounting_model','report_model');
	}

	public function index() {
		//$header = array('ID', 'Type','Harga Jual', 'Booking Fee', 'Diskon', 'Uang Muka','Plafon KPR','Sudut', 'Hadap Jalan','Fasum');
		$recordobject = $this->report_model->get_chartofaccount();
		$parameter = $this->report_model->get_parameter();
		$dataheader = $this->sidlib->setHeader_prn($parameter);
		$caption = 'Chart Of Account';
		$orientation = 'A4';
		
		$data = "<div class='title'>{$caption}</div>";
		
		$data .= "<table class='{$orientation}'>
				<thead>
				<tr>	
        			<th width='15%' class='no-border'>Account</th>
        			<th width='40%' class='no-border'>Description</th>
        			<th width='11%' class='no-border'>Opening</th>
        			<th width='11%' class='no-border'>Debit</th>
        			<th width='11%' class='no-border'>Credit</th>
        			<th width='11%' class='no-border'>Ballance Due</th>
        		</tr>
            	</thead>";

        	$data .= "<tbody>";
        foreach($recordobject as $value) {
	        $classname = ($value->classacc == 0) ? 'strong no-border' : 'italic no-border';
	        $desc = str_replace('~', '&nbsp;', str_pad($value->description, strlen($value->description)+(1*$value->levelacc), '~',STR_PAD_LEFT));
	        //$desc = str_pad($value->description, strlen($value->description)+(1*$value->levelacc),'&nbsp;',STR_PAD_LEFT);
	        $data .= 
	        	"<tr>
	        		<td class='text-right {$classname}'>{$value->accountno}</td>
	        		<td class='{$classname}'>{$desc}</td>
	        		<td class='text-right {$classname}'>".$this->sidlib->my_format($value->openingbalance)."</td>
	        		<td class='text-right {$classname}'>".$this->sidlib->my_format($value->debet)."</td>
	        		<td class='text-right {$classname}'>".$this->sidlib->my_format($value->kredit)."</td>
	        		<td class='text-right {$classname}'>".$this->sidlib->my_format($value->balancedue)."</td>
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