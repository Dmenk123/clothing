<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class mod_lap_permintaan extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		//alternative load library from config
		$this->load->database();
	}

	public function get_detail_lap_order($tanggal_awal, $tanggal_akhir)
	{
		$query =  $this->db->query(
		"SELECT tbl_trans_order.id_trans_order, tbl_trans_order.tgl_trans_order, tbl_produk.nama_produk, tbl_satuan.nama_satuan, tbl_supplier.nama_supplier, tbl_trans_order_detail.qty, tbl_trans_order_detail.ukuran, tbl_trans_order_detail.qty, tbl_trans_order_detail.harga_satuan_beli, tbl_trans_order_detail.harga_total_beli
		 FROM tbl_trans_order_detail
		 LEFT JOIN tbl_produk ON tbl_trans_order_detail.id_produk = tbl_produk.id_produk 
		 LEFT JOIN tbl_satuan ON tbl_trans_order_detail.id_satuan = tbl_satuan.id_satuan
		 LEFT JOIN tbl_trans_order ON tbl_trans_order_detail.id_trans_order = tbl_trans_order.id_trans_order
		 LEFT JOIN tbl_supplier ON tbl_trans_order.id_supplier = tbl_supplier.id_supplier
		 WHERE tbl_trans_order.tgl_trans_order 
		 BETWEEN '".$tanggal_awal."' AND '".$tanggal_akhir."' ORDER BY tbl_trans_order.tgl_trans_order ASC");

         return $query->result();
	}

	public function get_report_stok()
	{
		$this->db->select('tbl_stok.id_produk,
						   tbl_stok.ukuran_produk,
						   tbl_satuan.nama_satuan,
						   tbl_stok.berat_satuan,
						   tbl_stok.stok_sisa,
						   tbl_stok.stok_minimum,
						   tbl_stok.status,
						   tbl_produk.nama_produk');
		$this->db->from('tbl_produk');
		$this->db->join('tbl_stok', 'tbl_stok.id_produk = tbl_produk.id_produk', 'left');
		$this->db->join('tbl_satuan', 'tbl_satuan.id_satuan = tbl_produk.id_satuan', 'left');
		$this->db->where('tbl_stok.status', '1');
		$query = $this->db->get();
		return $query->result();
	}
}