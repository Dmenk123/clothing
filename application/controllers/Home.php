<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('homepage/mod_homepage','mod_hpg');
		$this->load->model('checkout/mod_checkout','mod_ckt');
	}

	public function index()
	{ 
		$menu_select_search = $this->mod_hpg->get_menu_search();
		$menu_navbar = $this->mod_hpg->get_menu_navbar();
		//hitung kategori yang terdapat pada submenu (groupby)
		$count_kategori = $this->mod_hpg->count_kategori();
		$submenu = array();
		for ($i=1; $i <= $count_kategori; $i++) { 
			//set array key berdasarkan loop dari angka 1
			$submenu[$i] =  $this->mod_hpg->get_submenu_navbar($i);	
		}
		
		$data = array(
			'content_slider' => 'homepage/view_homepage_slider',
			'content_advantage' => 'homepage/view_homepage_advantage',
			'content_hot' => 'homepage/view_homepage_hot',
			'js' => 'homepage/jsHomepage',
			'count_kategori' => $count_kategori,
			'menu_navbar' => $menu_navbar,
			'submenu' => $submenu,
			'menu_select_search' => $menu_select_search
		);

		if ($this->session->userdata('id_user') == !null) {
			$id_user = $this->session->userdata('id_user');
			$checkout_notif = $this->mod_ckt->notif_count($id_user);
			$data['notif_count'] = $checkout_notif;
		}

		$this->load->view('temp', $data);
	}

	public function error_404() 
	{	
		$menu_select_search = $this->mod_hpg->get_menu_search();
		$menu_navbar = $this->mod_hpg->get_menu_navbar();
		//hitung kategori yang terdapat pada submenu (groupby)
		$count_kategori = $this->mod_hpg->count_kategori();
		$submenu = array();
		for ($i=1; $i <= $count_kategori; $i++) { 
			//set array key berdasarkan loop dari angka 1
			$submenu[$i] =  $this->mod_hpg->get_submenu_navbar($i);	
		}

		$data = array(
			'content' => 'temp_view_404',
			'js' => 'homepage/jsHomepage',
			'count_kategori' => $count_kategori,
			'menu_navbar' => $menu_navbar,
			'submenu' => $submenu,
			'menu_select_search' => $menu_select_search
		);

		if ($this->session->userdata('id_user') == !null) {
			$id_user = $this->session->userdata('id_user');
			$checkout_notif = $this->mod_ckt->notif_count($id_user);
			$data['notif_count'] = $checkout_notif;
		}

		$this->load->view('temp', $data);
	}

}
