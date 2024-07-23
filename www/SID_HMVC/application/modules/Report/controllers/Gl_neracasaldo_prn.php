<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gl_neracasaldo_prn extends MX_Controller {

	public function __construct()
	{
		parent::__construct();		
		$this->load->library('Sidlib','sidlib');
		$this->load->model('Accounting_model','report_model');
	}

	public function index() {
		$recordobject = $this->report_model->get_GLNeracaSaldo();
		$parameter = $this->report_model->get_parameter();
		$dataheader = $this->sidlib->setHeader_prn($parameter);
		$caption = 'Neraca Percobaan (Trial Balance)';
		$orientation = 'A4';

		$data = "
			<div class='title underline'>{$caption}</div>
				<div class='subtitle'>".$this->input->post('bulanname').' - '.$this->input->post('tahun')."</div>
			<br/>";
			
		$data .= "<table class='{$orientation}'>
				<thead>
				<tr>	
        			<th width='20%'>Account #</th>
        			<th width='40%'>Description</th>
        			<th width='20%'>Debit</th>
        			<th width='20%'>Credit</th>
        		</tr>
            	</thead>";
        
	    $total = array("Debit"=>0,"Credit"=>0);
	    $data .= "<tbody>";
        foreach($recordobject as $value) {
	        $classname = ''; //($value->nilaibuku <= 0) ? 'warning' : '';
	        if ($value->classacc==0) {
				$data .= "<tr><td colspan='4' class='strong bgwarning'>{$value->description}</td></tr>";
        	} else {
        		$data .= 
	        	"<tr>
	        		<td class='{$classname}'>{$value->accountno}</td>
	        		<td class='{$classname}'>{$value->description}</td>
	        		<td class='text-right {$classname}'>".$this->sidlib->my_format($value->debit)."</td>
	        		<td class='text-right {$classname}'>".$this->sidlib->my_format($value->credit)."</td>
	        	</tr>";
        	}
        	$total['Debit'] += $value->debit;
            $total['Credit'] += $value->credit;

    		
    	}
    	$data .= "</tbody>";
    	$data .= 
    		"<tfoot>
    			<tr>
    				<td colspan='2' class='text-right strong'>TOTAL</td>
    				<td class='text-right strong'>".$this->sidlib->my_format($total['Debit'])."</td>
    				<td class='text-right strong'>".$this->sidlib->my_format($total['Credit'])."</td>
				</tr>
    		</tfoot>";
    	$data .= "</table>";
    	$data = array('title'		=> $caption,
					  'record'		=> $data,
					  'header'=>$dataheader,
					  'orientation' => $orientation
					  );
		$this->load->view('Report/laporan_print',$data);
    }
}	