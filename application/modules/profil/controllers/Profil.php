<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profil extends CI_Controller 
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('homepage/mod_homepage','mod_hpg');
		$this->load->model('mod_profil');
		$this->load->model('checkout/mod_checkout','mod_ckt');
		if ($this->session->userdata('logged_in') != true) {
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
		$id_user = $this->session->userdata('id_user');
		$checkout_notif = $this->mod_ckt->notif_count($id_user);
		$data_user = $this->mod_ckt->get_data_user($id_user);

		$data = array(
			'content' => 'profil/view_profil',
			'count_kategori' => $count_kategori,
			'submenu' => $submenu,
			'menu_navbar' => $menu_navbar,
			'js' => 'profil/jsProfil',
			'menu_select_search' => $menu_select_search,
			'data_user' => $data_user,
			'notif_count' => $checkout_notif,
		);

        $this->load->view('temp',$data);
	}

	public function edit_profil($id)
	{
		$this->load->library('Enkripsi');
		$menu_navbar = $this->mod_hpg->get_menu_navbar();
		$count_kategori = $this->mod_hpg->count_kategori();
		$submenu = array();
		for ($i=1; $i <= $count_kategori; $i++) { 
			//set array key berdasarkan loop dari angka 1
			$submenu[$i] =  $this->mod_hpg->get_submenu_navbar($i);	
		}
		$menu_select_search = $this->mod_hpg->get_menu_search();
		$data_user = $this->mod_profil->get_data_profil($id);
		//decrypt password
		$pass_string = $data_user->password;
		$hasil_password = $this->enkripsi->decrypt($pass_string);
		// replace array value
		$data_user->password = $hasil_password;

		$data = array(
			'content' => 'profil/form_edit_profil',
			'count_kategori' => $count_kategori,
			'submenu' => $submenu,
			'menu_navbar' => $menu_navbar,
			'js' => 'profil/jsProfil',
			'menu_select_search' => $menu_select_search,
			'data_user' => $data_user,
		);

		$this->load->view('temp', $data);
	}

	public function get_select_edit()
	{
		$id = $this->session->userdata('id_user');
		$data = $this->mod_profil->get_data_profil($id);

		//change format date to indonesian format
		$tgl_lahir_string = $data->tgl_lahir_user;
		$tgl_lahir = date("d-m-Y", strtotime($tgl_lahir_string));
		// replace array value
		$data->tgl_lahir_user = $tgl_lahir;

		echo json_encode($data);
	}

	public function list_checkout_history()
	{
		$id_user = $this->session->userdata('id_user');
		$list = $this->mod_profil->get_data_checkout($id_user);
		$data = array();
		$no =$_POST['start'];
		foreach ($list as $listCheckout) {
			$link_detail = site_url('profil/checkout_detail/').$listCheckout->id_checkout;
			$no++;
			$row = array();
			//loop value tabel db
			$row[] = $listCheckout->tgl_checkout;
			$row[] = $listCheckout->id_checkout;
			$row[] = $listCheckout->method_checkout;
			$row[] = "Rp. ".number_format($listCheckout->harga_total_produk,0,",",".");
			$row[] = $listCheckout->jasa_ekspedisi;
			$row[] = $listCheckout->pilihan_paket;
			$row[] = $listCheckout->estimasi_datang;
			$row[] = "Rp. ".number_format($listCheckout->ongkos_kirim,0,",",".");
			$row[] = "Rp. ".number_format($listCheckout->ongkos_total,0,",",".");
			$row[] = $listCheckout->kode_ref;
			//add html for action button
			$row[] ='<a class="btn btn-sm btn-success" href="'.$link_detail.'" title="Checkout Detail" id="btn_detail" onclick=""><i class="fa fa-info-circle"></i> '.$listCheckout->jml.' Items</a>
					<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="nonaktif" onclick="nonaktifCheckout('."'".$listCheckout->id_checkout."'".')"><i class="fa fa-times"></i> Nonaktif</a>';

			$data[] = $row;
		}//end loop

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->mod_profil->count_all(),
						"recordsFiltered" => $this->mod_profil->count_filtered($id_user),
						"data" => $data,
					);
		//output to json format
		echo json_encode($output);
	}

	public function update_profil()
	{
		$this->load->library('Enkripsi');
		$this->load->library('upload');
		//declare variabel
		$id_user = $this->input->post('frm_id_user');
		$pass_string = $this->input->post('frm_pass_user');
		$password = $this->enkripsi->encrypt($pass_string);
		$tgl_lahir_string = $this->input->post('frm_tgllhr_user');
		$tgl_lahir = date("Y-m-d", strtotime($tgl_lahir_string));
		$timestamp = date('Y-m-d H:i:s');
		//konfigurasi upload img
		$nmfile = "img_".$id_user;
		$config['upload_path'] = './assets/img/foto_profil/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
		$config['overwrite'] = TRUE;
		$config['max_size'] = '0'; 
		$config['max_width']  = '0'; 
		$config['max_height']  = '0';
		$config['file_name'] = $nmfile;
		$this->upload->initialize($config);
		if(isset($_FILES['frm_foto'])) 
		{	
			//jika melakukan upload foto
			if ($this->upload->do_upload('frm_foto')) 
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
					'email' => trim($this->input->post('frm_email_user')),
					'password' => $password,
					'fname_user' => trim(strtoupper($this->input->post('frm_fname_user'))),
					'lname_user' => trim(strtoupper($this->input->post('frm_lname_user'))),
					'alamat_user' => trim(strtoupper($this->input->post('frm_alamat_user'))),
					'tgl_lahir_user' => $tgl_lahir,
					'no_telp_user' => trim(strtoupper($this->input->post('frm_telp_user'))),
					'id_provinsi' => $this->input->post('frm_prov_user'),
					'id_kota' => $this->input->post('frm_kota_user'),
					'id_kecamatan' => $this->input->post('frm_kec_user'),
					'id_kelurahan' => $this->input->post('frm_kel_user'),
					'kode_pos' => trim(strtoupper($this->input->post('frm_kode_pos'))),
					'id_level_user' => 2,
					'foto_user' => $gbr['file_name'],
					'timestamp' => $timestamp 
				);
		    } //end do upload
		    else 
		    {
				$input = array(			
					'email' => trim($this->input->post('frm_email_user')),
					'password' => $password,
					'fname_user' => trim(strtoupper($this->input->post('frm_fname_user'))),
					'lname_user' => trim(strtoupper($this->input->post('frm_lname_user'))),
					'alamat_user' => trim(strtoupper($this->input->post('frm_alamat_user'))),
					'tgl_lahir_user' => $tgl_lahir,
					'no_telp_user' => trim(strtoupper($this->input->post('frm_telp_user'))),
					'id_provinsi' => $this->input->post('frm_prov_user'),
					'id_kota' => $this->input->post('frm_kota_user'),
					'id_kecamatan' => $this->input->post('frm_kec_user'),
					'id_kelurahan' => $this->input->post('frm_kel_user'),
					'kode_pos' => trim(strtoupper($this->input->post('frm_kode_pos'))),
					'id_level_user' => 2,
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

	public function checkout_detail($id)
	{
		$id_user = $this->session->userdata('id_user'); 
		$menu_navbar = $this->mod_hpg->get_menu_navbar();
		$count_kategori = $this->mod_hpg->count_kategori();
		$submenu = array();
		for ($i=1; $i <= $count_kategori; $i++) { 
			//set array key berdasarkan loop dari angka 1
			$submenu[$i] =  $this->mod_hpg->get_submenu_navbar($i);	
		}
		$menu_select_search = $this->mod_hpg->get_menu_search();
		$id_user = $this->session->userdata('id_user');
		$data_user = $this->mod_ckt->get_data_user($id_user);
		$checkout_notif = $this->mod_ckt->notif_count($id_user);

		$query_header = $this->mod_profil->get_detail_checkout_header($id);
		$query = $this->mod_profil->get_detail_checkout($id);

		$data = array(
			'content' => 'profil/view_checkout_detail',
			'count_kategori' => $count_kategori,
			'submenu' => $submenu,
			'menu_navbar' => $menu_navbar,
			'js' => 'profil/jsProfil',
			'menu_select_search' => $menu_select_search,
			'data_user' => $data_user,
			'hasil_header' => $query_header,
			'hasil_data' => $query,
			'notif_count' => $checkout_notif,
		);

        $this->load->view('temp',$data);
	}

	public function nonaktif_checkout($id)
	{
		$input = array(
			'status' => "nonaktif" 
		);
		$this->mod_profil->update_nonaktif_checkout(array('id_checkout' => $id), $input);
		$data = array(
			'status' => TRUE,
			'pesan' => "Transaksi anda dengan kode ".$id." berhasil di nonaktifkan.",
		);

		echo json_encode($data);
	}

	public function konfirmasi_checkout($id)
	{
		$menu_navbar = $this->mod_hpg->get_menu_navbar();
		$count_kategori = $this->mod_hpg->count_kategori();
		$submenu = array();
		for ($i=1; $i <= $count_kategori; $i++) { 
			//set array key berdasarkan loop dari angka 1
			$submenu[$i] =  $this->mod_hpg->get_submenu_navbar($i);	
		}
		$menu_select_search = $this->mod_hpg->get_menu_search();
		$id_user = $this->session->userdata('id_user');
		$checkout_notif = $this->mod_ckt->notif_count($id_user);
		$data_user = $this->mod_ckt->get_data_user($id_user);

		$query = $this->mod_profil->get_detail_checkout($id);
		$query_header = $this->mod_profil->get_detail_checkout_header($id);
		$data = array(
			'content' => 'profil/form_konfirmasi',
			'count_kategori' => $count_kategori,
			'submenu' => $submenu,
			'menu_navbar' => $menu_navbar,
			'js' => 'profil/jsProfil',
			'menu_select_search' => $menu_select_search,
			'data_user' => $data_user,
			'notif_count' => $checkout_notif,
			'hasil_data' => $query,
			'hasil_header' => $query_header,
		);

        $this->load->view('temp',$data);
	}

	public function konfirmasi_checkout_cod($id_checkout)
	{
		//update tbl checkout to nonaktif
		$input_checkout = array(
			'status' => "nonaktif" 
		);
		$this->mod_profil->update_nonaktif_checkout(array('id_checkout' => $id_checkout), $input_checkout);

		//insert tbl pembelian
		$id_user = $this->session->userdata('id_user');
		$timestamp = date('Y-m-d H:i:s');
		$id_beli = $this->mod_profil->getKodePembelian();
		$input_beli = array(
			'id_pembelian' => $id_beli,
			'id_checkout' => $this->input->post('cfrmIdCheckout'),
			'id_user' => $id_user,
			'tgl_pembelian' => date("Y-m-d"),
			'timestamp' => $timestamp
		);

		$this->mod_profil->insert_data_pembelian($input_beli);

		//proses update data stok
		$hitung = count($this->input->post('crfmIdStok'));
		//ambil niali stok sisa
		$stok_sisa = array(); //inisialisasi var array
		$hasil_kurang = array(); //inisialisasi var array
		for ($i=0; $i <$hitung; $i++) 
		{ 
			$stok_sisa[$i] = $this->mod_profil->get_sisa_stok($this->input->post("crfmIdStok")[$i]);
			$hasil_kurang[$i] = $stok_sisa[$i]->stok_sisa - $this->input->post('crfmQty')[$i];
		}
		// print_r($stok_sisa);
		// print_r($hasil_kurang);
		//siapkan data array untuk proses update
		$data_stok = array();
		for ($i=0; $i < $hitung; $i++) 
		{ 
			$data_stok[$i] = array(
				'id_stok' => $this->input->post('crfmIdStok')[$i],
				'stok_sisa' => $hasil_kurang[$i],
			);
			
		}
		//update batch
		$this->db->update_batch('tbl_stok',$data_stok,'id_stok');
        
		echo json_encode(array(
			"status" => TRUE,
			"pesan" => 'Terima Kasih Telah konfirmasi pembelian, Barang akan dikirim tiap hari senin-sabtu di jam kerja, Apabila barang belum datang lebih dari 2 hari dari tgl konfirmasi, anda dapat menghubungi Whatsapp kami'
		));
	}

	public function konfirmasi_checkout_tfr($id_checkout)
	{
		$this->load->library('upload');

		//update tbl checkout to nonaktif
		$input_checkout = array(
			'status' => "nonaktif" 
		);
		//ubdate status to db
		$this->mod_profil->update_nonaktif_checkout(array('id_checkout' => $id_checkout), $input_checkout);

		//insert tbl pembelian
		$id_user = $this->session->userdata('id_user');
		$timestamp = date('Y-m-d H:i:s');
		$id_beli = $this->mod_profil->getKodePembelian();
		$input_beli = array(
			'id_pembelian' => $id_beli,
			'id_checkout' => $this->input->post('cfrmIdCheckout'),
			'id_user' => $id_user,
			'tgl_pembelian' => date("Y-m-d"),
			'timestamp' => $timestamp
		);
		//konfigurasi upload img
		$config['upload_path'] = './assets/img/bukti_transfer/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
		//$config['overwrite'] = TRUE;
		$config['max_size'] = '4000';//in KB (4MB)
		$config['max_width']  = '0';//zero for no limit 
		$config['max_height']  = '0';//zero for no limit
		$config['encrypt_name'] = TRUE;// for encrypting the name
		$this->upload->initialize($config);

		for ($i=1; $i<=3 ; $i++) 
		{ 
			if(isset($_FILES['crfmBukti'.$i]))
			{
				//jika melakukan upload foto
		        if ($this->upload->do_upload('crfmBukti'.$i)) //will upload selected file to destiny folder
		        {
		        	$gbr = $this->upload->data();//get file upload data
		        	//konfigurasi image lib
	                $resize_gbr['image_library'] = 'gd2';
	                $resize_gbr['source_image'] = './assets/img/bukti_transfer/'.$gbr['file_name'];
	                $resize_gbr['create_thumb'] = FALSE;
	                $resize_gbr['maintain_ratio'] = FALSE;
	                $resize_gbr['width'] = 540; //resize
	                $resize_gbr['height'] = 540; //resize
	                $this->load->library('image_lib',$resize_gbr);
	                $this->image_lib->initialize($resize_gbr);
	                $this->image_lib->resize();
	                $input_beli["btransfer_".$i] = $gbr['file_name']; //add to array input
                    $this->image_lib->clear();//clear img lib after resize
		        }
			}
		}
		//print_r($input_beli);
		//add to db
		$this->mod_profil->insert_data_pembelian($input_beli);

		//proses update data stok
		$hitung = count($this->input->post('crfmIdStok'));
		//ambil niali stok sisa
		$stok_sisa = array(); //inisialisasi var array
		$hasil_kurang = array(); //inisialisasi var array
		for ($i=0; $i <$hitung; $i++) 
		{ 
			$stok_sisa[$i] = $this->mod_profil->get_sisa_stok($this->input->post("crfmIdStok")[$i]);
			$hasil_kurang[$i] = $stok_sisa[$i]->stok_sisa - $this->input->post('crfmQty')[$i];
		}
		
		//siapkan data array untuk proses update
		$data_stok = array();
		for ($i=0; $i < $hitung; $i++) 
		{ 
			$data_stok[$i] = array(
				'id_stok' => $this->input->post('crfmIdStok')[$i],
				'stok_sisa' => $hasil_kurang[$i],
			);
			
		}
		//update batch
		$this->db->update_batch('tbl_stok',$data_stok,'id_stok');
        
		echo json_encode(array(
			"status" => TRUE,
			"pesan" => 'Terima Kasih Telah konfirmasi pembelian, Bukti Resi Pengiriman akan dikirim pada email anda, anda dapat menghubungi Whatsapp kami apabila ada keluhan'
		));
	}
	
}//end of class profil.php
