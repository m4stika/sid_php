<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* 
 *  Author      : I Ketut Mastika
 *  Email       : m4stika@gmail.com
 *  FB          : https://www.facebook.com/mastenk
 *  Since       : Version 1.X
 *  Copyright   : 2017
 * 
 */
require_once APPPATH.'third_party/tcpdf/tcpdf'.EXT;
//require_once APPPATH.'libraries/sidlib'.EXT;
// TCPDF static color methods and data
class Pdf extends TCPDF{
    public $PageWidth = 0;
    public $PageHeight = 0;

 //    const COLOR = array("navy"=>array(array(0,44,163)), //#002CA3
	// 				   "blue-chambray"=>array(44,62,80),  //#2C3E50
 //        			   "black"=>array(50),				  //#323232	
 //        			   "white"=>array(240),				  //#F0F0F0	
 //        			   "green-sharp"=>array(42, 180, 192), //#28B4C0
 //        			   "grey" => array(150), 				//#969696
 //        			   "grey-dark" => array(169), 				//#a9a9a9
 //        			   "yellow-light"=>array(247, 231, 168)); //#F7E7A8

    

 //    const LINESTYLE_GREY = array('width' => .3, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => sidlib::rgbColor('grey-dark'));
	// const LINESTYLE_DASH_GREY = array('width' => .5, 'cap' => 'butt', 'join' => 'miter', 'dash' => '5,2', 'color' => self::COLOR['grey-dark']);
	// const LINESTYLE_NAVY = array('width' => .3, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => self::COLOR['navy']);
	// const LINESTYLE_WHITE = array('width' => .3, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => self::COLOR['white']);

    public function __construct($orientation = 'P', $unit = 'mm', $format = 'A4', $unicode = TRUE, $encoding = 'UTF-8', $diskcache = FALSE, $pdfa = FALSE) {
        parent::__construct($orientation, $unit, $format, $unicode, $encoding, $diskcache, $pdfa);
    }

    

    public function resetPageWidth() {
    	$margins = $this->getMargins();
		$this->PageWidth = $this->getPageWidth()-($margins['left'] + $margins['right']);
		$this->PageHeight = $this->getPageHeight()-($this->getBreakMargin() + $margins['top']);
    }

    public function initializeReport() {
    	$this->SetCreator(PDF_CREATOR);
		$this->SetAuthor('Mastika');
		$this->SetSubject('SID Report');
		$this->SetKeywords('TCPDF, PDF, SID');
		$this->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING,array(5,193,250));  
		$this->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
		$this->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
		$this->SetDefaultMonospacedFont('helvetica');  
		$this->SetFooterMargin(PDF_MARGIN_FOOTER);  
		$this->SetHeaderMargin(PDF_MARGIN_HEADER);
		$this->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		//$this->setPrintHeader(false);  
		$this->setPrintFooter(false);  
		$this->setFontSubsetting(false);
		$this->SetAutoPageBreak(TRUE, 10);  
		$this->SetFont('helvetica', '', 10);  
		$this->setImageScale(PDF_IMAGE_SCALE_RATIO);
		$this->setCellHeightRatio(1.5);
		$this->resetPageWidth();
    }

    public function reportHeader($text, $align='C', $border=0, $color = array(0), $fontsize = 12, $stretch = 0,  $valign = 'B', $calign='C') {
		//$w = ceil($this->PageWidth / 3);
		$this->SetFont(PDF_FONT_NAME_MAIN,'B',$fontsize);
		$this->SetTextColorArray($color); //Navy
		$this->Cell((30/100)*$this->PageWidth, 0,''); 
		$this->Cell((40/100)*$this->PageWidth, 0, $text, $border, $ln=1, $align, 0, '', $stretch, false, $calign, $valign);
		$this->SetFont(PDF_FONT_NAME_MAIN,'',PDF_FONT_SIZE_MAIN);
		$this->SetTextColorArray(array(0)); //Navy
	}

	public function Footer() {
		$this->SetY(-15);
		$this->SetFont(PDF_FONT_NAME_MAIN, 'I', 8);
		$this->Cell(0, 10, 'finalwebsites.com - PHP Script Resource, PHP classes and code for web developer', 0, false, 'C');
	}
	
	public function CreateTextBox($textval, $ln=0, $x=0, $y=0, $width=0, $height=10, $fontsize=10, $fontstyle='', $align='L') {
		//$this->SetXY($x+20, $y); // 20 = margin left
		$this->SetFont(PDF_FONT_NAME_MAIN, $fontstyle, $fontsize);
		$this->Cell($width, $height, $textval, 0, $ln, $align);
	}

//Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='M')
	public function CreateGroupText($textval=array(''), $ln=0, $width=array(0), $height=10, $fontsize=10, $fontstyle=array(''), $align=array('L'), $border=array(0), $Ln_LastCol=1, $fill = 0) {
		
		if ($height=='' || $height==0) $height=10;
		if ($fontsize=='' || $fontsize==0) $fontsize=10;
		
		for ($i=0; $i < count($textval); $i++) { 
			if (! isset($width[$i])) array_push($width,$width[$i-1]);
			if (! isset($fontstyle[$i])) array_push($fontstyle,$fontstyle[$i-1]);
			if (! isset($align[$i])) array_push($align,$align[$i-1]);
			if (! isset($border[$i])) array_push($border,$border[$i-1]);
			
			$this->SetFont(PDF_FONT_NAME_MAIN, $fontstyle[$i], $fontsize);
			$this->Cell($width[$i]/100*$this->PageWidth, $height, $textval[$i], $border[$i], $ln, $align[$i], $fill);
		}
		if ($Ln_LastCol == 1) $this->Ln();
		$this->SetFont(PDF_FONT_NAME_MAIN,'');
	}

//MultiCell($w, $h, $txt, $border=0, $align='J', $fill=false, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0, $valign='T', $fitcell=false)
	public function CreateGroupTextMulti($textval=array(''), $ln=0, $width=array(0), $height=10, $fontsize=10, $fontstyle=array(''), $align=array('L'), $border=array(0), $fill=0, $Ln_LastCol=1) {
		//$this->SetFont(PDF_FONT_NAME_MAIN, $fontstyle, $fontsize);
		for ($i=0; $i < count($textval); $i++) { 
			if (! isset($width[$i])) array_push($width,$width[$i-1]);
			if (! isset($fontstyle[$i])) array_push($fontstyle,$fontstyle[$i-1]);
			if (! isset($align[$i])) array_push($align,$align[$i-1]);
			if (! isset($border[$i])) array_push($border,$border[$i-1]);
			
			$this->SetFont(PDF_FONT_NAME_MAIN, $fontstyle[$i], $fontsize);
			$this->MultiCell($width[$i]/100*$this->PageWidth, $height, $textval[$i], $border[$i], $align[$i], $fill, $ln, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=$height, $valign='M');
		}
		if ($Ln_LastCol == 1) $this->Ln();
	}

	public function CreateDoubleLine($x, $y, $width=0, $height=0) {
		$this->SetXY($x, $y);
    	$this->Cell($width, $height, '', 'T', $ln=0, '');
    	$this->SetXY($x, $y+1);
    	$this->Cell($width, $height, '', 'T', $ln=0, '');
	}

	public function FooterAssign($parameter, $fontsize=8) {
		$this->SetFont('', '',$fontsize);
        $this->Cell($PageWidth, 8, $parameter->city.', '.date_format(date_create(), "d-M-Y") , 0, 0, 'R');
        $this->Ln();
        $this->setEqualColumns(3);
        $this->MultiCell(0, 0, 'Disetujui Oleh,'."\n\n\n\n".$parameter->pimpinan."\n".$parameter->pimpinantitle, 0, 'C');
        $this->selectColumn(1);
        $this->MultiCell(0, 0, 'Diperiksa Oleh,'."\n\n\n\n".$parameter->accounting."\n".$parameter->accountingtitle, 0, 'C');
        $this->selectColumn(2);
        $this->MultiCell(0, 0, 'Dibuat Oleh,'."\n\n\n\n".$parameter->kasir."\n".$parameter->kasirtitle, 0, 'C',0,1);
	}

	public function FooterAssignSingle($parameter, $fontsize=8, $penandatangan='Bagian Penjualan') {
		$this->SetFont('', '',$fontsize);
        $this->Cell(0, 8, $parameter->city.', '.date_format(date_create(), "d-M-Y") , 0, 0, 'L');
        $this->Ln();
        $this->MultiCell(0, 0, $parameter->company."\n\n\n\n".$penandatangan, 0, 'L');
	}

	public function HeaderTablePemasaran($firsText='No Booking') {
		$fill = 1;
        $h = 28;
        $h1 = 20;
        //Print Column 1 & 2
        $DataItem = array("value"=>array($firsText."\n".'Konsumen'."\n".'Kavling', 'Tgl Transaksi'."\n".'Status'."\n".'Tgl Akad'),
        				  "width" =>array(10,10),
        				  "align" =>array('C'),
        				  "style" =>array(''),
                          "border" =>array(1)
        				);
        $this->Ln();
        $this->CreateGroupTextMulti($DataItem['value'], $ln=0, $DataItem['width'], $h, 10, $DataItem['style'], $DataItem['align'], $DataItem['border'], $fill, 0);
        $x=$this->GetX();
        $y=$this->GetY();

        //Print Column 3 colspan=4
        $DataItem['value']=array('Rincian Harga');
        $DataItem['width']=array(36);
        $this->CreateGroupTextMulti($DataItem['value'], $ln=0, $DataItem['width'], 8, 10, $DataItem['style'], $DataItem['align'], $DataItem['border'], $fill, 1);

        //Print Column 3-6
        $this->SetX($x);
        $DataItem['value']=array('Hrg Dasar'."\n".'Plafon KPR'."\n".'Uang Muka', 'Booking Fee'."\n".'KLT'."\n".'Sudut', 'Hadap Jalan'."\n".'Fasum'."\n".'Redesign', '+ Kwalitas'."\n".'+ Kontruksi');
        $DataItem['width']=array(9);
        $this->CreateGroupTextMulti($DataItem['value'], $ln=0, $DataItem['width'], $h1, 10, $DataItem['style'], $DataItem['align'], $DataItem['border'], $fill, 0);

        //Print Column 7 colspan=4
        $this->SetXY($this->GetX(), $y);
        $x=$this->GetX();
        $DataItem['value']=array('Rincian Pembayaran');
        $DataItem['width']=array(36);
        $this->CreateGroupTextMulti($DataItem['value'], $ln=0, $DataItem['width'], 8, 10, $DataItem['style'], $DataItem['align'], $DataItem['border'], $fill, 1);

        //Print Column 7-10
        $DataItem['value']=array('Uang Muka'."\n".'Booking Fee'."\n".'KLT', 'Sudut'."\n".'Hadap Jalan'."\n".'Fasum' ,'Redesign'."\n".'+ Kwalitas'."\n".'+ Kontruksi','Harga Dasar');
        $DataItem['width']=array(9);
        $this->SetX($x);
        $this->CreateGroupTextMulti($DataItem['value'], $ln=0, $DataItem['width'], $h1, 10, $DataItem['style'], $DataItem['align'], $DataItem['border'], $fill, 0);

        //Print Column 11
        $this->SetXY($this->GetX(), $y);
        $DataItem['value']=array('Piutang'."\n".'Terbayar'."\n".'Saldo');
        $DataItem['width']=array(9);
        $this->CreateGroupTextMulti($DataItem['value'], $ln=0, $DataItem['width'], $h, 10, $DataItem['style'], $DataItem['align'], $DataItem['border'], $fill, 0);
	}
}