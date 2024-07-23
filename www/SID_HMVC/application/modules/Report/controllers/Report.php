<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
*
*/
class Report extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Report_model','report_model');
	}

	public function index() {
		//$listGroup = $this->get_accountLevel0();
		$data = array(
				'title'		=> 'SID | Reporting',
				'page' 		=> 'utility',
 				'content'	=> 'report',
 				'isi' 		=> 'Report/report_filter'
 				//'listGroup' => $listGroup
 			);
	 	$this->template->admin_template($data);
	}

	public function get_report() {
		$parent = ($this->input->post('parent') == '#') ? -1 : $this->input->post('parent');
		$list = $this->report_model->get_reportlist($parent);

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
				//"text" => ($parent == -1) ?  "[".$value->reportid."] - ". $value->reportname :
					//"<a href='javascript:;'> <span> [".$value->reportid."] - " . $value->reportname. "</span></a>",
				"text" => "[".$value->reportid."] - ". $value->reportname,
				"icon" => ($value->parentkey == -1) ? "fa fa-folder icon-lg icon-state-" . ($states[rand(0, 3)]) : "fa fa-file fa-large icon-state-default",
				"children" => (($value->parentkey == -1) ? true : false),
				"type" => (($parent == -1) ? "root" : "group"),
				"data" => array("noid" => $value->reportid,
								"keyvalue" => $value->keyvalue,
								"filename" => $value->reportfilename,
								"reportmodul" => $value->reportmodul,
								"showfilter" => $value->showfilter,
								"filterblth" => $value->filterblth,
								"filtertanggal" => $value->filtertanggal,
								"filterentry" => $value->filterentry,
								"filtergroupby" => $value->filtergroupby,
								"groupentry" => $value->groupentry

						),
			);
		}
		// header('Content-type: text/json');
		header('Content-type: application/json');
		echo json_encode($data);
	}
}
?>