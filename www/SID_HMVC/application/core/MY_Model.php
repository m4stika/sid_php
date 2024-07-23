<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//http://jeromejaglale.com/doc/php/codeigniter_models
 
class MY_Model extends CI_Model {
 
        public $table = "";
        public $column_index = "";
        public $column_select = "";
        public $column_where = array();
        public $column_order = array(); //set column field database for datatable orderable
        public $column_search = array(); //set column field database for datatable searchable just firstname , lastname , address are searchable
        public $order = array(); // default order 
        public $hasSelect = false;
 
        function __construct()
        {
                parent::__construct();
                $this->load->database();
        }

        public function count_all($where = '')
        {
                if ($where == '') {
                        $this->db->from($this->table);
                }
                else {$this->db->from($this->table)->where($where);}

                return $this->db->count_all_results();
        }
 
        function insert($data)
        {
                $this->db->insert($this->table, $data);
                return $this->db->insert_id();
        }

        function insert_batch($data) {
                $this->db->insert_batch($this->table, $data);
                return $this->db->insert_id();
        }

        function update($id, $data)
        {
                $this->db->where($this->column_index, $id);
                $this->db->update($this->table, $data);
                if ($this->db->affected_rows() > 0) {
                        return true;
                        //return $this->db->last_query();
                } 
                return false;
                //return $this->db->last_query();
        }

        function update_col($id, $data)
        {
                $this->db->where($this->column_index, $id);
                //$this->db->_compile_select(); 

                foreach($data as $value)
                {
                        if (isset($value['inc'])) { //Penambahan
                                if ($value['inc']) {
                                        $this->db->set($value['field'], "${value['field']} + ${value['value']}", FALSE);
                                } else
                                  $this->db->set($value['field'], $value['value']);
                        }
                        if (isset($value['dec'])) { //Pengurangan
                                if ($value['dec']) {
                                        $this->db->set($value['field'], "${value['field']} - ${value['value']}", FALSE);
                                } else
                                  $this->db->set($value['field'], $value['value']);
                        }
                }
                
                $this->db->update($this->table);
                if ($this->db->affected_rows() > 0) {
                        return true;
                        //return $this->db->last_query();
                } 
                return false;
                //return $this->db->last_query();
        }

        function delete($id)
        {
                if ($id != NULL)
                {
                        $this->db->where($this->column_index, $id);                    
                      return $this->db->delete($this->table);                        
                } else {return false;}
        }   
 
        function find_id($id)
        {
                if ($id == NULL)
                {
                        return NULL;
                }
 
                $this->db->select($this->column_select)->where($this->column_index, $id);
                $query = $this->db->get($this->table);

                $result = $query->result_array();
                return (count($result) > 0 ? $result[0] : NULL);
        }
 
        function find_all($sort = 'noid', $order = 'asc')
        {
                $this->db->select($this->column_select)->order_by($sort, $order);
                $query = $this->db->get($this->table);
                return $query->result();
        }

        function find_result($id)
        {
                $this->db->select($this->column_select)->where($this->column_index, $id);
                $query = $this->db->get($this->table);
                return $query->result();
        }

        function find_all_array($sort = 'noid', $order = 'asc')
        {
                $this->db->select($this->column_select)->order_by($sort, $order);
                $query = $this->db->get($this->table);
                return $query->result_array();
        }

        function find_where($sort = 'noid', $order = 'asc')
        {
                //$array = array('name !=' => $name, 'id <' => $id, 'date >' => $date);
                //$where = "name='Joe' AND status='boss' OR status='active'";
                $this->db->select($this->column_select)->where($this->column_where)->order_by($sort, $order);
                $query = $this->db->get($this->table);
                return $query->result();
        }

        function find_row_id($id)
        {
                if ($id == NULL)
                {
                        return NULL;
                }
 
                $this->db->select($this->column_select)->where($this->column_index, $id);
                $query = $this->db->get($this->table);

                $result = $query->row();
                return $result;
        }            

        private function _get_datatables_query($idwhere='')
        {
                
                if (! $this->hasSelect) $this->db->select($this->column_select)->from($this->table);

                if($idwhere !== '') $this->db->where($idwhere);
 
                $i = 0; $j = 0;

               // $this->db->where('noid', $this->input->post('noid'));

                //add custom filter here
                if(isset($_POST['customFilter'])) {
                        /*---------- TYPE RUMAH ---------- */
                        if($this->input->post('typerumah'))
                        {
                            $this->db->like('typerumah', $this->input->post('typerumah'));
                        }

                        if($this->input->post('keterangan'))
                        {
                            $this->db->like('keterangan', $this->input->post('keterangan'));
                        }

                        if($this->input->post('noid'))
                        {
                            $this->db->where('noid', $this->input->post('noid'));
                        }
                        if($this->input->post('statusverifikasi1'))
                        {
                            $this->db->where('statusverifikasi1', $this->input->post('statusverifikasi1'));
                        }
                        if($this->input->post('tgltransaksi'))
                        {
                            $this->db->where('tgltransaksi >=', $this->input->post('tgltransaksi'));
                        }
                        if($this->input->post('tgltransaksito'))
                        {
                            $this->db->where('tgltransaksi <=', $this->input->post('tgltransaksito'));
                        }
                        if($this->input->post('kasbanktype1'))
                        {
                            $this->db->where('kasbanktype1', $this->input->post('kasbanktype1'));
                        }
                        if($this->input->post('accountno'))
                        {
                            $this->db->where('rekid', $this->input->post('accountno'));
                        }

                        //extract
                        if($this->input->post('tglextract') && $_POST['flag'])
                        {
                            if ($_POST['flag'] == 1) {
                                $this->db->where('tglbayar >=', $this->input->post('tglextract'));
                            } elseif ($_POST['flag'] == 2) {
                                $this->db->where('tglbatal >=', $this->input->post('tglextract'));
                            } elseif ($_POST['flag'] == 3) {
                                $this->db->where('tglakadkredit >=', $this->input->post('tglextract'));
                            }
                        }
                        if($this->input->post('tglextractto'))
                        {
                            if ($_POST['flag'] == 1) {
                                $this->db->where('tglbayar <=', $this->input->post('tglextractto'));
                            } elseif ($_POST['flag'] == 2) {
                                $this->db->where('tglbatal <=', $this->input->post('tglextractto'));
                            } elseif ($_POST['flag'] == 3) {
                                $this->db->where('tglakadkredit <=', $this->input->post('tglextractto'));
                            }
                        }

                        /********************* GL ***************/
                        if($this->input->post('journalid'))
                        {
                            $this->db->where('journalid', $this->input->post('journalid'));
                        }
                        if($this->input->post('GL_tgljournal'))
                        {
                            $this->db->where('journaldate >=', $this->input->post('GL_tgljournal'));
                        }
                        if($this->input->post('GL_tgljournalto'))
                        {
                            $this->db->where('journaldate <=', $this->input->post('GL_tgljournalto'));
                        }
                        if($this->input->post('status'))
                        {
                            //$status = intVal($this->input->post('status')-1);
                            $this->db->where('status', intVal($this->input->post('status')-1));
                        }
                        if($this->input->post('GL_journalGroup'))
                        {
                            $this->db->where('journalgroup', intVal($this->input->post('GL_journalGroup')-1));
                        }
                }
                
             
                foreach ($this->column_search as $item) // loop column 
                {
                    if($_POST['search']['value']) // if datatable send POST for search
                    {
                         
                        if($i===0) // first loop
                        {
                                    
                            $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                            $this->db->like($item, $_POST['search']['value']);
                        }
                        else
                        {
                            $this->db->or_like($item, $_POST['search']['value']);
                        }
         
                        if(count($this->column_search) - 1 == $i) //last loop
                            $this->db->group_end(); //close bracket
                        $i++;
                    }
                };

                // foreach ($this->column_search as $item) // loop column 
                // {
                //     if (isset($_POST[$item]) && ($_POST[$item])) // if datatable send POST for search
                //     {
                //         if($j===0) // first loop
                //         {
                //              // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                //             if (($item !== 'tgltransaksi') && ($item !== 'tgltransaksito')) {
                //                     $this->db->group_start();
                //                     $this->db->like($item, $_POST[$item]);
                //                     $j++;
                //             }

                //         }
                //         else
                //         {
                //             if (($item !== 'tgltransaksi') && ($item !== 'tgltransaksito')) {
                //                 $this->db->or_like($item, $_POST[$item]);
                //                 $j++; }
                //         }
                //     }
                // };
                if ($j > 0) $this->db->group_end(); //close bracket

                if(isset($_POST['order'])) // here order processing
                {
                    $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
                } 
                else if(isset($this->order))
                {
                    $order = $this->order;
                    $this->db->order_by(key($order), $order[key($order)]);
                }

                
                // if(isset($_POST['order'])) // here order processing
                // {
                //    $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
                // } 
                // else if(isset($this->order))
                // {
                //     $order = $this->order;
                //     $this->db->order_by(key($order), $order[key($order)]);
                // }
        }

        function get_datatables($idwhere='')
        {
                $this->_get_datatables_query($idwhere);         
                if($_POST['length'] != -1)
                $this->db->limit($_POST['length'], $_POST['start']);
                $query = $this->db->get();
                return $query->result();
                //return $this->db->last_query();
        }

        function count_filtered($idwhere='')
        {
                $this->_get_datatables_query($idwhere);
                //$query = $this->db->get();
                //return $query->num_rows();
                return $this->db->count_all_results();
        }
         
         
        function terbilang($x, $style=3) {
                function kekata($x) {
                    $x = abs($x);
                    $angka = array("", "satu", "dua", "tiga", "empat", "lima",
                    "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
                    $temp = "";
                    if ($x <12) {
                        $temp = " ". $angka[$x];
                    } else if ($x <20) {
                        $temp = kekata($x - 10). " belas";
                    } else if ($x <100) {
                        $temp = kekata($x/10)." puluh". kekata($x % 10);
                    } else if ($x <200) {
                        $temp = " seratus" . kekata($x - 100);
                    } else if ($x <1000) {
                        $temp = kekata($x/100) . " ratus" . kekata($x % 100);
                    } else if ($x <2000) {
                        $temp = " seribu" . kekata($x - 1000);
                    } else if ($x <1000000) {
                        $temp = kekata($x/1000) . " ribu" . kekata($x % 1000);
                    } else if ($x <1000000000) {
                        $temp = kekata($x/1000000) . " juta" . kekata($x % 1000000);
                    } else if ($x <1000000000000) {
                        $temp = kekata($x/1000000000) . " milyar" . kekata(fmod($x,1000000000));
                    } else if ($x <1000000000000000) {
                        $temp = kekata($x/1000000000000) . " trilyun" . kekata(fmod($x,1000000000000));
                    }     
                        return $temp;
                }

            if($x<0) {
                $hasil = "minus ". trim(kekata($x));
            } else {
                $hasil = trim(kekata($x));
            }     
            switch ($style) {
                case 1:
                    $hasil = strtoupper($hasil);
                    break;
                case 2:
                    $hasil = strtolower($hasil);
                    break;
                case 3:
                    $hasil = ucwords($hasil);
                    break;
                default:
                    $hasil = ucfirst($hasil);
                    break;
            }     
            return $hasil;
        }
}
 
/* End of file */