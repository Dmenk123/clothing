<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mod_lap_mutasi extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		//alternative load library from config
		$this->load->database();
	}

	public function get_detail_mutasi($tanggal_awal, $tanggal_akhir)
	{
		$tanggal_awal2 = date('Y-m-d', strtotime('-1 days', strtotime($tanggal_awal)));
		$query =  $this->db->query("
			SELECT 	tbl_produk.id_produk, 
	   			   	tbl_produk.nama_produk,
	   			   	tbl_satuan.nama_satuan,
	   			   	tbl_stok.ukuran_produk,
	   			   	(SELECT tbl_stok.stok_awal + (IFNULL(sa_a.QTY_SA_IN, 0) + IFNULL(sa_c.QTY_SA_RETUR_IN, 0) - IFNULL(sa_b.QTY_SA_OUT, 0) - IFNULL(sa_d.QTY_SA_RETUR_OUT,0))) AS stok_awal,
	   			    IFNULL(a.QTY_IN, 0) + IFNULL(c.QTY_RETUR_IN, 0) AS masuk,
	   				IFNULL(b.QTY_OUT, 0) + IFNULL(d.QTY_RETUR_OUT, 0) AS keluar,
	   				(SELECT tbl_stok.stok_awal + (IFNULL(sa_a.QTY_SA_IN, 0) + IFNULL(sa_c.QTY_SA_RETUR_IN, 0) - IFNULL(sa_b.QTY_SA_OUT, 0) - IFNULL(sa_d.QTY_SA_RETUR_OUT,0))) + IFNULL(a.QTY_IN, 0) + IFNULL(c.QTY_RETUR_IN, 0) - IFNULL(b.QTY_OUT, 0) - IFNULL(d.QTY_RETUR_OUT, 0) AS sisa_stok
			FROM tbl_stok

			LEFT JOIN tbl_produk ON tbl_stok.id_produk = tbl_produk.id_produk

			LEFT JOIN tbl_satuan ON tbl_produk.id_satuan = tbl_satuan.id_satuan

			LEFT JOIN (
				SELECT tbl_trans_masuk_detail.id_produk, tbl_trans_masuk_detail.id_stok, tbl_trans_masuk.tgl_trans_masuk, SUM(tbl_trans_masuk_detail.qty) AS QTY_SA_IN
				FROM tbl_trans_masuk_detail
    			LEFT JOIN tbl_trans_masuk ON tbl_trans_masuk_detail.id_trans_masuk = tbl_trans_masuk.id_trans_masuk
				WHERE tbl_trans_masuk.tgl_trans_masuk BETWEEN '1990-01-01' AND '".$tanggal_awal2."'
				GROUP BY tbl_trans_masuk_detail.id_stok ASC
			)as sa_a ON sa_a.id_stok = tbl_stok.id_stok

			LEFT JOIN (
				SELECT tbl_checkout_detail.id_produk, tbl_checkout_detail.id_stok, tbl_pembelian.tgl_pembelian, SUM(tbl_checkout_detail.qty) AS QTY_SA_OUT
				FROM tbl_checkout_detail
		    	LEFT JOIN tbl_pembelian ON tbl_checkout_detail.id_checkout = tbl_pembelian.id_checkout
				WHERE tbl_pembelian.tgl_pembelian BETWEEN '1990-01-01' AND '".$tanggal_awal2."'
				GROUP BY tbl_checkout_detail.id_stok ASC
			)as sa_b ON sa_b.id_stok = tbl_stok.id_stok

			LEFT JOIN (
				SELECT tbl_retur_masuk_detail.id_produk, tbl_retur_masuk_detail.id_stok, tbl_retur_masuk.tgl_retur_masuk, SUM(tbl_retur_masuk_detail.qty) AS QTY_SA_RETUR_IN
				FROM tbl_retur_masuk_detail
		    	LEFT JOIN tbl_retur_masuk ON tbl_retur_masuk_detail.id_retur_masuk = tbl_retur_masuk.id_retur_masuk
				WHERE tbl_retur_masuk.tgl_retur_masuk BETWEEN '1990-01-01' AND '".$tanggal_awal2."'
				GROUP BY tbl_retur_masuk_detail.id_stok ASC
			)as sa_c ON sa_c.id_stok = tbl_stok.id_stok

			LEFT JOIN (
				SELECT tbl_retur_keluar_detail.id_produk, tbl_retur_keluar_detail.id_stok, tbl_retur_keluar.tgl_retur_keluar, SUM( tbl_retur_keluar_detail.qty) AS QTY_SA_RETUR_OUT
				FROM tbl_retur_keluar_detail
		    	LEFT JOIN tbl_retur_keluar ON tbl_retur_keluar_detail.id_retur_keluar = tbl_retur_keluar.id_retur_keluar
				WHERE tbl_retur_keluar.tgl_retur_keluar BETWEEN '1990-01-01' AND '".$tanggal_awal2."'
				GROUP BY tbl_retur_keluar_detail.id_stok ASC
			)as sa_d ON sa_d.id_stok = tbl_stok.id_stok

			LEFT JOIN (
				SELECT tbl_trans_masuk_detail.id_produk, tbl_trans_masuk_detail.id_stok, tbl_trans_masuk.tgl_trans_masuk, SUM( tbl_trans_masuk_detail.qty) AS QTY_IN
				FROM tbl_trans_masuk_detail
		    	LEFT JOIN tbl_trans_masuk ON tbl_trans_masuk_detail.id_trans_masuk = tbl_trans_masuk.id_trans_masuk
				WHERE tbl_trans_masuk.tgl_trans_masuk BETWEEN '".$tanggal_awal."' AND '".$tanggal_akhir."'
				GROUP BY tbl_trans_masuk_detail.id_stok ASC
			)as a ON a.id_stok = tbl_stok.id_stok

			LEFT JOIN (
				SELECT tbl_checkout_detail.id_produk, tbl_checkout_detail.id_stok, tbl_pembelian.tgl_pembelian, SUM( tbl_checkout_detail.qty) AS QTY_OUT
				FROM tbl_checkout_detail
		    	LEFT JOIN tbl_pembelian ON tbl_checkout_detail.id_checkout = tbl_pembelian.id_checkout
				WHERE tbl_pembelian.tgl_pembelian BETWEEN '".$tanggal_awal."' AND '".$tanggal_akhir."'
				GROUP BY tbl_checkout_detail.id_stok ASC
			)as b ON b.id_stok = tbl_stok.id_stok

			LEFT JOIN (
				SELECT tbl_retur_masuk_detail.id_produk, tbl_retur_masuk_detail.id_stok, tbl_retur_masuk.tgl_retur_masuk, SUM( tbl_retur_masuk_detail.qty) AS QTY_RETUR_IN
				FROM tbl_retur_masuk_detail
		    	LEFT JOIN tbl_retur_masuk ON tbl_retur_masuk_detail.id_retur_masuk = tbl_retur_masuk.id_retur_masuk
				WHERE tbl_retur_masuk.tgl_retur_masuk BETWEEN '".$tanggal_awal."' AND '".$tanggal_akhir."'
				GROUP BY tbl_retur_masuk_detail.id_stok ASC
			)as c ON c.id_stok = tbl_stok.id_stok

			LEFT JOIN (
				SELECT tbl_retur_keluar_detail.id_produk, tbl_retur_keluar_detail.id_stok, tbl_retur_keluar.tgl_retur_keluar, SUM( tbl_retur_keluar_detail.qty) AS QTY_RETUR_OUT
				FROM tbl_retur_keluar_detail
		    	LEFT JOIN tbl_retur_keluar ON tbl_retur_keluar_detail.id_retur_keluar = tbl_retur_keluar.id_retur_keluar
				WHERE tbl_retur_keluar.tgl_retur_keluar BETWEEN '".$tanggal_awal."' AND '".$tanggal_akhir."'
				GROUP BY tbl_retur_keluar_detail.id_stok ASC
			)as d ON d.id_stok = tbl_stok.id_stok"
		);
        return $query->result();
	}

	public function get_detail_mutasi2($tanggal_awal, $tanggal_akhir)
	{
		$tanggal_awal2 = date('Y-m-d', strtotime('-1 days', strtotime($tanggal_awal)));
		$query =  $this->db->query("
			SELECT tbl_produk.id_produk, 
	   				tbl_produk.nama_produk,
	   				tbl_stok.ukuran_produk,
	   				(SELECT tbl_stok.stok_awal + (IFNULL(sa_a.QTY_SA_IN, 0) + IFNULL(sa_c.QTY_SA_RETUR_IN, 0) - IFNULL(sa_b.QTY_SA_OUT, 0) - IFNULL(sa_d.QTY_SA_RETUR_OUT,0))) AS stok_awal,
	   				IFNULL(a.QTY_IN, 0) + IFNULL(c.QTY_RETUR_IN, 0) AS masuk,
	   				IFNULL(b.QTY_OUT, 0) + IFNULL(d.QTY_RETUR_OUT, 0) AS keluar,
	   				(SELECT tbl_stok.stok_awal + (IFNULL(sa_a.QTY_SA_IN, 0) + IFNULL(sa_c.QTY_SA_RETUR_IN, 0) - IFNULL(sa_b.QTY_SA_OUT, 0) - IFNULL(sa_d.QTY_SA_RETUR_OUT,0))) + IFNULL(a.QTY_IN, 0) + IFNULL(c.QTY_RETUR_IN, 0) - IFNULL(b.QTY_OUT, 0) - IFNULL(d.QTY_RETUR_OUT, 0) AS sisa_stok
			FROM tbl_stok

			LEFT JOIN tbl_produk ON tbl_stok.id_produk = tbl_produk.id_produk

			LEFT JOIN tbl_satuan ON tbl_produk.id_satuan = tbl_satuan.id_satuan

			LEFT JOIN (
				SELECT tbl_trans_masuk_detail.id_produk, tbl_trans_masuk_detail.id_stok, tbl_trans_masuk.tgl_trans_masuk, SUM(tbl_trans_masuk_detail.qty) AS QTY_SA_IN
				FROM tbl_trans_masuk_detail
    			LEFT JOIN tbl_trans_masuk ON tbl_trans_masuk_detail.id_trans_masuk = tbl_trans_masuk.id_trans_masuk
				WHERE tbl_trans_masuk.tgl_trans_masuk BETWEEN '1990-01-01' AND '".$tanggal_awal2."'
				GROUP BY tbl_trans_masuk_detail.id_stok ASC
			)as sa_a ON sa_a.id_stok = tbl_stok.id_stok

			LEFT JOIN (
				SELECT tbl_checkout_detail.id_produk, tbl_checkout_detail.id_stok, tbl_pembelian.tgl_pembelian, SUM(tbl_checkout_detail.qty) AS QTY_SA_OUT
				FROM tbl_checkout_detail
		    	LEFT JOIN tbl_pembelian ON tbl_checkout_detail.id_checkout = tbl_pembelian.id_checkout
				WHERE tbl_pembelian.tgl_pembelian BETWEEN '1990-01-01' AND '".$tanggal_awal2."'
				GROUP BY tbl_checkout_detail.id_stok ASC
			)as sa_b ON sa_b.id_stok = tbl_stok.id_stok

			LEFT JOIN (
				SELECT tbl_retur_masuk_detail.id_produk, tbl_retur_masuk_detail.id_stok, tbl_retur_masuk.tgl_retur_masuk, SUM(tbl_retur_masuk_detail.qty) AS QTY_SA_RETUR_IN
				FROM tbl_retur_masuk_detail
		    	LEFT JOIN tbl_retur_masuk ON tbl_retur_masuk_detail.id_retur_masuk = tbl_retur_masuk.id_retur_masuk
				WHERE tbl_retur_masuk.tgl_retur_masuk BETWEEN '1990-01-01' AND '".$tanggal_awal2."'
				GROUP BY tbl_retur_masuk_detail.id_stok ASC
			)as sa_c ON sa_c.id_stok = tbl_stok.id_stok

			LEFT JOIN (
				SELECT tbl_retur_keluar_detail.id_produk, tbl_retur_keluar_detail.id_stok, tbl_retur_keluar.tgl_retur_keluar, SUM( tbl_retur_keluar_detail.qty) AS QTY_SA_RETUR_OUT
				FROM tbl_retur_keluar_detail
		    	LEFT JOIN tbl_retur_keluar ON tbl_retur_keluar_detail.id_retur_keluar = tbl_retur_keluar.id_retur_keluar
				WHERE tbl_retur_keluar.tgl_retur_keluar BETWEEN '1990-01-01' AND '".$tanggal_awal2."'
				GROUP BY tbl_retur_keluar_detail.id_stok ASC
			)as sa_d ON sa_d.id_stok = tbl_stok.id_stok

			LEFT JOIN (
				SELECT tbl_trans_masuk_detail.id_produk, tbl_trans_masuk_detail.id_stok, tbl_trans_masuk.tgl_trans_masuk, SUM( tbl_trans_masuk_detail.qty) AS QTY_IN
				FROM tbl_trans_masuk_detail
		    	LEFT JOIN tbl_trans_masuk ON tbl_trans_masuk_detail.id_trans_masuk = tbl_trans_masuk.id_trans_masuk
				WHERE tbl_trans_masuk.tgl_trans_masuk BETWEEN '".$tanggal_awal."' AND '".$tanggal_akhir."'
				GROUP BY tbl_trans_masuk_detail.id_stok ASC
			)as a ON a.id_stok = tbl_stok.id_stok

			LEFT JOIN (
				SELECT tbl_checkout_detail.id_produk, tbl_checkout_detail.id_stok, tbl_pembelian.tgl_pembelian, SUM( tbl_checkout_detail.qty) AS QTY_OUT
				FROM tbl_checkout_detail
		    	LEFT JOIN tbl_pembelian ON tbl_checkout_detail.id_checkout = tbl_pembelian.id_checkout
				WHERE tbl_pembelian.tgl_pembelian BETWEEN '".$tanggal_awal."' AND '".$tanggal_akhir."'
				GROUP BY tbl_checkout_detail.id_stok ASC
			)as b ON b.id_stok = tbl_stok.id_stok

			LEFT JOIN (
				SELECT tbl_retur_masuk_detail.id_produk, tbl_retur_masuk_detail.id_stok, tbl_retur_masuk.tgl_retur_masuk, SUM( tbl_retur_masuk_detail.qty) AS QTY_RETUR_IN
				FROM tbl_retur_masuk_detail
		    	LEFT JOIN tbl_retur_masuk ON tbl_retur_masuk_detail.id_retur_masuk = tbl_retur_masuk.id_retur_masuk
				WHERE tbl_retur_masuk.tgl_retur_masuk BETWEEN '".$tanggal_awal."' AND '".$tanggal_akhir."'
				GROUP BY tbl_retur_masuk_detail.id_stok ASC
			)as c ON c.id_stok = tbl_stok.id_stok

			LEFT JOIN (
				SELECT tbl_retur_keluar_detail.id_produk, tbl_retur_keluar_detail.id_stok, tbl_retur_keluar.tgl_retur_keluar, SUM( tbl_retur_keluar_detail.qty) AS QTY_RETUR_OUT
				FROM tbl_retur_keluar_detail
		    	LEFT JOIN tbl_retur_keluar ON tbl_retur_keluar_detail.id_retur_keluar = tbl_retur_keluar.id_retur_keluar
				WHERE tbl_retur_keluar.tgl_retur_keluar BETWEEN '".$tanggal_awal."' AND '".$tanggal_akhir."'
				GROUP BY tbl_retur_keluar_detail.id_stok ASC
			)as d ON d.id_stok = tbl_stok.id_stok

		 	WHERE a.QTY_IN IS NOT NULL OR b.QTY_OUT IS NOT NULL OR c.QTY_RETUR_IN IS NOT NULL OR d.QTY_RETUR_OUT IS NOT NULL" 
		);
        return $query->result(); 
	}

}