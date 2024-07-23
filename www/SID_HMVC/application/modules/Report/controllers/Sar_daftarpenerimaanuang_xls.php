<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
//ini_set('include_path', ini_get('include_path').';../Classes/');
//include "PHPExcel/Writer/Excel2007.php";

class Sar_daftarpenerimaanuang_xls extends MY_Controller {

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
        $objPHPExcel->getDefaultStyle()->getFont()->setName('Verdana')->setSize(10);


        $caption = 'Daftar Penerimaan Uang';
        $groupby = $this->input->post('groupby'); //0=jenispenerimaan, 1=tglbayar
        $order = $groupby == 0 ? 'jenispenerimaan, tglbayar' : 'tglbayar, jenispenerimaan';
        $recordobject = $this->report_model->get_DaftarPenerimaanUang($order);
        
        //name the worksheet
        $objPHPExcel->getActiveSheet()->setTitle($caption);
 
        // Set Title
        $objPHPExcel->getActiveSheet()->setCellValue('B1', $caption);
        $objPHPExcel->getActiveSheet()->setCellValue('B2', date_format(date_create($this->input->post('periode')), "d-M-Y").' s/d '.date_format(date_create($this->input->post('periode1')), "d-M-Y"));
        $objPHPExcel->setFontStyle('B1',16,true,TITLE_COLOR, true);
        $objPHPExcel->setFontStyle('B2',10,false,TEXT_COLOR);
        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(20);
         //merge Title
        $objPHPExcel->getActiveSheet()->mergeCells('B1:F1');
        $objPHPExcel->getActiveSheet()->mergeCells('B2:F2');
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth("3");

        //Set Header Table
        $DataItem = array("value"=>array(($groupby == 1 ? 'Jenis Penerimaan' : 'Tanggal'),'Kwitansi','Konsumen', 'Keterangan', 'Jumlah'),
                              "width" =>array(25,20,30,25,20),
                              "align" =>array(PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::HORIZONTAL_LEFT, PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                            );
        
        $col = 'B';
        $x = 0;
        foreach ($DataItem['value'] as $key => $value) {
            $objPHPExcel->getActiveSheet()->setCellValue($col.'3', $value);
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setWidth($DataItem['width'][$key]);
            $objPHPExcel->getActiveSheet()->getStyle($col.'3')->getAlignment()->setHorizontal($DataItem['align'][$key]);
            $col++;
        }

        //Add Data Value to Cell Function
        $addCell = function($startcol, $row, $value=array(), $fill=false) use ($objPHPExcel, $DataItem) {
            $loop=$startcol;
            for ($i=0; $i < (count($value)); $i++) {
                $objPHPExcel->getActiveSheet()->setCellValue($loop.$row, $value[$i]);
                $objPHPExcel->getActiveSheet()->getStyle($loop.$row)->getAlignment()->setHorizontal($DataItem['align'][$i]);
                $loop++;
            }
        };

        //Sub Total Function
        $setTotal = function($row, $rowmerge, $totalbayar) use($objPHPExcel) {
            $objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(20);
            $objPHPExcel->getActiveSheet()->mergeCells('B'.$row.':E'.$row);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, 'Total');
            $objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $totalbayar);
            $objPHPExcel->getActiveSheet()->getStyle('B'.$row.':F'.$row)->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('B'.$row.':F'.$row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);    
        };

        $row = 4;
        $no = 0;
        $fill = false;
        $flagGroupby = '';
        $totalbayar = 0;
        $grandtotal = 0;
        $rowmerge = 4;
        //Set Data value to Cell
        foreach ($recordobject as $key => $value) {
            $groupbyname = $groupby == 0 ? $value->jenispenerimaan : $value->tglbayar;
            $datacol1 = $groupby == 1 ? $value->namapenerimaan : date_format(date_create($value->tglbayar), "d-M-Y");
            $datagroup = $groupby == 0 ? $value->namapenerimaan : date_format(date_create($value->tglbayar), "d-M-Y");

            //Group Total
            if ($no != 0 &&  $flagGroupby != $groupbyname) {
                $setTotal($row, $rowmerge, $totalbayar);
                $no=0;
                $totalbayar = 0;
                $row++;
                $rowmerge = $row;
            }

            //Group Header
            if ($flagGroupby != $groupbyname) {
                $objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(20);
                $objPHPExcel->getActiveSheet()->mergeCells('B'.$row.':F'.$row);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $datagroup);
                $row++;
            }

            $addCell('B',$row,array($datacol1, $value->nokwitansi,$value->namapemesan,$value->description,$value->jumlahbayar), $fill);

            $flagGroupby = $groupbyname;
            $totalbayar += $value->jumlahbayar;
            $grandtotal += $value->jumlahbayar; 
            $row++;
            $no++;
   //       $fill=!$fill;
        }
        $setTotal($row, $rowmerge, $totalbayar);
        $row++;

        //Grand Total
        $objPHPExcel->getActiveSheet()->mergeCells('B'.$row.':E'.$row);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, 'GRAND TOTAL');
        
        $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $grandtotal);
        $objPHPExcel->setFontStyle('B'.$row.':F'.$row,10,true,'navy');
        $objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(25);
        $objPHPExcel->getActiveSheet()->getStyle('B'.$row.':F'.$row)->getAlignment()
                                        ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)
                                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

        
        $highestColumm = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();
        $highestRow = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

        //Set Table Title Height
        $objPHPExcel->getActiveSheet()->getRowDimension(3)->setRowHeight(25);
        //Change Header Color
        $objPHPExcel->setFillColor('B3:'.$highestColumm.'3',HEADER_COLOR);
        $objPHPExcel->setFontStyle('B3:'.$highestColumm.'3',10,true,HEADER_TEXT_COLOR);

        //set number format
        $objPHPExcel->getActiveSheet()->getStyle('B4:'.$highestColumm.$highestRow)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED3);

        //Change Header Aliggnment
        //$objPHPExcel->getActiveSheet()->getStyle($objPHPExcel->getActiveSheet()->calculateWorksheetDimension())->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('B1:'.$highestColumm.'3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('B1:'.$highestColumm.'2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        

        //Border
        $objPHPExcel->getActiveSheet()->getStyle('B3:'.$highestColumm.$highestRow)->applyFromArray($objPHPExcel->setBorder('allborders'));
       
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