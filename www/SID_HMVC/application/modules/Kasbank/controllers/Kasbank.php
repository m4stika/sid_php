<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
*
*/
class Kasbank extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('kasbank_model');
	}

	public function index() {
		$listkas = $this->get_banklist('1000101');
		$listbank = $this->get_banklist('1000102');
		$listkasbank = $this->get_banklist();
		$data = array(
				'title'		=> 'SID | KasBank',
				'page' 		=> 'kasbank',
 				'content'	=> 'cash',
 				'isi' 		=> 'Kasbank/kasbank_page',
 				'pagecontent' => 'Kasbank/kasbank_jurnal',
 				'banklist' => $listbank,
 				'kaslist' => $listkas,
 				'acckasbank' => $listkasbank
 			);
	 	$this->template->admin_template($data);
	}

	public function get_BankInOut() {
		$listkas = $this->get_banklist('1000101');
		$listbank = $this->get_banklist('1000102');
		$listkasbank = $this->get_banklist();
		$data = array(
				'title'		=> 'SID | KasBank',
				'page' 		=> 'kasbank',
 				'content'	=> 'bank',
 				'isi' 		=> 'Kasbank/kasbank_page',
 				'pagecontent' => 'Kasbank/kasbank_jurnal',
 				'banklist' => $listbank,
 				'kaslist' => $listkas,
 				'acckasbank' => $listkasbank
 			);
	 	$this->template->admin_template($data);
	}

	public function get_assign() {
		$listkasbank = $this->get_banklist();
		$data = array(
				'title'		=> 'SID | KasBank',
				'page' 		=> 'kasbank',
 				'content'	=> 'kbassign',
 				'isi' 		=> 'Kasbank/kasbank_page',
 				'pagecontent' => 'Kasbank/kasbank_assign',
 				'acckasbank' => $listkasbank
 			);
	 	$this->template->admin_template($data);
	}

	public function get_extract() {
		$listkasbank = $this->get_banklist();
		$data = array(
				'title'		=> 'SID | KasBank',
				'page' 		=> 'kasbank',
 				'content'	=> 'kbextract',
 				'isi' 		=> 'Kasbank/kasbank_page',
 				'pagecontent' => 'Kasbank/kasbank_extract',
 				'acckasbank' => $listkasbank
 			);
	 	$this->template->admin_template($data);
	}


	public function get_banklist($parentkey = null) {
		$list = $this->kasbank_model->getbanklist($parentkey);
		$options = "";
		$keterangan;
		$states = array("success","info","danger","warning");

		//$loop = 0;
		if (count($list)) {
			foreach ($list as $key => $value) {
				$keterangan = "<span class='label label-sm label-{$states[rand(0, 3)]} font-dark'> {$value->accountno} </span>";
				$options .=  "<option class=''
								value = '{$value->rekid}'
								data-value='{\"rekid\":\"{$value->rekid}\",
											 \"accountno\":\"{$value->accountno}\",
											 \"description\":\"{$value->description}\"
											}'
								data-content=\"{$value->rekid} | $keterangan - {$value->description}
										\">$keterangan {$value->description}
							</option>";
			}
			return $options;
		};
	}

	public function get_acclist($parentkey = null, $classacc = 2, $parentlike = false) {
		$list = $this->kasbank_model->get_AccountList($parentkey, $classacc, $parentlike);
		$options = "";
		$keterangan;
		$states = array("success","info","danger","warning");

		//$loop = 0;
		if (count($list)) {
			foreach ($list as $key => $value) {
				$keterangan = "<span class='label label-sm label-{$states[rand(0, 3)]} font-dark'> {$value->accountno} </span>";
				$options .=  "<option class=''
								value = '{$value->rekid}'
								data-value='{\"rekid\":\"{$value->rekid}\",
											 \"accountno\":\"{$value->accountno}\",
											 \"description\":\"{$value->description}\"
											}'
								data-content=\"{$value->rekid} | $keterangan - {$value->description}
										\">$keterangan {$value->description}
							</option>";
			}
			return $options;
		};
		$this->kasbank_model->resetVar();

	}



	public function get_ListjurnalKB() {
		//$column_where = array('classacc =' => 2);
		$list = $this->kasbank_model->get_Listjurnal();
		$data = array();
		$no = $_POST['start'];
		$states = array(
		  	"default",
		  	"success",
		  	"info",
		  	"warning",
		  	"danger"
		);
		$verifikasi = array("Open","Kasir","Keuangan","Pimpinan","Closed");
        foreach ($list as $value) {
            $no++;
            $row = array();
            $statusverifikasi = "<span class='label label-sm label-{$states[$value->statusverifikasi]}'> {$verifikasi[$value->statusverifikasi]} </span>";
            $accountno = "<span class='label label-sm label-{$states[rand(0, 4)]} font-dark'> {$value->accountno} </span>  => {$value->description}";
			//$row[] = $this->template->add_dropdown(0,$no);
			($value->statusverifikasi < 3) ? $row[] = $this->template->add_dropdown(0,$no) : $row[] =  $this->template->add_dropdown(1,$no);
			$row[] = $value->noid;
			$row[] = $statusverifikasi;
			$row[] = $value->tgltransaksi;
			$row[] = $value->nokasbank;
			//$row[] = $value->rekid;
			$row[] = $accountno; // | $value->description;
			$row[] = $value->totaltransaksi;
			$row[] = $value->uraian;
			//$row[] = '<a class="edit" href="javascript:;"> Edit </a>';
			//$row[] = '<a class="delete" href="javascript:;"> Delete </a>';
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->kasbank_model->count_all(),
						"recordsFiltered" => $this->kasbank_model->count_filtered(),
						"data" => $data
				);
		$this->kasbank_model->resetVar();
		//output to json format
		echo json_encode($output);
	}

	public function get_listAssignKB() {
		//$column_where = array('classacc =' => 2);

		//Jika ada data Assign, lakukan proses assign terlebih dahulu
		$hasil = '';
		if (isset($_REQUEST["customActionType"]) && $_REQUEST["customActionType"] == "group_action") {
			$hasil = $this->kasbank_model->assign_jurnal();
		}
		$list = $this->kasbank_model->get_listAssign();

		$data = array();
		$no = $_POST['start'];
		$states = array(
		  	"default",
		  	"success",
		  	"info",
		  	"warning",
		  	"danger"
		);
		// echo "<script>console.log('" . json_encode(var_export($data, true)) . "');</script>";
		$verifikasi = array("Open","Kasir","Keuangan","Pimpinan","Closed");
        foreach ($list as $value) {
            $no++;
            $row = array();
            $statusverifikasi = "<span class='label label-sm label-{$states[$value->statusverifikasi]}'> {$verifikasi[$value->statusverifikasi]} </span>";
            $accountno = "<span class='label label-sm label-{$states[rand(0, 4)]} font-dark'> {$value->accountno} </span>  => {$value->description}";
			//$row[] = $this->template->add_dropdown(0,$no);
			//($value->statusverifikasi < 3) ? $row[] = $this->template->add_dropdown(0,$no) : $row[] =  $this->template->add_dropdown(1,$no);
			$row[] = "<label class='mt-checkbox mt-checkbox-single mt-checkbox-outline'>
                        <input type='checkbox' class='checkboxes' value='1' />
                        <span></span>
                    </label>";
			$row[] = $value->noid;
			$row[] = $statusverifikasi;
			$row[] = $value->tgltransaksi;
			$row[] = $value->nokasbank;
			//$row[] = $value->rekid;
			$row[] = $accountno; // | $value->description;
			$row[] = $value->totaltransaksi;
			$row[] = "<a class='view' data-value='{$value->noid}'> View </a>";
			//$row[] = '<a class="delete" href="javascript:;"> Delete </a>';
			$data[] = $row;
		}


		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->kasbank_model->count_all(),
						"recordsFiltered" => $this->kasbank_model->count_filtered(),
						//"customActionStatus" => "OK", // pass custom message(useful for getting status of group actions)
    					//"customActionMessage" => "Group action successfully has been completed. Well done!", // pass custom message(useful for getting status of group actions)
						"data" => $data
				);
		if (isset($_REQUEST["customActionType"]) && $_REQUEST["customActionType"] == "group_action") {
		    $output["customActionStatus"] = "OK"; // pass custom message(useful for getting status of group actions)
		    $output["customActionMessage"] = $hasil; // "Group action successfully has been completed. Well done!"; // pass custom message(useful for getting status of group actions)
		  }
		$this->kasbank_model->resetVar();
		//output to json format
		echo json_encode($output);
	}

	public function get_JurnalKB() {
		//$column_where = array('classacc =' => 2);
		$listHeader = $this->kasbank_model->get_jurnalHeader();
		$states = array("success","info","danger","warning");
		$accountno = "<span class='label label-sm label-info'>{$listHeader['accountno']}</span> => {$listHeader['description']}";
		if ($listHeader) {$listHeader['perkiraan'] = $accountno;};
		//$tgl = date_create('2013-03-15');
		//$listHeader['tgltransaksi'] = date_format($tgl, "d-M-Y");
		$listDetail = $this->kasbank_model->get_jurnalDetail();
		$data = array();
		$no = 0; //$_POST['start'];
        foreach ($listDetail as $value) {
            $no++;
            $row = array();
			//($value->statusverifikasi < 3) ? $row[] = $this->template->add_dropdown(0,$no) : $row[] =  $this->template->add_dropdown(1,$no);
			$row[] = ($_POST['crud'] == 'edit') ? "<a class='lock label label-danger' data-value=''>lock</a>" : "<a class='delete label label-info' data-value=''>delete</a>";
			$row[] = $value->rekid;
			$row[] = $value->accountno;
			$row[] = $value->description;
			$row[] = $value->remark;
			$row[] = $value->amount;
			$data[] = $row;
		}

		$output = array("jurnalDetail" => $data, "jurnalHeader" => $listHeader);
		//"jurnalHeader" => $listHeader,
		//$this->kasbank_model->resetVar();
		//output to json format
		echo json_encode($output);
	}

	public function get_listextractKB() {
		//Jika Tidak ada data yang di pilih
		if (! isset($_POST['flag']) || $_POST['flag'] < 1) {
			$output = array("draw" => $_POST['draw'], "recordsTotal" => 0, "recordsFiltered" => 0, "data" => array());
			echo json_encode($output);
			return false;
		}

		//Jika ada data Assign, lakukan proses assign terlebih dahulu
		$hasil = '';
		if (isset($_REQUEST["customActionType"]) && $_REQUEST["customActionType"] == "extract") {
			$hasil = $this->kasbank_model->insertJurnalExtract();
		}

		$list = $this->kasbank_model->get_listextract();
		$data = array();
		$no = $_POST['start'];
		$states = array("success","info","warning","danger","default");
		$jenisextract = array(1=>"Pembayaran","Batal Bayar","Akad Jual Beli","Pembatalan Pemesanan","Pencairan Insentif");
		$extracttype = "<span class='label label-sm label-{$states[1]}'>{$jenisextract[1]}</span>";

		if(isset($_POST['flag'])) {
            $extracttype = "<span class='label label-sm label-{$states[$this->input->post('flag')-1]}'>{$jenisextract[$this->input->post('flag')]}</span>";
		}


        foreach ($list['list'] as $value) {
            $no++;
            $row = array();
            $site = base_url('assets/pages/img/plus.png');
            $accountno = "<span class='label label-sm label-{$states[rand(0, 4)]} font-dark'> {$value->accountno} </span>  => {$value->description}";
			//$row[] = $this->template->add_dropdown(0,$no);
			//($value->statusverifikasi < 3) ? $row[] = $this->template->add_dropdown(0,$no) : $row[] =  $this->template->add_dropdown(1,$no);
			$row[] = "<img src= '$site'>"; //"http://i.imgur.com/SD7Dz.png'>";
			$row[] = $value->noid;
			$row[] = $extracttype;
			$row[] = $value->tgltransaksi;
			$row[] = $value->nobukti;
			//$row[] = $value->accountno;
			$row[] = $accountno; // | $value->description;
			$row[] = $value->totaltransaksi;
			//$row[] = '<a class="delete" href="javascript:;"> Delete </a>';
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $list['total_rec_all'],// $this->kasbank_model->count_all(array('kodeupdated'=>'O')),
						"recordsFiltered" => $list['total_filtered'],// $this->kasbank_model->count_filtered(array('kodeupdated'=>'O')),
						//"customActionStatus" => "OK", // pass custom message(useful for getting status of group actions)
    					//"customActionMessage" => "Group action successfully has been completed. Well done!", // pass custom message(useful for getting status of group actions)
						"data" => $data
				);
		//$output["flag"] = $_POST['flag'];
		if (isset($_REQUEST["customActionType"]) && $_REQUEST["customActionType"] == "group_action") {
		    $output["customActionStatus"] = "OK"; // pass custom message(useful for getting status of group actions)
		    $output["customActionMessage"] = $hasil; // "Group action successfully has been completed. Well done!"; // pass custom message(useful for getting status of group actions)

		  }
		$this->kasbank_model->resetVar();
		//output to json format
		echo json_encode($output);
	}

	public function get_extractDetilKB() {
		//$column_where = array('classacc =' => 2);
		$states = array("success","info","danger","warning");
		//$accountno = "<span class='label label-sm label-info'>{$listHeader['accountno']}</span> => {$listHeader['description']}";
		//$listHeader['perkiraan'] = $accountno;
		//$tgl = date_create('2013-03-15');
		//$listHeader['tgltransaksi'] = date_format($tgl, "d-M-Y");
		$listDetail = $this->kasbank_model->get_extractDetail();
		$data = array();
		$no = 0; //$_POST['start'];
        foreach ($listDetail as $value) {
            $no++;
            $row = array();
			//($value->statusverifikasi < 3) ? $row[] = $this->template->add_dropdown(0,$no) : $row[] =  $this->template->add_dropdown(1,$no);
			$row[] = $no;// ($_POST['crud'] == 'edit') ? "<a class='lock label label-danger' data-value=''>lock</a>" : "<a class='delete label label-info' data-value=''>delete</a>";
			// $row[] = $value->rekid;
			$row[] = $value->accountno;
			$row[] = $value->description;
			$row[] = $value->keterangan;
			$row[] = $value->amount;
			$data[] = $row;
		}

		$output = $data;// array("jurnalDetail" => $data, "jurnalHeader" => $listHeader);
		//"jurnalHeader" => $listHeader,
		//$this->kasbank_model->resetVar();
		//output to json format
		echo json_encode($output);
	}


	public function save_jurnal() {
		//$this->template->admin_template();
		$hasil = $this->kasbank_model->save_JurnalKB();
		echo json_encode($hasil);
	}

	public function delete_jurnal() {
		// Hapus Rincian Kasbank
		$this->kasbank_model->column_index = 'idkasbank';
		$this->kasbank_model->table = 'rinciankasbank';
		$this->kasbank_model->delete($_POST['noid']);

		// Hapus Data Header Kasbank
		$this->kasbank_model->column_index = 'noid';
		$this->kasbank_model->table = 'kasbank';
		$hasil =  $this->kasbank_model->delete($_POST['noid']);

		//Reset Variable Model
		$this->kasbank_model->resetVar();

		echo json_encode(array("status" => $hasil));
	}

	public function get_api() {
		$output = $_REQUEST['noid'];
		echo json_encode(array('Sukses'=>$output));
	}


}