<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mod_pesan_adm extends CI_Model
{
	var $column_search = array(
			'tbl_pesan_reply.id_reply',
			'tbl_pesan_reply.id_user',
			'tbl_pesan_reply.id_pesan',
			'tbl_pesan_reply.email_reply',
			'tbl_pesan_reply.subject_reply',
			'tbl_pesan_reply.isi_reply',
			'tbl_pesan_reply.dt_reply'
		);

	var $column_order = array(
			null,
			'tbl_pesan_reply.id_user',
			'tbl_pesan_reply.email_reply',
			'tbl_pesan_reply.subject_reply',
			'tbl_pesan_reply.isi_reply',
			'tbl_pesan_reply.dt_reply'
		);

	var $order = array('tbl_pesan_reply.id_reply' => 'asc'); // default order 
	
	public function __construct()
	{
		parent::__construct();
		//alternative load library from config
		$this->load->database();
	}

	private function _get_datatables_pesan_query($term="") //term is value of $_REQUEST['search']
	{
		$column = array(
			'tbl_pesan_reply.id_reply',
			'tbl_pesan_reply.id_user',
			'tbl_pesan.fname_pesan',
			'tbl_pesan.lname_pesan',
			'tbl_pesan_reply.email_reply',
			'tbl_pesan_reply.subject_reply',
			'tbl_pesan_reply.isi_reply',
			'tbl_pesan_reply.dt_reply'
			);

		$this->db->select('
			tbl_pesan_reply.id_reply,
			tbl_pesan_reply.id_user,
			tbl_pesan.fname_pesan,
			tbl_pesan.lname_pesan,
			tbl_pesan_reply.email_reply,
			tbl_pesan_reply.subject_reply,
			tbl_pesan_reply.isi_reply,
			tbl_pesan_reply.dt_reply
			');

		$this->db->from('tbl_pesan_reply');
		//join 'tbl', on 'tbl = tbl' , type join
		$this->db->join('tbl_pesan', 'tbl_pesan_reply.id_pesan = tbl_pesan.id_pesan','left');
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

	function get_datatable_pesan()
	{
		$term = $_REQUEST['search']['value'];
		$this->_get_datatables_pesan_query($term);

		if($_REQUEST['length'] != -1)
		$this->db->limit($_REQUEST['length'], $_REQUEST['start']);

		$query = $this->db->get();
		return $query->result();
	}

	function count_pesan_filtered()
	{
		$term = $_REQUEST['search']['value'];
		$this->_get_datatables_pesan_query($term);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_pesan_all()
	{
		$this->db->from('tbl_pesan_reply');
		return $this->db->count_all_results();
	}

	// end setting datatable

	public function get_detail_pesan_keluar($id)
	{
		$this->db->select('
			tbl_pesan_reply.id_reply,
			tbl_pesan_reply.id_user,
			tbl_pesan.fname_pesan,
			tbl_pesan.lname_pesan,
			tbl_pesan_reply.email_reply,
			tbl_pesan_reply.subject_reply,
			tbl_pesan_reply.isi_reply,
			tbl_pesan_reply.dt_reply
			');
		$this->db->from('tbl_pesan_reply');
		$this->db->join('tbl_pesan', 'tbl_pesan_reply.id_pesan = tbl_pesan.id_pesan', 'left');
		$this->db->where('tbl_pesan_reply.id_reply',$id);
		$query = $this->db->get();

		return $query->row();
	}

	public function save_data_pesan_keluar($data)
	{
		$this->db->insert('tbl_pesan_reply',$data);
		return $this->db->insert_id();
	}

	public function delete_data_pesan_keluar($id)
	{
		$this->db->where('id_reply', $id);
		$this->db->delete('tbl_pesan_reply');
	}
}