<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
//ini_set('include_path', ini_get('include_path').';../Classes/');
//include "PHPExcel/Writer/Excel2007.php";

class Kb_infobukuharian_xls extends MY_Controller {

	public function __construct()
	{
		parent::__construct();		
		$this->load->library('excel');
		$this->load->library('Sidlib','sidlib');
		$this->load->model('Kasbank_model','report_model');
		$this->report_model->excel_output = 1;
	}

	public function index() {		
		$objPHPExcel = $this->excel;// new excel();
		$recordobject = $this->report_model->get_infobukuharian();
		$header = array('Kode', 'Perkiraan','Saldo Awal', 'Debet', 'Kredit', 'Saldo Akhir');
		$caption='Informasi Buku Harian'; //save our workbook as this file name

		 //name the worksheet
        $objPHPExcel->getActiveSheet()->setTitle($caption);
 
        // Set Report Title
        $objPHPExcel->getActiveSheet()->setCellValue('B1', $caption);
        $objPHPExcel->getActiveSheet()->setCellValue('B2', date_format(date_create($this->input->post('periode')), "d-M-Y").' s/d '.date_format(date_create($this->input->post('periode1')), "d-M-Y"));
        $objPHPExcel->setFontStyle('B1',16,true,TITLE_COLOR, true);
        $objPHPExcel->setFontStyle('B2',FONT_SIZE,false,TEXT_COLOR);
        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth("3");

        //Set Table Title Load from Array
		$objPHPExcel->getActiveSheet()->fromArray($header, null, 'B3');
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);

		//get column count
        $highestColumm = $objPHPExcel->getActiveSheet()->getHighestColumn();
		//Set Table Title Height
        $objPHPExcel->getActiveSheet()->getRowDimension(3)->setRowHeight(25);


        //merge Title
        $objPHPExcel->getActiveSheet()->mergeCells('B1:'.$highestColumm.'1');
		$objPHPExcel->getActiveSheet()->mergeCells('B2:'.$highestColumm.'2');

        $col = 'B';
		$row = 3;

        //Change Table Header Color
        $objPHPExcel->setFillColor($col.$row.':'.$highestColumm.$row,HEADER_COLOR);
        $objPHPExcel->setFontStyle($col.$row.':'.$highestColumm.$row,FONT_SIZE,true,HEADER_TEXT_COLOR);

		$recorditem = array();
		$row++;
		foreach($recordobject as $key => $value) {
        	$recorditem[]=array($value->accountno, $value->description, $value->saldoawal, $value->debet, $value->kredit, $value->saldoakhir);
        	if ($value->classacc == 0) {
        		$objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(20);
        		$objPHPExcel->setFillColor($col.$row.':'.$highestColumm.$row,'blue-light');
        		$objPHPExcel->setFontStyle($col.$row.':'.$highestColumm.$row,FONT_SIZE,true,TEXT_COLOR);
        	}
        	$row++;
    	}
    	$objPHPExcel->getActiveSheet()->fromArray($recorditem, null, 'B4');
    	
    	//get row count
		$highestRow = $objPHPExcel->getActiveSheet()->getHighestRow();

		//set number format
		$objPHPExcel->getActiveSheet()->getStyle('B4:'.$highestColumm.$highestRow)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

		for ($i='D'; $i <= $highestColumm; $i++) { 
    		$objPHPExcel->getActiveSheet()->getColumnDimension($i)->setWidth(20); //((int) $calculatedWidth * 1.05);
    	}

        //Change Header Aliggnment
		$objPHPExcel->getActiveSheet()->getStyle($objPHPExcel->getActiveSheet()->calculateWorksheetDimension())->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('B1:'.$highestColumm.'3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		//Title Border
		$objPHPExcel->getActiveSheet()->getStyle('B3:'.$highestColumm.'3')->applyFromArray($objPHPExcel->setBorder('allborders'));
		
		//Border Detil
		$objPHPExcel->getActiveSheet()->getStyle('B4:'.$highestColumm.$highestRow)->applyFromArray($objPHPExcel->setBorder('outline'));
		$objPHPExcel->getActiveSheet()->getStyle('B4:'.$highestColumm.$highestRow)->applyFromArray($objPHPExcel->setBorder('vertical'));

		//Seting Print Area
        $objPHPExcel->getActiveSheet()
                    ->getPageSetup()
                    ->setPrintArea('B1:'.$highestColumm.$highestRow);
        
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