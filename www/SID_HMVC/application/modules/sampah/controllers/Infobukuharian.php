<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Infobukuharian extends MY_Controller {

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
			table, th {
				border: .5px solid grey;
				color: #003300;
				font-family: helvetica;
				font-size: 10pt;
				border-collapse: collapse;
			}
			td {
				font-size: 8pt;
				border-left:.5px solid grey;
    			border-right:.5px solid grey;
    			line-height: 2;
    			
			}
			td.header {
				font-size: 9pt;
				font-weight:bold;
				color: #2C3E50;
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

		$sidlib = $this->sidlib;
		$periode = date_create($this->input->post('periode'));
		$periode1 = date_create($this->input->post('periode1'));
		$parameter = $this->report_model->get_parameter();
		
		// Generate Report Title
		$this->pdf->SetMargins(5, PDF_MARGIN_TOP, 5);  
		$this->pdf->setCellHeightRatio(1.8);
		$this->pdf->SetTitle('SID | Informasi Buku Harian');
		$this->pdf->AddPage();
		
		// Generate Report Header
		$this->pdf->SetFont('','B',20);
		$this->pdf->SetTextColor(0,44,163);
		$this->pdf->Cell(60, 0,''); //267
		$this->pdf->Cell(80, 0, 'Informasi Buku Harian', 'B', $ln=1, 'C', 0, '', 4, false, 'C', 'B');
		$this->pdf->SetFont('','',10);
		$this->pdf->SetTextColor(0,0,0);
		$this->pdf->Cell(60, 0,'');
		$this->pdf->Cell(80, 0, date_format($periode, "d-M-Y").' s/d '.date_format($periode1, "d-M-Y"), '', $ln=1, 'C', 0, '', 0, false, 'T', 'T');
		$tableheader =
				'<tr>
        			<th width="14%" class="center">Kode</th>
            		<th width="30%">Perkiraan</th>
            		<th width="14%" class="right">Saldo Awal</th>
            		<th width="14%" class="right">Debet</th>
            		<th width="14%" class="right">Kredit</th>
            		<th width="14%" class="right">Saldo Akhir</th>
        		</tr>';

        $record = $this->report_model->get_infobukuharian();
        $tabledata = '';
        
        foreach ($record as $value) {
        	$classname = ($value->classacc == 0) ? "header" : "";
        	$params = ($value->classacc == 0) ? $this->pdf->serializeTCPDFtagParameters(array(0)) : $this->pdf->serializeTCPDFtagParameters(array(4));
        	$caption = $this->pdf->serializeTCPDFtagParameters(array(0,0, $value->description));
        	$tabledata .= <<<EOD
        		<tr>
        			<td class="center {$classname}">{$value->accountno}</td>
            		<td class="left {$classname}">
            			<tcpdf method="setCellPaddings" params="{$params}"/>
            			<tcpdf method="Cell" params="{$caption}" />            			
            		</td>
            		<td class="right {$classname}">{$sidlib->my_format($value->saldoawal)}</td>
            		<td class="right {$classname}">{$sidlib->my_format($value->debet)}</td>
            		<td class="right {$classname}">{$sidlib->my_format($value->kredit)}</td>
            		<td class="right {$classname}">{$sidlib->my_format($value->saldoakhir)}</td>
        		</tr>
EOD;
?>
<?php
        }

        $html = style.
        	'<table>'
        		.$tableheader
        		.$tabledata.
        	'</table>';

        $this->pdf->Ln(5);
	    $this->pdf->writeHTML($html, true, true, true, true);//, false, true, 'R', true);	    	

		//Generate PDF file
		ob_end_clean();
		$this->pdf->Output('infobukuharian.pdf', 'I');
	}
}
?>