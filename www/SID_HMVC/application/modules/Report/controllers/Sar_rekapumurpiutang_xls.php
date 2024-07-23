<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
//ini_set('include_path', ini_get('include_path').';../Classes/');
//include "PHPExcel/Writer/Excel2007.php";

class Sar_rekapumurpiutang_xls extends MY_Controller {

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
				    ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

		$recordobject = $this->report_model->get_RekapitulasiUmurpiutang();
//noid, statusbooking, "" as statusbookingname, blok, nokavling, typerumah, luasbangunan, luastanah, kelebihantanah, sudut, hadapjalan, fasum		
		$caption = 'Rekapitulasi Umur Piutang';
		$objPHPExcel->setActiveSheetIndex(0);
        //name the worksheet
        $objPHPExcel->getActiveSheet()->setTitle($caption);
 
        // Set Title
        $objPHPExcel->getActiveSheet()->setCellValue('B1', $caption);
        $objPHPExcel->getActiveSheet()->setCellValue('B2', date_format(date_create($this->input->post('periode')), "d-M-Y").' s/d '.date_format(date_create($this->input->post('periode1')), "d-M-Y"));
        $objPHPExcel->setFontStyle('B1',16,true,TITLE_COLOR, true);
        $objPHPExcel->setFontStyle('B2',FONT_SIZE,false,TEXT_COLOR);
        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth("3");

        
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
        $polapembayaran = array("KPR","Tunai Keras","Tunai Bertahap");
        foreach ($recordobject as $key => $value) {
        	$addCell('B',$row,array($polapembayaran[$value->polapembayaran], $value->namapemesan, $value->blok.' - '.$value->nokavling), $fill);
        	$addCell('C',$row,array(date_format(date_create($value->tgltransaksi), "d-M-Y"), $value->ketstatusbooking, date_format(date_create($value->tglakadkredit), "d-M-Y")), $fill);
        	$addCell('D',$row,array($value->hargajual,$value->plafonkpr, $value->totaluangmuka), $fill);
        	$addCell('E',$row,array($value->bookingfee, $value->hargaklt, $value->hargasudut), $fill);
        	$addCell('F',$row,array($value->hargahadapjalan, $value->hargafasum, $value->hargaredesign), $fill);
        	$addCell('G',$row,array($value->hargatambahkwalitas, $value->hargapekerjaantambah), $fill);
        	$addCell('H',$row,array($value->lunasuangmuka, $value->bookingfeebyr, $value->hargakltbyr), $fill);
        	$addCell('I',$row,array($value->hargasudutbyr, $value->hargahadapjalanbyr, $value->hargafasumbyr), $fill);
        	$addCell('J',$row,array($value->hargaredesignbyr, $value->hargatambahkwbyr, $value->hargakerjatambahbyr), $fill);
        	$addCell('K',$row,array($value->totalhargabyr), $fill);
        	$addCell('L',$row,array($value->totalbayar, $value->totalbayartitipan, $value->totalhutang), $fill);

        	//Buttom Border
			$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':L'.($row+2))->applyFromArray($objPHPExcel->setBorder('bottom'));
			$row+=3;
        	$fill=!$fill;
        }
        $highestColumm = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();
        $highestRow = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

        //Add Footer
        $colSUM = function($col, $row) use ($highestRow) {
        	$sum = '';
        	$r = $row;
        	for ($i=$r; $i <= $highestRow; $i++) { 
        		if ($i == $r) {
        			$sum .= $col.$r;
        			$r += 3;
        			if ($r <= $highestRow) $sum .= ',';
        		}
        	}
        	return $sum;
        };

        $objPHPExcel->getActiveSheet()->mergeCells('B'.($row).':C'.($row+2));
        $objPHPExcel->getActiveSheet()->setCellValue('B'.($row), 'TOTAL');
        for ($i='D'; $i <= $highestColumm; $i++) { 
        	for ($y=0; $y < 3 ; $y++) { 
        		$allsum = '=SUM('.$colSUM($i, 5+$y).')';
        		$objPHPExcel->getActiveSheet()->setCellValue($i.($row+$y),$allsum);
        	}
        }

        $highestColumm = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();
        $highestRow = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

        //Set Header Table
        $grupheader = array('Rincian Harga','Rincian Pembayaran');
        $header = array('title'=>array('Pola Pembayaran'."\n".'Konsumen'."\n".'Kavling',	
        				'Tgl Transaksi'."\n".'Status'."\n".'Tgl Akad',
        				'Hrg Dasar'."\n".'Plafon KPR'."\n".'Uang Muka', 
        				'Booking Fee'."\n".'KLT'."\n".'Sudut', 
        				'Hadap Jalan'."\n".'Fasum'."\n".'Redesign', 
        				'+ Kwalitas'."\n".'+ Kontruksi',
        				'Uang Muka'."\n".'Booking Fee'."\n".'KLT', 
        				'Sudut'."\n".'Hadap Jalan'."\n".'Fasum',
        				'Redesign'."\n".'+ Kwalitas'."\n".'+ Kontruksi',
        				'Harga Dasar', 'Piutang'."\n".'Terbayar'."\n".'Saldo'
        				),
        				'width'=>array(15)
        			);
        
        $col = 'B';
        $x = 0;
        $num_headers = count($header['title']);
        for ($i=0; $i < $num_headers; $i++) { 
        	if (in_array($i, array(0,1,10))) {
        		$objPHPExcel->getActiveSheet()->mergeCells($col.'3:'.$col.'4');
        		$objPHPExcel->getActiveSheet()->setCellValue($col.'3', $header['title'][$i]);
        	} else {
        		if ($i == 2) {
        			$objPHPExcel->getActiveSheet()->mergeCells($col.'3:'.sidlib::increment($col,3).'3');
        			$objPHPExcel->getActiveSheet()->setCellValue($col.'3', 'Rincian Harga');
        		} else if ($i == 6) {
        			$objPHPExcel->getActiveSheet()->mergeCells($col.'3:'.sidlib::increment($col,3).'3');
        			$objPHPExcel->getActiveSheet()->setCellValue($col.'3', 'Rincian Pembayaran');
        		}
        		$objPHPExcel->getActiveSheet()->setCellValue($col.'4', $header['title'][$i]);
        	}
        	
        	if ($col == 'B') {
        		$objPHPExcel->getActiveSheet()->getColumnDimension($col)->setWidth("20");
        	} else $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setWidth("15");
        	
        	$col++;
        }

        //Set Table Title Height
        $objPHPExcel->getActiveSheet()->getRowDimension(3)->setRowHeight(25);
        $objPHPExcel->getActiveSheet()->getRowDimension(4)->setRowHeight(50);

        

        //merge Title
        $objPHPExcel->getActiveSheet()->mergeCells('B1:'.$highestColumm.'1');
		$objPHPExcel->getActiveSheet()->mergeCells('B2:'.$highestColumm.'2');

		//Set Wrap Text
        $objPHPExcel->getActiveSheet()->getStyle('B3:'.$highestColumm.$highestRow)->getAlignment()->setWrapText(true);

		//set number format
		$objPHPExcel->getActiveSheet()->getStyle('B5:'.$highestColumm.$highestRow)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED3);

        //Change Header Aliggnment
		$objPHPExcel->getActiveSheet()->getStyle($objPHPExcel->getActiveSheet()->calculateWorksheetDimension())->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		//$objPHPExcel->getActiveSheet()->getStyle('A2:'.$highestColumm.'2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('B1:'.$highestColumm.'4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		//Change Header Color
		$objPHPExcel->setFillColor('B3:'.$highestColumm.'4',HEADER_COLOR);
        $objPHPExcel->setFontStyle('B3:'.$highestColumm.'4',FONT_SIZE,true,HEADER_TEXT_COLOR);

		//Title Border
		$objPHPExcel->getActiveSheet()->getStyle('B3:'.$highestColumm.'4')->applyFromArray($objPHPExcel->setBorder('allborders'));

		//Border Detil
		$objPHPExcel->getActiveSheet()->getStyle('B5:'.$highestColumm.$highestRow)->applyFromArray($objPHPExcel->setBorder('outline'));
        $objPHPExcel->getActiveSheet()->getStyle('B5:'.$highestColumm.$highestRow)->applyFromArray($objPHPExcel->setBorder('vertical'));

		 //Border Footer
        $objPHPExcel->getActiveSheet()->getStyle('B'.$row.':'.$highestColumm.($row+2))->applyFromArray($objPHPExcel->setBorder('outline'));
        $objPHPExcel->getActiveSheet()->getStyle('B'.$row.':'.$highestColumm.($row+2))->applyFromArray($objPHPExcel->setBorder('vertical'));
			
        //Fill Footer
		$objPHPExcel->setFillColor('B'.$row.':'.$highestColumm.($row+2),FOOTER_COLOR);
        $objPHPExcel->setFontStyle('B'.$row.':'.$highestColumm.($row+2),FONT_SIZE,true,FOOTER_TEXT_COLOR);

		//Seting Print Area
		$objPHPExcel->getActiveSheet()
				    ->getPageSetup()
				    ->setPrintArea('B1:'.$highestColumm.$highestRow);
				    	//->setPrintArea('B2:E5,G4:M20');
		
		//seting Compress 75%
		$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1)->setFitToHeight(0);
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