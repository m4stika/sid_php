<?php 
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Reportpdf extends MY_Controller
{	
	public $style = '
		<style type="text/css">
			h1 {
				color: navy;
				font-family: times;
				font-size: 24pt;
				text-align: center;
				/*text-decoration: underline;*/
			}
			h1 i {
				color:#990000;
				font-size: 15pt;
			}
			h1 >span {
				font-size: 11pt;
				text-decoration: none;
			}
			h1.underline {
				text-decoration: underline;
			}
			h3 {
				margin-bottom: 0;
				padding: 0 0 0 0;
				line-height: 1;
				height: 15px;
			}
			
			table {
				color: #003300;
				font-family: helvetica;
				font-size: 10pt;
				border-collapse: collapse;
				padding-top: 3px;
			}
			th {
				height: 20vh;
				background-color: #2AB4C0; /*#36D7B7;*/
				color: white;
				border: 1px solid black;
				text-align: center;
			}
			th.vcenter {
				line-height: 2;
			}
			th.vtop {
				line-height: .5;
			}
			/*td {
				border: .5px solid grey;
				height: 10vh;
				font-size: 8pt;
			}*/
			td {
				/*border-color: grey;*/
				height: 10vh;
				font-size: 8pt;
			}
			.none {
    			border-right-style:none;
    			border-left-style:none;
			}
			.nonebuttom {
    			border-right-style:none;
    			border-bottom-style:none;
			}
			td.footer {
				text-align:right; 
				font-weight:bold; 
				font-size:1em;
				color: #D91E18;
			}
			th.number, td.number {
				text-align: right;
			}
			td.bold {
				font-weight: bold;
			}
			.title {
				color: navy;
				font-family: times;
				font-size: 16pt;
			}
			.left {
				text-align: left;
			}
			.right {
				text-align: right;
			}
			.center {
				float: center;
			}
			.address > strong {
				font-size: 14pt;
			}
		</style>';

	public function __construct()
	{
		parent::__construct();		
		$this->load->library('Pdf','pdf');
		$this->load->library('Sidlib','sidlib');

		$this->pdf->SetCreator(PDF_CREATOR);
		$this->pdf->SetAuthor('Mastika');
		$this->pdf->SetTitle('SID | Export PDF');
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

		//$this->pdf->SetFont('times', 'BI', 20);
		// $this->pdf->SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 4, 'color' => array(255, 0, 0)));
		//$this->pdf->setHtmlVSpace(array('p' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0))));
		
	}

	public function generatePdf($content = '', $filename = 'sample.pdf') {
		$this->pdf->writeHTML($content);  
		//$this->pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $content, $border = 1, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);

		//$this->pdf->Write($h=0, $content, $link='', $fill=0, $align='C', $ln=true, $stretch=0, $firstline=false, $firstblock=false, $maxh=0);
      	ob_end_clean();
      	$this->pdf->Output($filename, 'I');
	}
}
?>