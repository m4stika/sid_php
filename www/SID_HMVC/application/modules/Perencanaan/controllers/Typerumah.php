<?php 
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Typerumah extends MY_Controller
{	
	public function __construct()
	{
		parent::__construct();		
		$this->load->model('typerumah_model');
		
	}

	public function index() {
	 	$data = array(				
				'title'		=> 'SID | Type Rumah',
				'page' 		=> 'pemasaran', 
 				'content'	=> 'typerumah', 				
 				'isi' 		=> 'Perencanaan/typerumah_view'
 			);
	 	$this->template->admin_template($data);
	}

	public function typerumah_list()
	{
		$list = $this->typerumah_model->get_datatables();		
		$data = array();
		$no = $_POST['start'];		
        foreach ($list as $person) {
            $no++;
			$person->action = $no;
			$data[] = $person;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" =>  $this->typerumah_model->count_all(),
						"recordsFiltered" => $this->typerumah_model->count_filtered(),
						"data" => $data
				);
		
		//output to json format
		echo json_encode($output);
	}

	public function typerumah_delete()
	{
		$hasil =  $this->typerumah_model->delete($_POST['noid']);
		echo json_encode(array("status" => $hasil));
	}

	public function typerumah_edit()
	{
		// $column = "noid, typerumah, keterangan, luasbangunan, luastanah";
		// $data =  $this->typerumah_modelget_by_id($_POST['noid'], $column);			
		$this->typerumah_model->column_select = 'noid,typerumah,keterangan,luasbangunan,luastanah,hargajual,bookingfee,hargaklt,hargasudut,
				hargahadapjalan,hargafasum,diskon,uangmuka, hpp,plafonkpr,
				penerimaankpracc, GetaccountNo(penerimaankpracc) as penerimaankpraccno, GetaccountDesc(penerimaankpracc) as penerimaankpraccdesc, 
				bookingfeeacc, GetaccountNo(bookingfeeacc) as bookingfeeaccno, GetaccountDesc(bookingfeeacc) as bookingfeeaccdesc, 
				uangmukaacc, GetaccountNo(uangmukaacc) as uangmukaaccno, GetaccountDesc(uangmukaacc) as uangmukaaccdesc, 
				kltacc, GetaccountNo(kltacc) as kltaccno, GetaccountDesc(kltacc) as kltaccdesc, 
				posisisudutacc, GetaccountNo(posisisudutacc) as posisisudutaccno, GetaccountDesc(posisisudutacc) as posisisudutaccdesc, 
				hadapjlnutamaacc, GetaccountNo(hadapjlnutamaacc) as hadapjlnutamaaccno, GetaccountDesc(hadapjlnutamaacc) as hadapjlnutamaaccdesc, 
				hadapfasumacc, GetaccountNo(hadapfasumacc) as hadapfasumaccno, GetaccountDesc(hadapfasumacc) as hadapfasumaccdesc, 
				redesignbangunanacc, GetaccountNo(redesignbangunanacc) as redesignbangunanaccno, GetaccountDesc(redesignbangunanacc) as redesignbangunanaccdesc, 
				tambahkwalitasacc, GetaccountNo(tambahkwalitasacc) as tambahkwalitasaccno, GetaccountDesc(tambahkwalitasacc) as tambahkwalitasaccdesc, 
				pekerjaantambahacc, GetaccountNo(pekerjaantambahacc) as pekerjaantambahaccno, GetaccountDesc(pekerjaantambahacc) as pekerjaantambahaccdesc, 
				hargajualacc, GetaccountNo(hargajualacc) as hargajualaccno, GetaccountDesc(hargajualacc) as hargajualaccdesc, 
				uangmukaacc1, GetaccountNo(uangmukaacc1) as uangmukaacc1no, GetaccountDesc(uangmukaacc1) as uangmukaacc1desc, 
				bookingfeeacc1, GetaccountNo(bookingfeeacc1) as bookingfeeacc1no, GetaccountDesc(bookingfeeacc1) as bookingfeeacc1desc, 
				kltacc1, GetaccountNo(kltacc1) as kltacc1no, GetaccountDesc(kltacc1) as kltacc1desc, 
				posisisudutacc1, GetaccountNo(posisisudutacc1) as posisisudutacc1no, GetaccountDesc(posisisudutacc1) as posisisudutacc1desc, 
				hadapjlnutamaacc1, GetaccountNo(hadapjlnutamaacc1) as hadapjlnutamaacc1no, GetaccountDesc(hadapjlnutamaacc1) as hadapjlnutamaacc1desc, 
				hadapfasumacc1, GetaccountNo(hadapfasumacc1) as hadapfasumacc1no, GetaccountDesc(hadapfasumacc1) as hadapfasumacc1desc, 
				redesignbangunanacc1, GetaccountNo(redesignbangunanacc1) as redesignbangunanacc1no, GetaccountDesc(redesignbangunanacc1) as redesignbangunanacc1desc, 
				tambahkwalitasacc1, GetaccountNo(tambahkwalitasacc1) as tambahkwalitasacc1no, GetaccountDesc(tambahkwalitasacc1) as tambahkwalitasacc1desc, 
				pekerjaantambahacc1, GetaccountNo(pekerjaantambahacc1) as pekerjaantambahacc1no, GetaccountDesc(pekerjaantambahacc1) as pekerjaantambahacc1desc, 
				hargajualacc1, GetaccountNo(hargajualacc1) as hargajualacc1no, GetaccountDesc(hargajualacc1) as hargajualacc1desc, 
				piutangacc1, GetaccountNo(piutangacc1) as piutangacc1no, GetaccountDesc(piutangacc1) as piutangacc1desc,
				hppacc, GetaccountNo(hppacc) as hppaccno, GetaccountDesc(hppacc) as hppaccdesc, 
				persediaanacc, GetaccountNo(persediaanacc) as persediaanaccno, GetaccountDesc(persediaanacc) as persediaanaccdesc';
		$data =  $this->typerumah_model->find_id($_POST['noid']);
		$output = array('hasil' => 'OK', 
						'data' => $data
			);		
		echo json_encode($output);
	}

	private function typerumah_validate()
	{
		$config = array(
			array(
				'field' => 'typerumah',
				'label' => 'typerumah',
				'rules' => 'required|min_length[5]|max_length[20]',
				'errors' => array(
					'required' => 'anda harus mengisi item %s.',
					'min_length' => 'minimum isian %s adalah 5 digit',
					'max_length' => 'maximum isian %s adalah 20 digit'
					)
				),
			array(
				'field' => 'keterangan',
				'label' => 'keterangan',
				'rules' => 'required',
				'errors' => array(
					'required' => 'anda harus mengisi item %s.',					
					)
				),
			array(
				'field' => 'luasbangunan',
				'label' => 'luasbangunan',
				'rules' => 'required|numeric',
				'errors' => array(
					'required' => 'anda harus mengisi item %s.',
					'numeric' => '%s harus bertipe numeric',					
					)
				),
			array(
				'field' => 'luastanah',
				'label' => 'luastanah',
				'rules' => 'required|numeric',
				'errors' => array(
					'required' => 'anda harus mengisi item %s.',
					'numeric' => '%s harus bertipe numeric',					
					)
				)
			); 
		$this->form_validation->set_rules($config); 
		return  $this->form_validation->run();
	}

	private function setdata() 
	{
		$data = array (				
					'typerumah' => $this->input->post('typerumah'),
					'keterangan' => $this->input->post('keterangan'),
					'luastanah' => $this->input->post('luastanah'),
					'luasbangunan' => $this->input->post('luasbangunan'),
					'hargajual' => $this->input->post('hargajual'),
					'bookingfee' => $this->input->post('bookingfee'),
					'uangmuka' => $this->input->post('uangmuka'),
					'hpp' => $this->input->post('hpp'),
					'plafonkpr' => $this->input->post('plafonkpr'),
					'hargasudut' => $this->input->post('hargasudut'),
					'hargahadapjalan' => $this->input->post('hargahadapjalan'),
					'hargafasum' => $this->input->post('hargafasum'),
					'bookingfeeacc1' => $this->input->post('acctitipanbfid'),
					'uangmukaacc1' => $this->input->post('acctitipanumid'),
					'kltacc1' => $this->input->post('acctitipankltid'),
					'posisisudutacc1' => $this->input->post('acctitipansudutid'),
					'hadapjlnutamaacc1' => $this->input->post('acctitipanhadapjalanid'),
					'hadapfasumacc1' => $this->input->post('acctitipanfasumid'),
					'redesignbangunanacc1' => $this->input->post('acctitipanredesignid'),
					'tambahkwalitasacc1' => $this->input->post('acctitipantambahkwalitasid'),
					'pekerjaantambahacc1' => $this->input->post('acctitipanpekerjaantambahid'),
					'hargajualacc1' => $this->input->post('acctitipanhrgjualid'),
					'piutangacc1' => $this->input->post('acctitipanpiutangid'),
					'penerimaankpracc' => $this->input->post('accpenerimaankprid'),
					'bookingfeeacc' => $this->input->post('accpenerimaanbfid'),
					'uangmukaacc' => $this->input->post('accpenerimaanumid'),
					'kltacc' => $this->input->post('accpenerimaankltid'),
					'posisisudutacc' => $this->input->post('accpenerimaansudutid'),
					'hadapjlnutamaacc' => $this->input->post('accpenerimaanhadapjalanid'),
					'hadapfasumacc' => $this->input->post('accpenerimaanfasumid'),
					'redesignbangunanacc' => $this->input->post('accpenerimaanredesignid'),
					'tambahkwalitasacc' => $this->input->post('accpenerimaantambahkwalitasid'),
					'pekerjaantambahacc' => $this->input->post('accpenerimaanpekerjaantambahid'),
					'hargajualacc' => $this->input->post('accpenerimaanhrgjualid'),
					'hppacc' => $this->input->post('acchppid'),
					'persediaanacc' => $this->input->post('accpersediaanid'),
					);	
		return $data;
	}

	public function typerumah_add()
	{
		
		if ($this->typerumah_validate() == FALSE) {
			$output = array("status" => FALSE, 'data' => validation_errors());
			//echo json_encode(array("status" => FALSE, 'data' => validation_errors()));
		} else {
			$data = $this->setdata();
			$hasil = $this->typerumah_model->insert($data);	
			$output = array("status" => true, 'data' => $hasil);	
		};		
		echo json_encode($output);
	}

	public function typerumah_update()
	{
		if ($this->typerumah_validate() == FALSE) {
			$output = array("status" => FALSE, 'data' => validation_errors());
		} else {
			$data = $this->setdata();	
			$hasil = $this->typerumah_model->update($this->input->post('noid'), $data);
			$output = array("status" => true, 'data' => $hasil);				
		};		
		echo json_encode($output);
	}

	

	private function cellColor($cells,$color){
	    $this->excel->getActiveSheet()->getStyle($cells)->getFill()->applyFromArray(array(
	        'type' => PHPExcel_Style_Fill::FILL_SOLID,
	        'startcolor' => array(
	             'rgb' => $color
	             
	        )
	    ));
	}

	private function setStyle($cells, $color='555555', $bold=false){
	    $this->excel->getActiveSheet()->getStyle($cells)->applyFromArray(array(
		    'font'  => array(
		        'bold'  => $bold,
		        'color' => array('rgb' => $color ),
		        'size'  => 10,
		        'name'  => 'Verdana'
		    )));
	}

	public function typerumah_ExportXLS() {
		// error_reporting(E_ALL);
		// ini_set('display_errors', TRUE);
		// ini_set('display_startup_errors', TRUE);
		// define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

		$this->load->library('excel');
		//$this->load->helper('download');

		//load our new PHPExcel library
        //$objPHPExcel = $this->excel;
        
        //activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Type Rumah');
 
        // get all users in array formate
        $typerumah = $this->typerumah_model->get_list_export();
        $typerumah = $this->template->array_change_key_ucword($typerumah);

        // Set Title
        $this->excel->getActiveSheet()->setCellValue('A1', 'Daftar Type Rumah');
 
        // read Key from Array to set to Header active sheet
		$this->excel->getActiveSheet()->fromArray(array_keys(current($typerumah)), null, 'A2');
		// read data from array to active sheet
		$this->excel->getActiveSheet()->fromArray($typerumah, null, 'A3');

        
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
		$this->cellColor('A2:'.$highestColumm.'2','32C5D2');
		$this->setStyle('A2:'.$highestColumm.'2','FAFAFA',true);

		$this->cellColor($highestColumm.'3:'.$highestColumm.$highestRow,'C6EFCE');
		$this->setStyle($highestColumm.'3:'.$highestColumm.$highestRow);

		//SET column autosize
		foreach(range('A',$highestColumm) as $columnID) {
			$this->excel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
		};

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
		//$this->excel->getActiveSheet()->getStyle('A2:'.$highestColumm.$highestRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		    

		/** Borders for heading */
		//$this->excel->getActiveSheet()->getDefaultStyle()->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

 
        $filename='typerumah.xls'; //save our workbook as this file name
 
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
		//force_download('typerumah.xls', $excelFileContents);


        //force user to download the Excel file without writing it to server's HD
        //$objWriter->save("php://output");
        $objWriter->save('D:/Downloads/'.$filename);
	}
}
?>