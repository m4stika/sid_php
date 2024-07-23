<?php 
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Masterkavling extends MY_Controller
{
	
	public function __construct()
	{
		parent::__construct();		
		$this->load->model('masterkavling_model','masterkavling');		
	}

	public function index() {
		$options = $this->typerumah_getlist();
	 	$data = array(				
				'title'		=> 'SID | Master Kavling',
				'page' 		=> 'pemasaran', 
 				'content'	=> 'masterkavling',
 				'isi' 		=> 'Perencanaan/masterkavling_view',
 				'options'	=>  $options
 			);
	 	$this->template->admin_template($data);
	}

	public function get_masterkavling_list()
	{		
		$this->masterkavling->table = 'vmasterkavling';
		$list = $this->masterkavling->get_datatables();		
		$data = array();
		$no = $_POST['start'];		
        foreach ($list	as $value) {
        	$no++;
        	$value->action = $no;
        	$data[] = $value;
        }
        $output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->masterkavling->count_all(),
						"recordsFiltered" => $this->masterkavling->count_filtered(),
						"data" => $data
				);
		$this->masterkavling->table = 'masterkavling';
		//output to json format
		echo json_encode($output);
    }

	public function masterkavling_list()
	{		
		$this->masterkavling->table = 'vmasterkavling';
		$list = $this->masterkavling->get_datatables();		
		$data = array();
		$no = $_POST['start'];		
        foreach ($list	as $value) {
			//array sementara data
			$ResultData = array();
			$no++;
			//masukan data ke array sesuai kolom table
			//$ResultData[] = $no;
			$ResultData[] = $this->template->add_dropdown($value->statusbooking,$no);
			$ResultData[] = $value->noid;
			$ResultData[] = $value->blok;
			$ResultData[] = $value->nokavling;
			$ResultData[] = $value->keterangan;	
			$ResultData[] = $value->typerumah;
			$ResultData[] = $value->luastanah;
			$ResultData[] = $value->luasbangunan;	
			$ResultData[] = $value->kelebihantanah;
			if ($value->sudut == 1) {$ResultData[] = "<span class=\"fa fa-check font-green-haze fa-2x\"></span>";} //$value->sudut;
			else {$ResultData[] = "<span class=\"fa fa-square-o font-green-haze fa-2x\"></span>";};
			
			if ($value->hadapjalan == 1) {$ResultData[] = "<span class=\"fa fa-check font-green-haze fa-2x\"></span>";} //$value->sudut;
			else {$ResultData[] = "<span class=\"fa fa-square-o font-green-haze fa-2x\"></span>";};
			
			if ($value->fasum == 1) {$ResultData[] = "<span class=\"fa fa-check font-green-haze fa-2x\"></span>";} //$value->sudut;
			else {$ResultData[] = "<span class=\"fa fa-square-o font-green-haze fa-2x\"></span>";};
			
			
			
			switch ($value->statusbooking) {
				case 0: //Status Booking Open
					$ResultData[] = "<span class=\"label label-sm label-primary\"> Open </span>";
					break;
				case 1: //Status Booking Lock
					$ResultData[] = "<span class=\"label label-sm label-warning\"> Lock </span>";
					break;
				case 2: //Status Booking Akad Kredit
					$ResultData[] = "<span class=\"label label-sm label-success\"> Akad Kredit </span>";
					break;
				case 3: //Status Booking Closed
					$ResultData[] = "<span class=\"label label-sm label-danger\"> Closed </span>";
					break;

				default: //di luar semua status diatas
					$ResultData[] = "<span class=\"label label-sm label-default\"> Batal </span>";
					break;
			};
			$ResultData[] = $value->statusbooking;
			
			//memasukan array ke variable $data
			$data[] = $ResultData;				
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->masterkavling->count_all(),
						"recordsFiltered" => $this->masterkavling->count_filtered(),
						"data" => $data
				);
		$this->masterkavling->table = 'masterkavling';
		//output to json format
		echo json_encode($output);
	}

	public function typerumah_getlist()
	{
		$this->load->model('typerumah_model','typerumah');
		$list = $this->typerumah->get_list();
		//$list =  Modules::run('typerumah')->get_list();
		$data = array();
		$no = 0;
		$options = "";
		if (count($list)) {
			foreach ($list as $key => $value) {
			$options .= "<option 
						value = '{$value->noid}' 
						data-value='{\"luasbangunan\":\"{$value->luasbangunan}\",
									 \"luastanah\":\"{$value->luastanah}\",
									 \"hargajual\":\"{$value->hargajual}\",
									 \"uangmuka\":\"{$value->uangmuka}\",
									 \"bookingfee\":\"{$value->bookingfee}\",
									 \"hpp\":\"{$value->hpp}\",
									 \"plafonkpr\":\"{$value->plafonkpr}\",
									 \"hargasudut\":\"{$value->hargasudut}\",
									 \"hargahadapjalan\":\"{$value->hargahadapjalan}\",
									 \"hargafasum\":\"{$value->hargafasum}\"
									}'
						data-content=\"{$value->keterangan}\">{$value->keterangan}
					</option>";
			}
		}
		return $options;
	}

	public function masterkavling_crud()
	{		
		$this->masterkavling->table = 'masterkavling';
		$colinsert                   = array();
		$colinsert["blok"]           = $this->input->post('blok');
		$colinsert["nokavling"]      = $this->input->post('nokavling');
		$colinsert["typerumah"]      = $this->input->post('idtyperumah');
		$colinsert["kelebihantanah"] = $this->input->post('kelebihantanah');
		$colinsert["hargakltm2"] = $this->input->post('hargakltm2');
		$colinsert["diskon"] = $this->input->post('diskon');
		$colinsert["alasandiskon"] = $this->input->post('alasandiskon');
		$colinsert["sudut"]          = 0;
		$colinsert["hadapjalan"]     = 0;
		$colinsert["fasum"]          = 0;
		$colinsert["statusbooking"]  = 0;
		if(!empty($this->input->post('check_list'))) {
			$checked_count = $this->input->post('check_list');
			foreach ($this->input->post('check_list') as $value) {				
				if ($value == "1") {$colinsert["sudut"] = 1;}
				elseif ($value == "2") {$colinsert["hadapjalan"] = 1;}
				elseif ($value == "3") {$colinsert["fasum"] = 1;}
			};
		};
		
		if ($this->input->post('status') == 'new') {
			$output = $this->masterkavling->insert($colinsert);
		} else if ($this->input->post('status') == 'edit') {
			$output = $this->masterkavling->update($this->input->post('noid'), $colinsert);
		} else if ($this->input->post('status') == 'copy') {
			$output = $this->masterkavling->insert($colinsert);
		}
		
		echo json_encode($output);
	}

	public function masterkavling_edit()
	{		
		$this->masterkavling->column_select = 'noid,blok,nokavling,idtyperumah,typerumah,keterangan,luasbangunan,luastanah,hargajual,kelebihantanah,hargakltm2,sudut,hadapjalan,fasum,statusbooking,hargasudut,hargahadapjalan,hargafasum,bookingfee,uangmuka,hpp,plafonkpr, diskon, alasandiskon';
		$this->masterkavling->table = 'vmasterkavling';
		$data =  $this->masterkavling->find_id($_POST['noid']);			
		$output = array('hasil' => 'OK', 
						'data' => $data
			);	
		$this->masterkavling->resetVar();
		echo json_encode($output);
	}

	public function masterkavling_delete()
	{		
		$hasil =  $this->masterkavling->delete($_POST['noid']);
		echo json_encode(array("status" => $hasil));
	}

	public function getform_kavling()
	{
		echo $this->load->view('perencanaan/kavling_form'); 
	}

	public function masterkavling_ExportXLS() {
		$setStyle = function($cells, $color='555555', $bold=false){
		    $this->excel->getActiveSheet()->getStyle($cells)->applyFromArray(array(
			    'font'  => array(
			        'bold'  => $bold,
			        'color' => array('rgb' => $color ),
			        'size'  => 10,
			        'name'  => 'Verdana'
			    )));
		};

		$cellColor = function($cells,$color){
		    $this->excel->getActiveSheet()->getStyle($cells)->getFill()->applyFromArray(array(
		        'type' => PHPExcel_Style_Fill::FILL_SOLID,
		        'startcolor' => array(
		             'rgb' => $color
		             
		        )
		    ));
		};
		// error_reporting(E_ALL);
		// ini_set('display_errors', TRUE);
		// ini_set('display_startup_errors', TRUE);
		// define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

		$this->load->library('excel');
		//$this->load->helper('download');

        //activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Masterkavling');
 
        // get all users in array formate
        $this->masterkavling->table = 'vmasterkavling';
        //$this->masterkavling->column_select = 'noid, blok, nokavling, idtyperumah, typerumah, keterangan,  luasbangunan, luastanah, kelebihantanah, sudut, hadapjalan, fasum, statusbooking';
        $masterkavling = $this->masterkavling->find_all_array();
        $masterkavling = $this->template->array_change_key_ucword($masterkavling);
        $this->masterkavling->table = 'masterkavling';

        // Set Title
        $this->excel->getActiveSheet()->setCellValue('A1', 'Daftar Master Kavling');
 
        // read Key from Array to set to Header active sheet
		$this->excel->getActiveSheet()->fromArray(array_keys(current($masterkavling)), null, 'A2');
		// read data from array to active sheet
		$this->excel->getActiveSheet()->fromArray($masterkavling, null, 'A3');

        
		//get column count
        $highestColumm = $this->excel->setActiveSheetIndex(0)->getHighestColumn();
        //get row count
		$highestRow = $this->excel->setActiveSheetIndex(0)->getHighestRow();

		//change the font size
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
		//make the font become bold
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		//merge cell A1 until D1
		$this->excel->getActiveSheet()->mergeCells('A1:'.$highestColumm.'1');
		//set aligment to center for that merged cell (A1 to D1)

		//set number format
		$this->excel->getActiveSheet()->getStyle('A3:'.$highestColumm.$highestRow)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED3);

		//Set Default Row height
		$this->excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(20);
		//Set Row height for Title
		$this->excel->getActiveSheet()->getRowDimension(1)->setRowHeight(35);
		//Set Row height for Header
		$this->excel->getActiveSheet()->getRowDimension(2)->setRowHeight(25);
		//Change Header Aliggnment
		$this->excel->getActiveSheet()->getStyle($this->excel->getActiveSheet()->calculateWorksheetDimension())->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		//$this->excel->getActiveSheet()->getStyle('A2:'.$highestColumm.'2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A1:'.$highestColumm.'2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		//Change Header Color
		$cellColor('A2:'.$highestColumm.'2','32C5D2');
		$setStyle('A2:'.$highestColumm.'2','FAFAFA',true);

		//$this->cellColor($highestColumm.'3:'.$highestColumm.$highestRow,'C6EFCE');
		//$this->setStyle($highestColumm.'3:'.$highestColumm.$highestRow);

		//SET column autosize
		$cellIterator = $this->excel->getActiveSheet()->getRowIterator()->current()->getCellIterator();
	    $cellIterator->setIterateOnlyExistingCells(true);
	    /** @var PHPExcel_Cell $cell */
	    foreach ($cellIterator as $cell) {
	        $this->excel->getActiveSheet()->getColumnDimension($cell->getColumn())->setAutoSize(true);
	    }

		// $styleArray = array(
		//   'borders' => array(
		//     'allborders' => array(
		//       'style' => PHPExcel_Style_Border::BORDER_THIN
		//     )
		//   )
		// );

		$this->excel->getActiveSheet()->getStyle('A2:'.$highestColumm.$highestRow)->applyFromArray(array(
		  'borders' => array(
		    'allborders' => array(
		      'style' => PHPExcel_Style_Border::BORDER_THIN
		    )
		  )
		));
		//unset($styleArray);

		/** Borders for all data */
		//$this->excel->->getActiveSheet()->getStyle('A2:'.$highestColumm.$highestRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		    

		/** Borders for heading */
		//$this->excel->->getActiveSheet()->getDefaultStyle()->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

 
        $filename='masterkavling.xls'; //save our workbook as this file name
 
        header('Content-Type: application/vnd.ms-excel'); //mime type
 
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
 
        header('Cache-Control: max-age=0'); //no cache
                    
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
 
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
 		//ob_start();
		//$objWriter->save('php://output');
		//$excelFileContents = ob_get_clean();

		// Download file contents using CodeIgniter
		//force_download('masterkavling.xls', $excelFileContents);


        //force user to download the Excel file without writing it to server's HD
        //$objWriter->save("php://output");
        $objWriter->save('D:/Downloads/'.$filename);
	}

	
}