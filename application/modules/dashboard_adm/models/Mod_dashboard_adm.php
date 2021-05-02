<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mod_dashboard_adm extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		//alternative load library from config
		$this->load->database();
	}

	public function get_produk()
	{
		$this->db->select('
			tbl_produk.id_produk,
			tbl_produk.nama_produk,
			tbl_stok.ukuran_produk,
			tbl_stok.stok_sisa,
			tbl_stok.stok_minimum,
			tbl_stok.status
		');
		$this->db->from('tbl_produk');
		$this->db->join('tbl_stok', 'tbl_produk.id_produk = tbl_stok.id_produk', 'left');
		$this->db->where('tbl_stok.status', '1');

		$query = $this->db->get();
		return $query->result();
	}

	public function get_data_user($id)
	{
		$this->db->select('*');
		$this->db->from('tbl_user');
		$this->db->where('id_user', $id);
		
		$query = $this->db->get();
		return $query->result();
	}

	public function email_notif_count($id_user) 
	{
        $this->db->from('tbl_pesan');
        $this->db->where('dt_read', null);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function get_email_notif($id_user) 
    {
    	$this->db->select('*');
        $this->db->from('tbl_pesan');
        $this->db->where('dt_read', null);
        $this->db->order_by('id_pesan', 'DESC');
 
        $query = $this->db->get();
 
        if ($query->num_rows() >0) {
            return $query->result();
        }
    }

    public function get_count_produk()
	{
		$this->db->select('id_produk, COUNT(id_produk) AS jumlah_produk');
		$this->db->from('tbl_produk');
		$this->db->where('status', '1');

		$query = $this->db->get();
		return $query->result();
	}

	public function get_count_stok()
	{
		$this->db->select('tbl_stok.id_produk, tbl_produk.nama_produk, tbl_stok.ukuran_produk, tbl_stok.stok_sisa');
		$this->db->from('tbl_stok');
		$this->db->join('tbl_produk', 'tbl_stok.id_produk = tbl_produk.id_produk', 'left');
		$this->db->where('tbl_stok.status', '1');
		$this->db->order_by('tbl_stok.stok_sisa', 'desc');
		$this->db->limit(5);

		$query = $this->db->get();
		return $query->result();
	}

	public function get_count_user()
	{
		$this->db->select('id_user, COUNT(id_user) AS jumlah_user');
		$this->db->from('tbl_user');
		$this->db->where('status', '1');

		$query = $this->db->get();
		return $query->result();
	}

	public function get_count_user_level()
	{
		$this->db->select('tbl_user.id_user, tbl_level_user.nama_level_user , count(tbl_level_user.id_level_user) AS jumlah_level');
		$this->db->from('tbl_user');
		$this->db->join('tbl_level_user', 'tbl_user.id_level_user = tbl_level_user.id_level_user', 'left');
		$this->db->where('tbl_user.status', '1');
		$this->db->group_by('tbl_level_user.id_level_user');

		$query = $this->db->get();
		return $query->result();
	}
	
}