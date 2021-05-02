<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class mod_lap_stok extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		//alternative load library from config
		$this->load->database();
	}

	public function get_detail($tanggal_awal, $tanggal_akhir)
	{
		$query =  $this->db->query(
		"SELECT tbl_trans_order_detail.tgl_trans_order_detail, tbl_barang.nama_barang, tbl_satuan.nama_satuan, tbl_trans_order_detail.qty_order, tbl_trans_order_detail.keterangan_order
		 FROM tbl_trans_order_detail
		 LEFT JOIN tbl_barang ON tbl_trans_order_detail.id_barang = tbl_barang.id_barang 
		 LEFT JOIN tbl_satuan ON tbl_trans_order_detail.id_satuan = tbl_satuan.id_satuan 
		 WHERE tbl_trans_order_detail.tgl_trans_order_detail 
		 BETWEEN '".$tanggal_awal."' AND '".$tanggal_akhir."' ORDER BY tbl_trans_order_detail.tgl_trans_order_detail ASC");

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

	public function get_detail_footer($id_user)
	{
		$this->db->select('fname_user, lname_user');
		$this->db->from('tbl_user');
        $this->db->where('id_user', $id_user);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
	}

}