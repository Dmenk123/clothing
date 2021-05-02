<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class mod_lap_ret_keluar extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		//alternative load library from config
		$this->load->database();
	}

	public function get_detail_lap_retur_keluar($tanggal_awal, $tanggal_akhir)
	{
		$query =  $this->db->query(
		"SELECT tbl_retur_keluar.id_retur_keluar,
				tbl_retur_keluar.tgl_retur_keluar,
				tbl_produk.nama_produk,
				tbl_satuan.nama_satuan,
				tbl_supplier.nama_supplier,
				tbl_retur_keluar_detail.qty,
				tbl_retur_keluar_detail.ukuran,
				tbl_trans_masuk.tgl_trans_masuk
		 FROM tbl_retur_keluar_detail
		 LEFT JOIN tbl_produk ON tbl_retur_keluar_detail.id_produk = tbl_produk.id_produk 
		 LEFT JOIN tbl_satuan ON tbl_retur_keluar_detail.id_satuan = tbl_satuan.id_satuan
		 LEFT JOIN tbl_retur_keluar ON tbl_retur_keluar_detail.id_retur_keluar = tbl_retur_keluar.id_retur_keluar
		 LEFT JOIN tbl_supplier ON tbl_retur_keluar.id_supplier = tbl_supplier.id_supplier
		 LEFT JOIN tbl_trans_masuk ON tbl_retur_keluar_detail.id_trans_masuk = tbl_trans_masuk.id_trans_masuk
		 WHERE tbl_trans_masuk.tgl_trans_masuk 
		 BETWEEN '".$tanggal_awal."' AND '".$tanggal_akhir."' ORDER BY tbl_trans_masuk.tgl_trans_masuk ASC");

         return $query->result();
	}
}