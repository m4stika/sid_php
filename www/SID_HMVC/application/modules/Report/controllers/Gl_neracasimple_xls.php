<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gl_neracasimple_xls extends MY_Controller {

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
		$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$objPHPExcel->getActiveSheet()->getDefaultColumnDimension()->setWidth(20);
		$caption='Neraca Simple'; //save our workbook as this file name

		$current = strtotime($this->input->post('bulan').'/01/'.$this->input->post('tahun'));
		$prevbulantahun = date("M - Y", strtotime("-1 month", $current));
		$bulantahun = date("M - Y", $current);

        // column titles & width
        $header = array('ACTIVA', 'PASIVA');

		 //name the worksheet
        $objPHPExcel->getActiveSheet()->setTitle($caption);
 
        // Set Report Title
        $objPHPExcel->getActiveSheet()->setCellValue('B1', $caption);
        $objPHPExcel->getActiveSheet()->setCellValue('B2', $this->input->post('bulanname').' - '.$this->input->post('tahun'));
        $objPHPExcel->setFontStyle('B1',16,true,TITLE_COLOR, true);
        $objPHPExcel->setFontStyle('B2',FONT_SIZE,false,TEXT_COLOR);
        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth("3");

        $col = 'B';
		$row = 4;
		$startrow = 4;

        //Set Table Title Load from Array
		$objPHPExcel->getActiveSheet()->fromArray($header, null, $col.$row);
		$objPHPExcel->getActiveSheet()->mergeCells('B'.$row.':C'.$row)->setCellValue('B'.$row, 'ACTIVA');
		$objPHPExcel->getActiveSheet()->mergeCells('D'.$row.':E'.$row)->setCellValue('D'.$row, 'PASIVA');
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(50);

        //get column count
        $highestColumm = 'E'; //$objPHPExcel->getActiveSheet()->getHighestColumn();
        
		//Set Table Title Height
        $objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(20);

        //Change Table Header Color
		$objPHPExcel->setFillColor($col.$row.':'.$highestColumm.$row,HEADER_COLOR);
        $objPHPExcel->setFontStyle($col.$row.':'.$highestColumm.$row,FONT_SIZE,true,HEADER_TEXT_COLOR);

        //merge Title
        $objPHPExcel->getActiveSheet()->mergeCells('B1:'.$highestColumm.'1');
		$objPHPExcel->getActiveSheet()->mergeCells('B2:'.$highestColumm.'2');

		//Record Detil
		$recordobject = $this->report_model->get_GLNeraca();
		$recorditem = array();
		//$row++;
		$row1st=$row;
		$row2nd=$row;
		$col1='C';
		$first2ndColumn = true;
		foreach($recordobject as $value) {
        	$desc = str_pad($value->description, strlen($value->description)+(1*$value->levelacc)," ",STR_PAD_LEFT);

        	if (substr($value->accountno,0,1) == '1') { //ACTIVA
        		$row1st++;
        		$row = $row1st;
        	} else { //PASIVA
	        	$row2nd++;
	        	if ($first2ndColumn==true) {
	        		$objPHPExcel->getActiveSheet()->fromArray($recorditem, null, $col.($startrow+1));
	        		$recorditem = array();
	        		$col='D';
	        		$col1='E';
	        		$first2ndColumn=false;
	        	}
	        	$row = $row2nd;
	        }
        	
        	if ($value->classacc == 0) {
        		$objPHPExcel->getActiveSheet()->getStyle($col.$row.':'.$col1.$row)->getFont()->setBold(true);
        	}
        	if ($value->flaggrandtotal == 2) {
        		$objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(18);
        		$objPHPExcel->setFillColor($col.$row.':'.$col1.$row,FOOTER_COLOR);
        		$objPHPExcel->setFontStyle($col.$row.':'.$col1.$row,FONT_SIZE,true,FOOTER_TEXT_COLOR);
        	}

        	$recorditem[]=array($desc, $value->dueamount);
        	$row++;
    	}
    	$objPHPExcel->getActiveSheet()->fromArray($recorditem, null, $col.($startrow+1));

    	$row = ($row1st > $row2nd) ? $row1st : $row2nd;
    	$col = 'B';
    	$highestColumm = $objPHPExcel->getActiveSheet()->getHighestColumn();
    	
    	//get row count
		$highestRow = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

    	//set number format
		$objPHPExcel->getActiveSheet()->getStyle($col.($startrow+1).':'.$highestColumm.$highestRow)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

		//Change Header Aliggnment
		$objPHPExcel->getActiveSheet()->getStyle('B1:'.$highestColumm.'4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		//Change Vertical Center
		$objPHPExcel->getActiveSheet()->getStyle($objPHPExcel->getActiveSheet()->calculateWorksheetDimension())->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

		//Border Detil
		$objPHPExcel->getActiveSheet()->getStyle($col.$startrow.':'.$highestColumm.$highestRow)->applyFromArray($objPHPExcel->setBorder('outline'));
		//Border Center
		$objPHPExcel->getActiveSheet()->getStyle('C'.$startrow.':C'.$highestRow)->applyFromArray($objPHPExcel->setBorder('right'));
		

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