<?php 
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Rekap_kasbank extends MY_Controller {

	public function __construct()
	{
		parent::__construct();		
		$this->load->library('Pdf','pdf');
		$this->load->library('Sidlib','sidlib');
		$this->load->model('report_model');

		$this->pdf->SetCreator(PDF_CREATOR);
		$this->pdf->SetAuthor('Mastika');
		$this->pdf->SetSubject('SID Report');
		$this->pdf->SetKeywords('TCPDF, PDF, SID');
		$this->pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING,array(5,193,250));  
		$this->pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
		$this->pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
		$this->pdf->SetDefaultMonospacedFont('helvetica');  
		$this->pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
		$this->pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$this->pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);  
		//$this->pdf->setPrintHeader(false);  
		$this->pdf->setPrintFooter(false);  
		$this->pdf->SetAutoPageBreak(TRUE, 10);  
		$this->pdf->SetFont('helvetica', '', 10);  
		$this->pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
	}

	public function index() {
		define('style', 
		'
		<style type="text/css">
			table {
				/*border: .5px solid grey;*/
				color: #003300;
				font-family: helvetica;
				font-size: 10pt;
				border-collapse: collapse;
				border-spacing: 10px;
			}
			td {
				font-size: 8pt;
			}
			td.borderleft {		
				border-left:.5px solid grey;
			}
			td.borderright {		
    			border-right:.5px solid grey;		
			}
			th.titlecaption {
    			border-bottom:.5px solid grey;
    			border-left:.5px solid grey;
    			text-align: right;
			}
			th.titlevalue {
    			border-bottom:.5px solid grey;
    			border-right:.5px solid grey;
    			text-align: right;
    			font-weight:bold;
			}
			th.grouptitle {
    			font-weight:bold;
    			text-align: center;
    			border-top:.5px solid grey;
    			border-left:.5px solid grey;
    			border-right:.5px solid grey;
			}
			th.subtitle {
    			font-weight:bold;
    			border-left:.5px solid grey;
    			border-right:.5px solid grey;
			}
			th.subtotalcaption {
    			border-top:.5px solid grey;
    			border-bottom:.5px solid grey;
    			border-left:.5px solid grey;
    			text-align: right;
			}
			th.subtotalvalue {
    			border-top:.5px solid grey;
    			border-right:.5px solid grey;
    			border-bottom:.5px solid grey;
    			text-align: right;
    			font-weight:bold;
			}

			th.space {
    			line-height: .2;
			}
			.left {
				text-align: left;
			}
			.right {
				text-align: right;
			}
			.center {
				text-align: center;
			}
		</style>');

		$periode = date_create($this->input->post('periode'));
		$periode1 = date_create($this->input->post('periode1'));
		$parameter = $this->report_model->get_parameter();
		
		// Generate Report Title
		$this->pdf->SetMargins(5, PDF_MARGIN_TOP, 5);  
		$this->pdf->setCellHeightRatio(1.8);
		$this->pdf->SetTitle('SID | Rekapitulasi Kas-Bank');
		$this->pdf->AddPage();
		
		// Generate Report Header
		$this->pdf->SetFont('','B',20);
		$this->pdf->SetTextColor(0,44,163);
		$this->pdf->Cell(60, 0,''); //267
		$this->pdf->Cell(80, 0, 'Rekapitulasi Kas-Bank', 'B', $ln=1, 'C', 0, '', 4, false, 'C', 'B');
		$this->pdf->SetFont('','',10);
		$this->pdf->SetTextColor(0,0,0);
		$this->pdf->Cell(60, 0,'');
		$this->pdf->Cell(80, 0, date_format($periode, "d-M-Y").' s/d '.date_format($periode1, "d-M-Y"), '', $ln=1, 'C', 0, '', 0, false, 'T', 'T');

		//Generate Table Header
		$tableData = '';
		if ($this->input->post('linkid') == 'undefined') {
			//$tableData .= 'Not Isset'.$this->input->post('linkid');
			$recordHeader = $this->report_model->get_AccountHeader();
			$haslinkid = 0;
		} else {
			//$tableData .= 'Isset : '.$this->input->post('linkid');
			$account = $this->report_model->get_Accountby_id($this->input->post('linkid'));
			$parentkey = ($account->classacc == 0) ? $account->keyvalue :  $account->parentkey;
			//$parentkey = $account->parentkey;
			//$tableData .= 'parentkey : '.$parentkey;
			$recordHeader = $this->report_model->get_Accountby_keyvalue($parentkey);
			$haslinkid = ($account->classacc == 0) ? 0 :  1;
		}
		
		$totHeader = count($recordHeader);
		$counter = 0;
		foreach ($recordHeader as $recordH) {
			$counter++;
			$saldoperGroupheader = 0;
			$tableData = 
				'<table  cellspacing="0" cellpadding="2"> 
					<tr> 
						<th colspan="3" class="center">'.$recordH->description.'</th>
					</tr>';

			$dataHeader = $this->report_model->get_RekapKasbankHeader($recordH->keyvalue, $haslinkid);
			//$tableData .= '<tr> <th colspan="3" class="center">'.$recordH->keyvalue.'</th></tr>';
			$newGroup = '';
			$subtotalpertype = 0;
			$subtotalgroup = array('penambahan'=>0, 'pengurangan'=>0);
			$banktype = -1;
			$saldoawal = 0;
			
			foreach ($dataHeader as $groupH) {
				$banktype = $subtotalpertype == 0 ? $groupH->kasbanktype : -1;
				$banktypedesc = ($groupH->kasbanktype == 0 || $groupH->kasbanktype == 2) ? 'PENERIMAAN' : 'PENGELUARAN';
				$banktypedesclower = ($groupH->kasbanktype == 0 || $groupH->kasbanktype == 2) ? 'Penerimaan' : 'Pengeluaran';
				$subtotal = 0;

				$dataDetil = $this->report_model->get_RekapKasbankDetil($groupH->rekid, $groupH->kasbanktype);
				$hasrecord = 0;
				foreach ($dataDetil as $value) {
					if ($hasrecord == 0) {
						if ($banktype == $groupH->kasbanktype) {
							$saldoawal = $this->report_model->get_SaldoawalKB($groupH->rekid);
							$tableData .= 
							'<tr> <th colspan="3" class="grouptitle">('.$groupH->accountno.') '.$groupH->description.'</th></tr>
							<tr> 
							 	<th width="85%" colspan="2" class="titlecaption">Saldo Awal</th>
								<th width="15%" class="titlevalue"><b>'.$this->sidlib->my_format($saldoawal).'</b></th>
							</tr>';
						}
						$tableData .=
							'<tr> <th colspan="3"  class="left subtitle">'.$banktypedesc.'</th></tr>';
					}
					$subtotal += $value->amount;
					$tableData .= 
					'<tr>
		        		<td width="20%" class="center borderleft">'.$value->accountno.'</td>
		        		<td width="60%" class="left">'.$value->description.'</td>
		        		<td width="20%" class="right borderright">'.$this->sidlib->my_format($value->amount).'</td>
		    		</tr>';
		    		$hasrecord = 1;
				}
				$subtotalpertype += $subtotal;
				if ($groupH->kasbanktype == 0 || $groupH->kasbanktype == 2) {
					$subtotalgroup['penambahan'] +=  $subtotal;
				} else {
					$subtotalgroup['pengurangan'] += $subtotal;
				}

				if ($hasrecord == 1) {
					$tableData .=
						'<tr> 
						 	<th width="85%" colspan="2" class="subtotalcaption">Total '.$banktypedesclower.'</th>
							<th width="15%" class="subtotalvalue">'.$this->sidlib->my_format($subtotal).'</th>
						</tr>';						
				}

				if ($subtotalpertype != 0 && $banktype != $groupH->kasbanktype) {
					$saldoperGroupheader += $saldoawal + $subtotalgroup['penambahan'] - $subtotalgroup['pengurangan'];
					$tableData .=
						'<tr> 
						 	<th width="85%" colspan="2" class="subtotalcaption"><b>Saldo Akhir '.$groupH->description.'</b></th>
							<th width="15%" class="subtotalvalue">'.$this->sidlib->my_format($saldoawal + $subtotalgroup['penambahan'] - $subtotalgroup['pengurangan']).'</th>
						</tr>	
						<tr> <th colspan="3" class="space"></th></tr>';
					$subtotalpertype = 0;

				}				
				$banktype = $groupH->kasbanktype;
			}

//Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='M')
			$tableData .= '</table>';
			$texthtml = style.'<table>'.$tableData.'</table>';
			$this->pdf->Ln(5);
	    	$this->pdf->writeHTML($texthtml, true, true, true, true);//, false, true, 'R', true);	    	
	    	$this->pdf->SetFont('','B',14);
			$this->pdf->SetTextColor(0,44,163);
	    	$this->pdf->Cell(148, 0,'');
	    	$this->pdf->SetLineStyle(array('width' => 1, 'cap' => 'square', 'join' => 'bevel', 'dash' => 2, 'color' => array(255, 0, 0)));
	    	$this->pdf->Cell(50, 0, $this->sidlib->my_format($saldoperGroupheader), 'B', $ln=1, 'R', 0, '', 0, false, 'C', 'B');
	    	if ($totHeader != $counter) {
	    		$this->pdf->AddPage();
	    	}
		}
		
		//Generate PDF file
		ob_end_clean();
		$this->pdf->Output('Rekap_kasbank.pdf', 'I');	
	}
}
?>    		