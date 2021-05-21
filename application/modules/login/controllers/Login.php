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
	
	// public function intip($str)
	// {
	// 	echo  $this->enkripsi->encrypt($str);
	// }

	public function index()
	{	
		if ($this->session->userdata('logged_in')) {
			return redirect('dashboard_adm');
		}

		$this->load->view('view_login2');
	}

	public function proses()
	{
		$pass_string = $this->input->post('password');
		$hasil_password = $this->enkripsi->encrypt($pass_string);

		$data_input = array(
			'data_email'=>$this->input->post('username'),
			'data_password'=>$hasil_password,
		);
		
		$result = $this->m_log->login($data_input);

		if ($result) {
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

			echo json_encode([
				'status' => true
			]);
		}else{
			echo json_encode([
				'status' => false
			]);
			// $this->session->set_flashdata('message', 'Kombinasi Username & Password Salah, Mohon di cek ulang');
			// redirect('login');
		}
	}

	public function logout_proc()
	{
		if ($this->session->userdata('logged_in')) 
		{
			$arr_userdata = [
				'username' => $this->session->userdata('username'),
				'id_user' => $this->session->userdata('id_user'),
				'last_login' => $this->session->userdata('last_login'),
				'id_role' => $this->session->userdata('id_role'),
				'logged_in' => false,
			];

			// $data_log = json_encode($arr_userdata);
			// $this->lib_fungsi->catat_log_aktifitas('LOGOUT', null, $data_log);

			//$this->session->sess_destroy();
			$this->session->unset_userdata('username');
			$this->session->unset_userdata('id_user');
			$this->session->unset_userdata('last_login');
			$this->session->unset_userdata('id_role');
			$this->session->set_userdata(array('logged_in' => false));
		}
		
		// return redirect('home');
		echo json_encode([
			'pesan' => 'berhasil log out',
		]);
	}

	public function lihat_pass($username)
	{
		$this->load->library('Enkripsi');
		$data = $this->db->query("select password from tbl_user where username = '$username'")->row();
		$str_dec = $this->enkripsi->decrypt($data->password);
		echo $str_dec;
	}

	public function register_user($username, $pass)
	{
		$data = [
			'id' => 1,
			'id_role' => 1,
			'kode_user' => 'USR-00001',
			'username' => trim($username),
			'password' => $pass,
			'created_at' => date('Y-m-d H:i:s') 
		];
		$this->db->insert('m_user', $data);
		
	}
}
