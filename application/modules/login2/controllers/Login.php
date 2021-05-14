<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('email'); // untuk kirim email
		$this->load->model('homepage/mod_homepage','mod_hpg');
		$this->load->model('checkout/mod_checkout','mod_ckt');
		$this->load->model('mod_login', 'm_log');
		$this->load->library('Enkripsi');
	}

	public function login_proc()
	{
		$email = $this->input->post('emailModal');
		$password = $this->input->post('passwordModal');
		$hasil_password = $this->enkripsi->encrypt($password);
		
		$data_input = array(
			'data_email'=>$email,
			'data_password'=>$hasil_password,
		);
		
		$result = $this->m_log->login($data_input);
		if (isset($result[0])) {
			if ($login_data = $result[0]) {
				$this->session->set_userdata(
					array(
						'id_user' => $login_data['id_user'],
						'email' => $login_data['email'],
						'password' => $login_data['password'],
						'id_level_user' => $login_data['id_level_user'],
						'fname_user' => $login_data['fname_user'],
						'lname_user' => $login_data['lname_user'],
						'logged_in' => true,
					));
				$this->m_log->set_lastlogin($login_data['id_user']);
			}
			if ($login_data['id_level_user'] == "2") {
			echo json_encode(array(
				"status" => TRUE,
				"pesan" => 'Selamat datang '.$login_data['fname_user'].' dan selamat berbelanja',
				"level" => $login_data['id_level_user'],
			));
			}else{
				echo json_encode(array(
					"status" => TRUE,
					"pesan" => 'Selamat datang '.$login_data['fname_user'].' dan selamat bekerja',
					"level" => $login_data['id_level_user'],
				));
			}
		}
	}

	public function logout_proc()
	{
		$nama = $this->session->userdata('fname_user');
		$id_level_user = $this->session->userdata('id_level_user');
		if ($this->session->userdata('logged_in')) 
		{
			//$this->session->sess_destroy();
			$this->session->unset_userdata('id_user');
			$this->session->unset_userdata('email');
			$this->session->unset_userdata('password');
			$this->session->unset_userdata('id_level_user');
			$this->session->unset_userdata('fname_user');
			$this->session->unset_userdata('lname_user');
			$this->session->set_userdata(array('logged_in' => false));
		}
		
		if ($id_level_user == '1') {
			echo json_encode(array(
			'pesan' => "Anda Telah Logout"));
		}else{
			echo json_encode(array(
			'pesan' => "Terima kasih ".$nama." telah berkunjung, kami tunggu kehadiran anda"));
		}
	}

	public function konfigurasi_email($userEmail, $tokenString)
	{
		$url = base_url('login/reset/token/');
		//SMTP & mail configuration
		$config = array(
			'protocol'  => 'smtp',
			'smtp_host' => 'ssl://smtp.googlemail.com',
			'smtp_port' => 465,
			'smtp_user' => 'slebzt@gmail.com',
			'smtp_pass' => 'as123456as',
			'mailtype'  => 'html',
			'charset'   => 'utf-8',
			'newline' => "\r\n",
		);
		
		$this->email->initialize($config);

		//Email content
		$htmlContent = '<h2>Dmenk Clothing E-shop</h2>';
		$htmlContent .= '<p>Terima Kasih kepada : '.trim($userEmail).' yang telah mendaftar pada kami</p>';
		$htmlContent .= '<p>Token berlaku untuk 2 jam dari pengiriman token ini : </p>';
		$htmlContent .= '<p>Klik disini untuk reset password anda : '.$url.$tokenString.'</p>';

		$this->email->to(trim($userEmail));
		$this->email->from("slebzt@gmail.com", 'Dmenk Clothing E-shop'); 
		$this->email->subject(trim('Konfirmasi Reset Password')); 
		$this->email->message($htmlContent);
	}

	public function kirim_token_forgotpass()
	{
		//berhubung file js dipaten di file temp induk, maka tidak disertakan jquery validation 
		//jadi dicek dulu apakah inputan kosong atau tidak
		if ($this->input->post('emailForgot') == "") 
		{
			echo json_encode(array(
				"status" => FALSE,
				"pesan" => 'Maaf anda harus mengisi email anda'
			));
		}
		else
		{
			$email = trim($this->input->post('emailForgot'));
			//get email
	  		$email_user = $this->m_log->getByEmail($email);
	 
	  		// cek apakah ada email
	  		if (!$email_user->num_rows() > 0)
	  		{
		    	$this->session->set_flashdata('style', 'danger');
		    	$this->session->set_flashdata('alert', 'Email tidak ditemukan!');
		    	$this->session->set_flashdata('message', 'Cek kembali email yang terdaftar.');
	 			redirect ('password/forgot');
	  		}
	 
	  		$user = $email_user->row();
	  		$user_token = $user->id_user;
	 		//create valid dan expire token (2hours)
	  		$date_create_token = date('Y-m-d H:i:s');
	  		$date_expired_token = date('Y-m-d H:i:s', strtotime('+2 hour', strtotime($date_create_token)));
	 		// create token string (concat string user_token and date_create)
	  		$tokenstring = md5(sha1($user_token.$date_create_token));
	 
	  		// simpan data token
	  		$data = array(
	  			'token' => $tokenstring,
	  			'id_user' => $user_token,
	  			'created' => $date_create_token,
	  			'expired' => $date_expired_token
	  		);

	  		//$simpan store affected_rows value (int) in model insert
	  		$simpan = $this->m_log->simpanToken($data);
	  		if ($simpan > 0)
	  		{
			    //call email config 
				$this->konfigurasi_email($email, $tokenstring);
				//send email
		   		$this->email->send();
	 	    	/*if (!$this->email->send()) {
			       echo $this->email->print_debugger();
			       exit;
	    		}*/
			    echo json_encode(array(
					"status" => TRUE,
					"pesan" => 'Link untuk Reset Password telah dikirim pada email anda, link ini akan kadaluarsa 2 jam dari sekarang'
				));
	  		}
		} 	
	}

	public function reset(){
		$menu_navbar = $this->mod_hpg->get_menu_navbar();
		$count_kategori = $this->mod_hpg->count_kategori();
		$submenu = array();
		for ($i=1; $i <= $count_kategori; $i++) { 
			//set array key berdasarkan loop dari angka 1
			$submenu[$i] =  $this->mod_hpg->get_submenu_navbar($i);	
		}
		$menu_select_search = $this->mod_hpg->get_menu_search();

  		$token = $this->uri->segment(4);
  		// get token ke nodel user
  		$cekToken = $this->m_log->cekToken($token);
  		$countToken = $cekToken->num_rows();
  		
  		if ($countToken > 0)
  		{
	 		$data = $cekToken->row();
	    	$tokenExpired = $data->expired;
	    	$timenow = date("Y-m-d H:i:s");
 
 		   	// cek token apakah sudah expired
    		if ($timenow < $tokenExpired)
    		{
 				// tampilkan form reset
 				$datatoken['token'] = $token;
 				$datatoken['content'] = 'login/view_form_reset_password';
 				$datatoken['count_kategori'] = $count_kategori;
 				$datatoken['submenu'] = $submenu;
 				$datatoken['menu_navbar'] = $menu_navbar;
      			$datatoken['js'] = 'login/jsLogin';
      			$datatoken['menu_select_search'] = $menu_select_search;

      			$this->load->view('temp',$datatoken);
 		    }
 		    else
 		    {
 				// redirect form home
 			    redirect ('home');
 			    echo '<script language="javascript">';
					echo 'alert("Token anda sudah expired!!, mohon ulangi input lupa password.")';
				echo '</script>';
    		}
  		}
  		else
  		{
  			// redirect form home
 			redirect ('home');
 			echo '<script language="javascript">';
				echo 'alert("TMaaf token anda tidak ditemukan, mohon ulangi input lupa password.")';
			echo '</script>';
  		}
	}

	public function update_user_data(){
 
	  	$password = $this->input->post('passForgot');
	  	$token = $this->input->post('tokenForgot');

		$hasil_password = $this->enkripsi->encrypt($password);
	  	$cekToken = $this->m_log->cekToken($token);
	  	$query = $cekToken->row();
	  	$id_user = $query->id_user;
	   
	  	// ubah password
	  	$data = array (
	  		'password' => $hasil_password
	  	);

	  	$count_update = $this->m_log->update_data_user(array('id_user' => $id_user), $data);

	  	if ($count_update > 0)
	  	{
	  		echo json_encode(array(
				"status" => TRUE,
				"pesan" => 'Password berhasil dirubah, silahkan login kembali dengan password baru'
			));
	  	}
	  	else
	  	{
		   	echo json_encode(array(
				"status" => FALSE,
				"pesan" => 'Password Gagal dirubah, cek kembali yang anda input'
			));
	  	}
	}
}
