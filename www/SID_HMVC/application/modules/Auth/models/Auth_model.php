<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*
*/
class Auth_model extends CI_Model
{
	var $table = "users";

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function get_count()
	{
		//  $passwd = md5($_POST['password']);
		 $this->db->select('username, password')->from($this->table)->where(array('username'=>$_POST['username'], 'approve'=>'1'))->limit(1);
		 //$this->db->from($this->table);
		 //$this->db->where('username', $_POST['username']);
		 //$this->db->where('approve', '1');
		 // $this->db->where('password', $passwd);
		 //$this->db->limit(1);
		 $query = $this->db->get();
		 $row = $query->num_rows();

		 if ($row >= 1) { //data di temukan
			$data = $query->row();
			$passwd = $data->password;
		 	if ($data->password == $passwd)
		 		return "OK";
	 		return "password yang anda masukkan salah";
		 }
		 	return "User tidak di temukan";

		 //return $query->num_rows();
		//return 1;
	}

	public function get_user()
	{
		 $this->db->select('username')->from($this->table)->where('username', $_POST['username'])->limit(1);
		 //$this->db->where('approve', '1');

		 $query = $this->db->get();

		 return $query->num_rows();
	}

	public function save($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function getparameter() {
		$this->db->select('company, bulanbuku, tahunbuku, kasir, accounting, pimpinan')
				 ->from('parameter');
		return $this->db->get()->row();
	}

}
?>