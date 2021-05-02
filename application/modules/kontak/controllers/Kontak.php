<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kontak extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('homepage/mod_homepage','mod_hpg');
		$this->load->model('mod_kontak','m_ktk');
		$this->load->model('checkout/mod_checkout','mod_ckt');
	}

	public function index()
	{
		$this->konfigurasi_gmap();
		$menu_navbar = $this->mod_hpg->get_menu_navbar();
		$count_kategori = $this->mod_hpg->count_kategori();
		$submenu = array();
		for ($i=1; $i <= $count_kategori; $i++) { 
			//set array key berdasarkan loop dari angka 1
			$submenu[$i] =  $this->mod_hpg->get_submenu_navbar($i);	
		}
		$menu_select_search = $this->mod_hpg->get_menu_search();

		$data = array(
			'map' => $this->googlemaps->create_map(),
			'content' => 'kontak/view_kontak',
			'count_kategori' => $count_kategori,
			'submenu' => $submenu,
			'menu_navbar' => $menu_navbar,
			'js' => 'kontak/jsKontak',
			'menu_select_search' => $menu_select_search,
		);

		if ($this->session->userdata('id_user') == !null) {
			$id_user = $this->session->userdata('id_user');
			$checkout_notif = $this->mod_ckt->notif_count($id_user);
			$data['notif_count'] = $checkout_notif;
		}

        $this->load->view('temp',$data);
	}

	public function konfigurasi_gmap()
	{
		$this->load->library('googlemaps');
		$config = array();
        $config['center'] = "-7.297836, 112.747833";
        $config['zoom'] = 17;
        $config['map_height'] = "400px";
        $this->googlemaps->initialize($config);
        $marker=array();
        $marker['position'] = "-7.297836, 112.747833";
        $this->googlemaps->add_marker($marker);
	}

	public function add_pesan()
	{
		$timestamp = date('Y-m-d H:i:s');
		$time = time();
		$data_input = array(
			'fname_pesan' => strtoupper(trim($this->input->post('msg_fname'))),
			'lname_pesan' => strtoupper(trim($this->input->post('msg_lname'))),
			'email_pesan' => trim($this->input->post('msg_email')),
			'subject_pesan' => strtoupper(trim($this->input->post('msg_subject'))),
			'isi_pesan' => trim($this->input->post('msg_message')),
			'dt_kirim' => $timestamp,
			'time_post' => $time
		);

		$insert = $this->m_ktk->add_pesan($data_input);

		echo json_encode(array(
			"status" => TRUE,
			"pesan" => 'Terima Kasih '.$data_input['fname_pesan'].' '.$data_input['lname_pesan'].' Atas masukkannya, balasan akan dikirim ke email anda',
			));	
	}
	

}
