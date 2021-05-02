<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Retur_masuk_adm extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('dashboard_adm/Mod_dashboard_adm','m_dasbor');
		$this->load->model('Mod_retur_masuk_adm','m_retmas');
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
			'content'=>'view_list_retur_masuk_adm',
			'modal'=>'modalReturMasukAdm',
			'css'=>'cssReturMasukAdm',
			'js'=>'jsReturMasukAdm',
			'data_user' => $data_user,
			'qty_notif' => $jumlah_notif,
			'isi_notif' => $notif,
		);
		$this->load->view('temp_adm',$data);
	}

	public function list_retur_masuk()
	{
		$list = $this->m_retmas->get_datatable_rtr_masuk();
		$data = array();
		$no =$_POST['start'];
		foreach ($list as $listRtrMasuk) {
			$link_detail = site_url('retur_masuk_adm/retur_masuk_detail/').$listRtrMasuk->id_retur_masuk;
			$no++;
			$row = array();
			//loop value tabel db
			$row[] = $listRtrMasuk->id_retur_masuk;
			$row[] = $listRtrMasuk->fname_user." ".$listRtrMasuk->lname_user;
			$row[] = $listRtrMasuk->nama_supplier;
			$row[] = $listRtrMasuk->tgl_retur_masuk;
			//add html for action button
			if ($listRtrMasuk->jml > 0) {
				$row[] = 
				'<a class="btn btn-sm btn-success" href="'.$link_detail.'" title="Retur Masuk Detail" id="btn_detail"><i class="glyphicon glyphicon-info-sign"></i> '.$listRtrMasuk->jml.' Items</a>
 				 <a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="editReturMasuk('."'".$listRtrMasuk->id_retur_masuk."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				 <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="deleteReturMasuk('."'".$listRtrMasuk->id_retur_masuk."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
			}else{
				$row[] = null;
			}

			$data[] = $row;
		}//end loop

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->m_retmas->count_all_rtr_masuk(),
						"recordsFiltered" => $this->m_retmas->count_filtered_rtr_masuk(),
						"data" => $data,
					);
		//output to json format
		echo json_encode($output);
	}

	public function get_header_form_retur_masuk()
	{
		$data = array(
			'kode_retur_masuk'=> $this->m_retmas->get_kode_retur_masuk(),
			'kode_retur_keluar'=> $this->m_retmas->get_kode_retur_keluar(),
		);

		echo json_encode($data);
	}

	public function list_data_retur_keluar()
	{
		$idReturOut = $this->input->post('idReturOut');
		$data = array(
			'supplier' => $this->m_retmas->lookup_id_supplier_retout($idReturOut),
			'data_list' => $this->m_retmas->get_data_retur_keluar_detail($idReturOut), 
		);

		echo json_encode($data);
	}

	public function add_retur_masuk()
	{
		$timestamp = date('Y-m-d H:i:s');
		//insert table retur_masuk
		$data_retur_masuk = array(			
			'id_retur_masuk' => $this->input->post('formIdRetMasuk'),
			'id_user' => $this->input->post('formIdUserRetMasuk'),
			'id_supplier' => $this->input->post('formIdSupplierRetMasuk'),
			'tgl_retur_masuk' => date("Y-m-d"),
			'timestamp' => $timestamp, 
		);

		//variabel count untuk looping each field
		$hitung = count($this->input->post('fieldIdProdukRetMasuk'));

		//update status masuk tbl_retur_keluar_detail
		$data_retur_keluar_detail = array();
			for ($i=0; $i < $hitung; $i++) 
			{
				$data_retur_keluar_detail[$i] = array(
					'id_retur_keluar_detail' => $this->input->post('fieldIdRetOutDet')[$i],
					'status_retur_masuk' => '1',
				);
			}

		$this->db->update_batch('tbl_retur_keluar_detail',$data_retur_keluar_detail,'id_retur_keluar_detail');

		//insert table retur_masuk_detail
		$data_retur_masuk_detail = array();
		for ($i=0; $i < $hitung; $i++) 
		{
			$data_retur_masuk_detail[$i] = array(
				'id_retur_keluar_detail' => $this->input->post('fieldIdRetOutDet')[$i],
				'id_retur_masuk' => $this->input->post('formIdRetMasuk'),
				'id_retur_keluar' => $this->input->post('fieldIdRetOut')[$i],
				'id_produk' => $this->input->post('fieldIdProdukRetMasuk')[$i],
				'id_satuan' => $this->input->post('fieldIdSatuanRetMasuk')[$i],
				'id_stok' => $this->input->post('fieldIdStokRetMasuk')[$i],
				'ukuran' => $this->input->post('fieldSizeRetMasuk')[$i],
				'qty' => $this->input->post('fieldJumlahRetMasuk')[$i],
				'keterangan' => $this->input->post('fieldKetRetMasuk')[$i],
				'timestamp' => $timestamp, 
			);
		}
						
		$insert = $this->m_retmas->simpan_data_retur_masuk($data_retur_masuk, $data_retur_masuk_detail);
		
		echo json_encode(array(
			"status" => TRUE,
			"pesan" => 'Data Penerimaan Retur Berhasil ditambahkan'
		));
	}

	public function edit_retur_masuk($id)
	{
		$data = array(
			'data_header' => $this->m_retmas->get_data_retur_masuk_header($id),
			'data_isi' => $this->m_retmas->get_data_retur_masuk_detail($id),
		);
		echo json_encode($data);
	}

	public function update_retur_masuk()
	{
		//delete by id retur masuk detail
		$id = $this->input->post('formIdRetMasuk');
		$timestamp = date('Y-m-d H:i:s');
		//hapus data
		$this->m_retmas->hapus_data_retur_masuk_detail($id);

		//update header tbl retur masuk
		$data_header = array(
			'timestamp' => $timestamp,
		); 
		$this->m_retmas->update_data_header_retur_masuk(array('id_retur_masuk' => $id), $data_header);

		//proses insert kembali ke tabel retur masuk detail
		//hitung variabel array
		$hitung = count($this->input->post('fieldIdProdukRetMasuk'));
		$data_retur_masuk_detail = array();
			for ($i=0; $i < $hitung; $i++) 
			{
				$data_retur_masuk_detail[$i] = array(
					'id_retur_keluar_detail' => $this->input->post('fieldIdRetOutDet')[$i],
					'id_retur_masuk' => $this->input->post('formIdRetMasuk'),
					'id_retur_keluar' => $this->input->post('fieldIdRetOut')[$i],
					'id_produk' => $this->input->post('fieldIdProdukRetMasuk')[$i],
					'id_satuan' => $this->input->post('fieldIdSatuanRetMasuk')[$i],
					'id_stok' => $this->input->post('fieldIdStokRetMasuk')[$i],
					'ukuran' => $this->input->post('fieldSizeRetMasuk')[$i],
					'qty' => $this->input->post('fieldJumlahRetMasuk')[$i],
					'keterangan' => $this->input->post('fieldKetRetMasuk')[$i],
					'timestamp' => $timestamp, 
				);
			}

		$this->m_retmas->reinsert_retur_masuk_detail($data_retur_masuk_detail);

		echo json_encode(array(
			"status" => TRUE,
			"pesan" => 'Data Retur Penerimaan Produk Berhasil diupdate'
		));
	}

	public function retur_masuk_detail()
	{
		$id_user = $this->session->userdata('id_user'); 
		$data_user = $this->m_dasbor->get_data_user($id_user);

		$jumlah_notif = $this->m_dasbor->email_notif_count($id_user);  //menghitung jumlah email masuk
		$notif = $this->m_dasbor->get_email_notif($id_user); //menampilkan isi email

		$id_retur_masuk = $this->uri->segment(3);
		$query_header = $this->m_retmas->get_data_retur_masuk_header($id_retur_masuk);
		$query_data = $this->m_retmas->get_data_retur_masuk_detail($id_retur_masuk);

		$data = array(
			'content'=>'view_detail_retur_masuk_adm',
			'modal'=>'modalReturMasukAdm',
			'css'=>'cssReturMasukAdm',
			'js'=>'jsReturMasukAdm',
			'data_user' => $data_user,
			'qty_notif' => $jumlah_notif,
			'isi_notif' => $notif,
			'hasil_header' => $query_header,
			'hasil_data' => $query_data,
		);
		$this->load->view('temp_adm',$data);
	}

	public function cetak_tanda_terima_retur()
	{
		$this->load->library('Pdf_gen');

		$id_retur_masuk = $this->uri->segment(3);
		$query_header = $this->m_retmas->get_data_retur_masuk_header($id_retur_masuk);
		$query = $this->m_retmas->get_data_retur_masuk_detail($id_retur_masuk);

		$data = array(
			'title' => 'Laporan Penerimaan Retur',
			'hasil_header' => $query_header,
			'hasil_data' => $query, 
		);

	    $html = $this->load->view('view_surat_tanda_terima_retur', $data, true);
	    
	    $filename = 'tanda_terima_retur_'.$id_retur_masuk.'_'.time();
	    $this->pdf_gen->generate($html, $filename, true, 'A4', 'portrait');
	}

	public function delete_penerimaan_retur($id_retur_masuk)
	{
		$id_retur_keluar = $this->m_retmas->get_id_retur_keluar($id_retur_masuk);
		$nilai = array(
               'status_retur_masuk' => '0',
        );
		$this->m_retmas->update_data_status_retur_masuk(array('id_retur_keluar' => $id_retur_keluar), $nilai);

		$this->m_retmas->delete_data_retur_masuk($id_retur_masuk);
		echo json_encode(array(
			"status" => TRUE,
			"pesan" => 'Data Penerimaan Retur No.'.$id_retur_masuk.' Berhasil dihapus'
		));
	}

}