<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sar_pembatalankwitansi_xls extends MY_Controller {

	public function __construct()
	{
		parent::__construct();		
		$this->load->library('excel');
		$this->load->library('Sidlib','sidlib');
		$this->load->model('Pemasaran_model','report_model');
		$this->report_model->excel_output = 1;
	}

	public function index() {		
		$objPHPExcel = $this->excel;// new excel();
		$recordobject = $this->report_model->get_LapPembatalanKwitansi();
		$header = array('Tgl Batal', 'Kwitansi','No. Pesanan', 'Konsumen', 'Jumlah');

		$recordobject = $objPHPExcel->array_change_key($recordobject, $header);


		$filename='Pembatalan Kwitansi'; //save our workbook as this file name

		$objPHPExcel->PrintFromTable($recordobject,$filename);

		//get column count
        $highestColumm = $objPHPExcel->getActiveSheet()->getHighestColumn();
		//get row count
		$highestRow = $objPHPExcel->getActiveSheet()->getHighestRow();

		//Print Footer
		$objPHPExcel->getActiveSheet()->mergeCells('B'.($highestRow+1).':E'.($highestRow+1));
        $objPHPExcel->getActiveSheet()->setCellValue('B'.($highestRow+1), 'TOTAL');
        $objPHPExcel->getActiveSheet()->getStyle('B'.($highestRow+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$allsum = '=SUM('.$highestColumm.'4:'.$highestColumm.$highestRow.')';
        $objPHPExcel->getActiveSheet()->setCellValue(($highestColumm).($highestRow+1),$allsum);
        //set number format
		$objPHPExcel->getActiveSheet()->getStyle(($highestColumm).($highestRow+1))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED3);
		$objPHPExcel->getActiveSheet()->getStyle('B3:F'.($highestRow+1))->applyFromArray($objPHPExcel->setBorder('allborders'));
		  
		//Fill Footer
		$objPHPExcel->setFillColor('B'.($highestRow+1).':'.$highestColumm.($highestRow+1),FOOTER_COLOR);
        $objPHPExcel->setFontStyle('B'.($highestRow+1).':'.$highestColumm.($highestRow+1),FONT_SIZE,true,FOOTER_TEXT_COLOR);

                    
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
        
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save("php://output");
  	}
}
?>