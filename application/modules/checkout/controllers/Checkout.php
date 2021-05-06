<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checkout extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('cart');
		$this->load->model('homepage/mod_homepage','mod_hpg');
		$this->load->model('mod_checkout','m_ckt');
	}
	
	public function index()
	{
		$id_user = $this->session->userdata('id_user');
		$menu_navbar = $this->mod_hpg->get_menu_navbar();
		$count_kategori = $this->mod_hpg->count_kategori();
		$submenu = array();
		$row_id_concat = '';
		for ($i=1; $i <= $count_kategori; $i++) { 
			//set array key berdasarkan loop dari angka 1
			$submenu[$i] =  $this->mod_hpg->get_submenu_navbar($i);	
		}
		$menu_select_search = $this->mod_hpg->get_menu_search();
		$data_user = $this->m_ckt->get_data_user($id_user);

		if(count($this->cart->contents()) >= 1) {
			foreach ($this->cart->contents() as $key => $value) {
				$row_id_concat .= $value['rowid'];
			}
		}

		$cek_tbl = $this->m_ckt->get_db_cart($row_id_concat);
		//echo $this->db->last_query();exit;
		
		if($cek_tbl) {
			$data_cart = $cek_tbl;
		}else{
			$data_cart = null;
		}

		echo "<pre>";
		print_r ($data_cart);
		echo "</pre>";
		exit;
		
		// echo "<pre>";
		// print_r ($this->cart->contents());
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
			'data_user' => $data_user,
		);

        $this->load->view('temp',$data);
	}

	public function step2()
	{
		$id_user = $this->session->userdata('id_user');
		$menu_navbar = $this->mod_hpg->get_menu_navbar();
		$count_kategori = $this->mod_hpg->count_kategori();
		$submenu = array();
		$row_id_concat = '';
		for ($i=1; $i <= $count_kategori; $i++) { 
			//set array key berdasarkan loop dari angka 1
			$submenu[$i] =  $this->mod_hpg->get_submenu_navbar($i);	
		}
		$menu_select_search = $this->mod_hpg->get_menu_search();
		$data_user = $this->m_ckt->get_data_user($id_user);
		
		if(count($this->cart->contents()) >= 1) {
			foreach ($this->cart->contents() as $key => $value) {
				$row_id_concat .= $value['rowid'];
			}
		}

		$cek_tbl = $this->m_ckt->single_row('tbl_checkout', ['row_id_concat' => $row_id_concat, 'deleted_at' => null]);
		if($cek_tbl) {
			$data_cart = $cek_tbl;
		}else{
			$data_cart = null;
		}
		
		// echo "<pre>";
		// print_r ($data_cart);
		// echo "</pre>";
		// exit;

		$data = array(
			'content' => 'checkout/view_checkout_1',
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
		$kecamatan = $this->input->post('kecamatan');
		$kelurahan = $this->input->post('kelurahan');
		$alamat = $this->input->post('alamat');

		if(count($this->cart->contents()) >= 1) {
			$row_id_concat = '';
			$harga_total = 0;
			$arr_data_det = [];
			foreach ($this->cart->contents() as $key => $value) {
				$harga_total += (float)$value['price'];
				$row_id_concat .= $value['rowid'];

				$arr_data_det[] = [
					'id_checkout' => $id_header,
					'id_produk' => $value['id'],
					'id_satuan' => $value['options']['Id_satuan_produk'],
					'id_stok' => $value['options']['Id_stok_produk'],
					'sess_row_id' => $value['rowid'],
					'harga_satuan' => $value['price']
				];
			}

			//cek di checkout apakah ada transaksi dengan rowid concat diatas
			$cek_tbl = $this->m_ckt->single_row('tbl_checkout', ['row_id_concat' => $row_id_concat, 'deleted_at' => null]);
			if($cek_tbl) {
				$flag_trans = 'update';
			}else{
				$flag_trans = 'insert';
			}
		}else{
			$retval['status'] = false;
			$retval['pesan'] = 'Data keranjang belanja kosong';
			echo json_encode($retval);
			return;
		}

		$this->db->trans_begin();
		

		if($flag_trans == 'insert') {
			$arr_data = [
				'id_checkout' => $id_header,
				'tgl_checkout' => $date,
				'status' => 1,
				'harga_total_produk' => $harga_total,
				'nama' => $nama,
				'alamat' => $alamat,
				'id_kel' => $kelurahan,
				'id_kec' => $kecamatan,
				'id_kota' => $kota,
				'id_prov' => $provinsi,
				'email' => trim($email),
				'telp' => trim($hp),
				'row_id_concat' => $row_id_concat,
				'created_at' => $timestamp
			];

			$ins = $this->m_ckt->insert_data('tbl_checkout', $arr_data);

			foreach ($arr_data_det as $k => $v) {
				$data_det = [
					'id_checkout' => $v['id_checkout'],
					'id_produk' => $v['id_produk'],
					'id_satuan' => $v['id_satuan'],
					'id_stok' => $v['id_stok'],
					'sess_row_id' => $v['sess_row_id'],
					'harga_satuan' => $v['harga_satuan'],
					'created_at' => $timestamp
				];
				$this->m_ckt->insert_data('tbl_checkout_detail', $data_det);
			}
		}else{
			$arr_data = [
				'tgl_checkout' => $date,
				'harga_total_produk' => $harga_total,
				'nama' => $nama,
				'alamat' => $alamat,
				'id_kel' => $kelurahan,
				'id_kec' => $kecamatan,
				'id_kota' => $kota,
				'id_prov' => $provinsi,
				'email' => trim($email),
				'telp' => trim($hp),
				'row_id_concat' => $row_id_concat,
				'updated_at' => $timestamp
			];

			$upd = $this->m_ckt->update_data('tbl_checkout', $arr_data, ['id_checkout' => $cek_tbl->id_checkout]);

			foreach ($arr_data_det as $k => $v) {
				$data_det = [
					'id_produk' => $v['id_produk'],
					'id_satuan' => $v['id_satuan'],
					'id_stok' => $v['id_stok'],
					'sess_row_id' => $v['sess_row_id'],
					'harga_satuan' => $v['harga_satuan'],
					'updated_at' => $timestamp
				];
				$this->m_ckt->update_data('tbl_checkout_detail', $data_det, ['id' => $v['id_checkout']]);
			}
		}
		
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$retval['status'] = false;
			$retval['pesan'] = 'Gagal proses data';
		}else{
			$this->db->trans_commit();
			$retval['status'] = true;
			$retval['pesan'] = 'Sukses proses data';
		}

		echo json_encode($retval);
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

		if ($this->input->post('kecamatan') == '') {
			$data['inputtipe'][] = 'select2';
			$data['inputerror'][] = 'kecamatan';
			$data['error_string'][] = 'Wajib mengisi kecamatan';
			$data['status'] = FALSE;
		}

		if ($this->input->post('kelurahan') == '') {
			$data['inputtipe'][] = 'select2';
			$data['inputerror'][] = 'kelurahan';
			$data['error_string'][] = 'Wajib mengisi kelurahan';
			$data['status'] = FALSE;
		}

		if ($this->input->post('alamat') == '') {
			$data['inputtipe'][] = 'text';
			$data['inputerror'][] = 'alamat';
			$data['error_string'][] = 'Wajib mengisi alamat';
			$data['status'] = FALSE;
		}
	

        return $data;
	}


	/////////////////////////////////////////////////////////

	public function add_alamat_kirim()
	{
		$timestamp = date('Y-m-d H:i:s');
		$type = "kirim";
		$input = array(
				'id_user' => $this->input->post('checkout1Id'),
				'fname' => trim(strtoupper($this->input->post('checkout1Fname'))),
				'lname' => trim(strtoupper($this->input->post('checkout1Lname'))),
				'id_provinsi' => $this->input->post('checkout1Provinsi'),
				'id_kota' => $this->input->post('checkout1Kota'),
				'id_kecamatan' => $this->input->post('checkout1Kecamatan'),
				'id_kelurahan' => $this->input->post('checkout1Kelurahan'),
				'alamat' => trim(strtoupper($this->input->post('checkout1Alamat'))),
				'kdpos' => trim(strtoupper($this->input->post('checkout1Kdpos'))),
				'telp' => trim(strtoupper($this->input->post('checkout1Telp'))),
				'type' => $type,
				'timestamp' => $timestamp 
			);

		$insert = $this->m_ckt->insert_data_chekout1($input);

		echo json_encode(array(
			"status" => TRUE,
			"id" => $insert,
			"type" => $type,
			"pesan_kirim" => 'Ubah alamat pengiriman berhasil'
		));
	}

	public function add_alamat_tagih()
	{
		$timestamp = date('Y-m-d H:i:s');
		$type = "tagih";
		$input = array(
				'id_user' => $this->input->post('checkout1Id'),
				'fname' => trim(strtoupper($this->input->post('checkout1Fname'))),
				'lname' => trim(strtoupper($this->input->post('checkout1Lname'))),
				'id_provinsi' => $this->input->post('checkout1Provinsi'),
				'id_kota' => $this->input->post('checkout1Kota'),
				'id_kecamatan' => $this->input->post('checkout1Kecamatan'),
				'id_kelurahan' => $this->input->post('checkout1Kelurahan'),
				'alamat' => trim(strtoupper($this->input->post('checkout1Alamat'))),
				'kdpos' => trim(strtoupper($this->input->post('checkout1Kdpos'))),
				'telp' => trim(strtoupper($this->input->post('checkout1Telp'))),
				'type' => $type,
				'timestamp' => $timestamp 
			);

		$insert = $this->m_ckt->insert_data_chekout1($input);

		echo json_encode(array(
			"status" => TRUE,
			"id" => $insert,
			"type" => $type,
			"pesan_tagih" => 'Ubah alamat penagihan berhasil'
		));
	}

	public function ekspedisi_ongkir($origin="", $destination="", $weight="", $courier="")
	{
		$this->load->library('rajaongkir');
		$cities = $this->rajaongkir->cost($origin, $destination, $weight, $courier);
		return json_decode($cities, true);
	}
	
	public function get_alamat_user($id)
	{
		$data = $this->m_ckt->get_data_user($id);
		echo json_encode($data);
	}

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

	public function kota_ongkir($province_id="", $city_id="")
	{
		$this->load->library('rajaongkir');
		$cities = $this->rajaongkir->city($province_id, $city_id);
		return json_decode($cities, true);
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

	public function prov_ongkir()
	{
		$this->load->library('rajaongkir');
		$provinces = $this->rajaongkir->province();
		return json_decode($provinces, true);
	}
	
	

	public function suggest_provinsi_tujuan()
	{
		$provinsi = [];
		if(!empty($this->input->get("term"))){
			$key = $_GET['term'];
			$query = $this->prov_ongkir($key);
		}else{
			$query = $this->prov_ongkir();
		}

		/*print_r($query);*/
		if (isset($query['rajaongkir']['results'][0])) {
			for ($i=0; $i < count($query['rajaongkir']['results']); $i++) {
				$provinsi[] = array(
					'id' => $query['rajaongkir']['results'][$i]['province_id'],
					'text' => $query['rajaongkir']['results'][$i]['province'],
				);
			}
			echo json_encode($provinsi);
		}
	}

	public function suggest_kota_tujuan()
	{
		$id = $this->input->get("idProv");
		$kota = [];
		if(!empty($this->input->get("term"))){
			$key = $_GET['term'];
			$query = $this->kota_ongkir($id, $key);
		}else{
			$query = $this->kota_ongkir($id);
		}

		/*print_r($query);*/
		if (isset($query['rajaongkir']['results'][0])) {
			for ($i=0; $i < count($query['rajaongkir']['results']); $i++) {
				$kota[] = array(
					'id' => $query['rajaongkir']['results'][$i]['city_id'],
					'text' => $query['rajaongkir']['results'][$i]['city_name'],
				);
			}
			echo json_encode($kota);
		}
	}

	public function suggest_paket_ongkir()
	{
		$origin = intval($this->input->get("origin"));
		$destination = intval($this->input->get("id"));
		$weight = intval($this->input->get("berat"));
		$courier = $this->input->get("kurir");
		$paket = [];
		if(!empty($this->input->get("term"))){
			$key = $_GET['term'];
			$query = $this->ekspedisi_ongkir($origin, $destination, $weight, $courier, $key);
		}else{
			$query = $this->ekspedisi_ongkir($origin, $destination, $weight, $courier);
		}

		/*print_r($query);*/
		if (isset($query['rajaongkir']['results'][0]['costs'][0])) {
			for ($i=0; $i < count($query['rajaongkir']['results'][0]['costs']); $i++) {
				$paket[] = array(
					'id' => $query['rajaongkir']['results'][0]['costs'][$i]['service'],
					'text' => array(
							'service' => $query['rajaongkir']['results'][0]['costs'][$i]['description'], 
							'etd' => $query['rajaongkir']['results'][0]['costs'][$i]['cost'][0]['etd'],
							'value' => $query['rajaongkir']['results'][0]['costs'][$i]['cost'][0]['value']
						), 
				);
			}
			echo json_encode($paket);
		}
	}

	public function summary()
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

		$data_input = array(
			'no_ref' => $this->generateRandomString(),
			'iduser_krm' => $id_user,
			'fname_krm' => $this->input->post('FFnameKrm'),
			'lname_krm' => $this->input->post('FLnameKrm'),
			'alamat_krm' => $this->input->post('FAlamatKrm'),
			'kel_krm' => $this->input->post('FKelKrm'),
			'nm_kel_krm' => $this->input->post('FTxtKelKrm'),
			'kec_krm' => $this->input->post('FKecKrm'),
			'nm_kec_krm' => $this->input->post('FTxtKecKrm'),
			'kota_krm' => $this->input->post('FKotaKrm'),
			'nm_kota_krm' => $this->input->post('FTxtKotaKrm'),
			'prov_krm' => $this->input->post('FProvKrm'),
			'nm_prov_krm' => $this->input->post('FTxtProvKrm'),
			'kdpos_krm' => $this->input->post('FKdposKrm'),
			'telp_krm' => $this->input->post('FTelpKrm'),
			'method_krm' => $this->input->post('FMethodKrm'),
			'prov_kurir' => $this->input->post('FProvKurir'),
			'kota_kurir' => $this->input->post('FKotaKurir'),
			'berat_kurir' => $this->input->post('FBeratKurir'),
			'nama_kurir' => $this->input->post('FNamaKurir'),
			'paket_kurir' => $this->input->post('FPaketKurir'),
			'etd_kurir' => $this->input->post('FEtdKurir'),
			'harga_kurir' => $this->input->post('FHargaKurir'),
		);


		$data = array(
			'beratTotal' => 0,
			'data_input' => $data_input,
			'content' => 'checkout/view_summary',
			'modal' => 'checkout/modal_checkout',
			'count_kategori' => $count_kategori,
			'submenu' => $submenu,
			'menu_navbar' => $menu_navbar,
			'js' => 'checkout/jsCheckout',
			'menu_select_search' => $menu_select_search,
			'data_user' => $data_user,
		);

        $this->load->view('temp',$data);
	}

    public function proses_summary()
    {
    	$method = $this->input->post('frmMethod');
    	if ($method == "cod") {
    		$metode = "COD";
    	}else{
    		$metode = "TFR";
    	}
    	$kode = $this->m_ckt->getKodeCheckout($metode);
    	$kode_ref = $this->input->post('frmRef');
    	$total_bayar = $this->input->post('frmBeaTotal');
    	$waktu_tanggal = date('Y-m-d H:i:s');
    	$tanggal = date('Y-m-d');
    	//data header
    	$data_header = array(
    		'id_checkout' => $kode,
    		'id_user' => $this->session->userdata('id_user'),
    		'tgl_checkout' => $tanggal,
    		'status' => "aktif",
    		'harga_total_produk' => $this->input->post('frmBeaProduk'),
    		'jasa_ekspedisi' => $this->input->post('frmKurir'),
    		'pilihan_paket' => $this->input->post('frmPaket'),
    		'estimasi_datang' => $this->input->post('frmEtd'),
    		'ongkos_kirim' => $this->input->post('frmOngkir'),
    		'alamat_kirim' => $this->input->post('frmAlamatKrm'),
    		'fname_kirim' => strtoupper($this->input->post('frmFnameKrm')),
    		'lname_kirim' => strtoupper($this->input->post('frmLnameKrm')),
    		'ongkos_total' => $total_bayar,
    		'method_checkout' => $metode,
    		'kode_ref' => $kode_ref,
    		'timestamp' => $waktu_tanggal,
    	);

    	//data detail header
    	$hitung_item = count($this->input->post('frmIdproduk'));
		$data_item_detail = array();
			for ($i=0; $i < $hitung_item; $i++) 
			{
				$data_item_detail[$i] = array(
					'id_checkout' => $kode,
					'status' => "aktif",
					'id_produk' => $this->input->post('frmIdproduk')[$i],
					'id_satuan' => $this->input->post('frmIdsatuan')[$i],
					'id_stok' => $this->input->post('frmIdstok')[$i],
					'qty' => $this->input->post('frmIdqty')[$i],
				);
			}
		//insert to db
		$insert = $this->m_ckt->simpan_data($data_header, $data_item_detail);

		//remove cart after insert
		$hitung_item_cart = count($this->input->post('rowId'));
		$data_cart = array();
		for ($i=0; $i < $hitung_item_cart; $i++)
		{
			$data_cart[$i] = array(
	            'rowid' => $this->input->post('rowId')[$i], 
	            'qty' => 0, 
	        );
		}
		// print_r($data_cart);
		$this->cart->update($data_cart);

		echo json_encode(array(
			"status" => TRUE,
			"pesan" => "Mohon Konfirmasi pembayaran sebelum 3 hari dari sekarang, untuk info lebih lanjut silahkan pilih menu nama anda pada menu navigasi. Terima kasih telah berbelanja."
			));
    }
 

	public function tampil_biaya_pengiriman($origin, $destination, $weight, $courier){
		echo "<pre>";
			print_r($this->ekspedisi_ongkir($origin, $destination, $weight, $courier));
		echo "</pre>";
	}

	public function tampil_kota($province_id="", $city_id=""){
		echo "<pre>";
			print_r($this->kota_ongkir($province_id, $city_id));
		echo "</pre>";
	}

	

}
