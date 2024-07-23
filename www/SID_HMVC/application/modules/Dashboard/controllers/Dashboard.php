<?php
(defined('BASEPATH')) OR exit('No direct script access allowed');

/**
*
*/
class Dashboard extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('dashboard_model');
	}

	function index()
	{
		// Berfungsi untuk mengecek apakah ada session user yang login
		if ($this->session->userdata('username')) {
			$data = array(
				'title'		=> 'SID | Dashboard',
				'page' 		=> 'dashboard',
 				'content'	=> 'perencanaan',
 				'isi' 		=> 'Dashboard/home_view'
 			);
			// Jika ada session user yang login maka akan dialihkan ke halaman dashboard
			$this->template->admin_template($data);
		}
		else{
			// jika tidak ada maka akan dikembalikan ke halaman login
			redirect(base_url(). 'Auth/show_login',"refresh");
			// redirect(base_url(). 'login',"refresh");
			// redirect('login');
			// $this->auth->show_login();
		}
	}

	public function get_kontrak() {
		$list = $this->dashboard_model->getkontrak($_POST['search']);
		$options = "";
		//$keterangan;
		$states = array("success","info","danger","warning");
		$group = array("ASSET","LIABILITY","EQUITY","INCOME","COST OF SALES","EXPENSE","OTHER INCOME","OTHER EXPENSE");

		//$loop = 0;
		if (count($list)) {
			foreach ($list as $value) {
				$options .= "<li data-value='{\"noid\":\"{$value->noid}\",
				 							 \"info\":\"{$value->nopesanan}\",
				 							 \"description\":\"{$value->namapemesan}\",
				 							 \"typerumah\":\"{$value->typerumah}\",
				 							 \"flag\":\"kontrak\"
				 							}' >";
                $options .= "    <div class='col1'>";
                $options .= "        <div class='cont'>";
                $options .= "            <div class='cont-col1'>";
                $options .= "                <div class='desc'> {$value->namapemesan} </div>";
                $options .= "                <span class='label label-sm label-{$states[rand(0, 3)]}'>{$value->nopesanan}</span>";
                $options .= "            </div>";
                $options .= "        </div>";
                $options .= "    </div>";
                $options .= "    <div class='col2'>";
                $options .= "        <div class='date'> ".number_format($value->hargajual,0,'.',',')."</div>";
                $options .= "    </div>";
                $options .= "</li>";
			}
			echo $options;
		};
	}

	public function get_kwitansi() {
		$list = $this->dashboard_model->getkwitansi($_POST['search']);
		$options = "";
		//$keterangan;
		$states = array("success","info","danger","warning");
		$group = array("ASSET","LIABILITY","EQUITY","INCOME","COST OF SALES","EXPENSE","OTHER INCOME","OTHER EXPENSE");

		//$loop = 0;
		if (count($list)) {
			foreach ($list as $value) {
				$options .= "<li data-value='{\"noid\":\"{$value->noid}\",
				 							 \"idpemesanan\":\"{$value->idpemesanan}\",
				 							 \"description\":\"{$value->namapemesan}\",
				 							 \"info\":\"{$value->nokwitansi}\",
				 							 \"flag\":\"kwitansi\"
				 							}' >";
                $options .= "    <div class='col1'>";
                $options .= "        <div class='cont'>";
                $options .= "            <div class='cont-col1'>";
                $options .= "                <div class='desc'> {$value->namapemesan} </div>";
                $options .= "                <span class='label label-sm label-{$states[rand(0, 3)]}'>{$value->nokwitansi}</span>";
                $options .= "            </div>";
                $options .= "        </div>";
                $options .= "    </div>";
                $options .= "    <div class='col2'>";
                $options .= "        <div class='date'> ".number_format($value->totalbayar,0,'.',',')."</div>";
                $options .= "    </div>";
                $options .= "</li>";
			}
			echo $options;
		};
	}

	public function get_journal() {
		$list = $this->dashboard_model->getjournal($_POST['search']);
		$options = "";
		//$keterangan;
		$states = array("success","info","danger","warning");

		//$loop = 0;
		if (count($list)) {
			foreach ($list as $value) {
				$options .= "<li data-value='{\"noid\":\"{$value->journalid}\",
				 							 \"info\":\"{$value->journalno}\",
				 							 \"bulan\":\"{$value->bulan}\",
				 							 \"tahun\":\"{$value->tahun}\",
				 							 \"description\":\"{$value->journalremark}\",
				 							 \"dueamount\":\"{$value->dueamount}\",
				 							 \"flag\":\"journal\"
				 							}' >";
                $options .= "    <div class='col1'>";
                $options .= "        <div class='cont'>";
                $options .= "            <div class='cont-col1'>";
                $options .= "                <div class='desc'> {$value->journalremark} </div>";
                $options .= "                <span class='label label-sm label-{$states[rand(0, 3)]}'>{$value->journalno}</span>";
                $options .= "            </div>";
                $options .= "        </div>";
                $options .= "    </div>";
                $options .= "    <div class='col2'>";
                $options .= "        <div class='date'> ".number_format($value->dueamount,0,'.',',')."</div>";
                $options .= "    </div>";
                $options .= "</li>";
			}
			echo $options;
		};
	}

	public function get_kasbank() {
		$list = $this->dashboard_model->getkasbank($_POST['search']);
		$options = "";
		//$keterangan;
		$states = array("success","info","danger","warning");

		//$loop = 0;
		if (count($list)) {
			foreach ($list as $value) {
				$options .= "<li data-value='{\"noid\":\"{$value->noid}\",
				 							 \"kasbanktype\":\"{$value->kasbanktype}\",
				 							 \"description\":\"{$value->nojurnal}\",
				 							 \"info\":\"{$value->nojurnal}\",
				 							 \"flag\":\"kasbank\"
				 							}' >";
                $options .= "    <div class='col1'>";
                $options .= "        <div class='cont'>";
                $options .= "            <div class='cont-col1'>";
                $options .= "                <div class='desc'> {$value->uraian} </div>";
                $options .= "                <span class='label label-sm label-{$states[rand(0, 3)]}'>{$value->nojurnal}</span>";
                $options .= "            </div>";
                $options .= "        </div>";
                $options .= "    </div>";
                $options .= "    <div class='col2'>";
                $options .= "        <div class='date'> ".number_format($value->totaltransaksi,0,'.',',')."</div>";
                $options .= "    </div>";
                $options .= "</li>";
			}
			echo $options;
		};
	}

	public function get_PerkiraanKB() {
		$list = $this->dashboard_model->getperkiraankb($_POST['search']);
		$options = "";
		//$keterangan;
		$states = array("success","info","danger","warning");

		//$loop = 0;
		if (count($list)) {
			foreach ($list as $value) {
				$options .= "<li data-value='{\"noid\":\"{$value->rekid}\",
				 							 \"keyvalue\":\"{$value->keyvalue}\",
				 							 \"description\":\"{$value->description}\",
				 							 \"info\":\"{$value->accountno}\",
				 							 \"flag\":\"perkiraankb\"
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
                $options .= "        <div class='date'> {$value->keyvalue}</div>";
                $options .= "    </div>";
                $options .= "</li>";
			}
			echo $options;
		};
	}

	public function get_Perkiraan() {
		$list = $this->dashboard_model->getperkiraan($_POST['search']);
		$options = "";
		//$keterangan;
		$states = array("success","info","danger","warning");

		//$loop = 0;
		if (count($list)) {
			foreach ($list as $value) {
				$options .= "<li data-value='{\"noid\":\"{$value->rekid}\",
				 							 \"keyvalue\":\"{$value->keyvalue}\",
				 							 \"description\":\"{$value->description}\",
				 							 \"info\":\"{$value->accountno}\",
				 							 \"flag\":\"perkiraan\"
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
                $options .= "        <div class='date'> {$value->keyvalue}</div>";
                $options .= "    </div>";
                $options .= "</li>";
			}
			echo $options;
		};
	}

}

?>