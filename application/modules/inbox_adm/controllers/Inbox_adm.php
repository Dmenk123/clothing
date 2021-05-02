<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inbox_adm extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('email'); // untuk kirim email
		$this->load->library('upload'); // untuk attachment
		$this->load->model('dashboard_adm/Mod_dashboard_adm','m_dasbor');
		$this->load->model('pesan_adm/Mod_pesan_adm','m_psn');
		$this->load->model('Mod_inbox_adm','m_ibx');
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
		foreach ($produk as $val) {
			if ($val->stok_sisa <= $val->stok_minimum) {
				$this->session->set_flashdata('cek_stok', 'Terdapat Stok produk dibawah nilai minimum, Mohon di cek ulang / melakukan permintaan');
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
			'content'=>'view_list_inbox_adm',
			'modal'=>'modalInboxAdm',
			'js'=>'inboxAdmJs',
			'data_user' => $data_user,
			'qty_notif' => $jumlah_notif,
			'isi_notif' => $notif,
		);
		$this->load->view('temp_adm',$data);
	}

	public function inbox_list()
	{
		//membuat format data json untuk ajax		
		$data = array();
		$no =$_POST['start'];
		$list = $this->m_ibx->get_datatable_inbox();
		foreach ($list as $listInbox) {
			$no++;
			$row = array();
			//loop value tabel db
			$row[] = $no;
			$row[] = $listInbox->fname_pesan." ".$listInbox->lname_pesan;
			$row[] = $listInbox->email_pesan;
			$row[] = $listInbox->subject_pesan;
			$row[] = $listInbox->isi_pesan;
			$row[] = $listInbox->dt_kirim;
			//add html for action
			$row[] = 
				'<a class="btn btn-sm btn-default" href="javascript:void(0)" title="Detail" onclick="detailInbox('."'".$listInbox->id_pesan."'".')"><i class="glyphicon glyphicon-search"></i> Detail</a>
				<a class="btn btn-sm btn-success" href="javascript:void(0)" title="Balas" onclick="replyInbox('."'".$listInbox->id_pesan."'".')"><i class="glyphicon glyphicon-pencil"></i> Reply</a>
				 <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="deleteInbox('."'".$listInbox->id_pesan."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';

			$data[] = $row;
		}//end loop
		$output = array(
					"draw" => $_POST['draw'],
					"recordsTotal" => $this->m_ibx->count_inbox_all(),
					"recordsFiltered" => $this->m_ibx->count_inbox_filtered(),
					"data" => $data,
				);
		
		//output to json format
		echo json_encode($output);
	}

	public function detail_pesan_masuk($id)
	{
		$data = $this->m_ibx->get_detail_pesan_masuk($id);
		echo json_encode($data);
	}

	public function email_konfigurasi()
	{
		$nama_dpn = $this->input->post('fnameReply');
		$nama_blkg = $this->input->post('lnameReply');
		$nama_lengkap = $nama_dpn." ".$nama_blkg;

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
		$htmlContent .= '<p><strong>Kepada Yth Sdr : '.$nama_lengkap.'</strong></p>';
		$htmlContent .= '<p>Terima Kasih telah memberi masukkan pada kami</p>';
		$htmlContent .= '<p>'.$this->input->post('isiReply').'.</p>';

		$this->email->to(trim($this->input->post('emailReply')));
		$this->email->from("slebzt@gmail.com", 'Dmenk Clothing E-shop'); 
		$this->email->subject(trim($this->input->post('subjectReply'))); 
		$this->email->message($htmlContent);
	}

	public function add_reply_pesan()
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

		if(isset($_FILES['attachReply'])) 
		{
			if ($this->upload->do_upload('attachReply')) //jika upload attachment
			{
				//save upload data in variable
				$upload_data = $this->upload->data();
				//call email config
				$this->email_konfigurasi();
				//add attachment pada konfigurasi email
				$this->email->attach($upload_data['full_path']);
		        //send email
		        if($this->email->send()) 
		        {
		        	$data = array(			
						'id_user' => $this->input->post('idUser'),
						'id_pesan' => $this->input->post('id'),
						'email_reply' => $this->input->post('emailReply'),
						'subject_reply' => trim($this->input->post('subjectReply')),
						'isi_reply' => trim($this->input->post('isiReply')),
						'dt_reply' => $initiated_date,
						'attachment' => $upload_data['file_name'],
					);

		        	//save to db
		        	$insert = $this->m_psn->save_data_pesan_keluar($data);
		        	//update status tbl pesan 1 to 0
		        	$input_update = array(
		        		'status' => '0', 
		        	);
		        	$this->m_ibx->update_data_pesan(array('id_pesan' => $this->input->post('id')), $input_update);

		        	echo json_encode(array(
						"status" => TRUE,
						"pesan" => 'Pesan berhasil dikirim ke email w/ attachment',
					));
		        }
			}
			else //tanpa upload attachment
			{
				//call email config
				$this->email_konfigurasi();
		        //send email
		        if($this->email->send()) 
		        {
		        	$data = array(			
						'id_user' => $this->input->post('idUser'),
						'id_pesan' => $this->input->post('id'),
						'email_reply' => $this->input->post('emailReply'),
						'subject_reply' => trim($this->input->post('subjectReply')),
						'isi_reply' => trim($this->input->post('isiReply')),
						'dt_reply' => $initiated_date,
					);
		        	//save to db
		        	$insert = $this->m_psn->save_data_pesan_keluar($data);
		        	//update status tbl pesan 1 to 0
		        	$input_update = array(
		        		'status' => '0', 
		        	);
		        	$this->m_ibx->update_data_pesan(array('id_pesan' => $this->input->post('id')), $input_update);
		        	echo json_encode(array(
						"status" => TRUE,
						"pesan" => 'Pesan berhasil dikirim ke email w/o attachment',
					));
		        }//end if send
			}//end if do_upload
		}//end if file isset
	}

	public function load_email_row_notif()
	{ //fungsi load_row untuk menampilkan jlh data pada navbar secara realtime
        echo $this->m_ibx->notif_email_count(); //jumlah data akan langsung di tampilkan
    }
 
    public function load_email_data_notif()
    { //fungsi load_data untuk menampilkan isi data pada navbar secara realtime
        $data = $this->m_ibx->get_notifikasi_email();
        $no = 0;
        if (count($data) > 0 ) {
        	foreach($data as $rdata) { 
	        	$no++;
	            if($no % 2 == 0) {
	            	$strip='strip1';
	            }else{
	            	$strip='strip2';
	            }
	            echo"<li><a href=\"#\" class=\"".$strip." linkNotif\" id=\"".$rdata->id_pesan."\">".$rdata->subject_pesan."<br>
	            <small><strong>".$rdata->email_pesan."</strong>  (".timeAgo($rdata->time_post).")</small>
	            </a><li>";
	        }
        }
    }

    public function update_read_email($id)
	{
		$initiated_date = date('Y-m-d H:i:s');
		$data = array(
				'dt_read' => $initiated_date,
			);
		$this->m_ibx->update_dtread_pesan(array('id_pesan' => $id), $data);
		echo json_encode(array(
			"status" => TRUE
			));
	}

	public function delete_inbox($id)
	{
		$this->m_ibx->delete_data_inbox($id);
		echo json_encode(array(
			"pesan" => "Data kotak masuk berhasil dihapus",
			"status" => TRUE
		));
	}
}
