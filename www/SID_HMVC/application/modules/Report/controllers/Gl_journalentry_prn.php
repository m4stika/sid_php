<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gl_journalentry_prn extends MX_Controller {

	public function __construct()
	{
		parent::__construct();		
		$this->load->library('Sidlib','sidlib');
		$this->load->model('Accounting_model','report_model');
	}

	public function index() {
		$parameter = $this->report_model->get_parameter();
		$dataheader = $this->sidlib->setHeader_prn($parameter);
		$caption = 'Journal Entry';
		$orientation = 'A4';
		
		$data = "<div class='title underline'>{$caption}</div>
            <div class='subtitle'>".$this->input->post('bulanname').' - '.$this->input->post('tahun')."</div>
        <br/>";

		if ($this->input->post('groupby') >=0) {
            $data .= "<div class='text-left strong'>".$this->input->post('groupdesc')."</div>";
        }
		$data .= "<div class='row'> <div class='captiongroup'>".$this->input->post('item')."</div></div>";
		$data .= "<table class='{$orientation}'>
				<thead>
				<tr>	
        			<th width='15%' class='no-border'>Tanggal</th>
        			<th width='15%' class='no-border'>Journal No</th>
        			<th width='40%' class='no-border'>Keterangan</th>
        			<th width='15%' class='no-border'>Debet</th>
        			<th width='15%' class='no-border'>Kredit</th>
        		</tr>
            	</thead>";

        $journal = $this->report_model->get_GLjournalHeader();
        $data .= "<tbody>";
        foreach($journal as $valueH) { 
        	$data .= 
        	"<tr>
        		<td class='text-left strong no-border'>".date_format(date_create($valueH->journaldate), "d-M-Y")."</td>
                <td class='text-left strong no-border'>{$valueH->journalno}</td>
        		<td colspan = '3' class='text-left strong no-border'>{$valueH->journalremark}</td>
        	</tr>";
            // <td class='text-right strong no-border'>".$this->sidlib->my_format($valueH->dueamount)."</td>
            // <td class='text-right strong no-border'>".$this->sidlib->my_format($valueH->dueamount)."</td>

        	$journaldetil = $this->report_model->get_GLjournalDetil($valueH->journalid);
            $debet = 0;
            $kredit = 0;
            $counter=0;
		    foreach ($journaldetil as $value) {
		    	$counter++;
		    	$border = ($counter == count($journaldetil)) ? 'no-border' : 'no-border';
		    	$data .= 
		    	"<tr>
	        		<td colspan='2' class='text-right {$border}'>{$value->accountno}</td>
	        		<td class='text-left {$border}'>{$value->description}</td>
	        		<td class='text-right {$border}'>{$value->debit}</td>
	        		<td class='text-right {$border}'>{$value->credit}</td>
	        	</tr>";
                $debet += $value->debit;
                $kredit += $value->credit;
		    }
            $data .= 
            "<tr>
                <td colspan='3' class='subtotal-gl saldocaption'></td>
                <td class='subtotal-gl'>".$this->sidlib->my_format($debet)."</td>
                <td class='subtotal-gl'>".$this->sidlib->my_format($kredit)."</td>
            </tr>
            ";
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