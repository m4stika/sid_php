<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
*
*/
class Perkiraan extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('perkiraan_model');
	}

	public function index() {
		$listGroup = $this->get_accountLevel0();
		$data = array(
				'title'		=> 'SID | Accounting',
				'page' 		=> 'accounting',
 				'content'	=> 'perkiraan',
 				'isi' 		=> 'Accounting/accounting_page',
 				'pagecontent' => 'Accounting/perkiraan_view',
 				'listGroup' => $listGroup
 			);
	 	$this->template->admin_template($data);
	}

	public function newAccountNo() {
		$output = $this->perkiraan_model->get_newAccountNo($_POST['keyvalue']);
		echo json_encode($output);
	}

	private function get_accountLevel0() {
		$list =  $this->perkiraan_model->get_ListPerkiraanParent(0);
		$states = array("success","info","danger","warning");
		$options = "";
		$no = 0;
		if (count($list)) {
			foreach ($list as $value) {
				$description = $value->description;// "<span class='label label-{$states[rand(0, 3)]}'> {$value->description} </span>";
				$options .= "<option value = '{$no}'
								data-value='{\"rekid\":\"{$value->rekid}\",
											 \"accountno\":\"{$value->accountno}\",
											 \"description\":\"{$value->description}\"
											}'
								data-content=\"{$description}
										\">
							</option>";
				$no++;
			}
		};
		unset($list, $states);
		return $options;
	}

	public function get_perkiraanItem() {
		$list = $this->perkiraan_model->get_ListPerkiraanKey($_POST['id']);
		$listParent = $this->perkiraan_model->get_ListPerkiraanKey($_POST['parentid']);
		$output = array('data'=>$list, 'parent' => $listParent);
		echo json_encode($output);
	}

	public function get_perkiraan() {
		$list = $this->perkiraan_model->get_ListPerkiraanParent($_POST['id']);
		if (!$list) {
			echo json_encode('ERROR');
			return false;
		}
		$groupacc = array(0=>"Asset","Liability","Equity","Income","Cost Of Sales","Expense","Other Income","Other Expense");
		$classacc = array(0=>"HEADER","Detail","Kas Bank");
		$output = array();
		$data = array();

		foreach ($list as $value) {
			$item = array();
			$accountnoD = "<span class=''> {$value->accountno} </span>";
			$accountnoH = "<span class='bold'> {$value->accountno} </span>";

			$item['ID'] = $value->keyvalue;
			$item['rekid'] = $value->rekid;
			$item['accountno'] = $value->accountno;
			$item['description'] = $value->description;
			$item['levelacc'] = $value->levelacc;
			$item['childNodeType'] = ($value->classacc == 0) ? 'branch' : 'leaf';
			$item['childData'] = array(($value->classacc == 0) ? $accountnoH : $accountnoD,
										$value->description,
										$groupacc[$value->groupacc],
										$classacc[$value->classacc],
										// $value->groupacc,
										// $value->classacc,
										$value->openingbalance,
										// $value->transbalance,
										// $value->transbalance,
										($value->debitacc == 1) ? $value->transbalance : 0,
										($value->debitacc == 0) ? $value->transbalance : 0,
										$value->balancedue
										);
			$data[] = $item;
		}
		$output[$value->parentkey] = $data;

		unset($list, $data, $item);

		echo json_encode(array('nodeID'=>$output));
	}

	public function get_ChartOfAccount()
	{
		$parent = ($_REQUEST['parent'] == '#') ? -1 : $_REQUEST['parent'];
		$list = $this->perkiraan_model->get_ListPerkiraanParent($parent);

		$data = array();
		$states = array(
		  	"success",
		  	"info",
		  	"danger",
		  	"warning"
		);

		foreach ($list as $value) {
			$data[] = array(
				"id" => $value->keyvalue, //$value->noid),
				"text" => '['.$value->accountno.'] - ' . $value->description,
				"icon" => ($value->classacc == 0) ? "fa fa-folder icon-lg icon-state-" . ($states[rand(0, 3)]) : "fa fa-file fa-large icon-state-default",
				"children" => (($value->classacc == 0) ? true : false),
				"type" => (($_REQUEST['parent'] == '#') ? "root" : "group"),
				"data" => array("noid" => $value->rekid,
								"accountno" => $value->accountno,
								"description" => $value->description,
								"classacc" => $value->classacc,
								"debitacc" => $value->debitacc,
								"balancesheetacc" => $value->balancesheetacc
						),
			);
		}
		header('Content-type: text/json');
		header('Content-type: application/json');
		echo json_encode($data);

	}

	public function get_SearchAccount() {
		$list = $this->perkiraan_model->get_SearchAccountList($_POST['search']);
		$options = "";
		//$keterangan;
		$states = array("success","info","danger","warning");
		$group = array("ASSET","LIABILITY","EQUITY","INCOME","COST OF SALES","EXPENSE","OTHER INCOME","OTHER EXPENSE");

		//$loop = 0;
		if (count($list)) {
			foreach ($list as $value) {
				$options .= "<li data-value='{\"noid\":\"{$value->rekid}\",
				 							 \"accountno\":\"{$value->accountno}\",
				 							 \"description\":\"{$value->description}\",
				 							 \"classacc\":\"{$value->classacc}\",
				 							 \"debitacc\":\"{$value->debitacc}\",
				 							 \"balancesheetacc\":\"{$value->balancesheetacc}\"
				 							}' >";
                $options .= "    <div class='col1'>";
                $options .= "        <div class='cont'>";
                $options .= "            <div class='cont-col1'>";
                $options .= "                <div class='desc'> {$value->description} </div>";
                $options .= "                <span class='label label-sm label-{$states[rand(0, 3)]}'>{$value->accountno}</span>";
                $options .= "            </div>";
                $options .= "        </div>";
                $options .= "    </div>";
                $options .= "    <div class='col2'>";
                $options .= "        <div class='date'> {$group[$value->groupacc]} </div>";
                $options .= "    </div>";
                $options .= "</li>";

				// $keterangan = "<span class='label label-sm label-{$states[rand(0, 3)]} font-dark'> {$value->accountno} </span>";
				// $options .=  "<option class=''
				// 				value = '{$value->rekid}'
				// 				data-value='{\"rekid\":\"{$value->rekid}\",
				// 							 \"accountno\":\"{$value->accountno}\",
				// 							 \"description\":\"{$value->description}\"
				// 							}'
				// 				data-content=\"{$value->rekid} | $keterangan - {$value->description}
				// 						\">$keterangan {$value->description}
				// 			</option>";
			}
			//return $options;
			//echo json_encode($options);
			echo $options;
		};
		//$this->kasbank_model->resetVar();
	}

	public function save_Perkiraan() {
		$rekid = $this->perkiraan_model->save_PerkiraanItem($_POST);
		echo json_encode($rekid);
	}

	public function delete_perkiraan() {
		$hasil = $this->perkiraan_model->delete_PerkiraanItem($_POST);
		$status = ($hasil == "Success") ? 1 : 0;
		echo json_encode(array('status'=>$status, 'message'=>$hasil));
	}
}