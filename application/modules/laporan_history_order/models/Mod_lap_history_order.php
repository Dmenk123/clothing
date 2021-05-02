<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class mod_lap_history_order extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		//alternative load library from config
		$this->load->database();
	}

	public function get_detail_supplier($data_list, $tanggal_awal, $tanggal_akhir)
	{
		$query =  $this->db->query(
		"SELECT tbl_trans_order_detail.id_trans_order,tbl_trans_order.tgl_trans_order, tbl_produk.id_produk, tbl_produk.nama_produk, tbl_satuan.nama_satuan,tbl_supplier.id_supplier, tbl_supplier.nama_supplier, tbl_trans_order_detail.qty, tbl_trans_order_detail.harga_total_beli, tbl_trans_order_detail.ukuran
		FROM tbl_trans_order
		LEFT JOIN tbl_trans_order_detail ON tbl_trans_order_detail.id_trans_order = tbl_trans_order.id_trans_order
		LEFT JOIN tbl_produk ON tbl_trans_order_detail.id_produk = tbl_produk.id_produk 
		LEFT JOIN tbl_satuan ON tbl_trans_order_detail.id_satuan = tbl_satuan.id_satuan 
		LEFT JOIN tbl_supplier ON tbl_trans_order.id_supplier = tbl_supplier.id_supplier
		WHERE tbl_supplier.id_supplier = '".$data_list."' AND tbl_trans_order.tgl_trans_order BETWEEN '".$tanggal_awal."' AND '".$tanggal_akhir."' ORDER BY tbl_trans_order.tgl_trans_order ASC"
		);

        if ($query->num_rows() > 0) {
            return $query->result();
        }
	}

	public function get_detail_barang($data_list, $tanggal_awal, $tanggal_akhir)
	{
		$query =  $this->db->query(
		"SELECT tbl_trans_order_detail.id_trans_order,tbl_trans_order.tgl_trans_order, tbl_produk.id_produk, tbl_produk.nama_produk, tbl_satuan.nama_satuan,tbl_supplier.id_supplier, tbl_supplier.nama_supplier, tbl_trans_order_detail.qty, tbl_trans_order_detail.harga_total_beli, tbl_trans_order_detail.ukuran
		FROM tbl_trans_order
		LEFT JOIN tbl_trans_order_detail ON tbl_trans_order_detail.id_trans_order = tbl_trans_order.id_trans_order
		LEFT JOIN tbl_produk ON tbl_trans_order_detail.id_produk = tbl_produk.id_produk 
		LEFT JOIN tbl_satuan ON tbl_trans_order_detail.id_satuan = tbl_satuan.id_satuan 
		LEFT JOIN tbl_supplier ON tbl_trans_order.id_supplier = tbl_supplier.id_supplier
		WHERE tbl_produk.id_produk = '".$data_list."' AND tbl_trans_order.tgl_trans_order BETWEEN '".$tanggal_awal."' AND '".$tanggal_akhir."' ORDER BY tbl_trans_order.tgl_trans_order ASC"
		);

        if ($query->num_rows() > 0) {
            return $query->result();
        }
	}

	public function lookup_data_supplier($keyword = "")
	{
		$this->db->select('id_supplier, nama_supplier');
		$this->db->from('tbl_supplier');
		$this->db->like('nama_supplier',$keyword);
		//$this->db->limit(25);
		$this->db->order_by('nama_supplier', 'ASC');
	
		$query = $this->db->get();
		return $query->result();
	}

	public function lookup_data_produk($keyword = "")
	{
		$this->db->select('id_produk, nama_produk');
		$this->db->from('tbl_produk');
		$this->db->where('status', '1');
		$this->db->like('nama_produk',$keyword);
		//$this->db->limit(25);
		$this->db->order_by('nama_produk', 'ASC');
	
		$query = $this->db->get();
		return $query->result();
	}
}