<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Chartofaccount extends MY_Controller {

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
		$this->pdf->setFontSubsetting(false);
		$this->pdf->SetAutoPageBreak(TRUE, 10);  
		$this->pdf->SetFont('helvetica', '', 10);  
		$this->pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
	}

	public function index() {
		$style =
		'<style type="text/css">
			table {
				border-width:.5px;  
    			border-style:solid;
    			border-color: white grey white grey;
    			border-collapse: collapse;
				/*color: #003300;
				font-family: helvetica;
				font-size: 10pt;
				*/
			}
			table.noborder {
				border:none;
			}
			th {
				height: 30vh;
				border-top:.5px solid grey;
				background-color: #2AB4C0;
				color: white;
				text-align: center;
			}
			th.nocolor {
				background-color: white;
				color: black;
			}
			td {
				font-size: 8pt;
				line-height: 2;
				font-style: italic;
			}
			td.header {
				font-size: 9pt;
				color: #2C3E50;
				font-style:normal;
				font-weight:bold;
			}
			td.total {
				font-size: 10pt;
				color: navy;
    			border-top:.5px solid grey;
				font-weight:bold;
			}
			td.grandtotal {
				font-size: 10pt;
				color: #2C3E50;
				/*border-width:3px;  
    			border-style:dashed;*/
    			border-top:1.5px dashed #2AB4C0;
				font-weight:bold;
			}
			td.grandtotalcaption {
				font-size: 10pt;
				color: #2C3E50;
				font-weight:bold;
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
			.underline {
				text-decoration: underline;
				line-height: 1.8em;
			}
		</style>';

		$sidlib = $this->sidlib;
		$periode = date_create($this->input->post('periode'));
		$periode1 = date_create($this->input->post('periode1'));
		$parameter = $this->report_model->get_parameter();
		
		// Generate Report Title
		$this->pdf->SetMargins(5, PDF_MARGIN_TOP, 5, true);  
		$this->pdf->setCellHeightRatio(1.8);
		$this->pdf->SetTitle('SID | Chart Of Account');
		$this->pdf->AddPage();
		
		// Generate Report Header
		$this->pdf->SetFont('','B',20);
		$this->pdf->SetTextColor(0,44,163);
		$this->pdf->Cell(60, 0,''); //267
		$this->pdf->Cell(80, 0, 'Chart Of Account', 'B', $ln=1, 'C', 0, '', 4, false, 'C', 'B');
		$this->pdf->SetFont('','',10);
		$this->pdf->SetTextColor(0,0,0);
		$this->pdf->Cell(60, 0,'');
		$this->pdf->Cell(80, 0, date_format($periode, "d-M-Y").' s/d '.date_format($periode1, "d-M-Y"), '', $ln=1, 'C', 0, '', 0, false, 'T', 'T');
		$this->pdf->SetFont('','B',12);
		$this->pdf->Cell(0, 0, $this->input->post('item'), '', $ln=1, 'C', 0, '', 0, false, 'T', 'B');
		$this->pdf->SetFont('','',10);
		$tableheader =
				'<tr>
        			<th width="15%" class="center">Account</th>
        			<th width="33%" class="center">Description</th>
            		<th width="13%" class="right">Opening</th>
            		<th width="13%" class="right">Debit</th>
            		<th width="13%" class="right">Credit</th>
            		<th width="13%" class="right">Ballance Due</th>
        		</tr>';

        $html = $style.'<table nobr="true">'.$tableheader.'</table>';
        $this->pdf->writeHTML($html, false, true, true, false);//, false, true, 'R', true);
        ob_clean();

        $start = 0;
        $limit = 10;
        $loop = 2;// ceil($this->report_model->get_totalrecord('perkiraan') / $limit);
        for ($i=0; $i <= $loop ; $i++) { 
        	$perkiraan = $this->report_model->get_chartofaccount($limit, $start);
        	$tabledata = null;
        	$html = null;

        	foreach ($perkiraan as $value) {
        	$classname = ($value->classacc == 0) ? "header" : "detil";
        	$params = ($value->classacc == 0) ? $this->pdf->serializeTCPDFtagParameters(array(0)) : $this->pdf->serializeTCPDFtagParameters(array(4));
        	$caption = $this->pdf->serializeTCPDFtagParameters(array(0,0, $value->description));
        	$tabledata .= <<<EOD
		    	<tr>
	        		<td class="right {$classname}">{$value->accountno}</td>
	        		<td class="left {$classname}">
            			<tcpdf method="setCellPaddings" params="{$params}"/>
            			<tcpdf method="Cell" params="{$caption}" />            			
            		</td>
	        		<td class="right {$classname}">{$this->sidlib->my_format($value->openingbalance)}</td>
	        		<td class="right {$classname}">{$this->sidlib->my_format($value->debet)}</td>
	        		<td class="right {$classname}">{$this->sidlib->my_format($value->kredit)}</td>
	        		<td class="right {$classname}">{$this->sidlib->my_format($value->balancedue)}</td>
		    	</tr>
EOD;

?>
 <?php

        }
        $start = $limit*($i+1);

        $html .= $style.'<table nobr="true">'.$tabledata.'</table>';
        $this->pdf->writeHTML($html, false, true, true, false);//, false, true, 'R', true);
        ob_clean();
        $this->pdf->SetMargins(5, PDF_MARGIN_TOP, 5, true);  
        
    }


        // $html = $style.'<table>'.$tabledata.'</table>';
        // $this->pdf->writeHTML($html, true, true, true, true);//, false, true, 'R', true);
        

        // $html = $style.
        // 	'<table>'
        // 		.$tableheader
        // 		.$tabledata.
        // 	'</table>';

        // $this->pdf->writeHTML($html, true, true, true, true);//, false, true, 'R', true);

		//Generate PDF file
		ob_end_clean();
		$this->pdf->Output('chartofaccount.pdf', 'I');
    }
}
?>