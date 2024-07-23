<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gl_neracasimple_prn extends MX_Controller {

	public function __construct()
	{
		parent::__construct();		
		$this->load->library('Sidlib','sidlib');
		$this->load->model('Accounting_model','report_model');
	}

	public function index() {
		$parameter = $this->report_model->get_parameter();
		$dataheader = $this->sidlib->setHeader_prn($parameter);
		$caption = 'Neraca ( Balance Sheet )';
		$orientation = 'A4';
		$data = "<div class='title underline'>{$caption}</div>
			<div class='subtitle'>".$this->input->post('bulanname').' - '.$this->input->post('tahun')."</div>
		<br/>";

        $recordobject = $this->report_model->get_GLNeraca();
	        
		//Left Table (Activa)
        $data .= "<div class='col-6' style='overflow-x:auto;'>";
        $data .= "<table class='{$orientation}' width='100%'>
			<thead>
			<tr>	
    			<th colspan='2' width='50%' class='no-border'>ACTIVA</th>
    		</tr>
        	</thead> <tbody>";
        foreach($recordobject as $value) {
	        if (substr($value->accountno,0,1) != '1') {break;}
	        $classname = ($value->flaggrandtotal == 2) ? 'strong bgwarning no-border' : 'no-border';
	        $desc = str_replace('~', '&nbsp;', str_pad($value->description, strlen($value->description)+(1*$value->levelacc), '~',STR_PAD_LEFT));
    		$data .= 
        	"<tr>
        		<td width='65%' class='{$classname}'>{$desc}</td>
        		<td width='35%' class='text-right {$classname}'>".$this->sidlib->my_format($value->dueamount)."</td>
        	</tr>";
    	}
    	$data .= "</tbody> </table> </div>";

        //Right Table (Pasiva)
        $data .= "<div class='col-6' style='overflow-x:auto;'>";
        $data .= "<table class='{$orientation}' width='100%'>
			<thead>
			<tr>	
    			<th colspan='2' width='50%' class='no-border'>PASIVA</th>
    		</tr>
        	</thead> <tbody>";
        foreach($recordobject as $value) {
	        if (substr($value->accountno,0,1) == '1') {continue;}
	        $classname = ($value->flaggrandtotal == 2) ? 'strong bgwarning no-border' : 'no-border';
	        $desc = str_replace('~', '&nbsp;', str_pad($value->description, strlen($value->description)+(1*$value->levelacc), '~',STR_PAD_LEFT));
    		$data .= 
        	"<tr>
        		<td width='65%' class='{$classname}'>{$desc}</td>
        		<td width='35%' class='text-right {$classname}'>".$this->sidlib->my_format($value->dueamount)."</td>
        	</tr>";
    	}
    	$data .= "</tbody> </table> </div>";
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