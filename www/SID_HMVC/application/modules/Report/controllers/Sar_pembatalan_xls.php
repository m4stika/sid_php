<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
//ini_set('include_path', ini_get('include_path').';../Classes/');
//include "PHPExcel/Writer/Excel2007.php";

class Sar_pembatalan_xls extends MY_Controller {

	public function __construct()
    {
        parent::__construct();      
        $this->load->library('excel');
        $this->load->library('Sidlib','sidlib');
        $this->load->model('Pemasaran_model','report_model');
        $this->report_model->excel_output = 1;
    }

    public function index() {       
        $objPHPExcel = $this->excel;// new PHPExcel();
        $objPHPExcel->getActiveSheet()
                    ->getPageSetup()
                    ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
        $objPHPExcel->getActiveSheet()
                    ->getPageSetup()
                    ->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $objPHPExcel->setMargin(.2, .5, .2, .5);
        $objPHPExcel->getActiveSheet()->setShowGridlines(false);
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getDefaultStyle()->getFont()->setName('Verdana')->setSize(FONT_SIZE);
        $objPHPExcel->getActiveSheet()->getDefaultColumnDimension()->setWidth(15);

        $recordobject = $this->report_model->get_LapPembatalan();
        $caption = 'Laporan Pembatalan';
        
        //name the worksheet
        $objPHPExcel->getActiveSheet()->setTitle($caption);
 
        // Set Title
        $row = 1;
        $col='B';
        $objPHPExcel->getActiveSheet()->setCellValue($col.$row, $caption);
        $objPHPExcel->getActiveSheet()->setCellValue($col.($row+1), date_format(date_create($this->input->post('periode')), "d-M-Y").' s/d '.date_format(date_create($this->input->post('periode1')), "d-M-Y"));
        $objPHPExcel->setFontStyle('B1',16,true,TITLE_COLOR, true);
        $objPHPExcel->setFontStyle('B2',10,false,TEXT_COLOR);
        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth("3");

        //---------- Set Header Table -------------
        $row=3;
        //Set Table Title Height
        $objPHPExcel->getActiveSheet()->getRowDimension(3)->setRowHeight(25);
        $objPHPExcel->getActiveSheet()->getRowDimension(4)->setRowHeight(50);
        //Merge Column
        $objPHPExcel->getActiveSheet()->mergeCells('B'.$row.':B'.($row+1));
        $objPHPExcel->getActiveSheet()->mergeCells('C'.$row.':E'.$row);
        $objPHPExcel->getActiveSheet()->mergeCells('F'.$row.':H'.$row);
        //Set Value
        $objPHPExcel->getActiveSheet()->setCellValue($col.$row, 'Tgl Batal'."\n".'Konsumen'."\n".'Kavling');
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, 'Penerimaan Uang');
        $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+1), 'Uang Muka'."\n".'KLT'."\n".'Sudut');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+1), 'Hadap Jalan'."\n".'Fasum'."\n".'Redesign');
        $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+1), '+Kwalitas'."\n".'+Kontruksi'."\n".'TOTAL');
        $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, 'Pengembalian Uang');
        $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+1), 'Uang Muka'."\n".'KLT'."\n".'Sudut');
        $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+1), 'Hadap Jalan'."\n".'Fasum'."\n".'Redesign');
        $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+1), '+Kwalitas'."\n".'+Kontruksi'."\n".'TOTAL');
        //Set Wrap Text
        //$objPHPExcel->getActiveSheet()->getStyle('B3:H4')->getAlignment()->setWrapText(true);

        $addCell = function($col, $row, $value=array(), $fill=false) use ($objPHPExcel) {
            for ($i=0; $i < count($value); $i++) {
                $objPHPExcel->getActiveSheet()->setCellValue($col.($row+$i), $value[$i]);
            }
            if ($fill==true) {
                $objPHPExcel->setFillColor($col.$row.':'.$col.($row+2),'blue-light');
            }
        };

        //Set Data value to Cell
        $row = 5;
        $fill = false;
        foreach ($recordobject as $value) {
            $addCell('B',$row,array(date_format(date_create($value->tglbatal), "d-M-Y"),$value->nopesanan,$value->namapemesan), $fill);
            $addCell('C',$row,array($value->uangmukabyr,$value->kltbyr, $value->sudutbyr), $fill);
            $addCell('D',$row,array($value->hadapjalanbyr, $value->fasumbyr, $value->redesignbyr), $fill);
            $addCell('E',$row,array($value->tambahkwbyr, $value->kerjatambahbyr, $value->totalbayartitipan), $fill);

            $addCell('F',$row,array($value->uangmuka, $value->klt, $value->sudut), $fill);
            $addCell('G',$row,array($value->hadapjalan, $value->fasum, $value->redesign), $fill);
            $addCell('H',$row,array($value->tambahkw, $value->kerjatambah, $value->totalpengembalian), $fill);

            //Buttom Border
            $objPHPExcel->getActiveSheet()->getStyle('B'.$row.':H'.($row+2))->applyFromArray($objPHPExcel->setBorder('bottom'));
            $row+=3;
            $fill=!$fill;
        }

        $highestColumm = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();
        $highestRow = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

        //merge Title
        $objPHPExcel->getActiveSheet()->mergeCells('B1:'.$highestColumm.'1');
        $objPHPExcel->getActiveSheet()->mergeCells('B2:'.$highestColumm.'2');

        //Set Wrap Text
        $objPHPExcel->getActiveSheet()->getStyle('B3:'.$highestColumm.$highestRow)->getAlignment()->setWrapText(true);

        //set number format
        $objPHPExcel->getActiveSheet()->getStyle('B5:'.$highestColumm.$highestRow)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED3);

        //Change Header Aliggnment
        $objPHPExcel->getActiveSheet()->getStyle($objPHPExcel->getActiveSheet()->calculateWorksheetDimension())->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('B1:'.$highestColumm.'4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        //Change Header Color
        $objPHPExcel->setFillColor('B3:'.$highestColumm.'4',HEADER_COLOR);
        $objPHPExcel->setFontStyle('B3:'.$highestColumm.'4',FONT_SIZE,true,HEADER_TEXT_COLOR);

        //Title Border
        $objPHPExcel->getActiveSheet()->getStyle('B3:'.$highestColumm.'4')->applyFromArray($objPHPExcel->setBorder('allborders'));

        //Border Detil
        $objPHPExcel->getActiveSheet()->getStyle('B5:'.$highestColumm.$highestRow)->applyFromArray($objPHPExcel->setBorder('outline'));
        $objPHPExcel->getActiveSheet()->getStyle('B5:'.$highestColumm.$highestRow)->applyFromArray($objPHPExcel->setBorder('vertical'));
        
        //Seting Print Area
        $objPHPExcel->getActiveSheet()
                    ->getPageSetup()
                    ->setPrintArea('B1:'.$highestColumm.$highestRow);
        
        //seting Compress
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
        //$objPHPExcel->getActiveSheet()->getPageSetup()->setScale(85);

        
        $filename=$caption.'.xls'; //save our workbook as this file name
 
        header('Content-Type: application/vnd.ms-excel'); //mime type
        //header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
 
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
 
        header('Cache-Control: max-age=0'); //no cache
                    
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
        
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save("php://output");
    }
}
?>