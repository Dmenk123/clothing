<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Terima_produk_adm extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('dashboard_adm/Mod_dashboard_adm','m_dasbor');
		$this->load->model('Mod_terima_produk_adm','m_masuk');
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
			'content'=>'view_list_terima_produk_adm',
			'modal'=>'modalTerimaProdukAdm',
			'css'=>'cssTerimaProdukAdm',
			'js'=>'jsTerimaProdukAdm',
			'data_user' => $data_user,
			'qty_notif' => $jumlah_notif,
			'isi_notif' => $notif,
		);
		$this->load->view('temp_adm',$data);
	}

	public function list_terima_produk()
	{
		$list = $this->m_masuk->get_datatable_penerimaan();
		$data = array();
		$no =$_POST['start'];
		foreach ($list as $listTerimaProduk) {
			$link_detail = site_url('terima_produk_adm/terima_produk_detail/').$listTerimaProduk->id_trans_masuk;
			$no++;
			$row = array();
			//loop value tabel db
			$row[] = $listTerimaProduk->id_trans_masuk;
			$row[] = $listTerimaProduk->fname_user." ".$listTerimaProduk->lname_user;
			$row[] = $listTerimaProduk->nama_supplier;
			$row[] = $listTerimaProduk->tgl_trans_masuk;
			//add html for action button
			if ($listTerimaProduk->jml > 0) {
				$row[] = 
				'<a class="btn btn-sm btn-success" href="'.$link_detail.'" title="Terima Detail" id="btn_detail"><i class="glyphicon glyphicon-info-sign"></i> '.$listTerimaProduk->jml.' Items</a>
 				 <a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="editTerimaProduk('."'".$listTerimaProduk->id_trans_masuk."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				 <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="deleteTerimaProduk('."'".$listTerimaProduk->id_trans_masuk."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
			}else{
				$row[] = null;
			}

			$data[] = $row;
		}//end loop

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->m_masuk->count_all_penerimaan(),
						"recordsFiltered" => $this->m_masuk->count_filtered_penerimaan(),
						"data" => $data,
					);
		//output to json format
		echo json_encode($output);
	}

	public function list_permintaan()
	{
		$idOrder = $this->input->post('idOrder');
		$data = array(
			'supplier' => $this->m_masuk->lookup_id_supplier($idOrder),
			'data_list' => $this->m_masuk->get_data_order_details($idOrder), 
		);

		echo json_encode($data);
	}

	public function add_terima_produk()
	{
		$timestamp = date('Y-m-d H:i:s');
		//insert table trans_masuk
		$data_masuk = array(			
			'id_trans_masuk' => $this->input->post('fieldIdMasuk'),
			'id_user' => $this->input->post('fieldIdUserMasuk'),
			'id_supplier' => $this->input->post('fieldIdSupplierMasuk'),
			'tgl_trans_masuk' => date("Y-m-d"),
			'timestamp' => $timestamp, 
		);

		//variabel count untuk looping each field
		$hitung = count($this->input->post('fieldIdProdukMasuk'));

		//update status masuk tbl_trans_order_detail
		$data_order_detail = array();
			for ($i=0; $i < $hitung; $i++) 
			{
				$data_order_detail[$i] = array(
					'id_trans_order_detail' => $this->input->post('fieldIdOrderDet')[$i],
					'status_masuk' => '1',
				);
			}

		$this->db->update_batch('tbl_trans_order_detail',$data_order_detail,'id_trans_order_detail');

		//insert table trans_masuk_detail
		$data_masuk_detail = array();
		for ($i=0; $i < $hitung; $i++) 
		{
			$data_masuk_detail[$i] = array(
				'id_trans_order_detail' => $this->input->post('fieldIdOrderDet')[$i],
				'id_trans_masuk' => $this->input->post('fieldIdMasuk'),
				'id_trans_order' => $this->input->post('fieldIdOrder')[$i],
				'id_stok' => $this->input->post('fieldIdStokMasuk')[$i],
				'id_produk' => $this->input->post('fieldIdProdukMasuk')[$i],
				'id_satuan' => $this->input->post('fieldIdSatuanMasuk')[$i],
				'ukuran' => $this->input->post('fieldSizeProdukMasuk')[$i],
				'qty' => $this->input->post('fieldJumlahProdukMasuk')[$i],
				'keterangan' => $this->input->post('fieldKetProdukMasuk')[$i],
				'timestamp' => $timestamp, 
			);
		}
						
		$insert = $this->m_masuk->simpan_data_masuk($data_masuk, $data_masuk_detail);
		
		echo json_encode(array(
			"status" => TRUE,
			"pesan" => 'Data Transaksi Order Produk Berhasil ditambahkan'
		));
	}

	public function edit_terima_produk($id)
	{
		$data = array(
			'data_header' => $this->m_masuk->get_data_masuk_header($id),
			'data_isi' => $this->m_masuk->get_data_masuk_detail($id),
		);
		echo json_encode($data);
	}

	public function update_terima_produk()
	{
		//delete id order in tabel detail
		$id = $this->input->post('fieldIdMasuk');
		$timestamp = date('Y-m-d H:i:s');
		//hapus data masuk
		$this->m_masuk->hapus_data_masuk_detail($id);

		//update header
		$data_header = array(
			'timestamp' => $timestamp,
		); 
		$this->m_masuk->update_data_header_masuk(array('id_trans_masuk' => $id), $data_header);

		//proses insert ke tabel detail
		//hitung variabel array
		$hitung = count($this->input->post('fieldIdProdukMasuk'));
		$data_masuk_detail = array();
			for ($i=0; $i < $hitung; $i++) 
			{
			$data_masuk_detail[$i] = array(
					'id_trans_order_detail' => $this->input->post('fieldIdOrderDet')[$i],
					'id_trans_masuk' => $this->input->post('fieldIdMasuk'),
					'id_trans_order' => $this->input->post('fieldIdOrder')[$i],
					'id_stok' => $this->input->post('fieldIdStokMasuk')[$i],
					'id_produk' => $this->input->post('fieldIdProdukMasuk')[$i],
					'id_satuan' => $this->input->post('fieldIdSatuanMasuk')[$i],
					'ukuran' => $this->input->post('fieldSizeProdukMasuk')[$i],
					'qty' => $this->input->post('fieldJumlahProdukMasuk')[$i],
					'keterangan' => $this->input->post('fieldKetProdukMasuk')[$i],
					'timestamp' => $timestamp, 
				);
			}

		$this->m_masuk->insert_update_masuk($data_masuk_detail);

		echo json_encode(array(
			"status" => TRUE,
			"pesan" => 'Data Transaksi Penerimaan Produk Berhasil diupdate'
		));
	}

	public function terima_produk_detail()
	{
		$id_user = $this->session->userdata('id_user'); 
		$data_user = $this->m_dasbor->get_data_user($id_user);

		$jumlah_notif = $this->m_dasbor->email_notif_count($id_user);  //menghitung jumlah email masuk
		$notif = $this->m_dasbor->get_email_notif($id_user); //menampilkan isi email

		$id_trans_masuk = $this->uri->segment(3);
		$query_header = $this->m_masuk->get_data_masuk_header($id_trans_masuk);
		$query_data = $this->m_masuk->get_data_masuk_detail($id_trans_masuk);

		$data = array(
			'content'=>'view_detail_terima_produk_adm',
			'modal'=>'modalTerimaProdukAdm',
			'css'=>'cssTerimaProdukAdm',
			'js'=>'jsTerimaProdukAdm',
			'data_user' => $data_user,
			'qty_notif' => $jumlah_notif,
			'isi_notif' => $notif,
			'hasil_header' => $query_header,
			'hasil_data' => $query_data,
		);
		$this->load->view('temp_adm',$data);
	}

	public function cetak_tanda_terima()
	{
		$this->load->library('Pdf_gen');

		$id_trans_masuk = $this->uri->segment(3);
		$query_header = $this->m_masuk->get_data_masuk_header($id_trans_masuk);
		$query = $this->m_masuk->get_data_masuk_detail($id_trans_masuk);

		$data = array(
			'title' => 'Laporan Penerimaan Produk',
			'hasil_header' => $query_header,
			'hasil_data' => $query, 
		);

	    $html = $this->load->view('view_surat_tanda_terima', $data, true);
	    
	    $filename = 'tanda_terima'.$id_trans_masuk.'_'.time();
	    $this->pdf_gen->generate($html, $filename, true, 'A4', 'portrait');
	}

	public function suggest_size_prevcost()
	{
		$id_prod = $this->input->post('idProduk');
		$data = array(
			'size' => $this->m_masuk->lookup_data_size($id_prod),
			'cost' => $this->m_masuk->lookup_last_beli($id_prod), 
		);

		echo json_encode($data);
	}

	public function suggest_idstok()
	{
		$size = $this->input->post('nmSize');
		$id_prod = $this->input->post('idProd');
		$data = $this->m_masuk->lookup_id_stok($size, $id_prod); 

		echo json_encode($data);
	}

	public function delete_penerimaan_produk($id)
	{
		$id_trans_order = $this->m_masuk->get_id_trans_order($id);
		$nilai = array(
               'status_masuk' => '0',
        );
		$this->m_masuk->update_data_status_masuk(array('id_trans_order' => $id_trans_order), $nilai);

		$this->m_masuk->delete_data_terima_produk($id);
		echo json_encode(array(
			"status" => TRUE,
			"pesan" => 'Data Penerimaan Produk No.'.$id.' Berhasil dihapus'
		));
	}

	public function get_header_form_masuk()
	{
		$data = array(
			'kode_trans_masuk'=> $this->m_masuk->get_kode_terima_produk(),
			'kode_po'=> $this->m_masuk->get_kode_po(),
		);

		echo json_encode($data);
	}

	public function suggest_produk()
	{
		$q = strtolower($_GET['term']);
		$query = $this->m_masuk->lookup_produk($q);
		foreach ($query as $row) {
			$produk[] = array(
						'label' => $row->nama_produk,
						'id_produk' => $row->id_produk,
						'nama_satuan' => $row->nama_satuan,
						'id_satuan' => $row->id_satuan,
						'harga' => $row->harga
					);
		}

		echo json_encode($produk);
	}

	public function get_data_barang($rowIdBrg)
	{
		$query = $this->m_masuk->lookup2($rowIdBrg);
		echo json_encode($query);
	}

}