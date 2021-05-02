<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_mutasi extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('dashboard_adm/Mod_dashboard_adm','m_dasbor');
		$this->load->model('Mod_lap_mutasi','m_mutasi');
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
			'content'=>'view_lap_mutasi',
			'css'=>'cssLapMutasi',
			'js'=>'jsLapMutasi',
			'data_user' => $data_user,
			'qty_notif' => $jumlah_notif,
			'isi_notif' => $notif
		);
		$this->load->view('temp_adm',$data);
	}

	public function laporan_mutasi_detail()
	{
		$id_user = $this->session->userdata('id_user'); 
		$data_user = $this->m_dasbor->get_data_user($id_user);

		$jumlah_notif = $this->m_dasbor->email_notif_count($id_user);  //menghitung jumlah email masuk
		$notif = $this->m_dasbor->get_email_notif($id_user); //menampilkan isi email

		$tampil_mutasi = $this->input->post('tampilMutasi');
		$tanggal_awal = date("Y-m-d", strtotime($this->input->post('tanggalLapAwal')));
		$tanggal_akhir = date("Y-m-d", strtotime($this->input->post('tanggalLapAkhir')));

		if ($tampil_mutasi == "semua") {
			$query = $this->m_mutasi->get_detail_mutasi($tanggal_awal, $tanggal_akhir);
			$tampil = 'semua';
		}else{
			$query = $this->m_mutasi->get_detail_mutasi2($tanggal_awal, $tanggal_akhir);
			$tampil = 'hanya-mutasi';
		}

		//echo var_dump($query_header);
		$data = array(
			'content'=>'view_lap_mutasi_detail',
			'css'=>'cssLapMutasi',
			'js'=>'jsLapMutasi',
			'hasil_data' => $query,
			'tanggal_awal' => $tanggal_awal,
			'tanggal_akhir' => $tanggal_akhir,
			'pilihan_tampil' => $tampil_mutasi,
			'data_user' => $data_user,
			'qty_notif' => $jumlah_notif,
			'isi_notif' => $notif,
		);
		$this->load->view('temp_adm',$data);
	}

	public function cetak_report_mutasi($tglAwal= 0, $tglAkhir= 0, $pilihanTampil= 0)
	{
		$this->load->library('Pdf_gen');

		if ($pilihanTampil == "semua") {
			$query = $this->m_mutasi->get_detail_mutasi($tglAwal, $tglAkhir);
		}else{
			$query = $this->m_mutasi->get_detail_mutasi2($tglAwal, $tglAkhir);
		}
		
		$data = array(
			'title' => 'Laporan Mutasi',
			'hasil_data' => $query,
			'tanggal_awal' => $tglAwal,
			'tanggal_akhir' => $tglAkhir,
		);

	    $html = $this->load->view('view_lap_mutasi_cetak', $data, true);
	    
	    $filename = 'laporan_mutasi_'.time();
	    $this->pdf_gen->generate($html, $filename, true, 'A4', 'portrait');
	}

}
