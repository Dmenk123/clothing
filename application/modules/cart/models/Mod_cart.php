<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mod_cart extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		//alternative load library from config
		$this->load->database();
	}

	public function get_all_data()
	{
		$this->db->select('tbl_produk.id_produk,
						   tbl_produk.nama_produk,
						   tbl_produk.harga,
						   tbl_satuan.nama_satuan,
						   tbl_gambar_produk.nama_gambar
						   ');

		$this->db->from('tbl_produk');
		$this->db->join('tbl_satuan', 'tbl_produk.id_satuan = tbl_satuan.id_satuan', 'left');
		$this->db->join('tbl_gambar_produk', 'tbl_produk.id_produk = tbl_gambar_produk.id_produk', 'left');
		$this->db->group_by('tbl_gambar_produk.id_produk');

		$query = $this->db->get();
        return $query->result();
	}
	
	public function get_satuan_produk($id)
	{
		$this->db->select('id_satuan');
		$this->db->from('tbl_produk');
		$this->db->where('id_produk', $id);

		$query = $this->db->get();
		return $query->result();
	}
}