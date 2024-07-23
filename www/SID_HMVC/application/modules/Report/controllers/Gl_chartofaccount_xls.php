<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gl_chartofaccount_xls extends MY_Controller {

	public function __construct()
	{
		parent::__construct();		
		$this->load->library('excel');
		$this->load->library('Sidlib','sidlib');
		$this->load->model('Accounting_model','report_model');
		$this->report_model->excel_output = 1;
	}

	public function index() {		
		$objPHPExcel = $this->excel;// new excel();
		//$recordobject = $this->report_model->get_infobukuharian();
		$header = array('Account', 'Description', 'Opening', 'Debit', 'Credit', 'Ballance Due');
		$caption='Chart Of Account'; //save our workbook as this file name

		 //name the worksheet
        $objPHPExcel->getActiveSheet()->setTitle($caption);
 
        // Set Report Title
        $objPHPExcel->getActiveSheet()->setCellValue('B1', $caption);
        $objPHPExcel->setFontStyle('B1',16,true,TITLE_COLOR, true);
        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth("3");

        //Print Group Title
        $col = 'B';
		$row = 3;
		$startrow = 3;

        //Set Table Title Load from Array
		$objPHPExcel->getActiveSheet()->fromArray($header, null, $col.$row);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(35);
		
		//Title and Header Table Set Center
		$objPHPExcel->getActiveSheet()->getStyle($objPHPExcel->getActiveSheet()->calculateWorksheetDimension())->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		

		//get column count
        $highestColumm = $objPHPExcel->getActiveSheet()->getHighestColumn();
		//Set Table Title Height
        $objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(25);

        //Change Table Header Color
		$objPHPExcel->setFillColor($col.$row.':'.$highestColumm.$row,HEADER_COLOR);
        $objPHPExcel->setFontStyle($col.$row.':'.$highestColumm.$row,FONT_SIZE,true,HEADER_TEXT_COLOR);

        //merge Title
        $objPHPExcel->getActiveSheet()->mergeCells('B1:'.$highestColumm.'1');
		$objPHPExcel->getActiveSheet()->mergeCells('B2:'.$highestColumm.'2');

		//Record Detil
		$recordobject = $this->report_model->get_chartofaccount();
		$recorditem = array();
		$row++;
		foreach($recordobject as $value) {
        	$desc = str_pad($value->description, strlen($value->description)+(1*$value->levelacc)," ",STR_PAD_LEFT);
        	if ($value->classacc == 0) {
        		$objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(15);
				$objPHPExcel->setFontStyle($col.$row.':'.$highestColumm.$row,FONT_SIZE,true,TEXT_COLOR);
        	}
        	$recorditem[]=array($value->accountno, $desc, $value->openingbalance, $value->debet, $value->kredit, $value->balancedue);
        	$row++;
    	}
    	$objPHPExcel->getActiveSheet()->fromArray($recorditem, null, 'B4');

    	//get row count
		$highestRow = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

		//Set alignment Right for First Column
		$objPHPExcel->getActiveSheet()->getStyle($col.'4:'.$col.$highestRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

    	//set number format
		$objPHPExcel->getActiveSheet()->getStyle('B4:'.$highestColumm.$highestRow)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

		
		//Change Vertical Center
		$objPHPExcel->getActiveSheet()->getStyle($objPHPExcel->getActiveSheet()->calculateWorksheetDimension())->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

		//Border Detil
		$objPHPExcel->getActiveSheet()->getStyle($col.'3:'.$highestColumm.$highestRow)->applyFromArray($objPHPExcel->setBorder('outline'));
		
		//Setting rows/columns to repeat at the top/left of each page
		$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(3,3);

		//set Footer
		$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R Page &P / &N');

		//Seting Print Area
        $objPHPExcel->getActiveSheet()
                    ->getPageSetup()
                    ->setPrintArea('B1:'.$highestColumm.$row);
        
        //seting Compress
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1)->setFitToHeight(0);

		$filename=$caption.'.xls'; //save our workbook as this file name
 
        //header('Content-Type: application/vnd.ms-excel'); //mime type
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
 
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
 
        header('Cache-Control: max-age=0'); //no cache
                    
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
        
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save("php://output");
  	}
}
?>