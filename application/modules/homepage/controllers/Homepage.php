<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Homepage extends CI_Controller {

	public function index()
	{	
		if ($this->session->userdata('username') !== null) {
			redirect('home');
		}
		$this->load->view('view_login');
	}

	public function proc()
	{
		$this->load->model('pengguna/mod_pengguna');
		$this->load->library('Enkripsi');

		$pass_string = $this->input->post('password');
		$hasil_password = $this->enkripsi->encrypt($pass_string);
		
		$data_input = array(
			'data_user'=>$this->input->post('username'),
			'data_password'=>$hasil_password,
		);
		
		$result = $this->mod_pengguna->login($data_input);

		if ($data = $result[0]) {
			$this->mod_pengguna->set_lastlogin($data['id_user']);
			// unset($data['id_user']);
			$this->session->set_userdata(
				array(
					'username' => $data['username'],
					'id_user' => $data['id_user'],
					'last_login' => $data['last_login'],
					'id_level_user' => $data['id_level_user'],
					'logged_in' => true,
				));
			redirect('home');
		}else{
			$this->session->set_flashdata('message', 'Kombinasi Username & Password Salah, Mohon di cek ulang');
			redirect('login');
		}
	}

}
