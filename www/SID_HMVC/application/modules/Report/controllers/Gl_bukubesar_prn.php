<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gl_bukubesar_prn extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Sidlib','sidlib');
		$this->load->model('Accounting_model','report_model');
	}

	public function index() {
		$parameter = $this->report_model->get_parameter();
		$dataheader = $this->sidlib->setHeader_prn($parameter);
		$caption = 'Buku Besar';
		$orientation = 'A4';

        $table = "<table class='{$orientation}'>";

		$data = "<div class='title underline'>{$caption}</div>
            <div class='subtitle'>".$this->input->post('bulanname').' - '.$this->input->post('tahun')."</div>
        <br/>";

        // $perkiraan = $this->report_model->get_Accountby_id($this->input->post('linkid'));
				$paramid = $this->input->post('linkid');
				// $newParamId = is_string($paramid) ? $paramid : -1;
				$perkiraan = $this->report_model->get_Accountby_id($paramid);
				$keyvalue = isset($perkiraan) ? $perkiraan->keyvalue : '';
        $bukubesar = $this->report_model->get_GLbukubesar($keyvalue);
        $groupaccount = '';
        $keyvalue = '';
        $total = array("Debit"=>0,"Credit"=>0,"Detil"=>0);
        $data .= "<tbody>";
            $generateTableHeader = function($value) {
                return "
                        <tr>
                            <td colspan = '3' class='text-left headerbukubesar'>{$value->accountno} ( {$value->description} )</td>
                            <td colspan = '2'  class='text-right headerbukubesar border-bottom'>Saldo Awal</td>
                            <td class='text-right headerbukubesar border-bottom'>".$this->sidlib->my_format($value->saldoawal)."</td>
                        </tr>";
            };
            $generateSubTotal = function($value) {
                return "
                    <tr>
                        <td colspan = '3' class='text-right subtotal-gl saldocaption'>Sub Total</td>
                        <td class='text-right subtotal-gl'>".$this->sidlib->my_format($value['Debit'])."</td>
                        <td class='text-right subtotal-gl'>".$this->sidlib->my_format($value['Credit'])."</td>
                        <td class='text-right subtotal-gl'>".$this->sidlib->my_format($value['Detil'])."</td>
                    </tr>";
            };
        //Generate Firs Record
        if (count($bukubesar) > 0) {
            //Generate Table Header
            $data .= "<div class='captiongroup'>{$bukubesar[0]->parentdescription}</div>";
            $data .= $table."<tbody>";
            $data .= $generateTableHeader($bukubesar[0]);

            //Reset Variable
            $groupaccount = $bukubesar[0]->parentaccountno;
            $keyvalue = $bukubesar[0]->keyvalue;
            $total = array("Debit"=>0,"Credit"=>0,"Detil"=>$bukubesar[0]->saldoawal);
        }
        $border = 'no-border';
        foreach($bukubesar as $value) {
        	if ($groupaccount != $value->parentaccountno) {
                //Generate Sub Total
                $data .= $generateSubTotal($total);
                $data .= "</tbody></table> <br/>";

                $data .= "<div class='captiongroup'>{$value->parentdescription}</div>";
                $data .= $table."<tbody>";
                $data .= $generateTableHeader($value);

                //Reset Variable
                $keyvalue = $value->keyvalue;
                $groupaccount = $value->parentaccountno;
                $total = array("Debit"=>0,"Credit"=>0,"Detil"=>$bukubesar[0]->saldoawal);
            }

            if ($keyvalue != $value->keyvalue) {
                //Generate Sub Total
                $data .= $generateSubTotal($total);
                $data .= $generateTableHeader($value);
                $total = array("Debit"=>0,"Credit"=>0,"Detil"=>$value->saldoawal);
            }

            $total['Debit'] += $value->debit;
            $total['Credit'] += $value->credit;
            $total['Detil'] += ($value->debitacc == 1 ? $value->debit - $value->credit : $value->credit - $value->debit);

            //Generate Table Detil
            $data .=
                "<tr>
                    <td width='13%' class='text-left {$border}'>".date_format(date_create($value->journaldate), "d-M-Y")."</td>
                    <td width='12%' class='text-left {$border}'>{$value->journalno}</td>
                    <td width='30%' class='text-left {$border}'>{$value->remark}</td>
                    <td width='15%' class='text-right {$border}'>".$this->sidlib->my_format($value->debit)."</td>
                    <td width='15%' class='text-right {$border}'>".$this->sidlib->my_format($value->credit)."</td>
                    <td width='15%' class='text-right {$border}'>".$this->sidlib->my_format($total['Detil'])."</td>
                </tr>";

            $keyvalue = $value->keyvalue;
            $groupaccount = $value->parentaccountno;
        }
        $data .= $generateSubTotal($total);


     //        $data .=
     //    	"<tr>
     //    		<td class='text-left strong no-border'>".date_format(date_create($valueH->journaldate), "d-M-Y")."</td>
     //            <td class='text-left strong no-border'>{$valueH->journalno}</td>
     //    		<td colspan = '3' class='text-left strong no-border'>{$valueH->journalremark}</td>
     //    	</tr>";
     //        // <td class='text-right strong no-border'>".$this->sidlib->my_format($valueH->dueamount)."</td>
     //        // <td class='text-right strong no-border'>".$this->sidlib->my_format($valueH->dueamount)."</td>

     //    	$journaldetil = $this->report_model->get_GLjournalDetil($valueH->journalid);
     //        $debet = 0;
     //        $kredit = 0;
     //        $counter=0;
		   //  foreach ($journaldetil as $value) {
		   //  	$counter++;
		   //  	$border = ($counter == count($journaldetil)) ? 'no-border' : 'no-border';
		   //  	$data .=
		   //  	"<tr>
	    //     		<td colspan='2' class='text-right {$border}'>{$value->accountno}</td>
	    //     		<td class='text-left {$border}'>{$value->description}</td>
	    //     		<td class='text-right {$border}'>{$value->debit}</td>
	    //     		<td class='text-right {$border}'>{$value->credit}</td>
	    //     	</tr>";
     //            $debet += $value->debit;
     //            $kredit += $value->credit;
		   //  }
     //        $data .=
     //        "<tr>
     //            <td colspan='3' class='subtotal-gl saldocaption'></td>
     //            <td class='subtotal-gl'>".$this->sidlib->my_format($debet)."</td>
     //            <td class='subtotal-gl'>".$this->sidlib->my_format($kredit)."</td>
     //        </tr>
     //        ";
    	// }
     //    if (count($bukubesar) > 0) {
     //    	$data .= "</tbody>";
     //    	$data .= "</table>";
     //    }

    	$data = array('title'		=> $caption,
					  'record'		=> $data,
					  'header'=>$dataheader,
					  'orientation' => $orientation
					  );
		$this->load->view('Report/laporan_print',$data);
    }
}