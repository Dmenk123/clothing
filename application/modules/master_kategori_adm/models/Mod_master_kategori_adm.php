<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mod_master_kategori_adm extends CI_Model
{
	// declare array variable to search datatable
	var $column_search = array(
			'nama_kategori',
			'ket_kategori',
			'akronim',
		);

	var $column_search2 = array(
			'nama_sub_kategori',
			'ket_sub_kategori',
			'gender_sub_kategori',
		);

	var $column_order = array(
			null,
			'nama_kategori',
			'ket_kategori',
			'akronim',
		);

	var $column_order2 = array(
			null,
			'nama_sub_kategori',
			'ket_sub_kategori',
			'gender_sub_kategori',
		);

	var $order = array('nama_kategori' => 'asc'); // default order
	var $order2 = array('nama_sub_kategori' => 'asc');

	public function __construct()
	{
		parent::__construct();
		//alternative load library from config
		$this->load->database();
	}

	//for kategori
	private function _get_data_kategori_query($term='') //term is value of $_REQUEST['search']
	{
		$column = array(
				null,
				'nama_kategori',
				'ket_kategori',
				'akronim',
				null,
			);

		$this->db->select('
				id_kategori,
				nama_kategori,
				ket_kategori,
				akronim,
			');

		$this->db->from('tbl_kategori_produk');
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

	function get_datatable_kategori()
	{
		$term = $_REQUEST['search']['value'];
		$this->_get_data_kategori_query($term);
		if($_REQUEST['length'] != -1)
		$this->db->limit($_REQUEST['length'], $_REQUEST['start']);

		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered()
	{
		$term = $_REQUEST['search']['value'];
		$this->_get_data_kategori_query($term);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from('tbl_kategori_produk');
		return $this->db->count_all_results();
	}

	//********************************************************************************************
	//for subkategori
	private function _get_data_subkategori_query($term='', $id_kategori) //term is value of $_REQUEST['search']
	{
		$column = array(
				null,
				'nama_sub_kategori',
				'ket_sub_kategori',
				'gender_sub_kategori',
				null,
			);

		$this->db->select('
				id_sub_kategori,
				nama_sub_kategori,
				ket_sub_kategori,
				gender_sub_kategori,
			');

		$this->db->from('tbl_sub_kategori_produk');
		$this->db->where('id_kategori', $id_kategori);
		$i = 0;
		// loop column 
		foreach ($this->column_search2 as $item) 
		{
			if($_POST['search']['value']) 
			{
				if($i===0) 
				{
					$this->db->group_start();
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}
				//last loop
				if(count($this->column_search2) - 1 == $i) 
					$this->db->group_end(); //close bracket
			}
			$i++;
		}

		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order2[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order2))
		{
			$order = $this->order2;
            $this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatable_subkategori($id_kategori)
	{
		$term = $_REQUEST['search']['value'];
		$this->_get_data_subkategori_query($term, $id_kategori);
		if($_REQUEST['length'] != -1)
		$this->db->limit($_REQUEST['length'], $_REQUEST['start']);

		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered_subkategori($id_kategori)
	{
		$term = $_REQUEST['search']['value'];
		$this->_get_data_subkategori_query($term, $id_kategori);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_subkategori($id_kategori)
	{
		$this->db->from('tbl_sub_kategori_produk');
		$this->db->where('id_kategori', $id_kategori);
		return $this->db->count_all_results();
	}
	//end datatable query
	//********************************************************************************************
	
	public function insert_data_kategori($input)
	{
		$this->db->insert('tbl_kategori_produk',$input);
	}

	public function insert_data_subkategori($input)
	{
		$this->db->insert('tbl_sub_kategori_produk',$input);
	}

	public function update_data_kategori($where, $data)
	{
		$this->db->update('tbl_kategori_produk', $data, $where);
	}

	public function update_data_subkategori($where, $data)
	{
		$this->db->update('tbl_sub_kategori_produk', $data, $where);
	}

	public function get_data_kategori_byid($id)
	{
		$this->db->from('tbl_kategori_produk');
		$this->db->where('id_kategori',$id);
		$query = $this->db->get();

		return $query->row();
	}

	public function get_data_subkategori_byid($id)
	{
		$this->db->from('tbl_sub_kategori_produk');
		$this->db->where('id_sub_kategori',$id);
		$query = $this->db->get();

		return $query->row();
	}

	public function get_detail_user($id_user)
	{
		$this->db->select('*');
		$this->db->from('tbl_user_detail');
		$this->db->where('id_user', $id_user);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
	}
	
	public function get_data_foto($id)
	{
		$this->db->select('foto_user');
		$this->db->from('tbl_user');
		$this->db->where('id_user',$id);
		$query = $this->db->get();

		return $query->row();
	}

	public function get_by_id($id)
	{
		$this->db->from('tbl_user');
		$this->db->where('id_user',$id);
		$query = $this->db->get();

		return $query->row();
	}

	public function delete_data_kategori($id_kategori)
	{
		$this->db->where('id_kategori', $id_kategori);
		$this->db->delete('tbl_kategori_produk');
	}

	public function delete_data_subkategori($id_subkategori)
	{
		$this->db->where('id_sub_kategori', $id_subkategori);
		$this->db->delete('tbl_sub_kategori_produk');
	}
	
}