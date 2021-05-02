<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_produk_adm extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('dashboard_adm/Mod_dashboard_adm','m_dasbor');
		$this->load->model('Mod_order_produk_adm','m_order');
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
			'content'=>'view_list_order_produk_adm',
			'modal'=>'modalOrderProdukAdm',
			'css'=>'cssOrderProdukAdm',
			'js'=>'jsOrderProdukAdm',
			'data_user' => $data_user,
			'qty_notif' => $jumlah_notif,
			'isi_notif' => $notif,
		);
		$this->load->view('temp_adm',$data);
	}

	public function list_order_produk()
	{
		$list = $this->m_order->get_datatable_order();
		$data = array();
		$no =$_POST['start'];
		foreach ($list as $listOrderProduk) {
			$link_detail = site_url('order_produk_adm/order_produk_detail/').$listOrderProduk->id_trans_order;
			$no++;
			$row = array();
			//loop value tabel db
			$row[] = $listOrderProduk->id_trans_order;
			$row[] = $listOrderProduk->fname_user." ".$listOrderProduk->lname_user;
			$row[] = $listOrderProduk->nama_supplier;
			$row[] = $listOrderProduk->tgl_trans_order;
			//add html for action button
			if ($listOrderProduk->jml > 0) {
				$row[] = 
				'<a class="btn btn-sm btn-success" href="'.$link_detail.'" title="Order Detail" id="btn_detail" onclick=""><i class="glyphicon glyphicon-info-sign"></i> '.$listOrderProduk->jml.' Items</a>
 				 <a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="editOrderProduk('."'".$listOrderProduk->id_trans_order."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				 <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="deleteOrderProduk('."'".$listOrderProduk->id_trans_order."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
			}else{
				$row[] = null;
			}
			
			$data[] = $row;
		}//end loop

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->m_order->count_all(),
						"recordsFiltered" => $this->m_order->count_filtered(),
						"data" => $data,
					);
		//output to json format
		echo json_encode($output);
	}

	public function order_produk_detail()
	{
		$id_user = $this->session->userdata('id_user'); 
		$data_user = $this->m_dasbor->get_data_user($id_user);

		$jumlah_notif = $this->m_dasbor->email_notif_count($id_user);  //menghitung jumlah email masuk
		$notif = $this->m_dasbor->get_email_notif($id_user); //menampilkan isi email

		$id_trans_order = $this->uri->segment(3);
		$query_header = $this->m_order->get_data_order_header($id_trans_order);
		$query_data = $this->m_order->get_data_order_detail($id_trans_order);

		$data = array(
			'content'=>'view_detail_order_produk_adm',
			'modal'=>'modalOrderProdukAdm',
			'css'=>'cssOrderProdukAdm',
			'js'=>'jsOrderProdukAdm',
			'data_user' => $data_user,
			'qty_notif' => $jumlah_notif,
			'isi_notif' => $notif,
			'hasil_header' => $query_header,
			'hasil_data' => $query_data,
		);
		$this->load->view('temp_adm',$data);
	}

	public function cetak_report_order_detail()
	{
		$this->load->library('Pdf_gen');

		$id_trans_order = $this->uri->segment(3);
		$query_header = $this->m_order->get_data_order_header($id_trans_order);
		$query = $this->m_order->get_data_order_detail($id_trans_order);

		$data = array(
			'title' => 'Laporan Order Produk',
			'hasil_header' => $query_header,
			'hasil_data' => $query, 
			);

	    $html = $this->load->view('view_detail_order_produk_report', $data, true);
	    
	    $filename = 'laporan_permintaan_'.$id_trans_order.'_'.time();
	    $this->pdf_gen->generate($html, $filename, true, 'A4', 'portrait');
	}

	public function cetak_surat_pembelian()
	{
		$this->load->library('Pdf_gen');

		$id_trans_order = $this->uri->segment(3);
		$query_header = $this->m_order->get_data_order_header($id_trans_order);
		$query = $this->m_order->get_data_order_detail($id_trans_order);

		$data = array(
			'title' => 'Laporan Order Produk',
			'hasil_header' => $query_header,
			'hasil_data' => $query, 
			);

	    $html = $this->load->view('view_surat_pembelian', $data, true);
	    
	    $filename = 'PO_'.$id_trans_order.'_'.time();
	    $this->pdf_gen->generate($html, $filename, true, 'A4', 'portrait');
	}

	public function edit_order_produk($id)
	{
		$data = array(
			'data_header' => $this->m_order->get_data_order_header($id),
			'data_isi' => $this->m_order->get_data_order_detail($id),
		);
		echo json_encode($data);
	}

	public function add_order_produk()
	{
		$timestamp = date('Y-m-d H:i:s');
		//for table trans_order
		$data_order = array(			
				'id_trans_order' => $this->input->post('fieldIdOrder'),
				'id_user' => $this->input->post('fieldIdUserOrder'),
				'id_supplier' => $this->input->post('fieldSupplier'),
				'tgl_trans_order' => date("Y-m-d"),
				'timestamp' => $timestamp, 
			);

		//for table trans_order_detail
		$hitung = count($this->input->post('fieldIdProdukOrder'));
		$data_order_detail = array();
		for ($i=0; $i < $hitung; $i++) 
		{
			$data_order_detail[$i] = array(
				'id_trans_order' => $this->input->post('fieldIdOrder'),
				'id_produk' => $this->input->post('fieldIdProdukOrder')[$i],
				'id_satuan' => $this->input->post('fieldIdSatuanOrder')[$i],
				'id_stok' => $this->input->post('fieldIdStokOrder')[$i],
				'ukuran' => $this->input->post('fieldSizeProdukOrder')[$i],
				'qty' => $this->input->post('fieldJumlahProdukOrder')[$i],
				'harga_prev_beli' => $this->input->post('fieldHargaPrevOrder')[$i],
				'harga_satuan_beli' => $this->input->post('fieldHargaSatOrder')[$i],
				'harga_total_beli' => $this->input->post('fieldHargaTotOrder')[$i],
				'timestamp' => $timestamp, 
			);
		}
						
		$insert = $this->m_order->simpan_data_order($data_order, $data_order_detail);

		//update tbl_stok u/ isi harga_satuan
		$data_harga = array();
			for ($i=0; $i < $hitung; $i++) 
			{
				$data_harga[$i] = array(
					'id_stok' => $this->input->post('fieldIdStokOrder')[$i],
					'harga_satuan' => $this->input->post('fieldHargaSatOrder')[$i],
				);
			}

		$this->db->update_batch('tbl_stok',$data_harga,'id_stok');

		echo json_encode(array(
			"status" => TRUE,
			"pesan" => 'Data Transaksi Order Produk Berhasil ditambahkan'
		));
	}

	public function suggest_size_prevcost()
	{
		$id_prod = $this->input->post('idProduk');
		$data = array(
			'size' => $this->m_order->lookup_data_size($id_prod),
			'cost' => $this->m_order->lookup_last_beli($id_prod), 
		);

		echo json_encode($data);
	}

	public function suggest_idstok()
	{
		$size = $this->input->post('nmSize');
		$id_prod = $this->input->post('idProd');
		$data = $this->m_order->lookup_id_stok($size, $id_prod); 

		echo json_encode($data);
	}

	public function update_order_produk()
	{
		//delete id order in tabel detail
		$id = $this->input->post('fieldIdOrder');
		$timestamp = date('Y-m-d H:i:s');
		$hapus_data_order_detail = $this->m_order->hapus_data_order_detail($id);

		//update header
		$data_header = array(
			'timestamp' => $timestamp,
			'id_supplier' => $this->input->post('fieldSupplier'),
		); 
		$this->m_order->update_data_header_order_detail(array('id_trans_order' => $id), $data_header);

		//proses insert ke tabel detail
		$hitung_detail = count($this->input->post('fieldIdProdukOrder'));
		$data_order_detail = array();
			for ($i=0; $i < $hitung_detail; $i++) 
			{
			$data_order_detail[$i] = array(
					'id_trans_order' => $this->input->post('fieldIdOrder'),
					'id_produk' => $this->input->post('fieldIdProdukOrder')[$i],
					'id_satuan' => $this->input->post('fieldIdSatuanOrder')[$i],
					'id_stok' => $this->input->post('fieldIdStokOrder')[$i],
					'ukuran' => $this->input->post('fieldSizeProdukOrder')[$i],
					'qty' => $this->input->post('fieldJumlahProdukOrder')[$i],
					'harga_prev_beli' => $this->input->post('fieldHargaPrevOrder')[$i],
					'harga_satuan_beli' => $this->input->post('fieldHargaSatOrder')[$i],
					'harga_total_beli' => $this->input->post('fieldHargaTotOrder')[$i],
					'timestamp' => $timestamp, 
				);
			}

		$insert_update = $this->m_order->insert_update_order($data_order_detail);

		//update tbl_stok u/ isi harga_satuan
		$data_harga = array();
			for ($i=0; $i < $hitung_detail; $i++) 
			{
				$data_harga[$i] = array(
					'id_stok' => $this->input->post('fieldIdStokOrder')[$i],
					'harga_satuan' => $this->input->post('fieldHargaSatOrder')[$i],
				);
			}

		$this->db->update_batch('tbl_stok',$data_harga,'id_stok');

		echo json_encode(array(
			"status" => TRUE,
			"pesan" => 'Data Transaksi Order Produk Berhasil diupdate'
		));
	}

	public function delete_order_produk($id)
	{
		$this->m_order->delete_data_order_produk($id);
		echo json_encode(array(
			"status" => TRUE,
			"pesan" => 'Data Transaksi Order Barang No.'.$id.' Berhasil dihapus'
		));
	}

	public function get_header_form_order()
	{
		$data = array(
			'kode_trans_order'=> $this->m_order->get_kode_order_produk(),
		);

		echo json_encode($data);
	}

	public function suggest_produk()
	{
		$q = strtolower($_GET['term']);
		$query = $this->m_order->lookup_produk($q);
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
		$query = $this->m_order->lookup2($rowIdBrg);
		echo json_encode($query);
	}

}