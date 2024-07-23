<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gl_neracalajur_prn extends MX_Controller {

	public function __construct()
	{
		parent::__construct();		
		$this->load->library('Sidlib','sidlib');
		$this->load->model('Accounting_model','report_model');
	}

	public function index() {
		$recordobject = $this->report_model->get_GLNeracaLajur();
		$parameter = $this->report_model->get_parameter();
		$dataheader = $this->sidlib->setHeader_prn($parameter);
		$caption = 'Neraca Lajur (Work Sheet)';
		$orientation = 'A4 landscape';
		$data = "<div class='title underline'>{$caption}</div>
			<div class='subtitle'>".$this->input->post('bulanname').' - '.$this->input->post('tahun')."</div>
		<br/>";

		$data .= "<table class='{$orientation}'>
				<thead>
				<tr>	
        			<th rowspan='2' width='10%'>Account #</th>
        			<th rowspan='2' width='26%'>Description</th>
        			<th colspan='2' width='16%'>Neraca Saldo</th>
        			<th colspan='2' width='16%'>Penyesuaian</th>
        			<th colspan='2' width='16%'>Laba(Rugi)</th>
        			<th colspan='2' width='16%'>Neraca</th>
        		</tr>
        		<tr>	
        			<th>Debet</th>
        			<th>Kredit</th>
        			<th>Debet</th>
        			<th>Kredit</th>
        			<th>Debet</th>
        			<th>Kredit</th>
        			<th>Debet</th>
        			<th>Kredit</th>
        		</tr>
            	</thead>";
        
	    $total = array("Debit"=>0,"Credit"=>0,
	        			   "debetadjust"=>0,"kreditadjust"=>0,
	        			   "debetlabarugi"=>0,"kreditlabarugi"=>0,
	        			   "debetneraca"=>0,"kreditneraca"=>0,
	        			);
	    $data .= "<tbody>";
        foreach($recordobject as $value) {
	        $classname = ''; //($value->nilaibuku <= 0) ? 'warning' : '';
	        if ($value->classacc==0) {
				$data .= "<tr><td colspan='10' class='strong bgwarning'>{$value->description}</td></tr>";
        	} else {
        		$data .= 
	        	"<tr>
	        		<td class='{$classname}'>{$value->accountno}</td>
	        		<td class='{$classname}'>{$value->description}</td>
	        		<td class='text-right {$classname}'>".$this->sidlib->my_format($value->debit)."</td>
	        		<td class='text-right {$classname}'>".$this->sidlib->my_format($value->credit)."</td>
	        		<td class='text-right {$classname}'>".$this->sidlib->my_format($value->debetadjust)."</td>
	        		<td class='text-right {$classname}'>".$this->sidlib->my_format($value->kreditadjust)."</td>
	        		<td class='text-right {$classname}'>".$this->sidlib->my_format($value->debetlabarugi)."</td>
	        		<td class='text-right {$classname}'>".$this->sidlib->my_format($value->kreditlabarugi)."</td>
	        		<td class='text-right {$classname}'>".$this->sidlib->my_format($value->debetneraca)."</td>
	        		<td class='text-right {$classname}'>".$this->sidlib->my_format($value->kreditneraca)."</td>
	        	</tr>";
        	}
        	$total['Debit'] += $value->debit;
            $total['Credit'] += $value->credit;
            $total['debetadjust'] += $value->debetadjust;
            $total['kreditadjust'] += $value->kreditadjust;
            $total['debetlabarugi'] += $value->debetlabarugi;
            $total['kreditlabarugi'] += $value->kreditlabarugi;
            $total['debetneraca'] += $value->debetneraca;
            $total['kreditneraca'] += $value->kreditneraca;
    	}
    	$data .= "</tbody>";
    	$data .= 
    		"<tfoot>
    			<tr>
    				<td colspan='2' class='text-right strong'>TOTAL</td>
    				<td class='text-right strong'>".$this->sidlib->my_format($total['Debit'])."</td>
    				<td class='text-right strong'>".$this->sidlib->my_format($total['Credit'])."</td>
    				<td class='text-right strong'>".$this->sidlib->my_format($total['debetadjust'])."</td>
    				<td class='text-right strong'>".$this->sidlib->my_format($total['kreditadjust'])."</td>
    				<td class='text-right strong'>".$this->sidlib->my_format($total['debetlabarugi'])."</td>
    				<td class='text-right strong'>".$this->sidlib->my_format($total['kreditlabarugi'])."</td>
    				<td class='text-right strong'>".$this->sidlib->my_format($total['debetneraca'])."</td>
    				<td class='text-right strong'>".$this->sidlib->my_format($total['kreditneraca'])."</td>
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