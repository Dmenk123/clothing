<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class mod_lap_penerimaan extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		//alternative load library from config
		$this->load->database();
	}

	public function get_detail_lap_masuk($tanggal_awal, $tanggal_akhir)
	{
		$query =  $this->db->query(
		"SELECT tbl_trans_masuk.id_trans_masuk,
				tbl_trans_masuk.tgl_trans_masuk,
				tbl_produk.nama_produk,
				tbl_satuan.nama_satuan,
				tbl_supplier.nama_supplier,
				tbl_trans_masuk_detail.qty,
				tbl_trans_masuk_detail.ukuran,
				tbl_trans_order.tgl_trans_order
		 FROM tbl_trans_masuk_detail
		 LEFT JOIN tbl_produk ON tbl_trans_masuk_detail.id_produk = tbl_produk.id_produk 
		 LEFT JOIN tbl_satuan ON tbl_trans_masuk_detail.id_satuan = tbl_satuan.id_satuan
		 LEFT JOIN tbl_trans_masuk ON tbl_trans_masuk_detail.id_trans_masuk = tbl_trans_masuk.id_trans_masuk
		 LEFT JOIN tbl_supplier ON tbl_trans_masuk.id_supplier = tbl_supplier.id_supplier
		 LEFT JOIN tbl_trans_order ON tbl_trans_masuk_detail.id_trans_order = tbl_trans_order.id_trans_order
		 WHERE tbl_trans_masuk.tgl_trans_masuk 
		 BETWEEN '".$tanggal_awal."' AND '".$tanggal_akhir."' ORDER BY tbl_trans_masuk.tgl_trans_masuk ASC");

         return $query->result();
	}
}