<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_history_order extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('dashboard_adm/Mod_dashboard_adm','m_dasbor');
		$this->load->model('Mod_lap_history_order','m_horder');
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
			'content'=>'view_lap_history_order',
			'css'=>'cssLapHistoryOrder',
			'js'=>'jsLapHistoryOrder',
			'data_user' => $data_user,
			'qty_notif' => $jumlah_notif,
			'isi_notif' => $notif
		);
		$this->load->view('temp_adm',$data);
	}

	public function laporan_history_order_detail()
	{
		$id_user = $this->session->userdata('id_user'); 
		$data_user = $this->m_dasbor->get_data_user($id_user);

		$jumlah_notif = $this->m_dasbor->email_notif_count($id_user);  //menghitung jumlah email masuk
		$notif = $this->m_dasbor->get_email_notif($id_user); //menampilkan isi email

		$tanggal_awal = date("Y-m-d", strtotime($this->input->post('tanggalLaporanAwal')));
		$tanggal_akhir = date("Y-m-d", strtotime($this->input->post('tanggalLaporanAkhir')));
		$data_tampil = $this->input->post('indexTampil');
		$data_list = $this->input->post('tampilData');

		if ($data_tampil == 'supplier') {
			$query = $this->m_horder->get_detail_supplier($data_list, $tanggal_awal, $tanggal_akhir);
		}elseif ($data_tampil == 'barang') {
			$query = $this->m_horder->get_detail_barang($data_list, $tanggal_awal, $tanggal_akhir);
		}

		//echo var_dump($query_header);
		$data = array(
			'css'=>'cssLapHistoryOrder',
			'js'=>'jsLapHistoryOrder',
			'content' => 'view_lap_history_order_detail',
			'hasil_data' => $query,
			'tanggal_awal' => $tanggal_awal,
			'tanggal_akhir' => $tanggal_akhir,
			'tanggal' => $tanggal_awal.' s/d '.$tanggal_akhir,
			'data_user' => $data_user,
			'qty_notif' => $jumlah_notif,
			'isi_notif' => $notif,
			'filter_by' => $data_tampil,
			'data_list' => $data_list,
		);
		$this->load->view('temp_adm',$data);
	}

	public function cetak_laporan_riwayat($filterBy, $dataList, $tglAwal= 0, $tglAkhir= 0)
	{
		$this->load->library('Pdf_gen');
		$id_user = $this->session->userdata('id_user');

		if ($filterBy == 'supplier') {
			$query = $this->m_horder->get_detail_supplier($dataList, $tglAwal, $tglAkhir);
		}elseif ($filterBy == 'barang') {
			$query = $this->m_horder->get_detail_barang($dataList, $tglAwal, $tglAkhir);
		}
		
		$query_footer = $this->m_lapstok->get_detail_footer($id_user);

		$data = array(
			'title' => 'Laporan Riwayat Permintaan Barang',
			'hasil_data' => $query,
			'hasil_footer' => $query_footer,
			'tanggal_awal' => $tglAwal,
			'tanggal_akhir' => $tglAkhir
		);

	    $html = $this->load->view('view_lap_history_order_cetak', $data, true);
	    
	    $filename = 'laporan_history_order_'.time();
	    $this->pdf_gen->generate($html, $filename, true, 'A4', 'portrait');
	}

	public function suggest_tampil_data()
	{
		// get data from ajax object (uri)
		$jenis = $this->uri->segment(3);
		$dataTampil = [];
		if ($jenis == 'supplier') {
			if(!empty($this->input->get("term"))){
				$key = $_GET['term'];
				$query = $this->m_horder->lookup_data_supplier($key);
			}else{
				$key = "";
				$query = $this->m_horder->lookup_data_supplier($key);
			}
			
			foreach ($query as $row) {
				$dataTampil[] = array(
					'id' => $row->id_supplier,
					'text' => $row->nama_supplier,
				);
			}
		}elseif ($jenis == 'barang') {
			if(!empty($this->input->get("term"))){
				$key = $_GET['term'];
				$query = $this->m_horder->lookup_data_produk($key);
			}else{
				$key = "";
				$query = $this->m_horder->lookup_data_produk($key);
			}
			
			foreach ($query as $row) {
				$dataTampil[] = array(
					'id' => $row->id_produk,
					'text' => $row->nama_produk,
				);
			}
		}
		echo json_encode($dataTampil);		
	}

}
