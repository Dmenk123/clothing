<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_supplier_adm extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('dashboard_adm/Mod_dashboard_adm','m_dasbor');
		$this->load->model('Mod_master_supplier_adm','m_sup');
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
		$listSupplier = $this->session->userdata('listSupplier'); 
		$data_user = $this->m_dasbor->get_data_user($listSupplier);

		$jumlah_notif = $this->m_dasbor->email_notif_count($listSupplier);  //menghitung jumlah email masuk
		$notif = $this->m_dasbor->get_email_notif($listSupplier); //menampilkan isi email

		$data = array(
			'content'=>'view_list_master_supplier',
			'modal'=>'modalMasterSupplierAdm',
			'js'=>'masterSupplierAdmJs',
			'data_user' => $data_user,
			'qty_notif' => $jumlah_notif,
			'isi_notif' => $notif,
		);
		$this->load->view('temp_adm',$data);
	}

	public function list_supplier()
	{
		$list = $this->m_sup->get_datatable_supplier();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $listSupplier) {
			$no++;
			$row = array();
			//loop value tabel db
			$row[] = $listSupplier->id_supplier;
			$row[] = $listSupplier->nama_supplier;
			$row[] = $listSupplier->alamat_supplier;
			$row[] = $listSupplier->keterangan;
			$row[] = $listSupplier->telp_supplier;
			//add html for action button
			if ($listSupplier->status == '1') {
				$row[] =
				'<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_supplier('."'".$listSupplier->id_supplier."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				 <a class="btn btn-sm btn-success btn_edit_status" href="javascript:void(0)" title="aktif" id="'.$listSupplier->id_supplier.'"><i class="fa fa-check"></i> Aktif</a>';
			}else{
				$row[] =
				'<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_supplier('."'".$listSupplier->id_supplier."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				 <a class="btn btn-sm btn-danger btn_edit_status" href="javascript:void(0)" title="nonaktif" id="'.$listSupplier->id_supplier.'"><i class="fa fa-times"></i> Nonaktif</a>';
			}
			
			$data[] = $row;
		}//end loop

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->m_sup->count_all(),
						"recordsFiltered" => $this->m_sup->count_filtered(),
						"data" => $data,
					);
		//output to json format
		echo json_encode($output);
	}

	public function add_master_supplier()
	{
		$id_supplier = $this->m_sup->get_kode_supplier();
		$timestamp = date('Y-m-d H:i:s');
		$data = array(
			'id_supplier' => $id_supplier,
			'nama_supplier' => strtoupper(trim($this->input->post('namaSupplier'))),
			'alamat_supplier' => strtoupper(trim($this->input->post('alamatSupplier'))),
			'keterangan' => strtoupper(trim($this->input->post('ketSupplier'))),
			'telp_supplier' => $this->input->post('telpSupplier'),
			'status' => '1',
			'timestamp' => $timestamp
		);

		$this->m_sup->insert_data_supplier($data);
		echo json_encode(array(
			'status' => TRUE,
			'pesan' => "Data Supplier berhasil ditambahkan", 
		));
	}

	public function edit_master_supplier($id)
	{
		$data = $this->m_sup->get_data_supplier($id);
		echo json_encode($data);
	}

	public function update_master_supplier()
	{
		$timestamp = date('Y-m-d H:i:s');
		$data = array(
			'nama_supplier' => strtoupper(trim($this->input->post('namaSupplier'))),
			'alamat_supplier' => strtoupper(trim($this->input->post('alamatSupplier'))),
			'keterangan' => strtoupper(trim($this->input->post('ketSupplier'))),
			'telp_supplier' => $this->input->post('telpSupplier'),
			'timestamp' => $timestamp
		);

		$this->m_sup->update_data_supplier(array('id_supplier' => $this->input->post('idSupplier')), $data);
		echo json_encode(array(
			'status' => TRUE,
			'pesan' => "Data kategori berhasil diupdate", 
		));
	}

	public function edit_status_supplier($id)
	{
		$input_status = $this->input->post('status');
		// jika aktif maka di set ke nonaktif / "0"
		if ($input_status == " Aktif") 
		{
			$status = '0';
		}
		elseif ($input_status == " Nonaktif")
		{
			$status = '1';
		}
		
		$input = array(
			'status' => $status 
		);
		$this->m_sup->update_status_supplier(array('id_supplier' => $id), $input);
		if ($status == '1') {
			$data = array(
				'status' => TRUE,
				'pesan' => "Supplier dengan kode ".$id." berhasil Aktifkan.",
			);
		}else{
			$data = array(
				'status' => TRUE,
				'pesan' => "Supplier dengan kode ".$id." berhasil Nonaktifkan.",
			);
		}
		

		echo json_encode($data);
	}

	public function delete_master_kategori($id_kategori)
	{
		$this->m_sup->delete_data_kategori($id_kategori);
		echo json_encode(array(
			'status' => TRUE,
			'pesan' => 'Master Kategori Berhasil dihapus'
		));
	}

}
