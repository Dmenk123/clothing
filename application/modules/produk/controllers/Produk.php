<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('mod_produk');
		$this->load->model('checkout/mod_checkout','mod_ckt');
		$this->load->model('homepage/mod_homepage','mod_hpg');
		$this->load->library('pagination');
	}

	public function sub_kategori()
	{ 
		$sub = $this->uri->segment(3);

		$per_page = $this->input->get('per_page');
		if (!isset($per_page)) {
			$per_page = 10; //default per page
		}

		$sort_by = $this->input->get('sort_by');
		if (!isset($sort_by)) {
			$sort_by = "created"; //default sort
		}

		//set array for pagination library
		$config = array();
		$total_row = $this->mod_produk->record_count($sub);
		$config["base_url"] = base_url() . "produk/sub_kategori/".$sub;
        $config["total_rows"] = $total_row;
        $config["per_page"] = $per_page;
        //beri tambahan path ketika next page
        $config['prefix'] = '/page/';
        //tampilkan url string pada next page
        $config['reuse_query_string'] = TRUE;
        $config['query_string_segment'] = 'page';
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = $total_row;
        $config['cur_tag_open'] = '&nbsp <a class="current">';
        $config['cur_tag_close'] = '</a>';
        $config['next_link'] = 'Next';
        $config['prev_link'] = 'Previous';
        $this->pagination->initialize($config);
        
        $page = $this->uri->segment(5);
        $str_links = $this->pagination->create_links();
		$id_show = $per_page;
		$id_sort = $sort_by;
		
		$get_data_page = $this->mod_produk->get_data_page($sub);
		$menu_navbar = $this->mod_hpg->get_menu_navbar();
		//hitung kategori yang terdapat pada submenu (groupby)
		$count_kategori = $this->mod_hpg->count_kategori();
		$submenu = array();
		for ($i=1; $i <= $count_kategori; $i++) { 
			//set array key berdasarkan loop dari angka 1
			$submenu[$i] =  $this->mod_hpg->get_submenu_navbar($i);	
		}
		//print_r($submenu);
		$menu_select_search = $this->mod_hpg->get_menu_search();
		
		$data = array(
			'content' => 'produk/view_list_produk',
			'content_sidebar' => 'temp_content_sidebar',
			'menu_navbar' => $menu_navbar,
			'count_kategori' => $count_kategori,
			'submenu' => $submenu,
			'js' => 'produk/jsProduk',
			'menu_select_search' => $menu_select_search,
			'get_data_page' => $get_data_page,
			'results' => $this->mod_produk->get_list_produk($config["per_page"], $page, $sort_by, $sub),
			'links' => explode('&nbsp', $str_links),
			'total_baris' => $total_row,
			'id_show' => $id_show,
			'id_sort' => $id_sort
		);

		if ($this->session->userdata('id_user') == !null) {
			$id_user = $this->session->userdata('id_user');
			$checkout_notif = $this->mod_ckt->notif_count($id_user);
			$data['notif_count'] = $checkout_notif;
		}

		$this->load->view('temp', $data);
	}


	public function cari_produk()
	{
		$sub_kategori = $this->input->get('select');
		$key = $this->input->get('key');

		$per_page = $this->input->get('per_page');
		if (!isset($per_page)) {
			$per_page = 10; //default per page
		}
		$sort_by = $this->input->get('sort_by');
		if (!isset($sort_by)) {
			$sort_by = "created"; //default sort
		}

		$select_sub = $this->input->get('select');
		$search_key = $this->input->get('key');
		
		//set array for pagination library
		$config = array();
		$total_row = $this->mod_produk->record_count($sub_kategori);
		$config["base_url"] = base_url() . "produk/cari_produk/".$sub_kategori;
        $config["total_rows"] = $total_row;
        $config["per_page"] = $per_page;
        //beri tambahan path ketika next page
        $config['prefix'] = '/page/';
        //tampilkan url string pada next page
        $config['reuse_query_string'] = TRUE;
        $config['query_string_segment'] = 'page';
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = $total_row;
        $config['cur_tag_open'] = '&nbsp <a class="current">';
        $config['cur_tag_close'] = '</a>';
        $config['next_link'] = 'Next';
        $config['prev_link'] = 'Previous';
        $this->pagination->initialize($config);

        $page = $this->uri->segment(5);
        $str_links = $this->pagination->create_links();
		$id_show = $per_page;
		$id_sort = $sort_by;
		
		$get_data_page = $this->mod_produk->get_data_page($sub_kategori);
		$menu_navbar = $this->mod_hpg->get_menu_navbar();
		//hitung kategori yang terdapat pada submenu (groupby)
		$count_kategori = $this->mod_hpg->count_kategori();
		$submenu = array();
		for ($i=1; $i <= $count_kategori; $i++) { 
			//set array key berdasarkan loop dari angka 1
			$submenu[$i] =  $this->mod_hpg->get_submenu_navbar($i);	
		}
		$menu_select_search = $this->mod_hpg->get_menu_search();

        $data = array(
			'content' => 'produk/view_list_produk',
			'content_sidebar' => 'temp_content_sidebar',
			'menu_navbar' => $menu_navbar,
			'count_kategori' => $count_kategori,
			'submenu' => $submenu,
			'js' => 'produk/jsProduk',
			'menu_select_search' => $menu_select_search,
			'get_data_page' => $get_data_page,
			'results' => $this->mod_produk->get_list_produk_search($config["per_page"], $page, $sort_by, $select_sub, $search_key),
			'links' => explode('&nbsp', $str_links),
			'total_baris' => $total_row,
			'id_show' => $id_show,
			'id_sort' => $id_sort
		);

		$this->load->view('temp', $data);
	}

	public function get_kategori()
	{
		$id_sub = $this->input->post('segment');
		$id_kategori = $this->mod_produk->get_id_kategori($id_sub);
		$count_kategori = $this->mod_hpg->count_kategori();

		$data = array(
			'kategori' => $id_kategori,
			'count_kategori' => $count_kategori 
		);

		echo json_encode($data);
	}

	public function get_size_produk()
	{
		$id_produk = $this->input->post('id_produk');
		$size = $this->mod_produk->get_data_size_produk($id_produk);

		$data = array(
			'size' => $size, 
		);

		echo json_encode($data);
	}

	public function get_stok_produk()
	{
		$id_produk = $this->input->post('id_produk');
		$size_produk = $this->input->post('size_produk');
		$stok = $this->mod_produk->get_data_stok_produk($id_produk, $size_produk);
		foreach ($stok as $value) {
			$stok_length = $value->stok_sisa;
		}
		
		$data_stok = array();
		$angka = 1;
		for ($i=0; $i<$stok_length; $i++) { 
			$data_stok[$i] = $angka;
			$angka++;
		}

		$data = array(
			'stok' => $data_stok, 
		);

		echo json_encode($data);
	}

	public function produk_detail()
	{
		$id_produk = $this->uri->segment(4);

		$menu_navbar = $this->mod_hpg->get_menu_navbar();
		//hitung kategori yang terdapat pada submenu (groupby)
		$count_kategori = $this->mod_hpg->count_kategori();
		$submenu = array();
		for ($i=1; $i <= $count_kategori; $i++) { 
			//set array key berdasarkan loop dari angka 1
			$submenu[$i] =  $this->mod_hpg->get_submenu_navbar($i);	
		}
		//print_r($submenu);
		$menu_select_search = $this->mod_hpg->get_menu_search();
		$img_detail_thumb = $this->mod_produk->get_img_detail_thumb($id_produk);
		$img_detail_big = $this->mod_produk->get_img_detail_big($id_produk);
		$detail_produk = $this->mod_produk->get_detail_produk($id_produk);
		$ukuran_produk = $this->mod_produk->get_ukuran_produk($id_produk);
		$produk_terlaris = $this->mod_produk->get_produk_terlaris();

		$data = array(
			'content' => 'produk/view_detail_produk',
			'content_sidebar' => 'temp_content_sidebar',
			'menu_navbar' => $menu_navbar,
			'count_kategori' => $count_kategori,
			'submenu' => $submenu,
			'js' => 'produk/jsProduk',
			'menu_select_search' => $menu_select_search,
			'img_detail_thumb' => $img_detail_thumb,
			'img_detail_big' => $img_detail_big,
			'detail_produk' => $detail_produk,
			'ukuran_produk' => $ukuran_produk,
			'produk_terlaris' => $produk_terlaris
		);

		if ($this->session->userdata('id_user') == !null) {
			$id_user = $this->session->userdata('id_user');
			$checkout_notif = $this->mod_ckt->notif_count($id_user);
			$data['notif_count'] = $checkout_notif;
		}

		$this->load->view('temp', $data); 
	}

}
