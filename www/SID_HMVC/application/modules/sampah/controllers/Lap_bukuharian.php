<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Lap_bukuharian extends MY_Controller {

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
		$style =
		'<style type="text/css">
			table {
				border: .5px solid grey;
				color: #003300;
				font-family: helvetica;
				font-size: 10pt;
				border-collapse: collapse;
			}
			table.noborder {
				border:none;
			}
			th {
				height: 30vh;
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
				font-size: 8pt;
				color: #2C3E50;
				border-top:.5px solid grey;
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
		$this->pdf->SetMargins(5, PDF_MARGIN_TOP, 5);  
		$this->pdf->setCellHeightRatio(1.8);
		$this->pdf->SetTitle('SID | Laporan Buku Harian');
		$this->pdf->AddPage();
		
		// Generate Report Header
		$this->pdf->SetFont('','B',20);
		$this->pdf->SetTextColor(0,44,163);
		$this->pdf->Cell(60, 0,''); //267
		$this->pdf->Cell(80, 0, 'Laporan Buku Harian', 'B', $ln=1, 'C', 0, '', 4, false, 'C', 'B');
		$this->pdf->SetFont('','',10);
		$this->pdf->SetTextColor(0,0,0);
		$this->pdf->Cell(60, 0,'');
		$this->pdf->Cell(80, 0, date_format($periode, "d-M-Y").' s/d '.date_format($periode1, "d-M-Y"), '', $ln=1, 'C', 0, '', 0, false, 'T', 'T');

		$this->pdf->SetFont('','B',12);
		$this->pdf->Cell(0, 0, $this->input->post('item'), '', $ln=1, 'C', 0, '', 0, false, 'T', 'B');
		$this->pdf->SetFont('','',10);
		$tableheader =
				'<tr>
        			<th width="15%" class="center">No. Bukti</th>
        			<th width="15%" class="center">Tanggal</th>
            		<th width="40%">Uraian</th>
            		<th width="15%" class="right">Penerimaan</th>
            		<th width="15%" class="right">Pengeluaran</th>
        		</tr>';

        //Generate Record
        $dataHeader = $this->report_model->get_lapbukuharianHeader($this->input->post('linkid'));
        $tabledata = '';
        $totalPenerimaan = 0;
        $totalPengeluaran = 0;
        foreach ($dataHeader as $valueHeader) {
        	$tglentry = date_create($valueHeader->tglentry);
        	$totalPenerimaan += $valueHeader->penerimaan;
        	$totalPengeluaran += $valueHeader->pengeluaran;
        	$tabledata .=
        		'<tr>
	        		<td class="center header">'.$valueHeader->nojurnal.'</td>
	        		<td class="center header">'.date_format($tglentry, "d-M-Y").'</td>
	        		<td class="left header">'.$valueHeader->uraian.'</td>
	        		<td class="right header">'.$this->sidlib->my_format($valueHeader->penerimaan).'</td>
	        		<td class="right header">'.$this->sidlib->my_format($valueHeader->pengeluaran).'</td>
		    	</tr>';

		    $dataDetil = $this->report_model->get_lapbukuharianDetil($valueHeader->noid);
		    foreach ($dataDetil as $value) {
		    	$debet = ($valueHeader->kasbanktype == 0 || $valueHeader->kasbanktype == 2) ? $this->sidlib->my_format($value->amount) : '';
		    	$kredit = ($valueHeader->kasbanktype == 1 || $valueHeader->kasbanktype == 3) ? $this->sidlib->my_format($value->amount) : '';
		    	$tabledata .=
		    	'<tr>
	        		<td colspan="2" class="right">'.$value->accountno.'</td>
	        		<td class="left">'.$value->remark.'</td>
	        		<td class="right">'.$debet.'</td>
	        		<td class="right">'.$kredit.'</td>
		    	</tr>';
		    }
        }
        $saldoawal = $this->report_model->get_SaldoawalKB($this->input->post('linkid'));
        $saldoakhir = $saldoawal + $totalPenerimaan - $totalPengeluaran;
        $tabledata .=
		    	'<tr>
	        		<td colspan="3" class="right total">JUMLAH MUTASI</td>
	        		<td class="right total">'.$this->sidlib->my_format($totalPenerimaan).'</td>
	        		<td class="right total">'.$this->sidlib->my_format($totalPengeluaran).'</td>
		    	</tr>
		    	<tr>
	        		<td colspan="3" class="right grandtotalcaption">SALDO AWAL & SALDO AKHIR</td>
	        		<td class="right grandtotal">'.$this->sidlib->my_format($saldoawal).'</td>
	        		<td class="right grandtotal">'.$this->sidlib->my_format($saldoakhir).'</td>
		    	</tr>';

        $html = $style.
        	'<table>'
        		.$tableheader
        		.$tabledata.
        	'</table>';

        // Generate Report Footer
		$tglsystem = date_create();
		$reportFooter = 
		'<br/><br/><table class="noborder">
			<tr><th colspan="3" class="right nocolor">'.$parameter->city.', '.date_format($tglsystem, "d-M-Y").'</th></tr>
			<tr>
				<th width="35%" class="left nocolor">Disetujui oleh,<br/><br/><br/><div class="underline">'.$parameter->pimpinan.'</div>'.$parameter->pimpinantitle.'</th>
				<th width="30%" class="center nocolor">Diperiksa oleh,<br/><br/><br/><div class="underline">'.$parameter->accounting.'</div>'.$parameter->accountingtitle.'</th>
				<th width="35%" class="right nocolor">Dibuat oleh,<br/><br/><br/><div class="underline">'.$parameter->kasir.'</div>'.$parameter->kasirtitle.'</th>
			</tr>
		</table>';

	    $this->pdf->writeHTML($html.$reportFooter, true, true, true, true);//, false, true, 'R', true);	    	

		//Generate PDF file
		ob_end_clean();
		$this->pdf->Output('infobukuharian.pdf', 'I');
    }
}
?>