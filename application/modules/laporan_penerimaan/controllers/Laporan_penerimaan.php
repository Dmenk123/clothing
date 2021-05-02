<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_penerimaan extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('dashboard_adm/Mod_dashboard_adm','m_dasbor');
		$this->load->model('Mod_lap_penerimaan','m_lapmsk');
		$this->load->model('Laporan_stok/Mod_lap_stok','m_lapstok');
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

		$data = array(
			'content'=>'view_lap_penerimaan',
			'css'=>'cssLapPenerimaan',
			'js'=>'jsLapPenerimaan',
			'data_user' => $data_user,
			'qty_notif' => $jumlah_notif,
			'isi_notif' => $notif
		);
		$this->load->view('temp_adm',$data);
	}

	public function laporan_penerimaan_detail()
	{
		$id_user = $this->session->userdata('id_user'); 
		$data_user = $this->m_dasbor->get_data_user($id_user);

		$jumlah_notif = $this->m_dasbor->email_notif_count($id_user);  //menghitung jumlah email masuk
		$notif = $this->m_dasbor->get_email_notif($id_user); //menampilkan isi email

		$tanggal_awal = date("Y-m-d", strtotime($this->input->post('tanggalLapAwal')));
		$tanggal_akhir = date("Y-m-d", strtotime($this->input->post('tanggalLapAkhir')));
		$query = $this->m_lapmsk->get_detail_lap_masuk($tanggal_awal, $tanggal_akhir);
		//echo var_dump($query_header);
		$data = array(
			'css'=>'cssLapPenerimaan',
			'js'=>'jsLapPenerimaan',
			'content' => 'view_lap_penerimaan_detail',
			'hasil_data' => $query,
			'tanggal_awal' => $tanggal_awal,
			'tanggal_akhir' => $tanggal_akhir,
			'tanggal' => $tanggal_awal.' s/d '.$tanggal_akhir,
			'data_user' => $data_user,
			'qty_notif' => $jumlah_notif,
			'isi_notif' => $notif,
		);
		$this->load->view('temp_adm',$data);
	}

	public function cetak_laporan_penerimaan($tglAwal= 0, $tglAkhir= 0)
	{
		$this->load->library('Pdf_gen');
		$id_user = $this->session->userdata('id_user');
		$query = $this->m_lapmsk->get_detail_lap_masuk($tglAwal, $tglAkhir);
		$query_footer = $this->m_lapstok->get_detail_footer($id_user);

		$data = array(
			'title' => 'Laporan Penerimaan Barang',
			'hasil_data' => $query,
			'hasil_footer' => $query_footer,
			'tanggal_awal' => $tglAwal,
			'tanggal_akhir' => $tglAkhir
		);

	    $html = $this->load->view('view_lap_penerimaan_cetak', $data, true);
	    
	    $filename = 'laporan_penerimaan_'.time();
	    $this->pdf_gen->generate($html, $filename, true, 'A4', 'portrait');
	}

}
