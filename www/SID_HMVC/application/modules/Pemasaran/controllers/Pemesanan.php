<?php 
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* //'Open', 'Lock', 'Akad Kredit', 'Closed', 'Cancel'
*/
class Pemesanan extends MY_Controller
{	
	public function __construct()
	{
		parent::__construct();		
		$this->load->model('pemesanan_model');
	}

	public function index() {
		$option = $this->get_kavlinglist();
		$optionbank =  Modules::run('Kasbank/kasbank/get_banklist');
		//$param = '10105';
		$optionbankretensi =  Modules::run('Kasbank/kasbank/get_acclist','1010505',1,true);
		
		$data = array(				
				'title'		=> 'SID | Pemesanan',
				'page' 		=> 'pemasaran', 
 				'content'	=> 'browsepemesanan', 				
 				'isi' 		=> 'Pemasaran/pemesanan_view',
 				//'pagecontent' => 'pemasaran/pemesanan_form',
 				//'dataparent' => $dataparent;
 				'options'   => $option,
 				'optionbank' => $optionbank,
 				'optionbankretensi' => $optionbankretensi,
 			);
	 	$this->template->admin_template($data);	 	
	}

	public function pemesanan_new() {		
		$option = $this->get_kavlinglist();
		$data = array(				
				'title'		=> 'SID | Pemesanan',
				'page' 		=> 'pemasaran', 
 				'content'	=> 'pemesanan',
 				'isi' 		=> 'Pemasaran/pemesanan_page',
 				'pagecontent' => 'Pemasaran/pemesanan_form',
 				'options'   => $option
 			);
	 	$this->template->admin_template($data);	 	
	}

	public function dokumenpemesanan_list()
	{
		$list = $this->pemesanan_model->getlist_dokumenpemesanan($_POST['noid'], $_POST['typekonsumen']);
		$data = array();
		$no = 0;
		//echo $list; die;
		foreach ($list as $value) {
			$no++;
			$ResultData = array();
			$ResultData[] = $no;
			$ResultData[] = $value->noid;
			$ResultData[] = $value->namadokumen;
			($value->status == 0) ? $ResultData[] = 'Belum' : $ResultData[] = 'Sudah';
			$ResultData[] = $value->tglpenyerahan;

			$data[] = $ResultData;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" =>  5, //$this->pemesanan_model->count_all(),
						"recordsFiltered" => 5, //$this->pemesanan_model->count_filtered(),
						"data" => $data
				);

		unset($list, $data, $ResultData);

		//output to json format
		echo json_encode($output);
	}

	public function pemesanan_datatable()
	{		
		//'Open', 'Lock', 'Akad Kredit', 'Closed', 'Cancel'
		$this->pemesanan_model->table = 'vpemesanan';
		$list = $this->pemesanan_model->get_datatables();		
		$data = array();
		$no = $_POST['start'];
        foreach ($list	as $value) { 
			$no++;
			$value->action = $no;
			$data[] = $value;			
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" =>  $this->pemesanan_model->count_all(),
						"recordsFiltered" => $this->pemesanan_model->count_filtered(),
						"data" => $data
				);
		$this->pemesanan_model->table = 'pemesanan';

		//output to json format
		echo json_encode($output);
	}

	public function pemesanan_datatables() //Tidak Terpakai
	{		
		//'Open', 'Lock', 'Akad Kredit', 'Closed', 'Cancel'
		$this->pemesanan_model->table = 'vpemesanan';
		$list = $this->pemesanan_model->get_datatables();		
		$data = array();
		$no = $_POST['start'];		
		$polabayar = array(array('states'=>'primary', 'caption'=>'KPR'), array('states'=>'warning', 'caption'=>'Tunai Keras'), array('states'=>'default', 'caption'=>'Tunai Bertahap'));
		$statustran = array(array("states"=>"primary","status"=>"","class"=>"bold","caption"=>"Open"),
						array("states"=>"warning","status"=>"disabled","class"=>"","caption"=>"Lock"),
						array("states"=>"success","status"=>"disabled","class"=>"","caption"=>"Akad Jual Beli"),
						array("states"=>"danger","status"=>"disabled","class"=>"","caption"=>"Closed"),
						array("states"=>"default","status"=>"","class"=>"bold","caption"=>"Batal")
						 );

        foreach ($list	as $value) { 
        	$action = $this->template->add_dropdown($value->statustransaksi,'',false);
        	if ($value->statustransaksi <= 1) { //Pop up Akad Jual Beli
        		$action .= "<li class='divider'> </li>";
        		$action .= 		"<li> <a href='javascript:;' class='akad'> <i class='fa fa-thumbs-o-up'></i> Akad Jual Beli</a> </li>";
        	}
        	if ($value->totalbayaronp == 0 && $value->totalbayar > 0 && $value->statustransaksi <= 1) { //Pop up Pembatalan konsumen
        		$action .= 		"<li> <a href='javascript:;' class='batal'> <i class='fa fa-reply'></i> Konsumen Batal</a> </li>";
        	}
        	
        	$action .=	"</ul> </div>"; 

			$no++;
			$ResultData = array();						
			$ResultData[] = $no;
			$ResultData[] = $action;
			$ResultData[] = $value->noid;
			$ResultData[] = $value->nopesanan;	
			$ResultData[] = "<span class=\"label label-sm label-{$polabayar[$value->polapembayaran]['states']}\"> {$polabayar[$value->polapembayaran]['caption']} </span>";
			$ResultData[] = $value->namapemesan;
			$ResultData[] = $value->blok;
			$ResultData[] = $value->nokavling;
			$ResultData[] = $value->typerumah; 
			$ResultData[] = "<span class=\"label label-sm label-{$statustran[$value->statustransaksi]['states']}\"> {$statustran[$value->statustransaksi]['caption']} </span>";
			$ResultData[] = $value->hargajual; 
			$ResultData[] = $value->diskon; 
			$ResultData[] = $value->hargaklt; 
			$ResultData[] = $value->hargasudut; 
			$ResultData[] = $value->hargahadapjalan; 
			$ResultData[] = $value->hargafasum;
			$ResultData[] = $value->hargaredesign;
			$ResultData[] = $value->hargatambahkwalitas;
			$ResultData[] = $value->hargapekerjaantambah;
			$ResultData[] = $value->totalharga;
			$ResultData[] = $value->bookingfee;
			$ResultData[] = $value->totaluangmuka;
			$ResultData[] = $value->bookingfeebyr;
						
			$ResultData[] = $value->lunasuangmuka;
			$ResultData[] = $value->hargasudutbyr;
			$ResultData[] = $value->hargahadapjalanbyr;
			$ResultData[] = $value->hargakltbyr;
			$ResultData[] = $value->hargafasumbyr;
			$ResultData[] = $value->hargaredesignbyr;
			$ResultData[] = $value->hargatambahkwbyr;
			$ResultData[] = $value->hargakerjatambahbyr;
			$ResultData[] = $value->totalhargabyr;
			$ResultData[] = $value->totalbayar;
			$ResultData[] = $value->totalbayartitipan;
			$ResultData[] = $value->totalhutang;
			
			//memasukan array ke variable $data
			$data[] = $ResultData;			
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" =>  $this->pemesanan_model->count_all(),
						"recordsFiltered" => $this->pemesanan_model->count_filtered(),
						"data" => $data
				);
		$this->pemesanan_model->reset_param();
		unset($action, $list, $ResultData, $data, $polabayar, $statustran);

		//output to json format
		echo json_encode($output);
	}

	public function get_kavlinglist() {
		//$this->load->model('perencanaan/masterkavling_model','masterkavling');
		$this->pemesanan_model->table = 'vmasterkavling';
		$this->pemesanan_model->column_select = 'noid, nokavling, typerumah, keterangan, statusbooking, luasbangunan, luastanah, hargajual, kelebihantanah, hargakltm2, sudut, hadapjalan, fasum, hargasudut, hargahadapjalan, hargafasum';
		
		$list = $this->pemesanan_model->find_all();
		$this->pemesanan_model->reset_param();

		$states = array(array("ket"=>"primary","status"=>"","class"=>"bold","desc"=>"Open"),
						array("ket"=>"warning","status"=>"disabled","class"=>"","desc"=>"Lock"),
						array("ket"=>"success","status"=>"disabled","class"=>"","desc"=>"Akad"),
						array("ket"=>"danger","status"=>"disabled","class"=>"","desc"=>"Closed"),
						array("ket"=>"default","status"=>"","class"=>"bold","desc"=>"Batal")
						 );
		//$list = $this->pemesanan_model->masterkavling_list();
		$options = "";//<option value = '0' >Select..</option>";
		$status;
		if (count($list)) {
			foreach ($list as $key => $value) {
				$ketStatusbooking = "<span class='label label-sm label-{$states[$value->statusbooking]['ket']}'> {$states[$value->statusbooking]['desc']} </span>";
				//$options .= "<option class='{$states[$value->statusbooking]['class']}' 
				$options .= "<option {$states[$value->statusbooking]['status']} class='{$states[$value->statusbooking]['class']}' 
								value = '{$value->noid}' 
								data-value='{\"luasbangunan\":\"{$value->luasbangunan}\",
											 \"luastanah\":\"{$value->luastanah}\",
											 \"hargajual\":\"{$value->hargajual}\",
											 \"kelebihantanah\":\"{$value->kelebihantanah}\",
											 \"hargakltm2\":\"{$value->hargakltm2}\",
											 \"sudut\":\"{$value->sudut}\",
											 \"hadapjalan\":\"{$value->hadapjalan}\",
											 \"fasum\":\"{$value->fasum}\",
											 \"hargasudut\":\"{$value->hargasudut}\",
											 \"hargahadapjalan\":\"{$value->hargahadapjalan}\",
											 \"hargafasum\":\"{$value->hargafasum}\"
											}'
								data-content=\"$value->noid | {$value->keterangan} $ketStatusbooking
										\">{$value->keterangan}
							</option>";
			}
			unset($states, $list);
			$this->pemesanan_model->reset_param();
			return $options;
		};

	}

	public function get_record() {
		$this->pemesanan_model->table = "vpemesanan";
		$data =  $this->pemesanan_model->find_id($_POST['noid']);
		$output = array('hasil' => 'OK', 
						'data' => $data
			);		
		$this->pemesanan_model->reset_param();
		echo json_encode($output);
	}

	private function check_validate()
	{				
		//$config = array(
			$config = array(
				array(
					'field' => 'namapemesan',
					'label' => 'Nama Pemesan',
					'rules' => 'required|min_length[5]|max_length[35]',
					'errors' => array(
						'required' => 'anda harus mengisi item %s.',
						'min_length' => 'minimum isian %s adalah 5 digit',
						'max_length' => 'maximum isian %s adalah 35 digit'
						)
					),
				array(
					'field' => 'alamatpemesan',
					'label' => 'Alamat Pemesan',
					'rules' => 'required|min_length[5]',
					'errors' => array(
						'required' => 'anda harus mengisi item %s.',
						'min_length' => 'minimum isian %s adalah 5 digit',
						)
					)
				); 
		//);
		
		$this->form_validation->set_rules($config); 

		if ($this->form_validation->run() == FALSE) {
			//echo json_encode(array("status" => FALSE, 'data' => validation_errors()));
			return false;
		} else {		
			return true;
		}

	}

	public function save_crud()
	{
		if ($this->check_validate() == false) {
			echo json_encode(array("status" => FALSE, 'data' => validation_errors()));
		} else {
			$output = $this->pemesanan_model->save_pemesanan();
			//echo json_encode($output);
			echo json_encode(array("status" => true, 'data' => $output));
		}
	}

	public function delete_pemesanan()
	{
		$output = $this->pemesanan_model->delete_pemesananbyID($this->input->post('noid'));
		echo json_encode($output);
	}

	public function pembatalan_pemesanan() {
		$output = $this->pemesanan_model->pembatalan();
		echo json_encode($output);
	}

	public function get_pemesananlist() {
		$list = $this->pemesanan_model->get_listpemesanan();
		$options = "";
		$status;
		$konsumen;
		$states = array("success","info","danger","warning");

		//$loop = 0;
		if (count($list)) {
			foreach ($list as $key => $value) {
				$class = 'bold';
				$status = '';
				$konsumen = "<span class='label label-sm label-{$states[rand(0, 3)]}'> {$value->namapemesan} </span>";
				$options .= "<option {$status} class='{$class}' 
								value = '{$value->noid}' 
								data-content=\"{$value->noid} | {$value->nopesanan} | {$value->keterangan} $konsumen
										\">
							</option>";
			}
			return $options;
		};

	}

	public function akadjualbeli() {
		$hasil = $this->pemesanan_model->save_akad();
		echo json_encode($hasil);
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

	public function pemesanan_ExportXLS() {
		$this->load->library('excel');

        //activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('list_konsumen');
 
        // get all users in array formate
        $this->pemesanan_model->table = 'vpemesanan';
        $this->pemesanan_model->column_select = "noid, nopesanan, 
        	CASE polapembayaran when polapembayaran = 0 then 'KPR' WHEN polapembayaran = 1 then 'Tunai Keras' else 'Tunai Bertahap' end as Polapembayaran,
        	namapemesan, blok, nokavling, typerumah,
        	CASE statusbooking when statusbooking = 0 then 'OPEN' WHEN statusbooking = 1 then 'LOCK' WHEN statusbooking = 2 then 'AKAD' WHEN statusbooking = 3 then 'CLOSED' ELSE 'BATAL' end as statusbooking,
        	,hargajual ,diskon ,hargaklt ,hargasudut ,hargahadapjalan ,hargafasum, hargaredesign, hargatambahkwalitas, hargapekerjaantambah, 
        	totalharga, bookingfee, totaluangmuka, bookingfeebyr, lunasuangmuka, hargasudutbyr, hargahadapjalanbyr, hargakltbyr, hargafasumbyr,
        	hargaredesignbyr, hargatambahkwbyr, hargakerjatambahbyr, totalhargabyr, totalbayar, totalbayartitipan, totalhutang";
        
        $arraypemesanan = $this->pemesanan_model->find_all_array();
        $arraypemesanan = $this->template->array_change_key_ucword($arraypemesanan);

        // Set Title
        $this->excel->getActiveSheet()->setCellValue('A1', 'Daftar Konsumen');
 
        // read Key from Array to set to Header active sheet
		$this->excel->getActiveSheet()->fromArray(array_keys(current($arraypemesanan)), null, 'A2');
		// read data from array to active sheet
		$this->excel->getActiveSheet()->fromArray($arraypemesanan, null, 'A3');

        
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

		//$this->cellColor($highestColumm.'3:'.$highestColumm.$highestRow,'C6EFCE');
		//$this->setStyle($highestColumm.'3:'.$highestColumm.$highestRow);

		//SET column autosize
		// foreach(range('A',$highestColumm) as $columnID) {
		// 	$this->excel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
		// };

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

 
        $filename='pemesanan.xls'; //save our workbook as this file name
 
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
		//force_download('arraypemesanan.xls', $excelFileContents);


        //force user to download the Excel file without writing it to server's HD
        //$objWriter->save("php://output");
        $objWriter->save('D:/Downloads/'.$filename);
	}	

	
}