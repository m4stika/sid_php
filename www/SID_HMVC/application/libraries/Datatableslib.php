<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Datatableslib
{
	var $table;
	var $column_list;
	var $column_search;
	var $column_order;

	$table = 'vpemesanan'; 
	$column_list = '"Noid", "NoPesanan", "PolaPembayaran", "NamaPemesan", "Blok", "NoKavling", "TypeRumah", "ketstatusbooking", "HargaJual", "Diskon", "HargaKLT", "HargaSudut", "HargaHadapJalan", "HargaFasum", "HargaRedesign", "HargaTambahKwalitas", "HargaPekerjaanTambah", "TotalHarga", "BookingFee", "TotalUangMuka", "BookingFeeByr", "LunasUangMuka", "HargaSudutByr", "HargaHadapJalanByr", "HargaKLTbyr", "HargaFasumByr", "HargaRedesignByr", "HargaTambahKwByr", "HargaKerjaTambahByr", "TotalHargaByr", "TotalBayar", "totalbayartitipan", "totalhutang"';
	$column_order = array('','noid', 'nopesanan', 'PolaPembayaran', 'NamaPemesan', 'blok', 'nokavling','typerumah','ketstatusbooking');
	$column_search = array('','noid', 'nopesanan', 'PolaPembayaran', 'NamaPemesan', 'blok', 'nokavling','typerumah','ketstatusbooking');
	$order = array('t.typerumah' => 'asc');

	//private $CI;

	public function __construct($dataarr)
	{
		// $table = $dataarr['table'];
		// $column_list = $dataarr['column_list'];
		// $column_search = $dataarr['column_search'];
		// $column_order = $dataarr['column_order'];

		// $CI =& get_instance();
		// $CI->load->helper('myhelper');
		// $CI->load->library('email');
		// $CI->config->item('myitem');
		$CI =& get_instance();
        $CI->load->database();		
	}

	private function _get_datatables_query()
	{		
		$this->CI->db->select($column_list)->from($this->table);		
 
        $i = 0;
     
        foreach ($this->column_search as $item) // loop column 
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {
                 
                if($i===0) // first loop
                {
                    $this->CI->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->CI->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->CI->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search) - 1 == $i) //last loop
                    $this->CI->db->group_end(); //close bracket
            }
            $i++;
        }

      
        if(isset($_POST['order'])) // here order processing
        {
            $this->CI->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->CI->db->order_by(key($order), $order[key($order)]);
        }
	}

	function load_datatables()
	{
		$this->_get_datatables_query();		
        if($_POST['length'] != -1)
        	$this->CI->db->limit($_POST['length'], $_POST['start']);
        
        $query = $this->CI->db->get();
        //$query = $this->db->query('SELECT noid, typerumah, keterangan, luasbangunan, luastanah FROM typerumah');
        return $query->result();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();		
		$query = $this->CI->db->get();
		return $query->num_rows();
	}

	function count_all()
	{
		$this->CI->db->from($this->table);
		return $this->CI->db->count_all_results();
	}
}

?>