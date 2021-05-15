<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_tag_adm extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('dashboard_adm/Mod_dashboard_adm','m_dasbor');
		$this->load->model('Mod_master_tag_adm','m_tag');
		//cek sudah login apa tidak
		if ($this->session->userdata('logged_in') != true) {
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
			'content'=>'view_list_master_tag_produk',
			'modal'=>'modalTagAdm',
			'js'=>'masterTagAdmJs',
			'data_user' => $data_user,
			'qty_notif' => $jumlah_notif,
			'isi_notif' => $notif,
		);
		$this->load->view('temp_adm',$data);
	}

	public function list_tag()
	{
		$list = $this->m_tag->get_datatable();
		$data = array();
		$angka = 1;
		$no = $_POST['start'];
		foreach ($list as $dataRow) {
			$no++;
			$row = array();
			//loop value tabel db
			$row[] = $angka;
			$row[] = $dataRow->nama_tag;
			$row[] = $dataRow->warna_tag;
			//add html for action button
			$row[] = '<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_tag('."'".$dataRow->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
			$angka++;				 
			$data[] = $row;
		}//end loop

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->m_tag->count_all(),
			"recordsFiltered" => $this->m_tag->count_filtered(),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function add_master_tag()
	{
		$data = array(
			'nama_tag' => trim($this->input->post('namaTag')),
			'warna_tag' => trim($this->input->post('warnaTag')),
		);

		$this->m_tag->insert_data_tag($data);
		echo json_encode(array(
			'status' => TRUE,
			'pesan' => "Data Tag berhasil ditambahkan", 
		));
	}

	public function delete_master_tag($id)
	{
		$this->m_tag->delete_data_tag($id);
		echo json_encode(array(
			'status' => TRUE,
			'pesan' => 'Master Tag Berhasil dihapus'
		));
	}
	
}
