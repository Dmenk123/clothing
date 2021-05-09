<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checkout extends CI_Controller {
	// KOTA SURABAYA
	const KOTA_ORIGIN = 444;
	public function __construct()
	{
		parent::__construct();
		$this->load->library('cart');
		$this->load->model('homepage/mod_homepage','mod_hpg');
		$this->load->model('mod_checkout','m_ckt');
		$this->load->model('m_global');
	}

	private function set_token_checkout()
	{
		$obj_date = new DateTime();
		$date = $obj_date->format('Y-m-d');
		$timestamp = $obj_date->format('Y-m-d H:i:s');
		$token = gen_uuid();
		$data_token = ['token_checkout' => $token];
		$this->session->set_userdata($data_token);

		if (count($this->cart->contents()) >= 1) {
			$id_header = gen_uuid();
			$harga_total = 0;
			$berat_total = 0;
			$arr_data_det = [];

			$this->db->trans_begin();

			foreach ($this->cart->contents() as $key => $value) {
				$harga_total += (float)$value['price'] * (float)$value['qty'];
				$berat_total += (float)$value['options']['Berat_produk'] * (float)$value['qty'];

				$arr_data_det[] = [
					'id_checkout' => $id_header,
					'id_produk' => $value['id'],
					'id_satuan' => $value['options']['Id_satuan_produk'],
					'id_stok' => $value['options']['Id_stok_produk'],
					'qty' => $value['qty'],
					'sess_row_id' => $value['rowid'],
					'berat_satuan' => $value['options']['Berat_produk'],
					'harga_satuan' => $value['price']
				];
			}

			$arr_data = [
				'id_checkout' => $id_header,
				'tgl_checkout' => $date,
				'status' => 1,
				'harga_total_produk' => $harga_total,
				'berat_total' => $berat_total,
				'token' => $token,
				'created_at' => $timestamp
			];

			$ins = $this->m_ckt->insert_data('tbl_checkout', $arr_data);

			foreach ($arr_data_det as $k => $v) {
				$data_det = [
					'id_checkout' => $v['id_checkout'],
					'id_produk' => $v['id_produk'],
					'id_satuan' => $v['id_satuan'],
					'id_stok' => $v['id_stok'],
					'qty' => $v['qty'],
					'sess_row_id' => $v['sess_row_id'],
					'harga_satuan' => $v['harga_satuan'],
					'berat_satuan' => $v['berat_satuan'],
					'created_at' => $timestamp
				];

				$this->m_ckt->insert_data('tbl_checkout_detail', $data_det);
			}

			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
			} else {
				$this->db->trans_commit();
			}
		}
	}

	private function check_token_session()
	{
		$token = $this->session->userdata('token_checkout');
		$cek = $this->m_ckt->single_row('tbl_checkout', ['token' => $token, 'status' => 1]);
		if($cek) {
			return ['status' => true, 'token' => $token, 'data' => $cek];
		}else{
			return ['status' => false, 'token' => null, 'data' => null];
		}
	}

	private function kota_ongkir($province_id="", $city_id="")
	{
		$this->load->library('rajaongkir');
		$cities = $this->rajaongkir->city($province_id, $city_id);
		return json_decode($cities, true);
	}

	private function prov_ongkir()
	{
		$this->load->library('rajaongkir');
		$provinces = $this->rajaongkir->province();
		return json_decode($provinces, true);
	}

	private function ekspedisi_ongkir($origin="", $destination="", $weight="", $courier="")
	{
		$this->load->library('rajaongkir');
		$cities = $this->rajaongkir->cost($origin, $destination, $weight, $courier);
		return json_decode($cities, true);
	}

	public function singkron_data_prov_rajaongkir()
	{
		// ambil data provinsi api rajaongkir
		// simpan pada tabel tbl_provinsi_ongkir

		$data_ongkir = $this->prov_ongkir();
		if($data_ongkir) {
			$this->db->trans_begin();
			foreach ($data_ongkir['rajaongkir']['results'] as $key => $value) {
				$data_ins = [
					'id_provinsi' => $value['province_id'],
					'nama' => trim(strtoupper(strtolower($value['province']))),
				];
				
				$this->m_ckt->insert_data('tbl_provinsi_ongkir', $data_ins);
			}

			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				echo 'false';
			} else {
				$this->db->trans_commit();
				echo 'true';
			}
		}
	}

	public function singkron_data_kota_rajaongkir()
	{
		// ambil data provinsi api rajaongkir
		// simpan pada tabel tbl_provinsi_ongkir

		$data_ongkir = $this->kota_ongkir();
		if($data_ongkir) {
			$this->db->trans_begin();
			foreach ($data_ongkir['rajaongkir']['results'] as $key => $value) {
				$data_ins = [
					'id_kota' => $value['city_id'],
					'id_provinsi' => $value['province_id'],
					'tipe_kota' => trim(strtoupper(strtolower($value['type']))),
					'nama_kota' => trim(strtoupper(strtolower($value['city_name']))),
					'kode_pos' => trim(strtoupper(strtolower($value['postal_code']))),
				];
				
				$this->m_ckt->insert_data('tbl_kota_ongkir', $data_ins);
			}

			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				echo 'false';
			} else {
				$this->db->trans_commit();
				echo 'true';
			}
		}
	}
	
	public function index()
	{
		$id_user = $this->session->userdata('id_user');
		$menu_navbar = $this->mod_hpg->get_menu_navbar();
		$count_kategori = $this->mod_hpg->count_kategori();
		$submenu = array();
		$data_cart = null;
		
		for ($i=1; $i <= $count_kategori; $i++) { 
			//set array key berdasarkan loop dari angka 1
			$submenu[$i] =  $this->mod_hpg->get_submenu_navbar($i);	
		}
		$menu_select_search = $this->mod_hpg->get_menu_search();
		
		// $data_user = $this->m_ckt->get_data_user($id_user);

		$cek_token = $this->check_token_session();
		if($cek_token['status']) {
			$cek_tbl = $this->m_ckt->get_db_cart($cek_token['token']);

			if ($cek_tbl) {
				$data_cart = $cek_tbl;
			}

		}else{
			//set new token
			$this->set_token_checkout();
		}

		
		// echo "<pre>";
		// print_r ($data_cart);
		// echo "</pre>";
		// exit;


		$data = array(
			'content' => 'checkout/view_checkout_1',
			'modal' => 'checkout/modal_checkout',
			'count_kategori' => $count_kategori,
			'data_cart' => $data_cart,
			'submenu' => $submenu,
			'menu_navbar' => $menu_navbar,
			'js' => 'checkout/jsCheckout',
			'menu_select_search' => $menu_select_search,
			// 'data_user' => $data_user,
		);

        $this->load->view('temp',$data);
	}

	public function simpan_step1()
	{
		$obj_date = new DateTime();
		$date = $obj_date->format('Y-m-d');
		$timestamp = $obj_date->format('Y-m-d H:i:s');
		$arr_valid = $this->rule_validasi_step1();

		if ($arr_valid['status'] == FALSE) {
			echo json_encode($arr_valid);
			return;
		}

		$id_header = gen_uuid();

		$email = $this->input->post('email');
		$hp = $this->input->post('hp');
		$nama = $this->input->post('nama');
		$provinsi = $this->input->post('provinsi');
		$kota = $this->input->post('kota');
		$alamat = $this->input->post('alamat');

		$cek_token = $this->check_token_session();
		if($cek_token['status']) {
			// update checkout
			$arr_data = [
				'nama' => $nama,
				'alamat' => $alamat,
				'id_kota' => $kota,
				'id_prov' => $provinsi,
				'email' => trim($email),
				'telp' => trim($hp),
				'updated_at' => $timestamp
			];

			$upd = $this->m_ckt->update_data('tbl_checkout', $arr_data, ['token' => $cek_token['token']]);
		}else{
			$retval['status'] = false;
			$retval['pesan'] = 'Data keranjang belanja kosong';
			echo json_encode($retval);
			return;
		}

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$retval['status'] = false;
			$retval['pesan'] = 'Gagal proses data';
		} else {
			$this->db->trans_commit();
			$retval['status'] = true;
			$retval['pesan'] = 'Sukses proses data';
		}

		echo json_encode($retval);
	}

	public function simpan_step2()
	{
		$obj_date = new DateTime();
		$date = $obj_date->format('Y-m-d');
		$timestamp = $obj_date->format('Y-m-d H:i:s');
		
		$cek_token = $this->check_token_session();
		if($cek_token['status'] && $cek_token['data']->jasa_ekspedisi) {
			$retval['status'] = true;
			$retval['pesan'] = '';
		}else{
			$retval['status'] = false;
			$retval['pesan'] = 'Wajib Memilih Jasa Kurir Terlebih Dahulu';
		}

		echo json_encode($retval);
		return;
	}

	public function step2()
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
		$data_user = $this->m_ckt->get_data_user($id_user);
		
		$cek_token = $this->check_token_session();
		if($cek_token['status']) {
			$cek_tbl = $this->m_ckt->get_db_cart($cek_token['token']);

			if ($cek_tbl) {
				$data_cart = $cek_tbl;
			}

		}else{
			return redirect('checkout');
			
		}
		

		$data = array(
			'content' => 'checkout/view_checkout_2',
			'modal' => 'checkout/modal_checkout',
			'count_kategori' => $count_kategori,
			'submenu' => $submenu,
			'data_cart' => $data_cart,
			'menu_navbar' => $menu_navbar,
			'js' => 'checkout/jsCheckout',
			'menu_select_search' => $menu_select_search,
			'data_user' => $data_user,
		);

        $this->load->view('temp',$data);
	}

	public function step3()
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
		$data_user = $this->m_ckt->get_data_user($id_user);
		
		$cek_token = $this->check_token_session();
		if($cek_token['status']) {
			$cek_tbl = $this->m_ckt->get_db_cart($cek_token['token']);

			if ($cek_tbl) {
				$data_cart = $cek_tbl;
			}

		}else{
			return redirect('checkout');
			
		}
		

		$data = array(
			'content' => 'checkout/view_checkout_3',
			'modal' => 'checkout/modal_checkout',
			'count_kategori' => $count_kategori,
			'submenu' => $submenu,
			'data_cart' => $data_cart,
			'menu_navbar' => $menu_navbar,
			'js' => 'checkout/jsCheckout',
			'menu_select_search' => $menu_select_search,
			'data_user' => $data_user,
		);

        $this->load->view('temp',$data);
	}

	public function suggest_provinsi()
	{
		$provinsi = [];
		if(!empty($this->input->get("term"))){
			$key = $_GET['term'];
			$query = $this->m_ckt->lookup_data_provinsi($key);
		}else{
			$query = $this->m_ckt->lookup_data_provinsi();
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
		if(!empty($this->input->get("term"))){
			$key = $_GET['term'];
			$query = $this->m_ckt->lookup_data_kotakabupaten($key, $id_provinsi);
		}else{
			$key = "";
			$query = $this->m_ckt->lookup_data_kotakabupaten($key, $id_provinsi);
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
		if(!empty($this->input->get("term"))){
			$key = $_GET['term'];
			$query = $this->m_ckt->lookup_data_kecamatan($key, $id_kota);
		}else{
			$key = "";
			$query = $this->m_ckt->lookup_data_kecamatan($key, $id_kota);
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
		if(!empty($this->input->get("term"))){
			$key = $_GET['term'];
			$query = $this->m_ckt->lookup_data_kelurahan($key, $id_kecamatan);
		}else{
			$key = "";
			$query = $this->m_ckt->lookup_data_kelurahan($key, $id_kecamatan);
		}
		
		foreach ($query as $row) {
			$kelurahan[] = array(
						'id' => $row->id_kelurahan,
						'text' => $row->nama_kelurahan,
					);
		}
		echo json_encode($kelurahan);
	}

	private function rule_validasi_step1()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if ($this->input->post('email') == '') {
			$data['inputtipe'][] = 'text';
			$data['inputerror'][] = 'email';
			$data['error_string'][] = 'Wajib mengisi email';
			$data['status'] = FALSE;
		}

		if ($this->input->post('hp') == '') {
			$data['inputtipe'][] = 'text';
			$data['inputerror'][] = 'hp';
			$data['error_string'][] = 'Wajib mengisi hp';
			$data['status'] = FALSE;
		}

		if ($this->input->post('nama') == '') {
			$data['inputtipe'][] = 'text';
			$data['inputerror'][] = 'nama';
			$data['error_string'][] = 'Wajib mengisi nama';
			$data['status'] = FALSE;
		}

		if ($this->input->post('provinsi') == '') {
			$data['inputtipe'][] = 'select2';
			$data['inputerror'][] = 'provinsi';
			$data['error_string'][] = 'Wajib mengisi provinsi';
			$data['status'] = FALSE;
		}

		if ($this->input->post('kota') == '') {
			$data['inputtipe'][] = 'select2';
			$data['inputerror'][] = 'kota';
			$data['error_string'][] = 'Wajib mengisi kota';
			$data['status'] = FALSE;
		}

		// if ($this->input->post('kecamatan') == '') {
		// 	$data['inputtipe'][] = 'select2';
		// 	$data['inputerror'][] = 'kecamatan';
		// 	$data['error_string'][] = 'Wajib mengisi kecamatan';
		// 	$data['status'] = FALSE;
		// }

		// if ($this->input->post('kelurahan') == '') {
		// 	$data['inputtipe'][] = 'select2';
		// 	$data['inputerror'][] = 'kelurahan';
		// 	$data['error_string'][] = 'Wajib mengisi kelurahan';
		// 	$data['status'] = FALSE;
		// }

		if ($this->input->post('alamat') == '') {
			$data['inputtipe'][] = 'text';
			$data['inputerror'][] = 'alamat';
			$data['error_string'][] = 'Wajib mengisi alamat';
			$data['status'] = FALSE;
		}
	

        return $data;
	}

	public function get_data_harga()
	{		
		$checkout_data = $this->check_token_session();
		$kurir = $this->input->post('kurir');
		$html = '';

		if($checkout_data) {
			$data = $this->ekspedisi_ongkir(self::KOTA_ORIGIN, $checkout_data['data']->id_kota, $checkout_data['data']->berat_total, $kurir);
			

			if($data) {
				$retval = [];
				foreach ($data['rajaongkir']['results'] as $key => $value) {
					foreach ($value['costs'] as $k => $v) {
						$arr_data['kurir'] = $value['name'];
						$arr_data['paket'] = $v['service'].' - '.$v['description'];
						$arr_data['asal'] = $data['rajaongkir']['origin_details']['type'].' '.$data['rajaongkir']['origin_details']['city_name'].' '.$data['rajaongkir']['origin_details']['province'];
						$arr_data['tujuan'] = $data['rajaongkir']['destination_details']['type'].' '.$data['rajaongkir']['destination_details']['city_name'].' '.$data['rajaongkir']['destination_details']['province'];
						$arr_data['harga'] = $v['cost'][0]['value'];
						$arr_data['estimasi'] = $v['cost'][0]['etd'];
						$retval[] = $arr_data;
					}
				}

				$html = $this->get_tabel_list_ekspedisi($retval);
				$data = $retval;
				$status = true;
			}else{
				$data = null;
				$status = false;
			}
		}else{
			$data = null;
			$status = false;
		}
		
		echo json_encode(['status' => $status, 'data' => $data, 'html' => $html]);
	}

	private function get_tabel_list_ekspedisi($data)
	{
		$html = "
		<table class='table'>
			<thead>
				<tr>
					<th>Kurir</th>
					<th>Paket</th>
					<th>Asal</th>
					<th>Tujuan</th>
					<th>Harga</th>
					<th>Estimasi Hari</th>
					<th>Pilih</th>
				</tr>
			</thead>
			<tbody>";


		foreach ($data as $key => $value) {
			$strHarga = "<span class='float-left'>Rp. </span><span class='float-right'>".number_format($value['harga'],0,',','.')."</span>";
			$html .= "
				<tr>
					<td data-kurir='".$value['kurir']."'>".$value['kurir']."</td>
					<td data-paket='".$value['paket']."'>".$value['paket']."</td>
					<td data-asal='".$value['asal']."'>".$value['asal']."</td>
					<td data-tujuan='".$value['tujuan']."'>".$value['tujuan']."</td>
					<td data-harga='".$value['harga']."'>".$strHarga."</td>
					<td data-estimasi='".$value['estimasi']."'>".$value['estimasi']."</td>
					<td><button type='button' class='btn btn-sm btn-primary' onclick='pilihKurir($(this))'>Pilih Kurir</button></td>
				</tr>";
		}

		$html .= "</tbody></table>";
		return $html;
	}

	public function simpan_data_kurir()
	{
		$obj_date = new DateTime();
		$date = $obj_date->format('Y-m-d');
		$timestamp = $obj_date->format('Y-m-d H:i:s');
		$html = '';

		$data_input = [
			'kurir' => $this->input->post('kurir'),
			'paket' => $this->input->post('paket'),
			'asal' => $this->input->post('asal'),
			'tujuan' => $this->input->post('tujuan'),
			'estimasi' => $this->input->post('estimasi'),
			'harga' => $this->input->post('harga')
		];
		

		$cek_sesi = $this->check_token_session();
		if($cek_sesi) {
			// update
			$data = [
				'jasa_ekspedisi' => $data_input['kurir'],
				'pilihan_paket' => $data_input['paket'],
				'estimasi_datang' => $data_input['estimasi'],
				'ongkos_kirim' => $data_input['harga'],
				'ongkos_total' => (float)$data_input['harga'] + (float)$cek_sesi['data']->harga_total_produk,
				'kota_asal_txt' => $data_input['asal'],
				'kota_tujuan_txt' => $data_input['tujuan'],
				'updated_at' => $timestamp

			];
			$upd = $this->m_ckt->update_data('tbl_checkout', $data, ['token' => $cek_sesi['token']]);

			if($upd) {
				$html = $this->get_template_kurir_terpilih($data_input);
				echo json_encode(['status' => true, 'html' => $html]);
			}else{
				echo json_encode(['status' => false, 'html' => $html]);
			}
		}else{
			return redirect('checkout');
		}
	}

	public function get_data_kurir_terpilih()
	{
		$cek_sesi = $this->check_token_session();
		if($cek_sesi && $cek_sesi['data']->jasa_ekspedisi) {
			$data = [
				'kurir' => $cek_sesi['data']->jasa_ekspedisi,
				'paket' => $cek_sesi['data']->pilihan_paket,
				'asal' => $cek_sesi['data']->kota_asal_txt,
				'tujuan' => $cek_sesi['data']->kota_tujuan_txt,
				'estimasi' => $cek_sesi['data']->estimasi_datang,
				'harga' => $cek_sesi['data']->ongkos_kirim
			];

			$html = $this->get_template_kurir_terpilih($data);
			$status = true;
		}else{
			$html = '';
			$status = false;
		}

		echo json_encode(['status' => $status, 'html' => $html]);
	}

	private function get_template_kurir_terpilih($data)
	{
		$html = "
		<h4>Kurir yang anda pilih : </h4>
		<table class='table table-bordered'>
			<thead>
				<tr style='background-color:#4fbfa8;border-color:#4fbfa8'>
					<th>Kurir</th>
					<th>Paket</th>
					<th>Asal</th>
					<th>Tujuan</th>
					<th>Harga</th>
					<th>Estimasi Hari</th>
				</tr>
			</thead>
			<tbody>";

		$strHarga = "<span class='float-left'>Rp. </span><span class='float-right'>".number_format($data['harga'],0,',','.')."</span>";
		$html .= "
			<tr>
				<td>".$data['kurir']."</td>
				<td>".$data['paket']."</td>
				<td>".$data['asal']."</td>
				<td>".$data['tujuan']."</td>
				<td>".$strHarga."</td>
				<td>".$data['estimasi']."</td>
			</tr>";
		

		$html .= "</tbody></table>";
		return $html;
	}


	/////////////////////////////////////////////////////////


	public function get_berat_total_cart()
	{
		//get berat total
		$beratTotal=0;
        foreach($this->cart->contents() as $item)
        {
           $beratTotal += $item['options']['Berat_produk'] * $item['qty'];
        }

        echo json_encode($beratTotal);
	}

	public function generateRandomString($length = 8) {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}

	public function get_html_form()
	{
		$metode = $this->input->get('file_inc');
		$sesi = $this->check_token_session();
		$checkout = $sesi['data'];

		if($metode == 'transfer'){
			$retval = $this->get_form_transfer($checkout);
		}else{
			$retval = $this->get_form_payment($checkout);
		}

		echo json_encode($retval);

	}

	private function get_form_transfer($data)
	{
		$data_detail = $this->m_ckt->get_data_produk($data->id_checkout);
		
		$html = '
			<div class="divider text-center"><span class="outer-line"></span><span class="outer-line"></span></div>
				<br>
				<form id="form_proses_transfer" method="post" enctype="multipart/form-data" class="ps-checkout__form">
					<div class="row">
						<div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 ">
							<div class="ps-checkout__billing">
								<div class="form-group">
									<label for="Wajib Diisi"><strong>Rincian Pembayaran.</strong></label>
									<table class="table table-borderless">
										<tbody>
											<tr>
												<td>Atas Nama</td>
												<td>:</td>
												<td>'.$data_detail[0]->nama.'</td>
											</tr>
											<tr>
												<td>Telp/Hp</td>
												<td>:</td>
												<td>'.$data_detail[0]->telp.'</td>
											</tr>
											<tr>
												<td>Email</td>
												<td>:</td>
												<td>'.$data_detail[0]->email.'</td>
											</tr>
											<tr>
												<td>Alamat</td>
												<td>:</td>
												<td>'.$data_detail[0]->kota_tujuan_txt.'</td>
											</tr>
										</tbody>
									</table>
								</div>
								<div class="table-responsive">
									<table class="table table-bordered" style="font-size:12px;">
										<thead>
											<tr>
												<th>Gambar</th>
												<th>Nama Produk</th>
												<th>Ukuran</th>
												<th>Qty</th>
												<th>Berat Total</th>
												<th>Harga Satuan</th>
												<th>Harga Total</th>
											</tr>
										</thead>
										<tbody id="show_detail">';

										foreach ($data_detail as $key => $value) {
											$html .= '<tr>
												<td><img src="'.base_url("assets/img/produk/$value->nama_gambar").'" width="50" height="50"></td>
												<td>'.$value->nama_produk.'</td>
												<td>'.$value->ukuran_produk.'</td>
												<td>'.$value->qty.'</td>
												<td>'.($value->berat_satuan * $value->qty).' gram</td>
												<td><span class="pull-left">Rp. </span><span class="pull-right">'.number_format($value->harga_satuan,0,",",".").'</span></td>
												<td><span class="pull-left">Rp. </span><span class="pull-right">'.number_format(($value->harga_satuan * $value->qty),0,",",".").'</span></td>
											</tr>';
										}

										$html .= '
											<tr>
												<td colspan="6">Harga Total Produk</td>
												<td><span class="pull-left">Rp. </span><span class="pull-right">'.number_format($data_detail[0]->harga_total_produk,0,",",".").'</span></td>
											</tr>
											<tr>
												<td colspan="6">'.$data_detail[0]->jasa_ekspedisi.' '.$data_detail[0]->pilihan_paket.'</td>
												<td><span class="pull-left">Rp. </span><span class="pull-right">'.number_format($data_detail[0]->ongkos_kirim,0,",",".").'</span></td>
											</tr>
											<tr>
												<td colspan="6">Total Keseluruhan</td>
												<td><span class="pull-left">Rp. </span><span class="pull-right">'.number_format($data_detail[0]->ongkos_total,0,",",".").'</span></td>
											</tr>
										';
										
										$html .= '</tbody>
									</table>
									</div>
									<div class="form-group form-group--inline">
										<label>Upload Bukti Transfer</label>
										<div></div>
										<div class="custom-file">
											<input type="hidden" class="form-control" id="id_checkout" name="id_checkout" value="'.$data_detail[0]->id_checkout.'">
											<input type="file" class="form-control" onchange="readURL(this)" id="bukti_transfer" style="" name="bukti_transfer" accept=".jpg,.jpeg,.png">
											<span class="help-block"></span>
										</div>
									</div>
									<div class="form-group" id="div_preview_foto" style="display: none;">
										<label for="" class="form-control-label">Preview Bukti:</label>
										<div></div>
										<img id="preview_img" src="#" alt="Preview Foto" height="200" width="200"/>
										<span class="help-block"></span>
									</div>
									<div class="form-group">
										<label for="Wajib Diisi"><strong>Keterangan.</strong></label>
										<br>
										<p style="font-size:18px; font-family:arial; color:red; line-height:24px;">Setelah anda upload bukti transfer, admin akan mengecek. Setelah pembayarannya masuk, admin akan kirimkan Username & Password ke email anda.</p>
									</div>
								</div>
							</div>
							<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 ">
								<div class="ps-checkout__order">
									<footer>
										<h3>Pembayaran dengan Transfer</h3>
										<div class="form-group cheque">
											<div class="">
												<p>Transfer <strong>Rp '.number_format($data->ongkos_total,0,',','.').'</strong> ke Nomor Rekening di bawah Ini.</p>
												<p>Rekening BCA : <span style="font-family:arial;">0885-181-223</span> <br> a.n Cipto Junaidi</p>
											</div>
										</div>
										<div class="ps-shipping">
											<p>Upload bukti transfer dg <strong>klik kolom upload di atas.</strong> Setelah  upload, lalu klik tombol Proses Menyimpan Data Pembayaran</p>
											<div class="form-group paypal">
												<button type="button" class="btn btn-md btn-success" id="pay-button" onclick="aksi_transfer()">Proses Menyimpan Data Pembayaran<i class="ps-icon-next"></button>
											</div>
										</div>
									</footer>
								</div>
								<div class="ps-shipping">
									<p>Kuota Terbatas. Yang duluan transfer, dilayani duluan.</p>
								</div>
							</div>
						</div>
					</div
				</form>
			</div>
		';

		return $html;
	}

	private function get_form_payment($data)
	{
		$html = '<div class="divider text-center"><span class="outer-line"></span><span class="outer-line"></span></div>
		<form id="payment-form" method="post" action="finish">
			<input type="hidden" name="result_type" id="result-type" value=""></div>
			<input type="hidden" name="result_data" id="result-data" value=""></div>
		</form>
				<br>
				<form id="form_proses_payment" method="post" enctype="multipart/form-data" class="ps-checkout__form">
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<!--<div class="alert alert-warning">
							<strong>Peringatan!</strong> Harap isikannn email anda dengan benar & Mohon periksa kembali !
						</div>-->
							<div class="ps-checkout__billing">
								<div class="form-group form-group--inline">
									<label>Nama Depan<span></span>
									</label>
									<input type="hidden" id="id" name="id" value="a1">
									<input class="form-control" style="" type="hidden" name="address" id="address">
									<input class="form-control" style="" type="text" name="nama_depan" id="nama_depan">
									<input type="hidden" name="keterangan" id="keterangan" value="">
									<span class="help-block"></span>
								</div>
								<div class="form-group form-group--inline">
									<label>Nama Belakang<span></span>
									</label>
									<input class="form-control" style="" type="text" name="nama_belakang" id="nama_belakang">
									<span class="help-block"></span>
								</div>
							
								<div class="form-group form-group--inline">
									<label>Email<span></span>
									</label>
									<input class="form-control" style="" type="email" name="email" id="email" placeholder="">
									<span class="help-block"></span>
								</div>
								
								<!--<div class="form-group form-group--inline">
									<label>Username<span></span>
									</label>
									<input class="form-control" style="" type="text" name="username" id="username" autocomplete="off">
									<span class="help-block"></span>
								</div>-->
								
								<!--<div class="form-group form-group--inline">
									<label>Password<span></span>
									</label>
									<input class="form-control" style="" type="password" name="password" id="password" autocomplete="off">
									<span class="help-block"></span>
								</div>-->
								
								<!--<div class="form-group form-group--inline">
									<label>Tulis Ulang Password<span></span>
									</label>
									<input class="form-control" style="" type="password" name="repassword" id="repassword" autocomplete="off">
									<span class="help-block"></span>
								</div>-->
								
								<div class="form-group form-group--inline">
									<label>No. Telepon<span></span>
									</label>
									<input class="form-control numberinput" style="" type="text" name="telp" id="telp">
									<span class="help-block"></span>
								</div>
								
								<!--<div class="form-group form-group--inline">
									<label>Nama Bank<span></span>
									</label>
									<input class="form-control" style="" type="text" name="bank" id="bank" placeholder="misal: BCA, MANDIRI, dll">
									<span class="help-block"></span>
								</div>-->
								
								<!--<div class="form-group form-group--inline">
									<label>No. Rekening<span></span>
									</label>
									<input class="form-control numberinput" style="" type="text" name="norek" id="norek">
									<span class="help-block"></span>
								</div>-->
								
								<div class="form-group--inline paypal">
									<button type="button" class="btn btn-md btn-success" id="pay-button" onclick="aksi_payment()">Continue<i class="ps-icon-next"></button>
								</div>
								<br>
									<p style="font-size:18px; color:blue; line-height:24px;"><strong><span style="font-family:arial;font-style:normal!important;">Data di atas perlu benar karena untuk penghasilan anda nantinya tiap bulan dari kami.</span></strong></p>
								
								<div class="ps-shipping">
									<p>Kuota Terbatas. Yang duluan transfer, dilayani duluan.</p>
								</div>
							</div>
						</div>
					</div>
				</form>';

		return $html;
	}

	public function trans_manual()
	{
		$obj_date = new DateTime();
		$timestamp = $obj_date->format('Y-m-d H:i:s');
		$id_checkout = $this->input->post('id_checkout');

		$this->db->trans_begin();
		$file_mimes = ['image/png', 'image/x-citrix-png', 'image/x-png', 'image/x-citrix-jpeg', 'image/jpeg', 'image/pjpeg'];
		if(isset($_FILES['bukti_transfer']['name']) && in_array($_FILES['bukti_transfer']['type'], $file_mimes)) {
									
			if (!file_exists('./assets/img/bukti_transfer')) {
				mkdir('./assets/img/bukti_transfer', 0777, true);
			}
			$namafileseo = $this->seoUrl($id_checkout.'-'.time());
			$this->konfigurasi_upload_img($namafileseo);
			
			//get detail extension
			$pathDet = $_FILES['bukti_transfer']['name'];
			$extDet = pathinfo($pathDet, PATHINFO_EXTENSION);

			if ($this->file_obj->do_upload('bukti_transfer')) 
			{	
				$gbrBukti = $this->file_obj->data();
				$nama_file_foto = $gbrBukti['file_name'];
				$resize = $this->konfigurasi_image_resize($nama_file_foto);
				
				$output_thumb = $this->konfigurasi_image_thumb($nama_file_foto, $gbrBukti);
				$this->image_lib->clear();
				## replace nama file + ext
				$namafileseo = $namafileseo.'.'.$extDet;
			} else {
				$error = array('error' => $this->file_obj->display_errors());
			}
		}else{
			$data['inputerror'][] = 'bukti_transfer';
			$data['error_string'][] = 'Wajib Mengisi Bukti Transfer';
			$data['status'] = FALSE;
			echo json_encode($data);
			return;
		}

		$order_id = $this->generate_order_id_manual();
		// $kode_ref = $this->cek_kode_affiliate();
		
		$data_trans = [
			'order_id' => $order_id,
			'updated_at' => $timestamp,
			'bukti_transfer'	=> 'assets/img/bukti_transfer/'.$namafileseo,
			'bukti_transfer_thumb' => 'assets/img/bukti_transfer/thumbs/'.$output_thumb,
			'is_manual' => 1
		];


		$update = $this->m_ckt->update_data('tbl_checkout', $data_trans, ['id_checkout' => $id_checkout]);
		
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$retval['status'] = false;
			$retval['pesan'] = 'Gagal menambahkan transaksi';
			$retval['redirect'] = base_url('checkout/step3');
		}else{
			$this->db->trans_commit();
			$retval['status'] = true;
			$retval['pesan'] = 'Sukses menambahkan transaksi';
			$retval['redirect'] = base_url('home');
		}

		echo json_encode($retval);
	}

	private function konfigurasi_upload_img($nmfile)
	{ 
		//konfigurasi upload img display
		$config['upload_path'] = './assets/img/bukti_transfer';
		$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
		$config['overwrite'] = TRUE;
		$config['max_size'] = '4000';//in KB (4MB)
		$config['max_width']  = '0';//zero for no limit 
		$config['max_height']  = '0';//zero for no limit
		$config['file_name'] = $nmfile;
		//load library with custom object name alias
		$this->load->library('upload', $config, 'file_obj');
	}

	private function konfigurasi_image_resize($nmfile)
	{
		//konfigurasi image lib
	    $config['image_library'] = 'gd2';
	    $config['source_image'] = './assets/img/bukti_transfer/'.$nmfile;
	    $config['create_thumb'] = FALSE;
	    $config['maintain_ratio'] = FALSE;
	    $config['new_image'] = './assets/img/bukti_transfer/'.$nmfile;
	    $config['overwrite'] = TRUE;
	    $config['width'] = 480; //resize
	    $config['height'] = 600; //resize
	    $this->load->library('image_lib',$config); //load image library
	    $this->image_lib->initialize($config);
		$this->image_lib->resize();
	}

	private function konfigurasi_image_thumb($filename, $gbr)
	{
		//buat folder
		if (!file_exists('./assets/img/bukti_transfer/thumbs')) {
			mkdir('./assets/img/bukti_transfer/thumbs', 0777, true);
		}

		//konfigurasi image lib
	    $config2['image_library'] = 'gd2';
	    $config2['source_image'] = './assets/img/bukti_transfer/'.$filename;
	    $config2['create_thumb'] = TRUE;
	 	$config2['thumb_marker'] = '_thumb';
	    $config2['maintain_ratio'] = FALSE;
	    $config2['new_image'] = './assets/img/bukti_transfer/thumbs'.'/'.$filename;
	    $config2['overwrite'] = TRUE;
	    $config2['quality'] = '100%';
	 	$config2['width'] = 45;
	 	$config2['height'] = 45;
	    $this->load->library('image_lib',$config2); //load image library
	    $this->image_lib->initialize($config2);
	    $this->image_lib->resize();
	    return $output_thumb = $gbr['raw_name'].'_thumb'.$gbr['file_ext'];	
	}

	private function seoUrl($string) {
	    //Lower case everything
	    $string = strtolower($string);
	    //Make alphanumeric (removes all other characters)
	    $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
	    //Clean up multiple dashes or whitespaces
	    $string = preg_replace("/[\s-]+/", " ", $string);
	    //Convert whitespaces and underscore to dash
	    $string = preg_replace("/[\s_]/", "-", $string);
	    return $string;
	}

	private function generate_order_id_manual() {

		$chars = array(
			'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm',
			'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
			'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M',
			'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
			'0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
		);
	
		shuffle($chars);
	
		$num_chars = count($chars) - 1;
		$token = '';
	
		for ($i = 0; $i < 8; $i++){ // <-- $num_chars instead of $len
			$token .= $chars[mt_rand(0, $num_chars)];
		}
	
		return $token;
	}
	
	private function rand_string() {

		$chars = array(
			'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm',
			'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
			'0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
		);
	
		shuffle($chars);
	
		$num_chars = count($chars) - 1;
		$token = '';
	
		for ($i = 0; $i < 3; $i++){ // <-- $num_chars instead of $len
			$token .= $chars[mt_rand(0, $num_chars)];
		}
	
		return $token;
	}
}
