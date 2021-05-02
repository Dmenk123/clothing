<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mod_master_supplier_adm extends CI_Model
{
	// declare array variable to search datatable
	var $column_search = array(
			'id_supplier',
			'nama_supplier',
			'alamat_supplier',
			'keterangan',
			'telp_supplier',
			null,
		);

	var $column_order = array(
			'id_supplier',
			'nama_supplier',
			'alamat_supplier',
			'keterangan',
			'telp_supplier',
			null,
		);

	var $order = array('id_supplier' => 'desc'); // default order

	public function __construct()
	{
		parent::__construct();
		//alternative load library from config
		$this->load->database();
	}

	//for kategori
	private function _get_data_supplier_query($term='') //term is value of $_REQUEST['search']
	{
		$column = array(
				'id_supplier',
				'nama_supplier',
				'alamat_supplier',
				'keterangan',
				'telp_supplier',
				null,
			);

		$this->db->select('
				id_supplier,
				nama_supplier,
				alamat_supplier,
				keterangan,
				telp_supplier,
				status
			');

		$this->db->from('tbl_supplier');
		$i = 0;
		// loop column 
		foreach ($this->column_search as $item) 
		{
			// if datatable send POST for search
			if($_POST['search']['value']) 
			{
				// first loop
				if($i===0) 
				{
					// open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->group_start();
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}
				//last loop
				if(count($this->column_search) - 1 == $i) 
					$this->db->group_end(); //close bracket
			}
			$i++;
		}

		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatable_supplier()
	{
		$term = $_REQUEST['search']['value'];
		$this->_get_data_supplier_query($term);
		if($_REQUEST['length'] != -1)
		$this->db->limit($_REQUEST['length'], $_REQUEST['start']);

		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered()
	{
		$term = $_REQUEST['search']['value'];
		$this->_get_data_supplier_query($term);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from('tbl_supplier');
		return $this->db->count_all_results();
	}
	
	public function insert_data_supplier($input)
	{
		$this->db->insert('tbl_supplier',$input);
	}

	public function update_data_supplier($where, $data)
	{
		$this->db->update('tbl_supplier', $data, $where);
	}

	public function get_data_supplier($id)
	{
		$this->db->from('tbl_supplier');
		$this->db->where('id_supplier',$id);
		$query = $this->db->get();

		return $query->row();
	}

	public function update_status_supplier($where, $data)
	{
		$this->db->update('tbl_supplier', $data, $where);
	}

	public function get_kode_supplier(){

	    $q = $this->db->query("select MAX(RIGHT(id_supplier,5)) as kode_max from tbl_supplier");
        $kd = "";
        if($q->num_rows()>0){
            foreach($q->result() as $hasil){
                $tmp = ((int)$hasil->kode_max)+1;
                $kd = sprintf("%05s", $tmp);
            }
        }else{
                $kd = "00001";
        }

        return "SUP".$kd;
    }


}