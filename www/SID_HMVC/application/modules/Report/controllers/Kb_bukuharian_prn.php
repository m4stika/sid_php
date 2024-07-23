<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kb_bukuharian_prn extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Sidlib','sidlib');
		$this->load->model('Kasbank_model','report_model');
	}

	public function index() {
		//$header = array('ID', 'Type','Harga Jual', 'Booking Fee', 'Diskon', 'Uang Muka','Plafon KPR','Sudut', 'Hadap Jalan','Fasum');

		$parameter = $this->report_model->get_parameter();
		$dataheader = $this->sidlib->setHeader_prn($parameter);
		$caption = 'Laporan Buku Harian';
		$orientation = 'A4';

		$data = "<div class='title underline'>{$caption}</div>
				<div class='subtitle'>".date_format(date_create($this->input->post('periode')), "d-M-Y").' s/d '.date_format(date_create($this->input->post('periode1')), "d-M-Y")."</div>";

		$data .= "<div class='row'> <div class='captiongroup'>".$this->input->post('item')."</div></div>";
		$data .= "<table class='{$orientation}'>
				<thead>
				<tr>
        			<th width='15%' class='no-border'>No. Bukti</th>
        			<th width='15%' class='no-border'>Tanggal</th>
        			<th width='40%' class='no-border'>Uraian</th>
        			<th width='15%' class='no-border'>Penerimaan</th>
        			<th width='15%' class='no-border'>Pengeluaran</th>
        		</tr>
            	</thead>";

        $bukuharian = $this->report_model->get_lapbukuharianHeader($this->input->post('linkid'));

        $totalPenerimaan = 0;
    	$totalPengeluaran = 0;
        $total = array('totalharga'=>0, 'akumpenyusutan'=>0,'nilaibuku'=>0);
        $data .= "<tbody>";
        foreach($bukuharian as $valueH) {
	        $totalPenerimaan += $valueH->penerimaan;
        	$totalPengeluaran += $valueH->pengeluaran;
        	$data .=
        	"<tr>
        		<td class='text-left strong no-border'>{$valueH->nokasbank}</td>
        		<td class='text-left strong no-border'>".date_format(date_create($valueH->tglentry), "d-M-Y")."</td>
        		<td class='text-left strong no-border'>{$valueH->uraian}</td>
        		<td class='text-right strong no-border'>".$this->sidlib->my_format($valueH->penerimaan)."</td>
        		<td class='text-right strong no-border'>".$this->sidlib->my_format($valueH->pengeluaran)."</td>
        	</tr>";

        	$bukuharianDetil = $this->report_model->get_lapbukuharianDetil($valueH->noid);
        	$counter = 0;
		    foreach ($bukuharianDetil as $value) {
		    	$counter++;
		    	$debet = ($valueH->kasbanktype == 0 || $valueH->kasbanktype == 2) ? $this->sidlib->my_format($value->amount) : '';
		    	$kredit = ($valueH->kasbanktype == 1 || $valueH->kasbanktype == 3) ? $this->sidlib->my_format($value->amount) : '';
		    	$border = ($counter == count($bukuharianDetil)) ? 'no-border border-bottom' : 'no-border';
		    	$data .=
		    	"<tr>
	        		<td colspan='2' class='text-right {$border}'>{$value->accountno}</td>
	        		<td class='text-left {$border}'>{$value->remark}</td>
	        		<td class='text-right {$border}'>{$debet}</td>
	        		<td class='text-right {$border}'>{$kredit}</td>
	        	</tr>";
		    }
    	}
    	$saldoawal = $this->report_model->get_SaldoawalKB($this->input->post('linkid'));
        $saldoakhir = $saldoawal + $totalPenerimaan - $totalPengeluaran;

        $data .=
	    	"<tr>
        		<td colspan='3' class='saldoakhir saldocaption'>JUMLAH MUTASI</td>
        		<td class='saldoakhir'>".$this->sidlib->my_format($totalPenerimaan)."</td>
        		<td class='saldoakhir'>".$this->sidlib->my_format($totalPengeluaran)."</td>
        	</tr>
        	<tr>
        		<td colspan='3' class='saldototal saldocaption'>Saldo Awal & Saldo Akhir</td>
        		<td class='saldototal'>".$this->sidlib->my_format($saldoawal)."</td>
        		<td class='saldototal'>".$this->sidlib->my_format($saldoakhir)."</td>
        	</tr>
        	";
    	$data .= "</tbody>";
    	$data .= "</table>";

    	$data .= "
        		<div class='row'>
        			<div class='footerdate'>{$parameter->city}, ".date_format(date_create(), "d-M-Y")."</div>
        		</div>
        		<div class='row'>
        			<div class='col-12 text-center'>
        				<div class='col-4 assign'>
        					<p>Disetujui Oleh,</p>
        					<p class='footer1 center underline'>{$parameter->pimpinan}</p>
        					<p class='footer center'>{$parameter->pimpinantitle}</p>
        				</div>
        				<div class='col-4 assign'>
        					<p>Diperiksa Oleh,</p>
        					<p class='footer1 center underline'>{$parameter->accounting}</p>
        					<p class='footer center'>{$parameter->accountingtitle}</p>
        				</div>
        				<div class='col-4 assign'>
        					<p>Dibuat Oleh,</p>
        					<p class='footer1 center underline'>{$parameter->kasir}</p>
        					<p class='footer center'>{$parameter->kasirtitle}</p>
        				</div>
        			</div>
        		</div>
        	";
    	$data = array('title'		=> $caption,
					  'record'		=> $data,
					  'header'=>$dataheader,
					  'orientation' => $orientation
					  );
		$this->load->view('Report/laporan_print',$data);
    }
}