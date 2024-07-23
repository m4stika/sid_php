<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gl_fixedasset_prn extends MX_Controller {

	public function __construct()
	{
		parent::__construct();		
		$this->load->library('Sidlib','sidlib');
		$this->load->model('Accounting_model','report_model');
	}

	public function index() {
		//$header = array('ID', 'Type','Harga Jual', 'Booking Fee', 'Diskon', 'Uang Muka','Plafon KPR','Sudut', 'Hadap Jalan','Fasum');
		$recordobject = $this->report_model->get_GLfixedasset();
		$parameter = $this->report_model->get_parameter();
		$dataheader = $this->sidlib->setHeader_prn($parameter);
		$caption = 'Aktiva Tetap ( Fixed Asset )';
		$orientation = 'A4 landscape';
		
		$data = "<div class='title'>{$caption}</div><br/>";
		$data .= "<table class='{$orientation}'>
				<thead>
				<tr>	
        			<th width='5%'>No</th>
        			<th width='20%'>Nama</th>
        			<th width='10%'>Bl-Th Perolehan</th>
        			<th width='5%'>Usia</th>
        			<th width='10%'>Peny. Bl-I</th>
        			<th width='10%'>Peny. Bl-X</th>
        			<th width='10%'>Mulai Susut</th>
        			<th width='10%'>Nilai Aktiva</th>
        			<th width='10%'>Akumulasi</th>
        			<th width='10%'>Nilai Buku</th>
        		</tr>
            	</thead>";
        
        $i = 0;
	    $total = array('totalharga'=>0, 'akumpenyusutan'=>0,'nilaibuku'=>0);
	    $data .= "<tbody>";
        foreach($recordobject as $value) {
	        $i++;
			$blthperolehan = date("M - Y", strtotime($value->bulanperolehan.'/01/'.$value->tahunperolehan));
			$blthpenyusutan = date("M - Y", strtotime($value->bulansusut.'/01/'.$value->tahunsusut));

    		$classname = ($value->nilaibuku <= 0) ? 'danger' : '';
	        //$desc = str_replace('~', '&nbsp;', str_pad($value->description, strlen($value->description)+(1*$value->levelacc), '~',STR_PAD_LEFT));
	        $data .= 
	        	"<tr>
	        		<td class='text-center {$classname}'>{$i}</td>
	        		<td class='{$classname}'>{$value->namaaktiva}</td>
	        		<td class='text-center {$classname}'>{$blthperolehan}</td>
	        		<td class='text-right {$classname}'>{$value->usiaekonomis} bln</td>
	        		<td class='text-right {$classname}'>".$this->sidlib->my_format($value->penyusutanbulan_I)."</td>
	        		<td class='text-right {$classname}'>".$this->sidlib->my_format($value->penyusutanbulan_II)."</td>
	        		<td class='text-center {$classname}'>{$blthpenyusutan}</td>
	        		<td class='text-right {$classname}'>".$this->sidlib->my_format($value->totalharga)."</td>
	        		<td class='text-right {$classname}'>".$this->sidlib->my_format($value->akumpenyusutan)."</td>
	        		<td class='text-right {$classname}'>".$this->sidlib->my_format($value->nilaibuku)."</td>
	        	</tr>";

	        $total['totalharga'] += $value->totalharga;
            $total['akumpenyusutan'] += $value->akumpenyusutan;
            $total['nilaibuku'] += $value->nilaibuku;
    	}
    	$data .= "</tbody>";
    	$data .= 
    		"<tfoot>
    			<tr>
    				<td colspan='7' class='text-right strong'>TOTAL</td>
    				<td class='text-right strong'>".$this->sidlib->my_format($total['totalharga'])."</td>
    				<td class='text-right strong'>".$this->sidlib->my_format($total['akumpenyusutan'])."</td>
    				<td class='text-right strong'>".$this->sidlib->my_format($total['nilaibuku'])."</td>
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