<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_adm extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Mod_dashboard_adm','m_dasbor');
		//cek sudah login apa tidak
		if ($this->session->userdata('logged_in') != true) {
			redirect('home/error_404');
		}
		//cek level user
		if ($this->session->userdata('id_level_user') == "2") {
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
		$jumlah_notif = $this->m_dasbor->email_notif_count($id_user);  //menghitung jumlah email masuk
		$notif = $this->m_dasbor->get_email_notif($id_user); //menampilkan isi email
		$data_user = $this->m_dasbor->get_data_user($id_user);

		$count_produk = $this->m_dasbor->get_count_produk();
		$count_stok = $this->m_dasbor->get_count_stok();
		$count_user = $this->m_dasbor->get_count_user();
		$count_user_level = $this->m_dasbor->get_count_user_level();

		$data = array(
			'content' => 'dashboard_adm/view_list_dashboard_adm',
			'data_user' => $data_user,
			'qty_notif' => $jumlah_notif,
			'isi_notif' => $notif,
			'counter_produk' => $count_produk,
			'counter_stok' => $count_stok,
			'counter_user' => $count_user,
			'counter_user_level' => $count_user_level,
		);

        $this->load->view('temp_adm',$data);
	}

}
