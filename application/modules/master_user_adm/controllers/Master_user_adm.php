<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_user_adm extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('dashboard_adm/Mod_dashboard_adm','m_dasbor');
		$this->load->model('Mod_master_user_adm','m_user');
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
			'content'=>'view_list_master_user',
			'modal'=>'modalMasterUserAdm',
			'js'=>'masterUserAdmJs',
			'data_user' => $data_user,
			'qty_notif' => $jumlah_notif,
			'isi_notif' => $notif,
		);
		$this->load->view('temp_adm',$data);
	}

	public function list_user()
	{
		$id_level_user = $this->session->userdata('id_level_user');
		$list = $this->m_user->get_datatable_user($id_level_user);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $listUser) {
			$no++;
			$row = array();
			//loop value tabel db
			$row[] = $listUser->id_user;
			$row[] = $listUser->fname_user." ".$listUser->lname_user;
			$row[] = $listUser->email;
			$row[] = $listUser->password;
			$row[] = $listUser->nama_level_user;
			if ($listUser->status == '1') {
				$row[] = "aktif";	
			}else{
				$row[] = "nonaktif";
			}
			$row[] = $listUser->last_login;
			//add html for action button
			if ($listUser->status == '1') {
				$row[] =
				'<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_user('."'".$listUser->id_user."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				 <a class="btn btn-sm btn-success btn_edit_status" href="javascript:void(0)" title="aktif" id="'.$listUser->id_user.'"><i class="fa fa-times"></i> Aktif</a>';
				}else{
					$row[] =
				'<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_user('."'".$listUser->id_user."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				 <a class="btn btn-sm btn-danger btn_edit_status" href="javascript:void(0)" title="nonaktif" id="'.$listUser->id_user.'"><i class="fa fa-times"></i> Nonaktif</a>';
				}
				
			
			
			$data[] = $row;
		}//end loop

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->m_user->count_all($id_level_user),
						"recordsFiltered" => $this->m_user->count_filtered(),
						"data" => $data,
					);
		//output to json format
		echo json_encode($output);
	}

	public function edit_data_user($id)
	{
		$this->load->model('profil/mod_profil');
		$this->load->library('Enkripsi');
		$data = $this->mod_profil->get_data_profil($id);

		//decrypt password
		$pass_string = $data->password;
		$hasil_password = $this->enkripsi->decrypt($pass_string);
		// replace array value
		$data->password = $hasil_password;

		//change format date to indonesian format
		$tgl_lahir_string = $data->tgl_lahir_user;
		$tgl_lahir = date("d-m-Y", strtotime($tgl_lahir_string));
		// replace array value
		$data->tgl_lahir_user = $tgl_lahir;

		echo json_encode($data);
	}

	public function add_data_user()
	{
		$this->load->model('profil/mod_profil');
		$this->load->library('Enkripsi');
		$this->load->library('upload');

		$pass_string = $this->input->post('userPassword');
		$password = $this->enkripsi->encrypt($pass_string);

		$tgl_lahir_string = $this->input->post('userTgllhr');
		$tgl_lahir = date("Y-m-d", strtotime($tgl_lahir_string));
		$timestamp = date('Y-m-d H:i:s');
		$id_user = $this->mod_profil->getKodeUser();

		//konfigurasi upload img
		$nmfile = "img_".$id_user;
		$config['upload_path'] = './assets/img/foto_profil/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
		$config['overwrite'] = TRUE;
		$config['max_size'] = '2048'; 
		$config['max_width']  = '1288'; 
		$config['max_height']  = '768';
		$config['file_name'] = $nmfile;
		$this->upload->initialize($config);
		if(isset($_FILES['userFoto'])) 
		{
			//jika melakukan upload foto
			if ($this->upload->do_upload('userFoto')) 
		    {
		    	$gbr = $this->upload->data();
		        //konfigurasi image lib
	            $config['image_library'] = 'gd2';
	            $config['source_image'] = './assets/img/foto_profil/'.$gbr['file_name'];
	            $config['create_thumb'] = FALSE;
	            $config['maintain_ratio'] = FALSE;
	            $config['new_image'] = './assets/img/foto_profil/'.$gbr['file_name'];
	            $config['overwrite'] = TRUE;
	            $config['width'] = 250; //resize
	            $config['height'] = 250; //resize
	            $this->load->library('image_lib',$config); //load image library
	            $this->image_lib->initialize($config);
	            $this->image_lib->resize();

	            //data input array
				$input = array(
					'id_user' => $id_user,	
					'email' => trim($this->input->post('userEmail')),
					'password' => $password,
					'fname_user' => trim(strtoupper($this->input->post('userFname'))),
					'lname_user' => trim(strtoupper($this->input->post('userLname'))),
					'alamat_user' => trim(strtoupper($this->input->post('userAlamat'))),
					'tgl_lahir_user' => $tgl_lahir,
					'no_telp_user' => trim(strtoupper($this->input->post('userTelp'))),
					'id_provinsi' => $this->input->post('userProvinsi'),
					'id_kota' => $this->input->post('userKota'),
					'id_kecamatan' => $this->input->post('userKecamatan'),
					'id_kelurahan' => $this->input->post('userKelurahan'),
					'kode_pos' => trim(strtoupper($this->input->post('userKdpos'))),
					'id_level_user' => $this->input->post('userLevel'),
					'foto_user' => $gbr['file_name'],
					'timestamp' => $timestamp 
				);
		    } //end do upload
		    else 
		    {
				$input = array(
					'id_user' => $id_user,
					'email' => trim($this->input->post('userEmail')),
					'password' => $password,
					'fname_user' => trim(strtoupper($this->input->post('userFname'))),
					'lname_user' => trim(strtoupper($this->input->post('userLname'))),
					'alamat_user' => trim(strtoupper($this->input->post('userAlamat'))),
					'tgl_lahir_user' => $tgl_lahir,
					'no_telp_user' => trim(strtoupper($this->input->post('userTelp'))),
					'id_provinsi' => $this->input->post('userProvinsi'),
					'id_kota' => $this->input->post('userKota'),
					'id_kecamatan' => $this->input->post('userKecamatan'),
					'id_kelurahan' => $this->input->post('userKelurahan'),
					'kode_pos' => trim(strtoupper($this->input->post('userKdpos'))),
					'id_level_user' => $this->input->post('userLevel'),
					'timestamp' => $timestamp  
				);	
		    }
		    //insert to db
		    $this->m_user->insert_data_user($input);
		    echo json_encode(array(
				"status" => TRUE,
				"pesan" => 'Master User Berhasil ditambahkan',
			));
		} //end isset file foto
	}

	public function update_data_user()
	{
		$this->load->model('profil/mod_profil');
		$this->load->library('Enkripsi');
		$this->load->library('upload');
		//declare variabel
		$id_user = $this->input->post('userId');
		$pass_string = $this->input->post('userPassword');
		$password = $this->enkripsi->encrypt($pass_string);
		$tgl_lahir_string = $this->input->post('userTgllhr');
		$tgl_lahir = date("Y-m-d", strtotime($tgl_lahir_string));
		$timestamp = date('Y-m-d H:i:s');
		//konfigurasi upload img
		$nmfile = "img_".$id_user;
		$config['upload_path'] = './assets/img/foto_profil/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
		$config['overwrite'] = TRUE;
		$config['max_size'] = '2048'; 
		$config['max_width']  = '1288'; 
		$config['max_height']  = '768';
		$config['file_name'] = $nmfile;
		$this->upload->initialize($config);
		if(isset($_FILES['userFoto'])) 
		{
			//jika melakukan upload foto
			if ($this->upload->do_upload('userFoto')) 
		    {
		    	/*//get filename from db then unlink file
		    	$get_filename = $this->m_user->get_data_foto($id_user);
		    	$path = './assets/img/foto_profil/'.$get_filename->foto_user;
		    	unlink($path);*/
		    	$gbr = $this->upload->data();
		        //konfigurasi image lib
	            $config['image_library'] = 'gd2';
	            $config['source_image'] = './assets/img/foto_profil/'.$gbr['file_name'];
	            $config['create_thumb'] = FALSE;
	            $config['maintain_ratio'] = FALSE;
	            $config['new_image'] = './assets/img/foto_profil/'.$gbr['file_name'];
	            $config['overwrite'] = TRUE;
	            $config['width'] = 250; //resize
	            $config['height'] = 250; //resize
	            $this->load->library('image_lib',$config); //load image library
	            $this->image_lib->initialize($config);
	            $this->image_lib->resize();

	            //data input array
				$input = array(			
					'email' => trim($this->input->post('userEmail')),
					'password' => $password,
					'fname_user' => trim(strtoupper($this->input->post('userFname'))),
					'lname_user' => trim(strtoupper($this->input->post('userLname'))),
					'alamat_user' => trim(strtoupper($this->input->post('userAlamat'))),
					'tgl_lahir_user' => $tgl_lahir,
					'no_telp_user' => trim(strtoupper($this->input->post('userTelp'))),
					'id_provinsi' => $this->input->post('userProvinsi'),
					'id_kota' => $this->input->post('userKota'),
					'id_kecamatan' => $this->input->post('userKecamatan'),
					'id_kelurahan' => $this->input->post('userKelurahan'),
					'kode_pos' => trim(strtoupper($this->input->post('userKdpos'))),
					'id_level_user' => $this->input->post('userLevel'),
					'foto_user' => $gbr['file_name'],
					'timestamp' => $timestamp 
				);
		    } //end do upload
		    else 
		    {
				$input = array(			
					'email' => trim($this->input->post('userEmail')),
					'password' => $password,
					'fname_user' => trim(strtoupper($this->input->post('userFname'))),
					'lname_user' => trim(strtoupper($this->input->post('userLname'))),
					'alamat_user' => trim(strtoupper($this->input->post('userAlamat'))),
					'tgl_lahir_user' => $tgl_lahir,
					'no_telp_user' => trim(strtoupper($this->input->post('userTelp'))),
					'id_provinsi' => $this->input->post('userProvinsi'),
					'id_kota' => $this->input->post('userKota'),
					'id_kecamatan' => $this->input->post('userKecamatan'),
					'id_kelurahan' => $this->input->post('userKelurahan'),
					'kode_pos' => trim(strtoupper($this->input->post('userKdpos'))),
					'id_level_user' => $this->input->post('userLevel'),
					'timestamp' => $timestamp  
				);	
		    }
		    //update to db
		    $this->mod_profil->update_data_profil(array('id_user' => $id_user), $input);
		    echo json_encode(array(
				"status" => TRUE,
				"pesan" => 'Profil anda berhasil di Update !!'
			));
		} //end isset file foto
	}//end function

	public function edit_status_user($id)
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
		$this->m_user->update_status_user(array('id_user' => $id), $input);
		$data = array(
			'stahus' => $input_status,
			'status' => TRUE,
			'pesan' => "Status User dengan kode ".$id." berhasil di ubah.",
		);

		echo json_encode($data);
	}

	
}
