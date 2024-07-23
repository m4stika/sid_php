<?php 
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Buktitransaksi_KB extends MY_Controller {

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
		$this->pdf->SetHeaderData('',0,'','');
		//$this->pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING,array(5,193,250));  
		//$this->pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
		//$this->pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
		$this->pdf->SetDefaultMonospacedFont('helvetica');  
		$this->pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
		$this->pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$this->pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);  
		$this->pdf->setPrintHeader(false);  
		$this->pdf->setPrintFooter(false);  
		$this->pdf->SetAutoPageBreak(TRUE, 10);  
		$this->pdf->SetFont('helvetica', '', 10);  
		$this->pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
	}

	public function index() {
		$reportstyle = '
		<style type="text/css">
			span.company {
				font-weight: bold;
			}
			.title {
			    text-align: center;
			    font-size: 14pt;
			    font-weight: bold;
			    color: navy;
			    text-decoration: underline;
			    line-height: 15px;
			}
			span.titlecaptioan {
			    text-align: center;
			    font-size: 10pt;
			    font-weight: bold;
			}
			th.info {
				font-size: 8pt;
			}
			th.line {
    			border-top-style:none;
			}
			td {
				height: 10vh;
				font-size: 9pt;
				border-right-style:none;
    			border-left-style:none;
			}
			.top {
				vertical-align: middle;
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
			.number {
				text-align: right;
				font-weight: bold;
			}
		</style>';

		$parameter = $this->report_model->get_parameter();
		$dataHeader = $this->report_model->get_KasbankHeader();
		
		// Generate Report Title
		$this->pdf->SetMargins(10, 5, 10);  
		$this->pdf->setCellHeightRatio(1.8);
		$this->pdf->SetTitle('SID | Bukti Transaksi Kasbank');
		$this->pdf->AddPage();

		// Generate Report Header
		$judul = ($dataHeader->kasbanktype == 0 | $dataHeader->kasbanktype == 2) ? "BUKTI PENERIMAAN" : "BUKTI PENGELUARAN";
		$reportHeader =
		'<table>
			<tr>
				<th width="35%"><span class="company">'.$parameter->company.'</span><br/>'.$parameter->address.'<br/>'.$parameter->city.'</th>
				<th width="30%" ><br/><br/><div class="title">'.$judul.'</div><span class="titlecaptioan">'.$dataHeader->namabank.'</span></th>
				<th width="35%" class="info right">No. Bukti : <b>'.$dataHeader->nojurnal.'</b><br/><br/>No. Cek : <b>'.$dataHeader->nomorcek.'</b></th>
			</tr>
			<tr ><th colspan="3" class="line"></th></tr>
		</table>';

		// Generate Report Data Header
		$reportDataHeader =
		'<table cellspacing="0" cellpadding="2" border="1">
			<tr><th colspan="4" class="line">Terima Dari : </th></tr>
			<tr>
				<th colspan="2" width="70%" height="60"> Terbilang : //'.$this->sidlib->terbilang($dataHeader->totaltransaksi).' Rupiah //</th>
				<th colspan="2" width="30%" class="number"> Rp. '.$this->sidlib->my_format($dataHeader->totaltransaksi).'</th>
			</tr>
			<tr>
				<th width="10%" class="center">No</th>
				<th width="50%">Uraian</th>
				<th width="20%" class="center">Perkiraan</th>
				<th width="20%" class="right">Nilai</th>
			</tr>';
		

		// Generate Report Data
		$reportData = '';
		$no = 0;
		$record = $this->report_model->get_Buktitransaksi_KB();
    	foreach ($record as $value) {
			$no++;
			$reportData .=
				'<tr>
					<td class="center">'.$no.'</td>
					<td>'.$value->remark.'</td>
					<td class="center">'.$value->accountno.'</td>
					<td class="right">'.$this->sidlib->my_format($value->amount).'</td>
				</tr>';
			
		}
		$reportData .= '</table>';

		// Generate Report Footer
		$tglsystem = date_create();
		$reportFooter =
		'<table>
			<tr><th colspan="3" class="right">'.$parameter->city.', '.date_format($tglsystem, "d-M-Y").'</th></tr>
			<tr>
				<th width="35%">Disetujui oleh,<br/><br/><br/><div class="underline">'.$parameter->pimpinan.'</div>'.$parameter->pimpinantitle.'</th>
				<th width="30%" class="center">Diperiksa oleh,<br/><br/><br/><div class="underline">'.$parameter->accounting.'</div>'.$parameter->accountingtitle.'</th>
				<th width="35%" class="right">Dibuat oleh,<br/><br/><br/><div class="underline">'.$parameter->kasir.'</div>'.$parameter->kasirtitle.'</th>
			</tr>
		</table>';


		$reporthtml = $reportstyle.$reportHeader.$reportDataHeader.$reportData.$reportFooter;

		$this->pdf->Ln(5);
    	$this->pdf->writeHTML($reporthtml, true, true, true, true);//, false, true, 'R', true);
    	//$this->pdf->Cell(190, 0, '', 'B', $ln=1, 'C', 0, '', 4, false, 'B', 'B');
		
		
		//Generate PDF file
		ob_end_clean();
		$this->pdf->Output('Buktitransaksi_KB.pdf', 'I');	
	}
}
?>