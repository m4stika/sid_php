<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gl_labarugi_prn extends MX_Controller {

	public function __construct()
	{
		parent::__construct();		
		$this->load->library('Sidlib','sidlib');
		$this->load->model('Accounting_model','report_model');
	}

	public function index() {
		$parameter = $this->report_model->get_parameter();
		$dataheader = $this->sidlib->setHeader_prn($parameter);
		$caption = 'Profit ( Lost )';
		$orientation = 'A4';
		$data = "<div class='title underline'>{$caption}</div>
			<div class='subtitle'>".$this->input->post('bulanname').' - '.$this->input->post('tahun')."</div>
		<br/>";

        $current = strtotime($this->input->post('bulan').'/01/'.$this->input->post('tahun'));
        $prevbulantahun = date("M - Y", strtotime("-1 month", $current));
        $bulantahun = date("M - Y", $current);

		$data .= "<table class='{$orientation}'>
				<thead>
				<tr>	
        			<th width='60%' class='no-border'>Description</th>
        			<th width='20%' class='no-border text-right'>{$bulantahun}</th>
                    <th width='20%' class='no-border text-right'>{$prevbulantahun}</th>
        		</tr>
            	</thead>";
        
	    $data .= "<tbody>";
        $recordobject = $this->report_model->get_GLLabarugi();
        foreach($recordobject as $value) {
	        $classname = ($value->flaggrandtotal == 2) ? 'strong bgwarning no-border' : 'no-border';
	        $desc = str_replace('~', '&nbsp;', str_pad($value->description, strlen($value->description)+(1*$value->levelacc), '~',STR_PAD_LEFT));
    		$data .= 
        	"<tr>
        		<td class='{$classname}'>{$desc}</td>
        		<td class='text-right {$classname}'>".$this->sidlib->my_format($value->dueamount)."</td>
        		<td class='text-right {$classname}'>".$this->sidlib->my_format($value->duekomparatif1)."</td>
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