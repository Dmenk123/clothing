<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mod_master_tag_adm extends CI_Model
{
	// declare array variable to search datatable
	var $column_search = array('nama_tag','warna_tag');
	var $column_order = array(null,'nama_tag','warna_tag');
	var $order = array('nama_tag' => 'asc'); // default order
	var $table = 'tbl_tag_produk';

	public function __construct()
	{
		parent::__construct();
		//alternative load library from config
		$this->load->database();
	}

	//for kategori
	private function _get_datatable_query($term='') //term is value of $_REQUEST['search']
	{
		$column = array(null,'nama_tag','warna_tag',null);

		$this->db->select('*');

		$this->db->from($this->table);
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

	function get_datatable()
	{
		$term = $_REQUEST['search']['value'];
		$this->_get_datatable_query($term);
		if($_REQUEST['length'] != -1)
		$this->db->limit($_REQUEST['length'], $_REQUEST['start']);

		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered()
	{
		$term = $_REQUEST['search']['value'];
		$this->_get_datatable_query($term);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}
	
	public function insert_data_tag($input)
	{
		$this->db->insert($this->table,$input);
	}

	public function update_data_tag($where, $data)
	{
		$this->db->update($this->table, $data, $where);
	}

	public function get_by_id($id)
	{
		$this->db->from('tbl_user');
		$this->db->where('id_user',$id);
		$query = $this->db->get();

		return $query->row();
	}

	public function delete_data_tag($id)
	{
		$this->db->where('id', $id);
		$this->db->delete($this->table);
	}
	
}
