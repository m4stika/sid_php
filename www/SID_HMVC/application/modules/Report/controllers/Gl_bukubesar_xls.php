<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
//ini_set('include_path', ini_get('include_path').';../Classes/');
//include "PHPExcel/Writer/Excel2007.php";

class Gl_bukubesar_xls extends MY_Controller {

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
		$objPHPExcel->getActiveSheet()->getDefaultColumnDimension()->setWidth(20);
		//$recordobject = $this->report_model->get_infobukuharian();
		$header = array('Tanggal', 'Journal No.', 'Keterangan', 'Debet', 'Kredit', 'Saldo Akhir');
		$caption='Buku Besar'; //save our workbook as this file name

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
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
		

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

		$generateTitleGroup = function($col, $row, $value) use ($objPHPExcel) {
			$objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(25);
			$objPHPExcel->getActiveSheet()->mergeCells($col.$row.':G'.$row);
        	$objPHPExcel->getActiveSheet()->setCellValue($col.$row, $value);
        	$objPHPExcel->getActiveSheet()->getStyle($col.$row.':G'.$row)->getFont()->setBold(true);
        	$objPHPExcel->getActiveSheet()->getStyle($col.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle($col.$row.':G'.$row)->applyFromArray($objPHPExcel->setBorder('outline'));
		};

		$generateDetailHeader = function($col, $row, $value) use ($objPHPExcel) {
        	$objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(25);
        	$objPHPExcel->getActiveSheet()->setCellValue($col.$row, $value->accountno.' ('.$value->description.')');
        	$objPHPExcel->getActiveSheet()->setCellValue('F'.$row, 'Saldo Awal');
        	$objPHPExcel->getActiveSheet()->setCellValue('G'.$row, $value->saldoawal);
        	$objPHPExcel->getActiveSheet()->getStyle($col.$row.':G'.$row)->getFont()->setItalic(true);
        	$objPHPExcel->getActiveSheet()->getStyle('F'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->getActiveSheet()->getStyle('E'.$row.':G'.$row)->applyFromArray($objPHPExcel->setBorder('bottom','grey-light'));
        };

        $generateDetailTotal = function($row, $value, $total) use ($objPHPExcel) {
	    	$objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(25);
	    	$objPHPExcel->getActiveSheet()
	    				->setCellValue('D'.$row, 'Sub Total')
	    				->setCellValue('E'.$row, $total['Debit'])
	    				->setCellValue('F'.$row, $total['Credit'])
	    				->setCellValue('G'.$row, $total['Detil']);
	    	$objPHPExcel->getActiveSheet()->getStyle('E'.$row.':G'.$row)->getFont()->setBold(true);
	    	$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->getActiveSheet()->getStyle('E'.$row.':G'.$row)->applyFromArray($objPHPExcel->setBorder('top','grey-light'));
            $objPHPExcel->getActiveSheet()->getStyle('E'.$row.':G'.$row)->applyFromArray($objPHPExcel->setBorder('bottom','grey-light'));
	    };
		
		$startrow=$row;
		$row++;
	    $loop = 0;
	    $perkiraan = $this->report_model->get_Accountby_id($this->input->post('linkid'));
	    $bukubesar = $this->report_model->get_GLbukubesar($perkiraan->keyvalue);

	    //Generate Firs Record
        if (count($bukubesar) > 0) {
        	//Generate Total and Header
        	$generateTitleGroup($col, $row, $bukubesar[0]->parentdescription);
        	$row++;
        	$generateDetailHeader($col, $row, $bukubesar[0]);
        	$row++;

        	//Reset Variable
        	$groupaccount = $bukubesar[0]->parentaccountno;
        	$keyvalue = $bukubesar[0]->keyvalue;
        	$total = array("Debit"=>0,"Credit"=>0,"Detil"=>$bukubesar[0]->saldoawal);
        }

        //Loop bukubesar Header
        foreach($bukubesar as $value) { 
            if ($groupaccount != $value->parentaccountno) {
            	//Generate Total and Header
            	$generateDetailTotal($row, $value, $total);
            	$row++;
            	$generateTitleGroup($col, $row, $value->parentdescription);
            	$row++;
            	$generateDetailHeader($col, $row, $value);
            	$row++;

            	//Reset Variable
            	$keyvalue = $value->keyvalue;
            	$groupaccount = $value->parentaccountno;
            	$total = array("Debit"=>0,"Credit"=>0,"Detil"=>$bukubesar[0]->saldoawal);
            }

            if ($keyvalue != $value->keyvalue) {
        		//Generate Sub Total
        		$generateDetailTotal($row, $value, $total);
            	$row++;
            	$generateDetailHeader($col, $row, $value);
            	$row++;
            	$total = array("Debit"=>0,"Credit"=>0,"Detil"=>$value->saldoawal);
            }

            $total['Debit'] += $value->debit;
            $total['Credit'] += $value->credit;
            $total['Detil'] += ($value->debitacc == 1 ? $value->debit - $value->credit : $value->credit - $value->debit); 

        	//Generate Table Detil
        	$recorditem=array(date_format(date_create($value->journaldate), "d-M-Y"), $value->journalno, $value->remark, $value->debit, $value->credit, $total['Detil']);
        	$objPHPExcel->getActiveSheet()->fromArray($recorditem, null, $col.$row);
        	$row++;
        	
	        $keyvalue = $value->keyvalue;
            $groupaccount = $value->parentaccountno;
        }
        $generateDetailTotal($row, $value, $total);
        $col = 'B';
        $row++;
    	//get row count
		$highestRow = $objPHPExcel->getActiveSheet()->getHighestRow();


		//set number format
		$objPHPExcel->getActiveSheet()->getStyle('B4:'.$highestColumm.$highestRow)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

        //Change Header Aliggnment
		$objPHPExcel->getActiveSheet()->getStyle($objPHPExcel->getActiveSheet()->calculateWorksheetDimension())->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('B1:'.$highestColumm.'4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		//Set Wrap Text
        $objPHPExcel->getActiveSheet()->getStyle('D4:'.$highestColumm.$highestRow)->getAlignment()->setWrapText(true);

		//Border Detil
        $objPHPExcel->getActiveSheet()->getStyle('B'.($startrow).':'.$highestColumm.$row)->applyFromArray($objPHPExcel->setBorder('outline'));    
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