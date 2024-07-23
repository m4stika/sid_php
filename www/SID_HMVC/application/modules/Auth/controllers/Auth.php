<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
// if ( ! defined('BASEPATH')) exit('No direct script access allowed');
(defined('BASEPATH')) OR exit('No direct script access allowed');

/**
*
*/
class Auth extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('auth_model','login');
	}

	// public function index() {
	// 	$this->load->library('form_validation');
	// 	$this->load->view('userlogin-view');
	// }

	function show_login()
	{
		$data = array(
				'title'		=> 'SID | Log-in'
 			);
		$this->load->view('Auth/login_view',$data);
		// echo "Modul Login";
	}

	function lockscreen()
	{
		$data = array(
				'title'		=> 'SID | User Lock'
 			);
		if ($this->session->userdata('username')) {
			$data['userlogin'] = $this->session->userdata('username');
		} else {
			$data['userlogin'] = "";
		}
		$this->load->view('Auth/lock_view',$data);
	}

	// Berfungsi untuk menghapus session atau logout
	function logout() {
		$this->session->sess_destroy();
		redirect(base_url() . 'Auth/show_login');
		// redirect(base_url() . 'Auth/lockscreen');
	}

	public function check_exist()
	{
			$row = $this->login->get_user();
			if ($row >= 1 ) {
				echo 'true';
			} else {
				echo 'false';
			}

	}


	public function check_validate()
	{
		//$config = array(
			$config = array(
				array(
					'field' => 'username',
					'label' => 'username',
					'rules' => 'required|min_length[5]|max_length[15]',
					'errors' => array(
						'required' => 'anda harus mengisi item %s.',
						'min_length' => 'minimum isian %s adalah 5 digit',
						'max_length' => 'maximum isian %s adalah 15 digit'
						)
					),
				array(
					'field' => 'password',
					'label' => 'password',
					'rules' => 'required|min_length[5]|max_length[15]',
					'errors' => array(
						'required' => 'anda harus mengisi item %s.',
						'min_length' => 'minimum isian %s adalah 5 digit',
						'max_length' => 'maximum isian %s adalah 15 digit'
						)
					)
				);
		//);

		$this->form_validation->set_rules($config);

		if ($this->form_validation->run() == FALSE) {
			echo json_encode(array("status" => FALSE, 'data' => validation_errors()));
		} else {
			$data=array(
				'username'=>$this->input->post('username'),
				'password'=>$this->input->post('password')
				);

			$row = $this->login->get_count();

			if ($row == "OK") {
				$param = $this->login->getparameter();
				$data['company'] = $param->company;
				$data['bulanbuku'] = $param->bulanbuku;
				$data['tahunbuku'] = $param->tahunbuku;
				$data['kasir'] = $param->kasir;
				$data['accounting'] = $param->accounting;
				$data['pimpinan'] = $param->pimpinan;

				$data['new_expiration'] = 60*60*24*30;//30 days
        		$this->session->sess_expiration = $data['new_expiration'];

				$sesi=$this->session->set_userdata($data);
				echo json_encode(array("status" => true, 'data' => $row));
			} else {
				echo json_encode(array("status" => false, 'data' => $row));
			}
		}

	}


	public function register_check_exist()
	{

			$row = $this->login->get_user();
			if ($row >= 1 ) {
				echo 'false';
			} else {
				echo 'true';
			}

	}

	public function register_validate()
	{
		//$config = array(
			$config = array(
				array(
					'field' => 'namalengkap',
					'label' => 'namalengkap',
					'rules' => 'required|min_length[5]|max_length[15]',
					'errors' => array(
						'required' => 'anda harus mengisi item %s.',
						'min_length' => 'minimum isian %s adalah 5 digit',
						'max_length' => 'maximum isian %s adalah 15 digit'
						)
					),
				array(
					'field' => 'email',
					'label' => 'email',
					'rules' => 'required|valid_email|is_unique[users.email]',
					'errors' => array(
						'required' => 'anda harus mengisi item %s.',
						'is_unique' => '%s sudah ada dalam database'
						)
					),
				array(
					'field' => 'username',
					'label' => 'username',
					'rules' => 'required|min_length[5]|max_length[15]|is_unique[users.username]',
					'errors' => array(
						'required' => 'anda harus mengisi item %s.',
						'min_length' => 'minimum isian %s adalah 5 digit',
						'max_length' => 'maximum isian %s adalah 15 digit',
						'is_unique' => '%s sudah ada dalam database'
						)
					),
				array(
					'field' => 'password',
					'label' => 'password',
					'rules' => 'required|min_length[5]|max_length[15]',
					'errors' => array(
						'required' => 'anda harus mengisi item %s.',
						'min_length' => 'minimum isian %s adalah 5 digit',
						'max_length' => 'maximum isian %s adalah 15 digit'
						)
					),
				array(
					'field' => 'rpassword',
					'label' => 'password confirmation',
					'rules' => 'required|matches[password]',
					'errors' => array(
						'required' => 'anda harus mengisi item %s.'
						)
					)
				);

		//);

		$this->form_validation->set_rules($config);

		if ($this->form_validation->run() == FALSE) {
			echo json_encode(array("status" => FALSE, 'data' => validation_errors()));
		} else {

			$row = $this->login->get_user();
			if ($row >= 1 ) {
				echo json_encode(array("status" => false, 'data' => "User Sudah terdaftar"));
			} else {

				$data_post = array(
					"username"=>$this->input->post('username'),
					"password"=>md5($this->input->post('password')),
					"namalengkap"=>$this->input->post('namalengkap'),
					"email"=>$this->input->post('email'),
					"alamat"=>$this->input->post('alamat'),
					"kota"=>$this->input->post('kota'),
					"approve"=>false
				);

				$id = $this->login->save($data_post);
				echo json_encode(array("status" => true, 'data' => $id));
			}
		}

	}


}
?>
