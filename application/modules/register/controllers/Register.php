<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('upload');
		$this->load->model('produk/mod_produk');
		$this->load->model('homepage/mod_homepage','mod_hpg');
		$this->load->model('mod_register','m_reg');
		$this->load->model('checkout/mod_checkout','mod_ckt');
		if ($this->session->userdata('logged_in') == true) {
			redirect('home/error_404');
		}
	}

	public function index()
	{
		$menu_navbar = $this->mod_hpg->get_menu_navbar();
		$count_kategori = $this->mod_hpg->count_kategori();
		$submenu = array();
		for ($i=1; $i <= $count_kategori; $i++) { 
			//set array key berdasarkan loop dari angka 1
			$submenu[$i] =  $this->mod_hpg->get_submenu_navbar($i);	
		}
		$menu_select_search = $this->mod_hpg->get_menu_search();
		
		//captcha	
		$imgCaptcha = $this->buat_captcha();
		

		$data = array(
			'content' => 'register/view_register',
			'count_kategori' => $count_kategori,
			'submenu' => $submenu,
			'menu_navbar' => $menu_navbar,
			'js' => 'register/jsRegister',
			'menu_select_search' => $menu_select_search,
			'img' => $imgCaptcha,
		);

		if ($this->session->userdata('id_user') == !null) {
			$id_user = $this->session->userdata('id_user');
			$checkout_notif = $this->mod_ckt->notif_count($id_user);
			$data['notif_count'] = $checkout_notif;
		}

        $this->load->view('temp',$data);
	}

	public function buat_captcha()
	{
		$options = array(
			'img_path' => 'assets/img/captcha_img/',
			'img_url' => base_url().'assets/img/captcha_img/',
			'img_width' => '200',
			'img_height' => '50',
			'word_length'   => 5,
			'font_size' => 16,
			'expiration' => 7200,
			'font_path' => FCPATH.'assets/css/fonts/E004007T.ttf',
			'show_grid' => false,
			'colors' => array(
                'background' => array(255, 255, 255),
                'border' => array(255, 255, 255),
                'text' => array(0, 0, 0),
                'grid' => array(255, 40, 40)
            ),
		);
		$cap = create_captcha($options);
		// Unset previous captcha and store new captcha word
		$this->session->unset_userdata('captchaCode');
		$this->session->set_userdata('captchaCode', $cap['word']);

		$image = $cap['image'];
		return $image;
	}

	public function refresh_captcha()
	{
        // Captcha configuration
        $options = array(
			'img_path' => 'assets/img/captcha_img/',
			'img_url' => base_url().'assets/img/captcha_img/',
			'img_width' => '200',
			'img_height' => '50',
			'word_length'   => 5,
			'font_size' => 16,
			'expiration' => 7200,
			'font_path' => FCPATH.'assets/css/fonts/E004007T.ttf',
			'show_grid' => false,
			'colors' => array(
                'background' => array(255, 255, 255),
                'border' => array(255, 255, 255),
                'text' => array(0, 0, 0),
                'grid' => array(255, 40, 40)
            ),
		);
        $captcha = create_captcha($options);
        
        // Unset previous captcha and store new captcha word
        $this->session->unset_userdata('captchaCode');
        $this->session->set_userdata('captchaCode',$captcha['word']);
        
        // Display captcha image
        echo $captcha['image'];
    }

	public function check_captcha()
	{
		if ($this->input->post('captcha') == $this->session->userdata('captchaCode')) 
		{
			return true;
		}
		else
		{
			echo json_encode(array('pesan_error' => 'Maaf terjadi kesalahan pada penulisan captcha'));
			return false;
		}
	}

	public function suggest_provinsi()
	{
		$provinsi = [];
		if(!empty($this->input->get("q"))){
			$key = $_GET['q'];
			$query = $this->m_reg->lookup_data_provinsi($key);
		}else{
			$query = $this->m_reg->lookup_data_provinsi();
		}
		
		foreach ($query as $row) {
			$provinsi[] = array(
						'id' => $row->id_provinsi,
						'text' => $row->nama_provinsi,
					);
		}
		echo json_encode($provinsi);
	}

	public function suggest_kotakabupaten()
	{
		// get data from ajax object (uri)
		$id_provinsi = $this->uri->segment(3);
		$kotkab = [];
		if(!empty($this->input->get("q"))){
			$key = $_GET['q'];
			$query = $this->m_reg->lookup_data_kotakabupaten($key, $id_provinsi);
		}else{
			$key = "";
			$query = $this->m_reg->lookup_data_kotakabupaten($key, $id_provinsi);
		}
		
		foreach ($query as $row) {
			$kotkab[] = array(
						'id' => $row->id_kota,
						'text' => $row->nama_kota,
					);
		}
		echo json_encode($kotkab);
	}

	public function suggest_kecamatan()
	{
		// get data from ajax object (uri)
		$id_kota = $this->uri->segment(3);
		$kecamatan = [];
		if(!empty($this->input->get("q"))){
			$key = $_GET['q'];
			$query = $this->m_reg->lookup_data_kecamatan($key, $id_kota);
		}else{
			$key = "";
			$query = $this->m_reg->lookup_data_kecamatan($key, $id_kota);
		}
		
		foreach ($query as $row) {
			$kecamatan[] = array(
						'id' => $row->id_kecamatan,
						'text' => $row->nama_kecamatan,
					);
		}
		echo json_encode($kecamatan);
	}

	public function suggest_kelurahan()
	{
		// get data from ajax object (uri)
		$id_kecamatan = $this->uri->segment(3);
		$kelurahan = [];
		if(!empty($this->input->get("q"))){
			$key = $_GET['q'];
			$query = $this->m_reg->lookup_data_kelurahan($key, $id_kecamatan);
		}else{
			$key = "";
			$query = $this->m_reg->lookup_data_kelurahan($key, $id_kecamatan);
		}
		
		foreach ($query as $row) {
			$kelurahan[] = array(
						'id' => $row->id_kelurahan,
						'text' => $row->nama_kelurahan,
					);
		}
		echo json_encode($kelurahan);
	}

	public function add_register()
	{
		$this->load->model('login/mod_login','m_log');
		$this->load->model('homepage/mod_homepage','mod_hpg');
		$this->load->library('Enkripsi');

		if ($this->input->post('reg_captcha') == $this->session->userdata('captchaCode')) 
		{	//declare variabel
			$rand = $this->m_reg->getKodeUser();
			$pass_string = $this->input->post('reg_password');
			$password = $this->enkripsi->encrypt($pass_string);
			$tgl_lahir_string = $this->input->post('reg_tgl_lahir');
			$tgl_lahir = date("Y-m-d", strtotime($tgl_lahir_string));
			$timestamp = date('Y-m-d H:i:s');
			//konfigurasi upload img
			$nmfile = "img_".$rand;
			$config['upload_path'] = './assets/img/foto_profil/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
			$config['overwrite'] = TRUE;
			$config['max_size'] = '0'; 
		    $config['max_width']  = '0'; 
		    $config['max_height']  = '0';
		    $config['file_name'] = $nmfile;
		    $this->upload->initialize($config);
			
			if(isset($_FILES['reg_foto_profil'])) 
			{
		        //jika melakukan upload foto
		        if ($this->upload->do_upload('reg_foto_profil')) 
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
						'id_user' => $this->m_reg->getKodeUser(),
						'email' => trim($this->input->post('reg_email')),
						'password' => $password,
						'fname_user' => trim(strtoupper($this->input->post('reg_nama'))),
						'lname_user' => trim(strtoupper($this->input->post('reg_nama_blkg'))),
						'alamat_user' => trim(strtoupper($this->input->post('reg_alamat'))),
						'tgl_lahir_user' => $tgl_lahir,
						'no_telp_user' => trim(strtoupper($this->input->post('reg_telp'))),
						'id_provinsi' => $this->input->post('reg_provinsi'),
						'id_kota' => $this->input->post('reg_kota'),
						'id_kecamatan' => $this->input->post('reg_kecamatan'),
						'id_kelurahan' => $this->input->post('reg_kelurahan'),
						'kode_pos' => trim(strtoupper($this->input->post('reg_kode_pos'))),
						'id_level_user' => 2,
						'foto_user' => $gbr['file_name'],
						'timestamp' => $timestamp 
					);

		        } //end do upload
		        else 
		        {
					$input = array(			
						'id_user' => $this->m_reg->getKodeUser(),
						'email' => trim($this->input->post('reg_email')),
						'password' => $password,
						'fname_user' => trim(strtoupper($this->input->post('reg_nama'))),
						'lname_user' => trim(strtoupper($this->input->post('reg_nama_blkg'))),
						'alamat_user' => trim(strtoupper($this->input->post('reg_alamat'))),
						'tgl_lahir_user' => $tgl_lahir,
						'no_telp_user' => trim(strtoupper($this->input->post('reg_telp'))),
						'id_provinsi' => $this->input->post('reg_provinsi'),
						'id_kota' => $this->input->post('reg_kota'),
						'id_kecamatan' => $this->input->post('reg_kecamatan'),
						'id_kelurahan' => $this->input->post('reg_kelurahan'),
						'kode_pos' => trim(strtoupper($this->input->post('reg_kode_pos'))),
						'id_level_user' => 2,
						'timestamp' => $timestamp 
					);
					
		        }
		        //save to db
		        $this->m_reg->add_data_register($input);

		       	//get data user from tbl_user
				$data_login = array(
					'data_email'=> trim($this->input->post('reg_email')),
					'data_password'=>$password,
				);
				$result = $this->m_log->login($data_login);

				if ($login = $result[0]) 
				{
					$this->session->set_userdata(
						array(
							'id_user' => $login['id_user'],
							'email' => $login['email'],
							'password' => $login['password'],
							'id_level_user' => $login['id_level_user'],
							'fname_user' => $login['fname_user'],
							'logged_in' => true,
						));
					$this->m_log->set_lastlogin($login['id_user']);
					echo json_encode(array(
						"status" => TRUE,
						"pesan" => 'Selamat datang '.$login['fname_user'].' Akun anda berhasil dibuat'
					));
				}
			} //end isset upload
		}//end if captcha true
		else
		{
			echo json_encode(array(
				"status" => FALSE,
				'pesan' => 'Maaf terjadi kesalahan pada penulisan captcha'
			));
		}
	}//end function

}
