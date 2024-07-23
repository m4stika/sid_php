<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Report_model extends Base_model {
	function __construct()
    {
        parent::__construct();
    }

    function get_reportlist($parentkey) {
		//$parentkey = ($this->input->post('parent') == '#') ? -1 : $this->input->post('parent');
		//$parent = ($_REQUEST['parent'] == '#') ? -1 : $_REQUEST['parent'];
		
		$this->db->select('reportid, parentkey, keyvalue, reportname, reportfilename, reportmodul, showfilter, filterblth, filtertanggal, filterentry, groupentry, filtergroupby')
				 ->where('parentkey', $parentkey);
				 //->order_by('keyvalue','asc');
		$query = $this->db->get('reportlist');
		return $query->result();
	}
}
