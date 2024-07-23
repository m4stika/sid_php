<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
//ini_set('include_path', ini_get('include_path').';../Classes/');
//include "PHPExcel/Writer/Excel2007.php";

class Gl_journalentry_xls extends MY_Controller {

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
		$header = array('Tanggal', 'Journal No.', 'Keterangan', 'Debet', 'Kredit');
		$caption='Journal Entry'; //save our workbook as this file name

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
        if ($this->input->post('groupby') >=0) {
			$objPHPExcel->getActiveSheet()->mergeCells($col.$row.':F'.$row);
	        $objPHPExcel->getActiveSheet()->setCellValue($col.$row, $this->input->post('groupdesc'));
	        $row++;
		}

        //Set Table Title Load from Array
		$objPHPExcel->getActiveSheet()->fromArray($header, null, $col.$row);
		$objPHPExcel->getActiveSheet()->getColumnDimension($col)->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);

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
		
		$startrow=$row;
		$row++;
    	$journalheader = $this->report_model->get_GLjournalHeader();
	    $loop = 0;
        //$total = array('totalharga'=>0, 'akumpenyusutan'=>0,'nilaibuku'=>0);
        foreach($journalheader as $valueH) { 
    		$col = 'B';
    		$recordHeader=array(date_format(date_create($valueH->journaldate), "d-M-Y"), $valueH->journalno, $valueH->journalremark);
    		$objPHPExcel->getActiveSheet()->fromArray($recordHeader, null, $col.$row);
    		$objPHPExcel->getActiveSheet()->getStyle($col.$row.':'.$highestColumm.$row)->getFont()->setBold(true);
    		$row++;
    		$loop++;

            //Detil Item
            $journaldetil = $this->report_model->get_GLjournalDetil($valueH->journalid);
            $recorditem=array();
            $i=0;
            $debet = 0;
	        $kredit = 0;
            foreach ($journaldetil as $value) { 
            	$debet += $value->debit;
            	$kredit += $value->credit;
            	$recorditem[]=array($value->accountno, $value->description, $value->debit, $value->credit);
		    	$i++;
            }
		    $i--;
		    $col = 'C';
		    $startrowdetil = $row;
		    $objPHPExcel->getActiveSheet()->fromArray($recorditem, null, $col.$row);
		    $row = $row+count($recorditem);
		    $objPHPExcel->getActiveSheet()->getStyle('E'.($row).':'.$highestColumm.$row)->applyFromArray($objPHPExcel->setBorder('top','grey-light'));
		    
		    //Total Mutasi
	    	$objPHPExcel->getActiveSheet()->setCellValue('E'.$row, '=SUM(E'.$startrowdetil.':E'.($row-1).')');
	    	$objPHPExcel->getActiveSheet()->setCellValue('F'.$row, '=SUM(F'.$startrowdetil.':F'.($row-1).')');
	    	($debet != $kredit) ? $objPHPExcel->setFontStyle('E'.$row.':'.'F'.$row,FONT_SIZE,true,'red') : $objPHPExcel->setFontStyle('E'.$row.':'.'F'.$row,FONT_SIZE,true,TEXT_COLOR);;

	    	$objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(25);

		    $col = 'B';
		    $color = ($loop >= count($journalheader)) ? 'grey' : 'grey-light';
		    $objPHPExcel->getActiveSheet()->getStyle('E'.($row).':'.$highestColumm.$row)->applyFromArray($objPHPExcel->setBorder('bottom',$color));
		    $row++; //=$row+$i+1;

        }
        $col = 'B';
        $row--;

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