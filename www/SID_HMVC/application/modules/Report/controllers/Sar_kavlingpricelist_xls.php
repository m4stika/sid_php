<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
//ini_set('include_path', ini_get('include_path').';../Classes/');
//include "PHPExcel/Writer/Excel2007.php";

class Sar_kavlingpricelist_xls extends MY_Controller {

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
		$recordobject = $this->report_model->get_Sar_Kavlingpricelist();
		$header = array('Noid',	'Status', 'Blok',	'No. kavling',	'Type Rumah', 'Harga Dasar', 'Diskon', 'Hrg Klt', 'Hrg Sudut',	'Hadap Jalan',	'Fasum', 'Total harga', 'Booking fee',	'Uang muka');
		foreach ($recordobject as $key => $value) {
			$recordobject[$key]['statusbookingname'] = STATUS_BOOKING[$value['statusbooking']];// $this->sidlib->StatusBookingName($value['statusbooking']);
			unset($recordobject[$key]['statusbooking']);
		}

		$recordobject = $objPHPExcel->array_change_key($recordobject, $header);


		$filename='Kavling Price List'; //save our workbook as this file name

		$objPHPExcel->PrintFromTable($recordobject,$filename);

		//get column count
        $highestColumm = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();
        //get row count
		$highestRow = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

		$objPHPExcel->setFillColor('M4:'.'M'.$highestRow,'yellow-light');
		//$objPHPExcel->setFontStyle('M4:'.'M'.$highestRow,0,true);

                    
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
        
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save("php://output");
  	}
}
?>