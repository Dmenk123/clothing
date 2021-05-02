<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Retur_keluar_adm extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('dashboard_adm/Mod_dashboard_adm','m_dasbor');
		$this->load->model('Mod_retur_keluar_adm','m_retout');
		$this->load->model('Order_produk_adm/mod_order_produk_adm','m_order');
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
			'content'=>'view_list_retur_keluar_adm',
			'modal'=>'modalReturKeluarAdm',
			'css'=>'cssReturKeluarAdm',
			'js'=>'jsReturKeluarAdm',
			'data_user' => $data_user,
			'qty_notif' => $jumlah_notif,
			'isi_notif' => $notif,
		);
		$this->load->view('temp_adm',$data);
	}

	public function list_retur_keluar()
	{
		$list = $this->m_retout->get_datatable_rtr_keluar();
		$data = array();
		$no =$_POST['start'];
		foreach ($list as $listRtrKeluar) {
			$link_detail = site_url('retur_keluar_adm/retur_keluar_detail/').$listRtrKeluar->id_retur_keluar;
			$no++;
			$row = array();
			//loop value tabel db
			$row[] = $listRtrKeluar->id_retur_keluar;
			$row[] = $listRtrKeluar->fname_user." ".$listRtrKeluar->lname_user;
			$row[] = $listRtrKeluar->nama_supplier;
			$row[] = $listRtrKeluar->tgl_retur_keluar;
			//add html for action button
			if ($listRtrKeluar->jml > 0) {
				$row[] = 
				'<a class="btn btn-sm btn-success" href="'.$link_detail.'" title="Retur Masuk Detail" id="btn_detail"><i class="glyphicon glyphicon-info-sign"></i> '.$listRtrKeluar->jml.' Items</a>
 				 <a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="editReturKeluar('."'".$listRtrKeluar->id_retur_keluar."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				 <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="deleteReturKeluar('."'".$listRtrKeluar->id_retur_keluar."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
			}else{
				$row[] = null;
			}

			$data[] = $row;
		}//end loop

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->m_retout->count_all_rtr_keluar(),
						"recordsFiltered" => $this->m_retout->count_filtered_rtr_keluar(),
						"data" => $data,
					);
		//output to json format
		echo json_encode($output);
	}

	public function get_header_form_retur_keluar()
	{
		$data = array(
			'kode_retur_keluar'=> $this->m_retout->get_kode_trans_retur_keluar(),
			'kode_penerimaan'=> $this->m_retout->get_kode_penerimaan(),
		);

		echo json_encode($data);
	}

	public function list_penerimaan()
	{
		$idPenerimaan = $this->input->post('idPenerimaan');
		$data = array(
			'supplier' => $this->m_retout->lookup_id_supplier_penerimaan($idPenerimaan),
			'data_list' => $this->m_retout->get_data_penerimaan_detail($idPenerimaan), 
		);

		echo json_encode($data);
	}

	public function add_retur_keluar()
	{
		$timestamp = date('Y-m-d H:i:s');
		//insert table retur_masuk
		$data_retur_keluar = array(			
			'id_retur_keluar' => $this->input->post('formIdRetKeluar'),
			'id_user' => $this->input->post('formIdUserRetKeluar'),
			'id_supplier' => $this->input->post('formIdSupplierRetKeluar'),
			'tgl_retur_keluar' => date("Y-m-d"),
			'timestamp' => $timestamp, 
		);

		//variabel count untuk looping each field
		$hitung = count($this->input->post('fieldIdProdukRetKeluar'));

		//insert table retur_masuk_detail
		$data_retur_keluar_detail = array();
		for ($i=0; $i < $hitung; $i++) 
		{
			$data_retur_keluar_detail[$i] = array(
				'id_trans_masuk_detail' => $this->input->post('fieldIdMasukDet')[$i],
				'id_retur_keluar' => $this->input->post('formIdRetKeluar'),
				'id_trans_masuk' => $this->input->post('fieldIdMasuk')[$i],
				'id_produk' => $this->input->post('fieldIdProdukRetKeluar')[$i],
				'id_satuan' => $this->input->post('fieldIdSatuanRetKeluar')[$i],
				'id_stok' => $this->input->post('fieldIdStokRetKeluar')[$i],
				'ukuran' => $this->input->post('fieldSizeRetKeluar')[$i],
				'qty' => $this->input->post('fieldJumlahRetKeluar')[$i],
				'keterangan' => $this->input->post('fieldKetRetKeluar')[$i],
				'timestamp' => $timestamp, 
			);
		}
						
		$insert = $this->m_retout->simpan_data_retur_keluar($data_retur_keluar, $data_retur_keluar_detail);
		
		echo json_encode(array(
			"status" => TRUE,
			"pesan" => 'Data Pengeluarn Retur Berhasil ditambahkan'
		));
	}

	public function edit_retur_keluar($id)
	{
		$data = array(
			'data_header' => $this->m_retout->get_data_retur_keluar_header($id),
			'data_isi' => $this->m_retout->get_data_retur_keluar_detail($id),
		);
		echo json_encode($data);
	}

	public function update_retur_keluar()
	{
		//delete by id_retur_keluar tbl retur keluar detail
		$id = $this->input->post('formIdRetKeluar');
		$timestamp = date('Y-m-d H:i:s');
		//hapus data retur_keluar_detail
		$this->m_retout->hapus_data_retur_keluar_detail($id);

		//update header tbl retur_keluar
		$data_header = array(
			'timestamp' => $timestamp,
		); 
		$this->m_retout->update_data_header_retur_keluar(array('id_retur_keluar' => $id), $data_header);

		//proses insert ke tabel retur keluar detail
		//hitung variabel array
		$hitung = count($this->input->post('fieldIdProdukRetKeluar'));
		$data_retur_keluar_detail = array();
			for ($i=0; $i < $hitung; $i++) 
			{
				$data_retur_keluar_detail[$i] = array(
					'id_trans_masuk_detail' => $this->input->post('fieldIdMasukDet')[$i],
					'id_retur_keluar' => $this->input->post('formIdRetKeluar'),
					'id_trans_masuk' => $this->input->post('fieldIdMasuk')[$i],
					'id_produk' => $this->input->post('fieldIdProdukRetKeluar')[$i],
					'id_satuan' => $this->input->post('fieldIdSatuanRetKeluar')[$i],
					'id_stok' => $this->input->post('fieldIdStokRetKeluar')[$i],
					'ukuran' => $this->input->post('fieldSizeRetKeluar')[$i],
					'qty' => $this->input->post('fieldJumlahRetKeluar')[$i],
					'keterangan' => $this->input->post('fieldKetRetKeluar')[$i],
					'timestamp' => $timestamp, 
				);
			}

		$this->m_retout->reinsert_data_retur_keluar_detail($data_retur_keluar_detail);

		echo json_encode(array(
			"status" => TRUE,
			"pesan" => 'Data Retur Pengeluaran Produk Berhasil diupdate'
		));
	}

	public function retur_keluar_detail()
	{
		$id_user = $this->session->userdata('id_user'); 
		$data_user = $this->m_dasbor->get_data_user($id_user);

		$jumlah_notif = $this->m_dasbor->email_notif_count($id_user);  //menghitung jumlah email masuk
		$notif = $this->m_dasbor->get_email_notif($id_user); //menampilkan isi email

		$id_retur_keluar = $this->uri->segment(3);
		$query_header = $this->m_retout->get_data_retur_keluar_header($id_retur_keluar);
		$query_data = $this->m_retout->get_data_retur_keluar_detail($id_retur_keluar);

		$data = array(
			'content'=>'view_detail_retur_keluar_adm',
			'modal'=>'modalReturKeluarAdm',
			'css'=>'cssReturKeluarAdm',
			'js'=>'jsReturKeluarAdm',
			'data_user' => $data_user,
			'qty_notif' => $jumlah_notif,
			'isi_notif' => $notif,
			'hasil_header' => $query_header,
			'hasil_data' => $query_data,
		);
		$this->load->view('temp_adm',$data);
	}

	public function cetak_surat_jalan_retur()
	{
		$this->load->library('Pdf_gen');

		$id_retur_keluar = $this->uri->segment(3);
		$query_header = $this->m_retout->get_data_retur_keluar_header($id_retur_keluar);
		$query = $this->m_retout->get_data_retur_keluar_detail($id_retur_keluar);

		$data = array(
			'title' => 'Laporan Pengeluaran Retur',
			'hasil_header' => $query_header,
			'hasil_data' => $query, 
		);

	    $html = $this->load->view('view_surat_jalan_retur_keluar', $data, true);
	    
	    $filename = 'surat_jalan_retur'.$id_retur_keluar.'_'.time();
	    $this->pdf_gen->generate($html, $filename, true, 'A4', 'portrait');
	}

	public function delete_retur_keluar($id)
	{
		$this->m_retout->delete_data_retur_keluar($id);
		echo json_encode(array(
			"status" => TRUE,
			"pesan" => 'Data Pengeluaran Retur. '.$id.' Berhasil dihapus'
		));
	}

}