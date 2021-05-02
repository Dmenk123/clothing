<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mod_homepage extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		//alternative load library from config
		$this->load->database();
	}


	public function get_menu_navbar()
	{
		$this->db->select('tbl_sub_kategori_produk.id_sub_kategori,
						   tbl_kategori_produk.id_kategori,
						   tbl_kategori_produk.nama_kategori');	
		$this->db->from('tbl_sub_kategori_produk');
		$this->db->join('tbl_kategori_produk', 'tbl_sub_kategori_produk.id_kategori = tbl_kategori_produk.id_kategori', 'left');
		$this->db->group_by('tbl_kategori_produk.nama_kategori');
		$this->db->order_by('tbl_sub_kategori_produk.id_sub_kategori', 'asc');

		$query = $this->db->get();
		return $query->result();
	}

	public function count_kategori()
	{
		$this->db->select('id_kategori');
		$this->db->from('tbl_sub_kategori_produk');
		$this->db->group_by('id_kategori');
		
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function get_submenu_navbar($id)
	{
		$this->db->select('*');	
		$this->db->from('tbl_sub_kategori_produk');
		$this->db->where('id_kategori', $id);

		$query = $this->db->get();
		return $query->result();
	}

	public function get_menu_search()
	{
		$query = $this->db->get('tbl_sub_kategori_produk');
		return $query->result();
	}

}