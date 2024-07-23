<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sar_daftarpenerimaanuang_prn extends MX_Controller {

	public function __construct()
	{
		parent::__construct();		
		$this->load->library('Sidlib','sidlib');
		$this->load->model('Pemasaran_model','report_model');
	}

	public function index() {
		//$header = array('ID', 'Type','Harga Jual', 'Booking Fee', 'Diskon', 'Uang Muka','Plafon KPR','Sudut', 'Hadap Jalan','Fasum');
		$groupby = $this->input->post('groupby'); //0=jenispenerimaan, 1=tglbayar
    	$order = $groupby == 0 ? 'jenispenerimaan, tglbayar' : 'tglbayar, jenispenerimaan';
		$recordobject = $this->report_model->get_DaftarPenerimaanUang($order);
		$parameter = $this->report_model->get_parameter();
		$dataheader = $this->sidlib->setHeader_prn($parameter);
		$caption = 'Rincian Penerimaan Uang';
		$orientation = 'A4';
		
		$data = "<div class='title underline'>{$caption}</div>
				<div class='subtitle'>".date_format(date_create($this->input->post('periode')), "d-M-Y").' s/d '.date_format(date_create($this->input->post('periode1')), "d-M-Y")."</div>";
			
		$data .= "<table class='{$orientation}'>
				<thead>
				<tr>	
        			<th width='20%'>".($groupby == 1 ? 'Jenis Penerimaan' : 'Tanggal')."</th>
        			<th width='15%'>Kwitansi</th>
        			<th width='25%'>Konsumen</th>
        			<th width='25%'>Keterangan</th>
        			<th width='15%'>Total Bayar</th>
        		</tr>
            	</thead>";

        $flagGroupby = '';
        $no = 0;
        $totalbayar = 0;
        $grandtotal = 0;
        $data .= "<tbody>";
        foreach($recordobject as $value) {
	        $groupbyname = $groupby == 0 ? $value->jenispenerimaan : $value->tglbayar;
			$datacol1 = $groupby == 1 ? $value->namapenerimaan : date_format(date_create($value->tglbayar), "d-M-Y");
			$datagroup = $groupby == 0 ? $value->namapenerimaan : date_format(date_create($value->tglbayar), "d-M-Y");
            
            //Group Total
            if ($no != 0 &&  $flagGroupby != $groupbyname) {
                $data .= 
	        		"<tr>
	        			<td colspan='4' class='text-right strong border-all'>Total</td>
	        			<td class='text-right strong border-all'>".$this->sidlib->my_format($totalbayar)."</td>
	        		</tr>";
                $no=0;
                $totalbayar = 0;
            }
            //Group Header
			if ($flagGroupby != $groupbyname) {
				$data .= "<tr><td colspan='5' class='strong border-bottom'>{$datagroup}</td></tr>";
			}

            $data .= 
	        		"<tr>
	        			<td>{$datacol1}</td>
	        			<td class=''>{$value->nokwitansi}</td>
	        			<td class=''>{$value->namapemesan}</td>
	        			<td class=''>{$value->description}</td>
	        			<td class='text-right'>".$this->sidlib->my_format($value->jumlahbayar)."</td>
	        		</tr>";
            $flagGroupby = $groupbyname;
            $totalbayar += $value->jumlahbayar;
            $grandtotal += $value->jumlahbayar;
            $no++;
    	}
    	//Last Group Total
        $data .= 
    		"<tr>
    			<td colspan='4' class='text-right strong border-all'>Total</td>
    			<td class='text-right strong border-all'>".$this->sidlib->my_format($totalbayar)."</td>
    		</tr>
    	</tbody>";

    	$data .= 
    		"<tfoot>
    			<tr>
    				<td colspan='4' class='text-right strong'>TOTAL</td>
    				<td class='text-right strong'>".$this->sidlib->my_format($grandtotal)."</td>
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