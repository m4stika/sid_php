<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');  
 
require_once APPPATH."third_party/classes/PHPExcel.php";
//require_once APPPATH."third_party/classes/PHPExcel/Writer/Excel2007.php";

require_once(APPPATH.'config/report_constants'.EXT);
require_once(APPPATH.'libraries/sidlib'.EXT);
class Excel extends PHPExcel {
  
    public function __construct() {
        parent::__construct();
        $this->getActiveSheet()
                    ->getPageSetup()
                    ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
        $this->getActiveSheet()
                    ->getPageSetup()
                    ->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $this->setMargin(.2, .5, .2, .5);
        $this->getActiveSheet()->setShowGridlines(false);
        $this->setActiveSheetIndex(0);
        $this->getDefaultStyle()->getFont()->setName('Verdana')->setSize(10);
        $this->getActiveSheet()->getDefaultColumnDimension()->setWidth(15);
        $this->getActiveSheet()->getDefaultRowDimension()->setRowHeight(15);
    }

    public function setBorder($style='allborders', $color=LINE_COLOR) {
        return array(
            'borders' => array(
                $style => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => sidlib::webcolor($color)),
                ),
            ),
        );
    }

    function setFontStyle($cells, $fontsize = 0, $bold=false, $color='', $underline=false) {
        if ($fontsize==0 || $fontsize=="") $fontsize = FONT_SIZE;
        if ($bold==0 || $bold=="") $bold = false;
        if ($color=='0' || $color=="") $color = TEXT_COLOR;

        $this->getActiveSheet()->getStyle($cells)->applyFromArray(array(
            'font'  => array(
                'bold'  => $bold,
                'underline' => $underline,
                'color' => array('rgb' => sidlib::webcolor($color)),
                'size'  => $fontsize
            )));
    }

    function setFillColor($cells, $color='') {
        if ($color=='0' || $color=="") $color = HEADER_COLOR;

        $this->getActiveSheet()->getStyle($cells)->getFill()->applyFromArray(array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array('rgb' => sidlib::webcolor($color))
            ));
    }

    public function setMargin($left=0.75, $top=1, $right=0.75, $bottom=1) {
    	$this->getActiveSheet()
		    ->getPageMargins()->setLeft($left);
    	$this->getActiveSheet()
		    ->getPageMargins()->setTop($top);
		$this->getActiveSheet()
		    ->getPageMargins()->setRight($right);
		$this->getActiveSheet()
		    ->getPageMargins()->setBottom($bottom);
    }

    public function array_change_key($array, $newkeys) {
        $key=array_keys($array);
        foreach($key as $ki)
        {
            $klower=ucwords($ki);
            $val=$array[$ki];
            if(is_array($val))
            {
                $i=0;
                foreach($val as $kinner=>$vinner)
                {
                    $tl=$newkeys[$i];
                    unset($val[$kinner]);
                    $val[$tl]=$vinner; 
                    $i++;
                }
            }
            unset($array[$ki]);
            $array[$klower]=$val; 
        }
        return $array;
    }

    public function PrintFromTable($objectname, $caption='') {
        //name the worksheet
        $this->getActiveSheet()->setTitle($caption);
 
        // Set Title
        $this->setFontStyle('B2', 16, true, TITLE_COLOR);
        $this->getActiveSheet()->setCellValue('B2', $caption);
 
        // read Key from Array to set to Header active sheet
		$this->getActiveSheet()->fromArray(array_keys(current($objectname)), null, 'B3');
		// read data from array to active sheet
		$this->getActiveSheet()->fromArray($objectname, null, 'B4');

        
		//get column count
        $highestColumm = $this->setActiveSheetIndex(0)->getHighestColumn();
        //get row count
		$highestRow = $this->setActiveSheetIndex(0)->getHighestRow();

		//merge Title
		$this->getActiveSheet()->mergeCells('B2:'.$highestColumm.'2');
		//set aligment to center for that merged cell (A1 to D1)

		//set number format
		$this->getActiveSheet()->getStyle('B4:'.$highestColumm.$highestRow)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED3);

		//Set Default Row height
		$this->getActiveSheet()->getDefaultRowDimension()->setRowHeight(20);
		//Set Row height for Title
		$this->getActiveSheet()->getRowDimension(2)->setRowHeight(35);
		//Set Row height for Header
		$this->getActiveSheet()->getRowDimension(3)->setRowHeight(25);

		$this->getActiveSheet()->getDefaultColumnDimension()->setWidth(10);
    

		//Change Header Aliggnment
		$this->getActiveSheet()->getStyle($this->getActiveSheet()->calculateWorksheetDimension())->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		//$this->getActiveSheet()->getStyle('A2:'.$highestColumm.'2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->getActiveSheet()->getStyle('B2:'.$highestColumm.'3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		//Change Header Color
		$this->setFillColor('B3:'.$highestColumm.'3', HEADER_COLOR);
		$this->setFontStyle('B3:'.$highestColumm.'3', 0, true, HEADER_TEXT_COLOR);


		$this->getActiveSheet()->getStyle('B3:'.$highestColumm.'3')->applyFromArray($this->setBorder('allborders'));
		$this->getActiveSheet()->getStyle('B4:'.$highestColumm.$highestRow)->applyFromArray($this->setBorder('outline'));
		$this->getActiveSheet()->getStyle('B4:'.$highestColumm.$highestRow)->applyFromArray($this->setBorder('vertical'));
		
		//SET column autosize
		foreach(range('B',$highestColumm) as $columnID) {
			$this->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
		};
		$this->getActiveSheet()->calculateColumnWidths();
		
		// Set setAutoSize(false) so that the widths are not recalculated
		foreach(range('B',$highestColumm) as $columnID) {
			$this->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(false);
		};

		//Seting Print Area
        $this->getActiveSheet()
                    ->getPageSetup()
                    ->setPrintArea('B2:'.$highestColumm.$highestRow);
        
        //seting Compress
        $this->getActiveSheet()->getPageSetup()->setFitToWidth(1)->setFitToHeight(0);

		/** Borders for heading */
		//$this->getActiveSheet()->getDefaultStyle()->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

 
        $filename=$caption.'.xls'; //save our workbook as this file name
 
        //header('Content-Type: application/vnd.ms-excel'); //mime type
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
 
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
 
        header('Cache-Control: max-age=0'); //no cache


                    
  //       //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
  //       //if you want to save it as .XLSX Excel 2007 format
 
  //       $objWriter = PHPExcel_IOFactory::createWriter($this, 'Excel5'); 
  //       //$objWriter = new PHPExcel_Writer_Excel2007($this);
		// //$objWriter->save(str_replace('.php', '.xlsx', __FILE__));

 	// 	//ob_start();
		// //$objWriter->save('php://output');
		// //$excelFileContents = ob_get_clean();

		// // Download file contents using CodeIgniter
		// //force_download('daftarkaryawan.xls', $excelFileContents);


  //       //force user to download the Excel file without writing it to server's HD
  //       $objWriter->save("php://output");
        //$objWriter->save('D:/Downloads/'.$filename);    }
    }
}