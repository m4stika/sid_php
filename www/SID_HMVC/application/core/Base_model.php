<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Base_model extends CI_Model {
	public $table = "";
    public $column_index = "";
    public $column_select = "";
    public $excel_output = 0;


	function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function get_totalrecord($table)
    {
        return $this->db->count_all($table);
    }

    function find_result($id)
        {
                $this->db->select($this->column_select)->where($this->column_index, $id);
                $query = $this->db->get($this->table);
                return $query->result();
        }

    function find_all($sort = 'noid', $order = 'asc')
    {
        $this->db->select($this->column_select)->order_by($sort, $order);
        $query = $this->db->get($this->table);
        return $query->result();
    }

    function get_parameter()
	{
		$query = $this->db->select('bulanbuku, tahunbuku, tahunbuku*100+bulanbuku as blthbuku, company, address,
				city, kasir, kasirtitle, accounting, accountingtitle, pimpinan, pimpinantitle', FALSE)->limit(1)->get('parameter');
		return $query->row();
	}

    function get_Accountby_id($rekid)
    {
			$this->db->select('rekid, classacc, parentkey, keyvalue, accountno, description');
        $this->db->where('rekid', $rekid);
        $query = $this->db->get('perkiraan');
        return $query->row();
    }

    function get_Accountby_keyvalue($keyvalue)
    {
        $this->db->select('rekid, classacc, parentkey, keyvalue, accountno, description');
        $this->db->where('keyvalue', $keyvalue);
        $query = $this->db->get('perkiraan');
        return $query->result();
    }
}
