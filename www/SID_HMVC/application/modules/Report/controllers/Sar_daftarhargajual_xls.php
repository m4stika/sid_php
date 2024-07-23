<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
//ini_set('include_path', ini_get('include_path').';../Classes/');
//include "PHPExcel/Writer/Excel2007.php";

class Sar_daftarhargajual_xls extends MY_Controller {

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
		$recordobject = $this->report_model->get_Sar_Hargajual();
		$header = array('ID', 'Type','Harga Jual', 'Booking Fee', 'Diskon', 'Uang Muka','Plafon KPR','Sudut', 'Hadap Jalan','Fasum');

		$recordobject = $objPHPExcel->array_change_key($recordobject, $header);


		$filename='Master Harga Jual'; //save our workbook as this file name

		$objPHPExcel->PrintFromTable($recordobject,$filename);

		//get column count
        $highestColumm = $objPHPExcel->getActiveSheet()->getHighestColumn();
        //Inset New Row
		$objPHPExcel->getActiveSheet()->insertNewRowBefore(4);
		//get row count
		$highestRow = $objPHPExcel->getActiveSheet()->getHighestRow();

		for ($i='B'; $i < 'I'; $i++) { 
			$objPHPExcel->getActiveSheet()->mergeCells($i.'3:'.$i.'4');
		}
		for ($i='I'; $i < 'L'; $i++) { 
			$val = $objPHPExcel->getActiveSheet()->getCell($i.'3')->getValue();
			$objPHPExcel->getActiveSheet()->setCellValue($i.'4',$val);
			
		}

		//Merge Cell
		$objPHPExcel->getActiveSheet()->mergeCells('I3:K3');
		//Change value cell
		$objPHPExcel->getActiveSheet()->setCellValue('I3','Posisi');

		//Title Row auto height
		$objPHPExcel->getActiveSheet()->getRowDimension(3)->setRowHeight(-1);
		$objPHPExcel->getActiveSheet()->getRowDimension(4)->setRowHeight(-1);

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
        
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save("php://output");
  	}
}
?>