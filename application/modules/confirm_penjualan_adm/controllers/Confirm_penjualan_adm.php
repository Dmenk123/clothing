<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Confirm_penjualan_adm extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('email'); // untuk kirim email
		$this->load->model('dashboard_adm/Mod_dashboard_adm','m_dasbor');
		$this->load->model('Mod_confirm_penjualan_adm','m_cfrm');
		$this->load->model('m_global');
		//cek sudah login apa tidak
		if ($this->session->userdata('logged_in') != true) {
			redirect('home/error_404');
		}

		//pesan stok minimum
		/* $produk = $this->m_dasbor->get_produk();
		$link_notif = site_url('laporan_stok');
		foreach ($produk as $val) {
			if ($val->stok_sisa <= $val->stok_minimum) {
				$this->session->set_flashdata('cek_stok', 'Terdapat Stok produk dibawah nilai minimum, Mohon di cek ulang <a href="'.$link_notif.'">disini</a>');
			}
		} */
	}

	public function index()
	{
		$id_user = $this->session->userdata('id_user'); 
		$data_user = $this->m_dasbor->get_data_user($id_user);

		// $jumlah_notif = $this->m_dasbor->email_notif_count($id_user);  //menghitung jumlah email masuk
		// $notif = $this->m_dasbor->get_email_notif($id_user); //menampilkan isi email

		$data = array(
			'content' => 'view_list_confirm_penjualan_adm',
			'modal' => 'modalConfirmPenjualanAdm',
			'css' => 'cssConfirmPenjualanAdm',
			'js' => 'jsConfirmPenjualanAdm',
			'data_user' => $data_user,
			// 'qty_notif' => $jumlah_notif,
			// 'isi_notif' => $notif,
		);
		$this->load->view('temp_adm',$data);
	}

	public function list_penjualan()
	{
		$list = $this->m_cfrm->get_datatable_penjualan();
		$data = array();
		$no =$_POST['start'];
		foreach ($list as $datalist) {
			$link_detail = site_url('confirm_penjualan_adm/confirm_penjualan_detail/').$datalist->id_checkout;
			$no++;
			$row = array();

			//loop value tabel db
			$row[] = $datalist->order_id;
			$row[] = $datalist->tgl_checkout;
			$row[] = $datalist->metode;
			$row[] = $datalist->nama;
			$row[] = $datalist->alamat;
			$row[] = number_format($datalist->ongkos_kirim,0,",",".");
			$row[] = number_format($datalist->ongkos_total,0,",",".");
			
			//add html for action button
			$row[] = '<a class="btn btn-sm btn-success" href="'.$link_detail.'" title="Penjualan Detail" id="btn_detail"><i class="glyphicon glyphicon-info-sign"></i> Detail</a>';
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

	public function confirm_penjualan_detail()
	{
		$id_user = $this->session->userdata('id_user'); 
		$data_user = $this->m_dasbor->get_data_user($id_user);

		// $jumlah_notif = $this->m_dasbor->email_notif_count($id_user);  //menghitung jumlah email masuk
		// $notif = $this->m_dasbor->get_email_notif($id_user); //menampilkan isi email

		$id_checkout = $this->uri->segment(3);
		$query_header = $this->m_cfrm->get_data_penjualan_header($id_checkout);
		$query_data = $this->m_cfrm->get_data_penjualan_detail($id_checkout);

		
		// echo "<pre>";
		// print_r ($query_header);
		// echo "</pre>";

		// echo "<pre>";
		// print_r ($query_data);
		// echo "</pre>";
		// exit;

		$data = array(
			'content'=>'view_confirm_penjualan_detail',
			'modal'=>'modalConfirmPenjualanAdm',
			'css'=>'cssConfirmPenjualanAdm',
			'js'=>'jsConfirmPenjualanAdm',
			'data_user' => $data_user,
			// 'qty_notif' => $jumlah_notif,
			// 'isi_notif' => $notif,
			'hasil_header' => $query_header,
			'hasil_data' => $query_data,
		);
		$this->load->view('temp_adm',$data);
	}

	public function get_konfirmasi_penjualan($id)
	{
		$data_header = $this->m_cfrm->get_data_penjualan_header($id);
		$txt_email = "<p>Kepada Yth.</p>";
		$txt_email .= "<ul>";
		$txt_email .= "<li>Nama : $data_header->nama</li>";
		$txt_email .= "<li>Alamat : ".$data_header->alamat." ".$data_header->kota_asal_txt."</li>";
		$txt_email .= "<li>Email : $data_header->email</li>";
		$txt_email .= "</ul>";
		$txt_email .= "<p>Terima kasih telah menyelesaikan pembayaran. Berikut Kode Resi Anda.</p>";
		$txt_email .= "<ul>";
		$txt_email .= "<li><strong>Kode Resi : XXX-XXX-XXX </strong></li>";
		$txt_email .= "</ul>";
		//$txt_email .= "<p> Salam Sukses (Crazy Property Tycoon)</p>";

		$data = array(
			'data_header' => $data_header,
			'txt_email' => $txt_email
		);
		echo json_encode($data);
	}
	////////////////////////////////////////////////////////////////////////////////////////////////

	

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

	public function konfirmasi_penjualan()
	{	
		$order_id = $this->input->post('fieldOrderId');
		$nama = $this->input->post('fieldNama');
		$email = $this->input->post('fieldEmail');
		$subjek = $this->input->post('subjekEmail');
		$txt_email = $this->input->post('pesanEmail');
		
		//data input array
		$data_input = array(
			'status' => "3",
			'tgl_confirm_adm' => date('Y-m-d'),
		);
		
		//update tbl_pembelian
		$this->m_cfrm->update_data_konfirmasi(['order_id' => $order_id], $data_input); 

		// kirim email manual
		$data_ckt = $this->m_global->single_row('*', ['order_id' => $order_id], 'tbl_checkout');
		$email_manual = $this->kirim_email_manual($data_ckt, $subjek, $txt_email);

		echo json_encode(array(
			"status" => TRUE,
			"pesan" => 'Data Telah berhasil dikonfirmasi'
		));
	}

	public function kirim_email_manual($data_ckt, $subjek, $txt_email)
	{
		$obj_date = new DateTime();
		$timestamp = $obj_date->format('Y-m-d H:i:s');
		// $arr_valid = $this->rule_validasi();
		
		$nama = $data_ckt->nama;
		$email = $data_ckt->email;
		$subjek = $subjek;
		$pesan_email = $txt_email;
		
		$this->db->trans_begin();

		$send_email = $this->send_email(trim($email), trim($subjek), $txt_email);
		// if($send_email){
		// 	$data_mail['isi_email'] = $pesan_email;
		// 	$data_mail['created_at'] = $timestamp;
		// 	$insert = $this->m_global->store($data_mail, 't_email');
		// }
		
		// if ($this->db->trans_status() === FALSE){
		// 	$this->db->trans_rollback();
		// 	$retval['status'] = false;
		// 	$retval['pesan'] = 'Gagal Kirim Email';
		// 	$dataret['err'] = TRUE;
		// }else{
		// 	$this->db->trans_commit();
		// 	$retval['status'] = true;
		// 	$retval['pesan'] = 'Sukses Kirim Email';
		// 	$dataret['err'] = FALSE;
		// }

		if($send_email){
			return true;
		}else{
			return false;
		}
	}

	public function send_email($receiver_email, $subject, $message)
	{
		// Storing submitted values
		$sender_email = 'admin@crazypropertytycoon.com';
		$user_password = 'admin@crazypropertytycoon.com';
		$username = 'admin@crazypropertytycoon.com';

		// Configure email library
		$config['protocol'] = 'http';
		$config['smtp_host'] = 'mx1.hostinger.in';
		$config['smtp_timeout'] = '7';
		$config['smtp_port'] = 110;
		$config['charset']    = 'utf-8';
		$config['newline']    = "\r\n";
		$config['mailtype'] = 'text'; // or html
		//$config['validation'] = TRUE; // bool whether to validate email or not
		$config['smtp_user'] = $sender_email;
		$config['smtp_pass'] = $user_password;

		// Load email library and passing configured values to email library
		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");

		// Sender email address
		$this->email->from($sender_email, $username);
		// Receiver email address
		$this->email->to($receiver_email);
		// Subject of email
		$this->email->subject($subject);
		// Message in email
		$this->email->message($message);

		if ($this->email->send()) {
			return TRUE;
		} else {
			return FALSE;
		}
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
