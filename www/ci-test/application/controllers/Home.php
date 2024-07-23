<?php
class Home extends CI_Controller {
	public function index()
	{
		// $this->load->database();
		$this->load->view('home/index');
	}
}