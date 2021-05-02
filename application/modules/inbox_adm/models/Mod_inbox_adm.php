<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mod_inbox_adm extends CI_Model
{
	var $column_search = array(
			'id_pesan',
			'fname_pesan',
			'lname_pesan',
			'email_pesan',
			'subject_pesan',
			'isi_pesan',
			'dt_kirim'
		);

	var $column_order = array(
			null,
			'fname_pesan',
			'email_pesan',
			'subject_pesan',
			'isi_pesan',
			'dt_kirim'
		);

	var $order = array('dt_kirim' => 'desc'); // default order 

	public function __construct()
	{
		parent::__construct();
		//alternative load library from config
		$this->load->database();
	}

	private function _get_datatables_inbox_query($term="") //term is value of $_REQUEST['search']
	{
		$column = array(
			'id_pesan',
			'fname_pesan',
			'lname_pesan',
			'email_pesan',
			'subject_pesan',
			'isi_pesan',
			'dt_kirim'
		);

		$this->db->select('
			id_pesan,
			fname_pesan,
			lname_pesan,
			email_pesan,
			subject_pesan,
			isi_pesan,
			dt_kirim
		');

		$this->db->from('tbl_pesan');
		$this->db->where('status', '1');
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

	function get_datatable_inbox()
	{
		$term = $_REQUEST['search']['value'];
		$this->_get_datatables_inbox_query($term);

		if($_REQUEST['length'] != -1)
		$this->db->limit($_REQUEST['length'], $_REQUEST['start']);

		$query = $this->db->get();
		return $query->result();
	}

	function count_inbox_filtered()
	{
		$term = $_REQUEST['search']['value'];
		$this->_get_datatables_inbox_query($term);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_inbox_all()
	{
		$this->db->from('tbl_pesan');
		return $this->db->count_all_results();
	}

	// end setting datatable

	public function get_detail_pesan_masuk($id)
	{
		$this->db->select('
			id_pesan,
			fname_pesan,
			lname_pesan,
			email_pesan,
			subject_pesan,
			isi_pesan,
			dt_kirim
		');
		$this->db->from('tbl_pesan');
		$this->db->where('id_pesan',$id);
		$query = $this->db->get();

		return $query->row();
	}

	public function save_data_pesan($data)
	{
		$this->db->insert('tbl_pesan',$data);
		return $this->db->insert_id();
	}

	public function delete_data_inbox($id)
	{
		$this->db->where('id_pesan', $id);
		$this->db->delete('tbl_pesan');
	}

	function notif_email_count() 
	{
        $this->db->from('tbl_pesan');
        $this->db->where('dt_read', null);
        $query = $this->db->get();
        return $query->num_rows();
    }
	
	function get_notifikasi_email() 
    {
    	$this->db->select('id_pesan, subject_pesan, email_pesan, time_post');
        $this->db->from('tbl_pesan');
        $this->db->where('dt_read', null);
        $this->db->order_by('id_pesan', 'DESC');
 
        $query = $this->db->get();
 
        if ($query->num_rows() >0) {
            return $query->result();
        }
    }

    public function update_dtread_pesan($where, $data)
	{
		$this->db->update('tbl_pesan', $data, $where);
		return $this->db->affected_rows();
	}

	public function update_data_pesan($where, $data)
	{
		$this->db->update('tbl_pesan', $data, $where);
		return $this->db->affected_rows();
	}

}