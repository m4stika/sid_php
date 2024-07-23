<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gl_neracasaldo_xls extends MY_Controller {

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
		$header = array('Account #', 'Description', 'Debit', 'Credit');
		$caption='Neraca Percobaan'; //save our workbook as this file name

		 //name the worksheet
        $objPHPExcel->getActiveSheet()->setTitle($caption);
 
        // Set Report Title
        $objPHPExcel->getActiveSheet()->setCellValue('B1', $caption);
        $objPHPExcel->getActiveSheet()->setCellValue('B2', $this->input->post('bulanname').' - '.$this->input->post('tahun'));
        $objPHPExcel->setFontStyle('B1',16,true,TITLE_COLOR, true);
        $objPHPExcel->setFontStyle('B2',FONT_SIZE,false,TEXT_COLOR);
        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth("3");

        //Print Group Title
        $col = 'B';
		$row = 4;
		$startrow = 4;

        //Set Table Title Load from Array
		$objPHPExcel->getActiveSheet()->fromArray($header, null, $col.$row);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);

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
		$recordobject = $this->report_model->get_GLNeracaSaldo();
		$recorditem = array();
		$row++;
		foreach($recordobject as $value) {
        	//$desc = str_pad($value->description, strlen($value->description)+(1*$value->levelacc)," ",STR_PAD_LEFT);
        	if ($value->classacc == 0) {
        		$objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(18);
        		$objPHPExcel->setFillColor($col.$row.':'.$highestColumm.$row,'blue-light');
        		$objPHPExcel->setFontStyle($col.$row.':'.$highestColumm.$row,FONT_SIZE,true,TEXT_COLOR);
				$recorditem[]=array($value->description);
        	} else $recorditem[]=array($value->accountno, $value->description, $value->debit, $value->credit);
        	
        	$row++;
    	}
    	//$row--;
    	$objPHPExcel->getActiveSheet()->fromArray($recorditem, null, $col.($startrow+1));

    	//Grand Total
    	$objPHPExcel->getActiveSheet()->mergeCells($col.$row.':C'.$row);
    	$objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(25);
    	$objPHPExcel->getActiveSheet()
    				->setCellValue('B'.$row, 'TOTAL')
    				->setCellValue('D'.$row, '=SUM(D'.($startrow+1).':D'.($row-1).')')
    				->setCellValue('E'.$row, '=SUM(E'.($startrow+1).':E'.($row-1).')');
    	$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':E'.$row)->getFont()->setBold(true);
    	$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':E'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    	$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':E'.$row)->applyFromArray($objPHPExcel->setBorder('allborders'));
    	$row++;
    	//get row count
		$highestRow = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

		//Set alignment Right for First Column
		//$objPHPExcel->getActiveSheet()->getStyle($col.'4:'.$col.$highestRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

    	//set number format
		$objPHPExcel->getActiveSheet()->getStyle($col.($startrow+1).':'.$highestColumm.$highestRow)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

		//Change Header Aliggnment
		$objPHPExcel->getActiveSheet()->getStyle('B1:'.$highestColumm.'4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		
		//Change Vertical Center
		$objPHPExcel->getActiveSheet()->getStyle($objPHPExcel->getActiveSheet()->calculateWorksheetDimension())->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

		//Border Detil
		$objPHPExcel->getActiveSheet()->getStyle($col.$startrow.':'.$highestColumm.$highestRow)->applyFromArray($objPHPExcel->setBorder('outline'));
		$objPHPExcel->getActiveSheet()->getStyle($col.$startrow.':'.$highestColumm.$highestRow)->applyFromArray($objPHPExcel->setBorder('vertical'));
		
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