<?php
(defined('BASEPATH')) OR exit('No direct script access allowed');

/**
* 
*/
class Template extends MY_controller
{
	
	function __construct()
	{
		parent::__construct();
	}

	function index()
	{		
		$data = array(
				'userlogin' => 'admin',
				'title'		=> 'SID | System Informasi Property',
				'page' 		=> 'dashboard', 
 				'content'	=> 'perencanaan',
 				'isi' 		=> 'Template/blank_page'
 			);		
		$this->load->view('Template/wrapper',$data);
	}

	function admin_template($data = NULL)
	{
		if (!isset($data)) {
			$data = array(
					'title'		=> 'SID | System Informasi Property',
					'page' 		=> 'dashboard', 
	 				'content'	=> 'perencanaan',
	 				'isi' 		=> 'Template/blank_page'
	 			);
		};


		if ($this->session->userdata('username')) {
			$data['userlogin'] = $this->session->userdata('username');
			$data['parameter'] = $this->session->userdata();
		} else {
			$data['userlogin'] = "";
		}
		
		$this->load->view('Template/wrapper',$data);
	}

	public function add_dropdown($statusbooking = 0, $no='', $enddiv = true) {
		$menustr = "<div class='btn-group no-margin'>";
		// $menustr .= 	"<span class=\"label label-sm label-primary\"> No. </span>";
		$menustr .= 	"<button class='btn btn-xs btn-success dropdown-toggle no-margin' type='button' data-toggle='dropdown' aria-expanded='false'>";
		$menustr .= 		"<label class='label bg-green-jungle bg-font-green-jungle'>".$no;
		$menustr .= 		"</label> Actions";
		$menustr .= 		"<i class='fa fa-angle-down'></i>";
		$menustr .= 	"</button>";
		
		$menustr .= 	"<ul class='dropdown-menu' role='menu'>";
		$menustr .= 		"<li>";
		$menustr .= 			"<a href='javascript:;' class='edit'> <i class='fa fa-edit'></i> Edit</a>";
		$menustr .= 		"</li>";
		
		$menustr .= 		"<li>";
		$menustr .= 			"<a href='javascript:;' class='copy'> <i class='fa fa-files-o'></i> Copy Form</a>";
		$menustr .= 		"</li>";
		if ($statusbooking == 0) {
			$menustr .= 		"<li class=''>";
			$menustr .= 			"<a href='javascript:;' class='delete'> <i class='fa fa-trash-o'></i> Delete</a>";	
			$menustr .= 		"</li>";
		}
		if ($enddiv) {
			$menustr .=	"</ul>"; 
			$menustr .= "</div>";
		}
		return $menustr;
	}

	public function array_change_key_ucword($array) {
		$key=array_keys($array);
		foreach($key as $ki)
		{
		    $klower=ucwords($ki);
		    $val=$array[$ki];
		    if(is_array($val))
		    {
		        foreach($val as $kinner=>$vinner)
		        {
		            
		            $tl=ucwords($kinner);
		            unset($val[$kinner]);
		            $val[$tl]=$vinner; 
		        }
		    }
		    unset($array[$ki]);
		    $array[$klower]=$val; 
		}
		return $array;
	}
}

?>