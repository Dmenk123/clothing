<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Confirm_penjualan_adm extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('email'); // untuk kirim email
		$this->load->model('dashboard_adm/Mod_dashboard_adm','m_dasbor');
		$this->load->model('Mod_confirm_penjualan_adm','m_cfrm');
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
			'content'=>'view_list_confirm_penjualan_adm',
			'modal'=>'modalConfirmPenjualanAdm',
			'css'=>'cssConfirmPenjualanAdm',
			'js'=>'jsConfirmPenjualanAdm',
			'data_user' => $data_user,
			'qty_notif' => $jumlah_notif,
			'isi_notif' => $notif,
		);
		$this->load->view('temp_adm',$data);
	}

	public function list_penjualan()
	{
		$list = $this->m_cfrm->get_datatable_penjualan();
		$data = array();
		$no =$_POST['start'];
		foreach ($list as $listPenjualan) {
			$link_detail = site_url('confirm_penjualan_adm/confirm_penjualan_detail/').$listPenjualan->id_pembelian;
			$no++;
			$row = array();
			//loop value tabel db
			$row[] = $listPenjualan->id_pembelian;
			$row[] = $listPenjualan->fname_user." ".$listPenjualan->lname_user;
			$row[] = $listPenjualan->fname_kirim." ".$listPenjualan->lname_kirim;
			$row[] = $listPenjualan->method_checkout;
			$row[] = $listPenjualan->alamat_kirim;
			$row[] = number_format($listPenjualan->ongkos_total,0,",",".");
			$row[] = $listPenjualan->kode_ref;
			if ($listPenjualan->status_confirm_adm == '0') {
				$row[] = "<span style='color: red;'>Belum Dikonfirmasi</span>";
			}elseif ($listPenjualan->status_confirm_adm == '1'){
				$row[] = "Sudah Dikonfirmasi";
			}else{
				$row[] = "<span style='color: red;'><strong>Dibatalkan</strong></span>";
			}
			//add html for action button
			if ($listPenjualan->jml > 0) {
				if ($listPenjualan->status_confirm_adm != '2') {
					$row[] = 
					'<a class="btn btn-sm btn-default" href="'.$link_detail.'" title="Penjualan Detail" id="btn_detail"><i class="glyphicon glyphicon-info-sign"></i> '.$listPenjualan->jml.' Items</a>
					 <a class="btn btn-sm btn-success btn_edit_status" href="javascript:void(0)" title="Aktif" id="'.$listPenjualan->id_pembelian.'"><i class="fa fa-check"></i> Aktif</a>';
				}else{
					$row[] = 
					'<a class="btn btn-sm btn-default" href="'.$link_detail.'" title="Penjualan Detail" id="btn_detail"><i class="glyphicon glyphicon-info-sign"></i> '.$listPenjualan->jml.' Items</a>
					 <a class="btn btn-sm btn-danger btn_edit_status" href="javascript:void(0)" title="Batal" id="'.$listPenjualan->id_pembelian.'"><i class="fa fa-times"></i> Batal</a>';
				}
			}
			else
			{
				$row[] = null;
			}

			$data[] = $row;
		}//end loop

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->m_cfrm->count_all_penjualan(),
						"recordsFiltered" => $this->m_cfrm->count_filtered_penjualan(),
						"data" => $data,
					);
		//output to json format
		echo json_encode($output);
	}

	public function get_konfirmasi_penjualan($id)
	{
		$data = array(
			'data_header' => $this->m_cfrm->get_data_penjualan_header($id),
		);
		echo json_encode($data);
	}

	public function konfigurasi_upload_bukti($nmfile)
	{ 
		//konfigurasi upload img display
		$config['upload_path'] = './assets/img/bukti_konfirmasi/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
		$config['overwrite'] = TRUE;
		$config['max_size'] = '4000';//in KB (4MB)
		$config['max_width']  = '0';//zero for no limit 
		$config['max_height']  = '0';//zero for no limit
		$config['file_name'] = $nmfile;
		//load library with custom object name alias
		$this->load->library('upload', $config, 'gbr_bukti');
		$this->gbr_bukti->initialize($config);
	}

	public function konfigurasi_email($userEmail)
	{
		//SMTP & mail configuration
		$config = array(
			'protocol'  => 'smtp',
			'smtp_host' => 'ssl://smtp.googlemail.com',
			'smtp_port' => 465,
			'smtp_user' => 'slebzt@gmail.com',
			'smtp_pass' => 'as123456as',
			'mailtype'  => 'html',
			'charset'   => 'utf-8'
		);
		
		$this->email->initialize($config);
		$this->email->set_mailtype("html");
		$this->email->set_newline("\r\n");

		//Email content
		$htmlContent = '<h2>Dmenk Clothing E-shop</h2>';
		$htmlContent .= '<p>Terima Kasih kepada : '.trim($userEmail).' yang telah memilih berbelanja pada kami</p>';
		$htmlContent .= '<p>Berikut Merupakan Bukti Bahwa barang telah kami kirimkan, gambar yang kami kirimkan berupa gambar hasil scan dari Resi pengiriman Ekspedisi</p>';
		$htmlContent .= '<p>Kami Tunggu Kunjungan anda kembali, Terima kasih :D </p>';

		$this->email->to(trim($userEmail));
		$this->email->from("slebzt@gmail.com", 'Dmenk Clothing E-shop'); 
		$this->email->subject(trim('Konfirmasi Pembelian')); 
		$this->email->message($htmlContent);
	}

	public function konfigurasi_image_bukti($filename)
	{
		//konfigurasi image lib
	    $config['image_library'] = 'gd2';
	    $config['source_image'] = './assets/img/bukti_konfirmasi/'.$filename;
	    $config['create_thumb'] = FALSE;
	    $config['maintain_ratio'] = FALSE;
	    $config['new_image'] = './assets/img/bukti_konfirmasi/'.$filename;
	    $config['overwrite'] = TRUE;
	    $config['width'] = 600; //resize
	    $config['height'] = 500; //resize
	    $this->load->library('image_lib',$config); //load image library
	    $this->image_lib->initialize($config);
	    $this->image_lib->resize();
	}

	public function konfirmasi_penjualan($idBeli)
	{	
		//replace space with dash
		$nmfile = str_replace(" ", "-", strtolower(trim("bukti transfer ".$this->input->post('fieldIdBeli'))));
		//load konfig upload
		$this->konfigurasi_upload_bukti($nmfile);
		//jika melakukan upload foto
		if ($this->gbr_bukti->do_upload('buktiConfirm')) 
		{
			$gbrBukti = $this->gbr_bukti->data();
			//inisiasi variabel u/ digunakan pada fungsi config img bukti
			$nama_file_bukti = $gbrBukti['file_name'];
			//call email config 
			$this->konfigurasi_email($this->input->post('fieldEmailCustomer'));
			//add attachment pada konfigurasi email
			$this->email->attach($gbrBukti['full_path']);
		    //send email
		    $this->email->send();
		    //load config img bukti
		    $this->konfigurasi_image_bukti($nama_file_bukti);
	        //data input array
			$data_input = array(
				'status_confirm_adm' => "1",
				'tgl_confirm_adm' => date('Y-m-d'),
				'bconfirm_adm' => $gbrBukti['file_name'], 
			);
			//clear img lib after resize
			$this->image_lib->clear();
			//update tbl_pembelian
			$this->m_cfrm->update_data_konfirmasi(array('id_pembelian' => $this->input->post('fieldIdBeli')), $data_input);
			//insert tbl log
			$data_log = array(
				'keterangan' => 'Insert data konfirmasi ke tabel pembelian, id_user = '.$this->input->post('fieldIdUser'),
				'datetime' => date('Y-m-d H:i:s'),
				'id_user' => $this->input->post('fieldIdUser'),
				'data_baru' => $nmfile
			);
			$this->m_cfrm->tambah_datalog_konfirmasi($data_log);
		} //end 

		echo json_encode(array(
			"status" => TRUE,
			"pesan" => 'Data Telah berhasil dikonfirmasi'
		));
	}

	public function edit_status_penjualan($id)
	{
		$input_status = $this->input->post('status');
		// jika aktif maka di set ke Batal / "0"
		if ($input_status == " Aktif") {
			$status = '2';
			$psn_txt = "Penjualan dengan kode ".$id." dinonaktifkan.";
			$data_lama = '0';
			$data_baru = '2';
		} elseif ($input_status == " Batal") {
			$status = '0';
			$psn_txt = "Penjualan dengan kode ".$id." diaktifkan kembali.";
			$data_lama = '2';
			$data_baru = '0';
		}
		
		$input = array(
			'status_confirm_adm' => $status 
		);

		$this->m_cfrm->update_status_penjualan(array('id_pembelian' => $id), $input);

		//insert tbl log
		$data_log = array(
			'keterangan' => 'Update status tabel pembelian, id = '.$id,
			'datetime' => date('Y-m-d H:i:s'),
			'id_user' => $this->session->userdata('id_user'),
			'data_lama' => 'status_confirm_adm = '.$data_lama,
			'data_baru' => 'status_confirm_adm = '.$data_baru
		);
		$this->m_cfrm->tambah_datalog_konfirmasi($data_log);

		$data = array(
			'status' => TRUE,
			'pesan' => $psn_txt,
		);
		echo json_encode($data);
	}

	public function confirm_penjualan_detail()
	{
		$id_user = $this->session->userdata('id_user'); 
		$data_user = $this->m_dasbor->get_data_user($id_user);

		$jumlah_notif = $this->m_dasbor->email_notif_count($id_user);  //menghitung jumlah email masuk
		$notif = $this->m_dasbor->get_email_notif($id_user); //menampilkan isi email

		$id_pembelian = $this->uri->segment(3);
		$query_header = $this->m_cfrm->get_data_penjualan_header($id_pembelian);
		$id_checkout = $this->m_cfrm->get_data_id_checkout($id_pembelian);
		$query_data = $this->m_cfrm->get_data_penjualan_detail($id_checkout);

		$data = array(
			'content'=>'view_detail_confirm_penjualan_adm',
			'modal'=>'modalConfirmPenjualanAdm',
			'css'=>'cssConfirmPenjualanAdm',
			'js'=>'jsConfirmPenjualanAdm',
			'data_user' => $data_user,
			'qty_notif' => $jumlah_notif,
			'isi_notif' => $notif,
			'hasil_header' => $query_header,
			'hasil_data' => $query_data,
		);
		$this->load->view('temp_adm',$data);
	}

	public function cetak_nota_penjualan()
	{
		$this->load->library('Pdf_gen');

		$id_pembelian = $this->uri->segment(3);
		$query_header = $this->m_cfrm->get_data_penjualan_header($id_pembelian);
		//get id_checkout
		$id_checkout = $this->m_cfrm->get_data_id_checkout($id_pembelian);
		$query = $this->m_cfrm->get_data_penjualan_detail($id_checkout);

		$data = array(
			'title' => 'Nota Penjualan',
			'hasil_header' => $query_header,
			'hasil_data' => $query, 
		);

	    $html = $this->load->view('view_nota_penjualan', $data, true);
	    
	    $filename = 'nota_penjualan_'.$id_pembelian.'_'.time();
	    $this->pdf_gen->generate($html, $filename, true, 'A4', 'portrait');
	}

}