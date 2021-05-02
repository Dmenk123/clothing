<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pesan_adm extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('email'); // untuk kirim email
		$this->load->library('upload'); // untuk attachment
		$this->load->model('dashboard_adm/Mod_dashboard_adm','m_dasbor');
		$this->load->model('Mod_pesan_adm','m_psn');
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
		$data_user = $this->m_dasbor->get_data_user($id_user);

		$jumlah_notif = $this->m_dasbor->email_notif_count($id_user);  //menghitung jumlah email masuk
		$notif = $this->m_dasbor->get_email_notif($id_user); //menampilkan isi email
		
		$data = array(
			'content'=>'view_list_pesan_adm',
			'modal'=>'modalPesanAdm',
			'js'=>'pesanAdmJs',
			'data_user' => $data_user,
			'qty_notif' => $jumlah_notif,
			'isi_notif' => $notif,
		);
		$this->load->view('temp_adm',$data);
	}

	public function pesan_list()
	{
		//membuat format data json untuk ajax		
		$data = array();
		$no =$_POST['start'];
		$list = $this->m_psn->get_datatable_pesan();
		foreach ($list as $listPesan) {
			$no++;
			$row = array();
			//loop value tabel db
			$row[] = $no;
			$row[] = $listPesan->id_user;
			$row[] = $listPesan->email_reply;
			$row[] = $listPesan->subject_reply;
			$row[] = $listPesan->isi_reply;
			$row[] = $listPesan->dt_reply;
			//add html for action
			$row[] = 
				'<a class="btn btn-sm btn-default" href="javascript:void(0)" title="Detail" onclick="detailPesan('."'".$listPesan->id_reply."'".')"><i class="glyphicon glyphicon-search"></i> Detail</a>
				 <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="deletePesan('."'".$listPesan->id_reply."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';

			$data[] = $row;
		}//end loop
		$output = array(
					"draw" => $_POST['draw'],
					"recordsTotal" => $this->m_psn->count_pesan_all(),
					"recordsFiltered" => $this->m_psn->count_pesan_filtered(),
					"data" => $data,
				);
		
		//output to json format
		echo json_encode($output);
	}

	public function detail_pesan_keluar($id)
	{
		$data = $this->m_psn->get_detail_pesan_keluar($id);
		echo json_encode($data);
	}

	public function konfigurasi_email()
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
		$htmlContent .= '<p>Terima Kasih kepada : '.trim($this->input->post("emailPesan")).' telah memberi masukkan pada kami</p>';
		$htmlContent .= '<p>Berdasarkan masukkan yang telah anda sampaikan, Maka '.$this->input->post('isiPesan').'.</p>';

		$this->email->to(trim($this->input->post('emailPesan')));
		$this->email->from("slebzt@gmail.com", 'Dmenk Clothing E-shop'); 
		$this->email->subject(trim($this->input->post('subjectPesan'))); 
		$this->email->message($htmlContent);
	}

	public function add_pesan_keluar()
	{
		$initiated_date = date('Y-m-d H:i:s');
		
		//konfigurasi upload attachment
		$config['upload_path'] = './assets/upload/upload_data/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp|pdf|doc|docx|xls|xlsx|txt';
		$config['overwrite'] = TRUE;
		$config['max_size'] = '2048'; 
		// $config['max_width']  = '1288'; 
		// $config['max_height']  = '768';
		$config['encrypt_name'] = TRUE;// for encrypting the name
		$this->upload->initialize($config);

		if(isset($_FILES['attachPesan'])) 
		{
			if ($this->upload->do_upload('attachPesan')) //jika upload attachment
			{
				//save upload data in variable
				$upload_data = $this->upload->data();
				//call email config
				$this->konfigurasi_email();
				//add attachment pada konfigurasi email
				$this->email->attach($upload_data['full_path']);
		        //send email
		        if($this->email->send()) 
		        {
		        	$data = array(			
						'id_user' => $this->input->post('idUser'),
						'subject_reply' => trim($this->input->post('subjectPesan')),
						'email_reply' => $this->input->post('emailPesan'),
						'isi_reply' => trim($this->input->post('isiPesan')),
						'dt_reply' => $initiated_date,
						'attachment' => $upload_data['file_name'],
					);

		        	$insert = $this->m_psn->save_data_pesan_keluar($data);
		        	echo json_encode(array(
						"status" => TRUE,
						"pesan" => 'Pesan berhasil dikirim ke email w/ attachment',
					));
		        }
			}
			else //tanpa upload attachment
			{
				//call email config
				$this->konfigurasi_email();
		        //send email
		        if($this->email->send()) 
		        {
		        	$data = array(			
						'id_user' => $this->input->post('idUser'),
						'subject_reply' => trim($this->input->post('subjectPesan')),
						'email_reply' => $this->input->post('emailPesan'),
						'isi_reply' => trim($this->input->post('isiPesan')),
						'dt_reply' => $initiated_date,
					);

		        	$insert = $this->m_psn->save_data_pesan_keluar($data);
		        	echo json_encode(array(
						"status" => TRUE,
						"pesan" => 'Pesan berhasil dikirim ke email w/o attachment',
					));
		        }//end if send
			}//end if do_upload
		}//end if file isset
	}

	public function delete_pesan_keluar($id)
	{
		$this->m_psn->delete_data_pesan_keluar($id);
		echo json_encode(array(
			"status" => TRUE,
			"pesan" => 'Data Pesan Berhasil dihapus'
			));
	}

	

}
