<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kb_rekapitulasikasbank_prn extends MX_Controller {

	public function __construct()
	{
		parent::__construct();		
		$this->load->library('Sidlib','sidlib');
		$this->load->model('Kasbank_model','report_model');
	}

	public function index() {
		$parameter = $this->report_model->get_parameter();
		$dataheader = $this->sidlib->setHeader_prn($parameter);
		$caption = 'Rekapitulasi Kas-Bank';
		$orientation = 'A4';
		
		$data = "<div class='title underline'>{$caption}</div>
				<div class='subtitle'>".date_format(date_create($this->input->post('periode')), "d-M-Y").' s/d '.date_format(date_create($this->input->post('periode1')), "d-M-Y")."</div>";
		
		if ($this->input->post('linkid') == 'undefined') {
			$recordHeader = $this->report_model->get_AccountHeader();
			$haslinkid = 0;
		} else {
			$account = $this->report_model->get_Accountby_id($this->input->post('linkid'));
			$parentkey = ($account->classacc == 0) ? $account->keyvalue :  $account->parentkey;
			$recordHeader = $this->report_model->get_Accountby_keyvalue($parentkey);
			$haslinkid = ($account->classacc == 0) ? 0 :  1;
		}

		$totHeader = count($recordHeader);
		$counter = 0;
        foreach($recordHeader as $valueH) { 
        	$counter++;
			$saldoperGroupheader = 0;
			$data .= "<div class='row'><div class='captiongroup'><span class='text-center strong'>{$valueH->description}</span></div></div>";

			$dataHeader = $this->report_model->get_RekapKasbankHeader($valueH->keyvalue, $haslinkid);
			$newGroup = '';
			$subtotalpertype = 0;
			$subtotalgroup = array('penambahan'=>0, 'pengurangan'=>0);
			$banktype = -1;
			$saldoawal = 0;
			// $groupcounter = 0;
			
			foreach ($dataHeader as $groupH) {
				
				$banktype = $subtotalpertype == 0 ? $groupH->kasbanktype : -1;
				$banktypedesc = ($groupH->kasbanktype == 0 || $groupH->kasbanktype == 2) ? 'PENERIMAAN' : 'PENGELUARAN';
				$banktypedesclower = ($groupH->kasbanktype == 0 || $groupH->kasbanktype == 2) ? 'Penerimaan' : 'Pengeluaran';
				$subtotal = 0;

				$dataDetil = $this->report_model->get_RekapKasbankDetil($groupH->rekid, $groupH->kasbanktype);
				$hasrecord = 0; //(count(dataDetil) != 0);
				foreach ($dataDetil as $value) {
					if ($hasrecord == 0) {
						if ($banktype == $groupH->kasbanktype) {
							$data .= "<table class='{$orientation}'>";
							$saldoawal = $this->report_model->get_SaldoawalKB($groupH->rekid);
							$data .= "
								<tr><td colspan='5' class='captionsubgroup'>({$groupH->accountno}) - {$groupH->description}</td></tr>
								<tr>
									<td colspan='4' class='text-right no-border border-left'>Saldo Awal</td>
									<td class='text-right strong  no-border border-right'>".$this->sidlib->my_format($saldoawal)."</td>
								</tr>
							";
						}
						$data .= "<tr><th colspan='5' class='text-left strong'>{$banktypedesc}</th></tr>";
					}
					$data .= "
							<tr>
							<td colspan='2' class='text-right no-border border-left'>{$value->accountno}</td>
							<td colspan='2' class='text-left  no-border'>{$value->description}</td>
							<td class='text-right no-border border-right'>".$this->sidlib->my_format($value->amount)."</td>
							</tr>
						";
					$subtotal += $value->amount;
		    		$hasrecord = 1;
				}

				$subtotalpertype += $subtotal;
				if ($groupH->kasbanktype == 0 || $groupH->kasbanktype == 2) {
					$subtotalgroup['penambahan'] +=  $subtotal;
				} else {
					$subtotalgroup['pengurangan'] += $subtotal;
				}

				if ($hasrecord == 1) {
					$data .= "
							<tr>
								<td colspan='4' class='text-right no-border border-top'>Total {$banktypedesclower}</td>
								<td class='border-top text-right strong'>".$this->sidlib->my_format($subtotal)."</td>
							</tr>
						";
				}
				// if ($subtotalpertype != 0) {
				// 	$banktypeNext = ($groupcounter < count($dataHeader)-1) ? $dataHeader[$groupcounter+1]->kasbanktype : $groupH->kasbanktype;
				// 	if ($banktype != $banktypeNext)	{
				// 		$data .= "
				// 			<tr>
				// 				<td colspan='4' class='text-right'>Saldo Akhir {$groupH->description}</td>
				// 				<td class='text-right strong'>".$this->sidlib->my_format($saldoawal + $subtotalgroup['penambahan'] - $subtotalgroup['pengurangan'])."</td>
				// 			</tr>
				// 		";
				// 		$data .= "</table> <br/>";
				// 	}
				// }
				
				if ($subtotalpertype != 0 && $banktype != $groupH->kasbanktype) {
					$saldoperGroupheader += $saldoawal + $subtotalgroup['penambahan'] - $subtotalgroup['pengurangan'];
					$data .= "
							<tr>
								<td colspan='4' class='text-right strong no-border border-top'>Saldo Akhir {$groupH->description}</td>
								<td class='text-right strong border-top'>".$this->sidlib->my_format($saldoawal + $subtotalgroup['penambahan'] - $subtotalgroup['pengurangan'])."</td>
							</tr>
						";
					$data .= "</table> <br/>";
					$subtotalpertype = 0;
				}
				// $groupcounter++;
				$banktype = $groupH->kasbanktype;
			}
			
			$data .= "<div class='row'><div class='grandtotal'>".$this->sidlib->my_format($saldoperGroupheader)."</div></div><br/>";
			

	    	// if ($totHeader != $counter) {
	    	// 	$pdf->AddPage();
	    	// }
    	}

		
    	$data = array('title'		=> $caption,
					  'record'		=> $data,
					  'header'=>$dataheader,
					  'orientation' => $orientation
					  );
		$this->load->view('Report/laporan_print',$data);
    }
}	