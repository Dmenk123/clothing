<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mod_master_user_adm extends CI_Model
{
	// declare array variable to search datatable
	var $column_search = array(
			'tbl_user.id_user',
			'tbl_user.fname_user',
			'tbl_user.lname_user',
			'tbl_user.email',
			'tbl_user.password',
			'tbl_level_user.nama_level_user',
			'tbl_user.status',
		);

	var $column_order = array(
			'tbl_user.id_user',
			'tbl_user.fname_user',
			'tbl_user.lname_user',
			'tbl_user.email',
			'tbl_user.password',
			'tbl_level_user.nama_level_user',
			'tbl_user.last_login',
		);

	var $order = array('tbl_user.id_user' => 'asc'); // default order 

	public function __construct()
	{
		parent::__construct();
		//alternative load library from config
		$this->load->database();
	}

	//for all data
	private function _get_data_user_query($term='') //term is value of $_REQUEST['search']
	{
		$column = array(
				'tbl_user.id_user',
				'tbl_user.fname_user',
				'tbl_user.lname_user',
				'tbl_user.email',
				'tbl_user.password',
				'tbl_level_user.nama_level_user',
				'tbl_user.status',
				'tbl_user.last_login',
				null,
			);

		$this->db->select('
				tbl_user.id_user,
				tbl_user.fname_user,
				tbl_user.lname_user,
				tbl_user.email,
				tbl_user.password,
				tbl_level_user.nama_level_user,
				tbl_user.status,
				tbl_user.last_login
			');

		$this->db->from('tbl_user');
		//join 'tbl', on 'tbl = tbl' , type join
		$this->db->join('tbl_level_user', 'tbl_user.id_level_user = tbl_level_user.id_level_user','left');
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

	//customer data only
	private function _get_data_user_query_filter($term='') //term is value of $_REQUEST['search']
	{
		$column = array(
				'tbl_user.id_user',
				'tbl_user.fname_user',
				'tbl_user.lname_user',
				'tbl_user.email',
				'tbl_user.password',
				'tbl_level_user.nama_level_user',
				'tbl_user.status',
				'tbl_user.last_login',
				null,
			);

		$this->db->select('
				tbl_user.id_user,
				tbl_user.fname_user,
				tbl_user.lname_user,
				tbl_user.email,
				tbl_user.password,
				tbl_level_user.nama_level_user,
				tbl_user.status,
				tbl_user.last_login
			');

		$this->db->from('tbl_user');
		//join 'tbl', on 'tbl = tbl' , type join
		$this->db->join('tbl_level_user', 'tbl_user.id_level_user = tbl_level_user.id_level_user','left');
		$this->db->where('tbl_user.id_level_user', '2');
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

	function get_datatable_user($id_level_user)
	{
		$term = $_REQUEST['search']['value'];
		if ($id_level_user == '1') 
		{
			$this->_get_data_user_query($term);
		}
		else
		{
			$this->_get_data_user_query_filter($term);
		}
		

		if($_REQUEST['length'] != -1)
		$this->db->limit($_REQUEST['length'], $_REQUEST['start']);

		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered()
	{
		$term = $_REQUEST['search']['value'];
		$this->_get_data_user_query($term);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all($id_level_user)
	{
		if ($id_level_user == '1') 
		{
			$this->db->from('tbl_user');
			return $this->db->count_all_results();
		}
		else
		{
			$this->db->from('tbl_user');
			$this->db->where('id_level_user', '2');
			return $this->db->count_all_results();
		}
		
	}
	//end datatable query

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

	public function insert_data_user($input)
	{
		//insert into tbl_user 
		$this->db->insert('tbl_user',$input);
	}

	public function update_status_user($where, $data)
	{
		$this->db->update("tbl_user", $data, $where);
	}
	
}