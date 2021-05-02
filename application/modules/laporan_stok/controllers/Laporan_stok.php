<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_stok extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('dashboard_adm/Mod_dashboard_adm','m_dasbor');
		$this->load->model('Mod_lap_stok','m_lapstok');
		//cek sudah login apa tidak
		if ($this->session->userdata('logged_in') != true) {
			redirect('home/error_404');
		}
		//cek level user
		if ($this->session->userdata('id_level_user') == "2" || $this->session->userdata('id_level_user') == "4") {
			redirect('home/error_404');
		}

		//pesan stok minimum
		$produk = $this->m_dasbor->get_produk();
		$link_notif = site_url('laporan_stok');
		foreach ($produk as $val) {
			if ($val->stok_sisa <= $val->stok_minimum) {
				$this->session->set_flashdata('cek_stok', 'Terdapat Stok produk dibawah nilai minimum, Mohon di cek ulang <a href="'.$link_notif.'">disini</a>');
			}
		}
	}

	public function index()
	{
		$id_user = $this->session->userdata('id_user'); 
		$data_user = $this->m_dasbor->get_data_user($id_user);

		$jumlah_notif = $this->m_dasbor->email_notif_count($id_user);  //menghitung jumlah email masuk
		$notif = $this->m_dasbor->get_email_notif($id_user); //menampilkan isi email

		$query = $this->m_lapstok->get_report_stok();

		$data = array(
			'content'=>'view_lap_stok_detail',
			// 'modal'=>'modalReturKeluarAdm',
			'css'=>'cssLapStok',
			'js'=>'jsLapStok',
			'data_user' => $data_user,
			'qty_notif' => $jumlah_notif,
			'isi_notif' => $notif,
			'hasil_data' => $query
		);
		$this->load->view('temp_adm',$data);
	}

	public function cetak_report_stok()
	{
		$this->load->library('Pdf_gen');
		$id_user = $this->session->userdata('id_user');
		$query_footer = $this->m_lapstok->get_detail_footer($id_user);
		$query = $this->m_lapstok->get_report_stok();

		$data = array(
			'title' => 'Laporan Permintaan Barang',
			'hasil_data' => $query,
			'hasil_footer' => $query_footer,
			);

	    $html = $this->load->view('view_lap_order_cetak', $data, true);
	    
	    $filename = 'laporan_stok_'.time();
	    $this->pdf_gen->generate($html, $filename, true, 'A4', 'portrait');
	}

}
