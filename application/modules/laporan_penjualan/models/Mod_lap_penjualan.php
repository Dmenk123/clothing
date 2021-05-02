<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class mod_lap_penjualan extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		//alternative load library from config
		$this->load->database();
	}

	public function get_detail_lap_jual($tanggal_awal, $tanggal_akhir)
	{
		$query =  $this->db->query(
		"SELECT tbl_pembelian.id_pembelian,
				tbl_pembelian.tgl_pembelian,
				tbl_checkout.fname_kirim,
				tbl_checkout.lname_kirim,
				tbl_checkout.method_checkout,
				tbl_checkout.ongkos_kirim,
				tbl_checkout_detail.id_checkout,
				tbl_checkout_detail.id_produk,
				tbl_checkout_detail.id_stok,
				tbl_checkout_detail.qty,
				tbl_produk.nama_produk,
				tbl_produk.harga,
				tbl_satuan.nama_satuan,
				tbl_stok.ukuran_produk,
				tbl_stok.harga_satuan
		 FROM tbl_checkout_detail
		 LEFT JOIN tbl_pembelian ON tbl_checkout_detail.id_checkout = tbl_pembelian.id_checkout 
		 LEFT JOIN tbl_checkout ON tbl_checkout_detail.id_checkout = tbl_checkout.id_checkout
		 LEFT JOIN tbl_produk ON tbl_checkout_detail.id_produk = tbl_produk.id_produk
		 LEFT JOIN tbl_satuan ON tbl_checkout_detail.id_satuan = tbl_satuan.id_satuan
		 LEFT JOIN tbl_stok ON tbl_checkout_detail.id_stok = tbl_stok.id_stok
		 WHERE tbl_pembelian.status_confirm_adm = '1' 
		 AND tbl_pembelian.tgl_pembelian 
		 BETWEEN '".$tanggal_awal."' AND '".$tanggal_akhir."' ORDER BY tbl_pembelian.tgl_pembelian ASC");

         return $query->result();
	}
}