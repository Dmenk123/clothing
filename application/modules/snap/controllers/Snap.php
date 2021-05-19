<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Snap extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $params = array('server_key' => 'SB-Mid-server-baIKLPFjzA2U6XbOwd2-1ro0', 'production' => false);
		$this->load->library('midtrans');
		$this->load->library('veritrans');
		$this->midtrans->config($params);
		$this->load->helper('url');	
		// $this->load->model('mod_checkout','m_ckt');
		$this->load->model('m_global');
    }

    public function index()
    {
		
		
    }

    public function token()
    {
		$data_where = ['id_checkout' => '25ef8ddd-191e-440c-a64e-0d0ae94fd50a'];
		$join = [ 
			[
				'table' => 'tbl_produk',
				'on'	=> 'tbl_produk.id_produk = tbl_checkout_detail.id_produk'
			]
		];
		$checkout   = $this->m_global->multi_row(null, $data_where, 'tbl_checkout_detail', $join);
		$check      = $this->m_global->single_row("*", $data_where, 'tbl_checkout');
		

		// Optional

		$item_detail = array();
		$jumlah_harga = 0;
		for ($i=0; $i<count($checkout); $i++) { 
			
				$item[$i] = array(
					'id' => $checkout[$i]->id_produk,
					'price' => $checkout[$i]->harga_satuan,
					'quantity' => 1,
					'name' => $checkout[$i]->nama_produk
				);

				array_push($item_detail, $item[$i]);

				$jumlah_harga += $checkout[$i]->harga_satuan;

		};

		$order_id = rand();
		$jumlah = $jumlah_harga + $check->ongkos_kirim;
		$transaction_details = array(
			'order_id' => $order_id,
			'gross_amount' => $jumlah, // no decimal allowed for creditcard
		  );

		$ongkir = array(
			'id' => 'a002',
			'price' => $check->ongkos_kirim,
			'quantity' => 1,
			'name' => $check->pilihan_paket,
		);

		array_push($item_detail, $ongkir);

		// Optional
		$item_details = $item_detail;

		// Optional
		$billing_address = array(
		  'first_name'    => "tes",
		  'last_name'     => "coba",
		  'address'       => "Mangga 20",
		  'city'          => "Jakarta",
		  'postal_code'   => "16602",
		  'phone'         => "08923553636",
		  'country_code'  => 'IDN'
		);

		// Optional
		$shipping_address = array(
		  'first_name'    => "Obet",
		  'last_name'     => "Supriadi",
		  'address'       => "",
		  'city'          => "",
		  'postal_code'   => "",
		  'phone'         => "",
		  'country_code'  => ''
		);

		// Optional
		$customer_details = array(
		  'first_name'    => "coba",
		  'last_name'     => "tes",
		  'email'         => "ashbd@gmail.com",
		  'phone'         => "082352546236",
		  'billing_address'  => $billing_address,
		  'shipping_address' => $shipping_address
		);
		
	

		// Data yang akan dikirim untuk request redirect_url.
        $credit_card['secure'] = true;
        //ser save_card true to enable oneclick or 2click
        //$credit_card['save_card'] = true;

		$time = time();
		$custom_expiry = array(
			'start_time' => date("Y-m-d H:i:s O",$time),
			'unit' => 'minute', 
			'duration'  => 2
		);
        
        $transaction_data = array(
            'transaction_details'=> $transaction_details,
            'item_details'       => $item_details,
            'customer_details'   => $customer_details,
            'credit_card'        => $credit_card,
            'expiry'             => $custom_expiry
        );

		error_log(json_encode($transaction_data));
		$snapToken = $this->midtrans->getSnapToken($transaction_data);
		error_log($snapToken);
		echo $snapToken;
    }

	public function view_snap(){
		$this->load->view('checkout_snap');
	}

    public function finish()
    {

		$this->load->model('snapmodel');
    	$result = json_decode($this->input->post('result_data'));
    	if (isset($result->va_number[0]->bank)) {
			$bank = $result->va_number[0]->bank;
		} else {
			$bank = '-';
		}

		if (isset($result->va_number[0]->va_number)) {
			$va_number = $result->va_number[0]->va_number;
		} else {
			$va_number = '-';
		}

		if (isset($result->bca_va_number)) {
			$bca_va_number = $result->bca_va_number;
		} else {
			$bca_va_number = '-';
		}

		if (isset($result->bill_key)) {
			$bill_key = $result->bill_key;
		} else {
			$bill_key = '-';
		}

		if (isset($result->biller_code)) {
			$biller_code = $result->biller_code;
		} else {
			$biller_code = '-';
		}

		if (isset($result->permata_va_number)) {
			$permata_va_number = $result->permata_va_number;
		} else {
			$permata_va_number = '-';
		}

		$data = [
			'status_code' => $result->status_code,
			'status_message' => $result->status_message,
			'transaction_id' => $result->transaction_id,
			'order_id' => $result->order_id,
			'gross_amount' => $result->gross_amount,
			'payment_type' => $result->payment_type,
			'transaction_time' => $result->transaction_time,
			'transaction_status' => $result->transaction_status,
			'bank' => $bank,
			'va_number' => $va_number,
			'fraud_status' => $result->fraud_status,
			'bca_va_number' => $bca_va_number,
			'permata_va_number' => $permata_va_number,
			'pdf_url' => $result->pdf_url,
			'finish_redirect_url' => $result->finish_redirect_url,
			'bill_key' => $bill_key,
			'biller_code' => $biller_code,
		];

	    $return = $this->snapmodel->insert($data);
		$this->data['finish'] = json_decode($this->input->post('result_data'));

		// update status pembayaran
		
		// $order_id = $result->order_id;
		// $res = ($this->veritrans->status($order_id) );

		// $bank  		= (isset($result->va_numbers[0]->bank))?$result->va_numbers[0]->bank:"";
		// $va_number 	= (isset($result->va_numbers[0]->va_number))?$result->va_numbers[0]->va_number:"";

		// $data = [
		// 	'status_code' => $result->status_code,
		// 	'status_message' => $result->status_message,
		// 	'transaction_id' => $result->transaction_id,
		// 	'order_id' => $result->order_id,
		// 	'gross_amount' => $result->gross_amount,
		// 	'payment_type' => $result->payment_type,
		// 	'transaction_time' => $result->transaction_time,
		// 	'transaction_status' => $result->transaction_status,
		// 	'bank' => $bank,
		// 	'va_number' => $va_number,
		// 	'fraud_status' => $result->fraud_status,
		// ];

		// $transaksi = $this->m_global->single_row('*', array('order_id'=>$order_id), 'tbl_requesttransaksi');
		// $i = 0;
		// if(empty($transaksi)){
		// 	$this->m_global->store_id($data, 'tbl_requesttransaksi');
		// 	$i = $i + 1;
		// }else{
		// 	$this->m_global->update('tbl_requesttransaksi', $data, array('order_id'=>$order_id));
		// 	$i = $i + 2;
		// }

		// update status pembayaran
		if ($result->transaction_status == 'pending' || $result->transaction_status == 'settlement') {
			redirect('confirm/confirm_success/'.$result->order_id);
		}else{
			redirect('home/oops/');
		}

	}

	function tes() {
		$mysql_query = "SELECT * FROM contoh ORDER BY co_id DESC";
		$query = $this->db->query($mysql_query);

		$arr = [];
		foreach ($query->result_array() as $row) {
			array_push($arr, $row);
		}

		// echo "<pre>";
		// print_r($arr);

		return $arr;

    }
    
    private function rule_validasi()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if ($this->input->post('price') == '') {
			$data['inputerror'][] = 'keterangan';
            $data['error_string'][] = 'Wajib Memilih Nama keterangan';
            $data['status'] = FALSE;
		}

		if ($this->input->post('first_name') == '') {
			$data['inputerror'][] = 'nama_depan';
            $data['error_string'][] = 'Wajib Mengisi Nama Depan';
            $data['status'] = FALSE;
		}

		if ($this->input->post('email') == '') {
			$data['inputerror'][] = 'email';
            $data['error_string'][] = 'Wajib Mengisi Nama Email';
            $data['status'] = FALSE;
		}

		if ($this->input->post('telp') == '') {
			$data['inputerror'][] = 'telp';
            $data['error_string'][] = 'Wajib Mengisi Nomor Telp';
            $data['status'] = FALSE;
		}

        return $data;
	}
	
	public function get_html_form()
	{
		$metode = $this->input->get('file_inc');
		
		$harga = $this->m_global->single_row('*',['deleted_at' => null], 't_harga', NULL);
		
		$data = [
			'harga' => $harga
		];

		if($metode == 'transfer'){
			$retval = $this->get_form_transfer($data);
		}else{
			$retval = $this->get_form_payment($data);
		}

		echo json_encode($retval);

	}

	private function get_form_transfer($data)
	{
		$html = '<div class="divider text-center"><span class="outer-line"></span><span class="outer-line"></span></div>
					<br>
					<form id="form_proses_transfer" method="post" enctype="multipart/form-data" class="ps-checkout__form">
					<div class="row">
						<div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 ">
						<!--<div class="alert alert-warning">
							<strong>Peringatan!</strong> Harap isikan data anda dengan benar & pastikan melakukan <strong>Upload Bukti Transfer !</strong>
						</div>-->
							<div class="ps-checkout__billing">
								<div class="form-group form-group--inline">
									<label>Nama Depan<span></span>
									</label>
									<input class="form-control" style="" type="hidden" name="address_trans" id="address_trans" autocomplete="off">
									<input type="hidden" id="id_trans" name="id_trans" value="">
									<input class="form-control" style="" type="text" name="fname_trans" id="fname_trans">
									<span class="help-block"></span>
								</div>
								
								<div class="form-group form-group--inline">
									<label>Nama Belakang<span></span>
									</label>
									<input class="form-control" style="" type="text" name="lname_trans" id="lname_trans" autocomplete="off">
									<span class="help-block"></span>
								</div>
								
								<!--<div class="form-group form-group--inline">
									<label>Nama User<span></span>
									</label>
									<input class="form-control" style="" type="text" name="username" id="username" autocomplete="off">
									<span class="help-block"></span>
								</div>-->
								
								<div class="form-group form-group--inline">
									<label>Email<span></span>
									</label>
									<input class="form-control" style="" type="email" name="email_trans" id="email_trans" placeholder="">
									<span class="help-block"></span>
								</div>
								
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
									<input class="form-control numberinput" style="" type="text" name="telp_trans" id="telp_trans">
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
								
								<div class="form-group form-group--inline">
									<label>Upload Bukti Transfer</label>
									<div></div>
									<div class="custom-file">
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
									<!--<label for="">Mohon memasukkan nomor rekening anda dengan valid. Komisi anda akan kami transfer pada rekening yg anda daftarkan</label>-->
									<p style="font-size:18px; font-family:arial; color:red; line-height:24px;">Setelah anda upload bukti transfer, admin akan mengecek. Setelah pembayarannya masuk, admin akan kiirimkan Username & Password ke email anda.</p>
										<p>Sehingga anda nantinya <strong>bisa masuk ke Profile Brand Ambassador kami untuk mendapatkan link website Produk online yang sudah teridentifikasi dengan id anda.</strong> Sehingga bisa melihat penghasilan anda dari orang yang sudah membeli Produk online kami dari link anda.</p>
								</div>
							</div>
						</div>
						<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 ">
							<div class="ps-checkout__order">
								<footer>
									<h3>Pembayaran Langsung Transfer</h3>
									<div class="form-group cheque">
										<div class="">
											<p>Transfer <strong>Rp '.number_format($data['harga']->nilai_harga,0,',','.').'</strong> ke Nomor Rekening di bawah Ini.</p>
											<p>Rekening BCA : 0885-181-223 <br> a.n Cipto Junaidi</p>
										</div>
									</div>
									<div class="ps-shipping">
										<p style="font-size:18px; font-family:arial; color:blue; line-height:24px;"><strong>Setelah transfer, lalu fotokan bukti transfer untuk memulai Majang Link Produk Onlinekami.</strong></p>
										<p>Upload bukti transfer dg <strong>klik kolom upload di atas.</strong> Setelah  upload, lalu klik tombol Proses Pembayaran</p>
										<div class="form-group paypal">
											<button type="button" class="btn btn-md btn-success" id="pay-button" onclick="aksi_transfer()">Proses Data Pembayaran<i class="ps-icon-next"></button>
										</div>
									</div>
								</footer>
							</div>
							<div class="ps-shipping">
								<p>Kuota Terbatas. Yang duluan transfer, dilayani duluan.</p>
							</div>
						</div>
					</div>
				</form>';


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
									<button type="button" class="btn btn-md btn-success" id="pay-button" onclick="aksi_payment()">Bayar Sekarang<i class="ps-icon-next"></button>
								</div>
								<br>
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
		$arr_valid = $this->validasi_trans_manual();
		
		if ($arr_valid['status'] == FALSE) {
			echo json_encode($arr_valid);
			return;
		}

		$nama = trim($this->input->post('fname_trans').' '.$this->input->post('lname_trans'));
		// $username = trim($this->input->post('username'));
		// $bank = trim(strtoupper(strtolower($this->input->post('bank'))));
		// $rekening = trim($this->input->post('norek'));
		$email = trim($this->input->post('email_trans'));
		$telp = trim($this->input->post('telp_trans'));
		$alamat = trim($this->input->post('address_trans'));
		
		// $password = trim($this->input->post('password'));
		// $repassword = trim($this->input->post('repassword'));

		/*if ($password != $repassword) {
			$arr_error['inputerror'][] = 'password';
            $arr_error['error_string'][] = 'Password Tidak Sama';
			$arr_error['status'] = FALSE;

			$arr_error['inputerror'][] = 'repassword';
            $arr_error['error_string'][] = 'Password Tidak Sama';
            $arr_error['status'] = FALSE;
			
			echo json_encode($arr_error);
			return;
		}*/
        
        $username = trim(strtolower(str_ireplace(" ", "_", $this->input->post('fname_trans'))).'_'.strtolower(str_ireplace(" ", "_", $this->input->post('lname_trans'))));
        $password = '123456';
		$hash_password = $this->enkripsi->enc_dec('encrypt', $password);
		
		$id = $this->t_checkout->get_max_id();
		$namafileseo = $this->seoUrl($nama.' '.time());

		$this->db->trans_begin();

		$file_mimes = ['image/png', 'image/x-citrix-png', 'image/x-png', 'image/x-citrix-jpeg', 'image/jpeg', 'image/pjpeg'];

		if(isset($_FILES['bukti_transfer']['name']) && in_array($_FILES['bukti_transfer']['type'], $file_mimes)) {
									
			if (!file_exists('./files/img/bukti_bayar')) {
				mkdir('./files/img/bukti_bayar', 0777, true);
			}

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

		$harga = $this->m_global->single_row('*',['deleted_at' => null], 't_harga', NULL);
		
		$order_id = $this->generate_order_id_manual();
		$kode_agen = $this->m_user->get_kode_agen();
		$kode_ref = $this->cek_kode_affiliate();
		
		$data_trans = [
			'id' => $id,
			'nama' => $nama,
			'email' => $email,
			'telp' => $telp,
			'harga' => (float)$harga->nilai_harga,
			'harga_bruto' => (float)$harga->nilai_harga,
			'order_id' => $order_id,
			'alamat' => $alamat,
			'created_at' => $timestamp,
			'path_file'	=> 'files/img/bukti_bayar/'.$namafileseo,
			'path_thumb' => 'files/img/bukti_bayar/thumbs/'.$output_thumb,
			'is_manual' => 1,
			'kode_agen' => $kode_agen,
		];

		## sisipkan kode affiliate jika membeli melalui link referal
		if($kode_ref !== false) {
			$data_trans['kode_ref'] = $kode_ref;
			$data_trans['laba_agen_total'] = (float)$harga->laba_agen;
		}

		$insert = $this->t_checkout->save($data_trans);

		if($insert) {
			//data input array
			$input = array(
				'id_role' => 3, // role agen
				'username' => $username,
				'password' => $hash_password,
				'status' => '1',
				'kode_user' => $this->m_user->get_kode_user(),
				'kode_agen' => $kode_agen,
				'nama_lengkap' => $nama,
				'no_telp' => $telp,
				'created_at' => $timestamp,
				'email' => $email,
				//'bank' => $bank,
				//'rekening' => $rekening,
				'created_at' => $timestamp
			);

			$insert_user = $this->m_user->save($input);

			/*if($insert_user) {
				//login
				$user_exist = $this->m_global->single_row('*',['username' => $username,'password' => $hash_password, 'deleted_at' => null ], 'm_user', NULL);

				if($user_exist){
					$this->session->set_userdata(
						[
							'username' => $user_exist->username,
							'id_user' => $user_exist->id,
							'last_login' => $user_exist->last_login,
							'id_role' => $user_exist->id_role,
							'logged_in' => true,
							'is_agen' => true
						]
					);
				}
			}*/

		}
		
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$retval['status'] = false;
			$retval['pesan'] = 'Gagal menambahkan transaksi';
			$retval['redirect'] = base_url('home');
		}else{
			$this->db->trans_commit();
			$retval['status'] = true;
			$retval['pesan'] = 'Sukses menambahkan transaksi';
			$retval['redirect'] = base_url('confirm/confirm_success_transfer/').$order_id;
		}

		echo json_encode($retval);
	}

	private function konfigurasi_upload_img($nmfile)
	{ 
		//konfigurasi upload img display
		$config['upload_path'] = './files/img/bukti_bayar';
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
	    $config['source_image'] = './files/img/bukti_bayar/'.$nmfile;
	    $config['create_thumb'] = FALSE;
	    $config['maintain_ratio'] = FALSE;
	    $config['new_image'] = './files/img/bukti_bayar/'.$nmfile;
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
		if (!file_exists('./files/img/bukti_bayar/thumbs')) {
			mkdir('./files/img/bukti_bayar/thumbs', 0777, true);
		}

		//konfigurasi image lib
	    $config2['image_library'] = 'gd2';
	    $config2['source_image'] = './files/img/bukti_bayar/'.$filename;
	    $config2['create_thumb'] = TRUE;
	 	$config2['thumb_marker'] = '_thumb';
	    $config2['maintain_ratio'] = FALSE;
	    $config2['new_image'] = './files/img/bukti_bayar/thumbs'.'/'.$filename;
	    $config2['overwrite'] = TRUE;
	    $config2['quality'] = '100%';
	 	$config2['width'] = 45;
	 	$config2['height'] = 45;
	    $this->load->library('image_lib',$config2); //load image library
	    $this->image_lib->initialize($config2);
	    $this->image_lib->resize();
	    return $output_thumb = $gbr['raw_name'].'_thumb'.$gbr['file_ext'];	
	}

	private function validasi_trans_manual()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if ($this->input->post('fname_trans') == '') {
			$data['inputerror'][] = 'fname_trans';
            $data['error_string'][] = 'Wajib Mengisi Nama';
            $data['status'] = FALSE;
		}

		if ($this->input->post('email_trans') == '') {
			$data['inputerror'][] = 'email_trans';
            $data['error_string'][] = 'Wajib Mengisi Email';
            $data['status'] = FALSE;
		}

		if ($this->input->post('telp_trans') == '') {
			$data['inputerror'][] = 'telp_trans';
            $data['error_string'][] = 'Wajib Mengisi telp';
            $data['status'] = FALSE;
		}

// 		if ($this->input->post('username') == '') {
// 			$data['inputerror'][] = 'username';
//             $data['error_string'][] = 'Wajib Mengisi Nama User';
//             $data['status'] = FALSE;
// 		}

// 		if ($this->input->post('bank') == '') {
// 			$data['inputerror'][] = 'bank';
//             $data['error_string'][] = 'Wajib Mengisi Bank';
//             $data['status'] = FALSE;
// 		}

// 		if ($this->input->post('norek') == '') {
// 			$data['inputerror'][] = 'norek';
//             $data['error_string'][] = 'Wajib Mengisi Nomor rekening';
//             $data['status'] = FALSE;
// 		}

// 		if ($this->input->post('password') == '') {
// 			$data['inputerror'][] = 'password';
//             $data['error_string'][] = 'Wajib Mengisi Password';
//             $data['status'] = FALSE;
// 		}

// 		if ($this->input->post('repassword') == '') {
// 			$data['inputerror'][] = 'repassword';
//             $data['error_string'][] = 'Wajib Mengisi Password Ulang';
//             $data['status'] = FALSE;
// 		}
		
		
        return $data;
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

	public function cek_kode_affiliate()
	{
		$sess = $this->session->all_userdata();
		if(isset($sess['kode_affiliate'])) {
			return $sess['kode_affiliate'];
		}else{
			return false;
		}
		
	}

	public function coba(){
		$this->load->view('checkout_snap2');
	}

	public function token2()
    {
		$first_name     = $this->input->post('first_name');
		$last_name   	= $this->input->post('last_name');
// 		$username       = $this->input->post('username');
		$email    		= $this->input->post('email');
		$price    		= $this->input->post('price');
		$quantity 		= $this->input->post('quantity');
		$telp     		= $this->input->post('telp');
// 		$password       = $this->input->post('pass');
// 		$bank           = $this->input->post('bank');
// 		$norek           = $this->input->post('norek');
        $username       = $first_name.' '.$last_name;
        $password       = '123456';
// 		$repassword     = $this->input->post('repass');
		$hash_password = $this->enkripsi->enc_dec('encrypt',$password);

		$obj_date = new DateTime();
		$timestamp = $obj_date->format('Y-m-d H:i:s');
		$datenow = $obj_date->format('Y-m-d');
		
		$arr_valid = $this->rule_validasi();
		
        // if ($arr_valid['status'] == FALSE) {
		// 	$this->session->set_flashdata('feedback_failed','Gagal menyimpan Data, pastikan telah mengisi semua inputan yang wajib di isi.'); 
		// 	return redirect('snap').'?type='.$price.'#checkout';
		// 	echo json_encode(['status' => false]);
		// 	return;
		// 	exit;
		// }
		$price = 'reg';
		if($price == 'reg') {
			$harga = $this->m_global->single_row('*',['deleted_at' => null], 't_harga', NULL);
		}else{
			$harga = $this->m_global->single_row('*',['id_talent' => 1, 'jenis_harga' => 2, 'deleted_at' => null], 't_harga', NULL);
		}
		
		
		if(isset($harga->is_diskon)) {
			// cek tanggal
			$tgl_mulai_diskon = $obj_date->createFromFormat('Y-m-d H:i:s', $harga->tgl_mulai_diskon.' 00:00:00')->format('Y-m-d H:i:s');
			$tgl_akhir_diskon = $obj_date->createFromFormat('Y-m-d H:i:s', $harga->tgl_akhir_diskon.' 00:00:00')->format('Y-m-d H:i:s');
			$diskon = $this->m_global->single_row('*', ['id' => $harga->id_m_diskon], 'm_diskon');
			//jika harga normal (timestamp > tgl_akhir diskon)
			if(strtotime($timestamp) > strtotime($tgl_akhir_diskon)) {
				$harga_fix = (float)$harga->nilai_harga;
			}else{
				//cek apakah sudah masuk tgl diskon ?
				if(strtotime($timestamp) >= strtotime($tgl_mulai_diskon)) {
					$harga_fix = (float)$harga->nilai_harga - ((float)$harga->nilai_harga * (float)$diskon->besaran / 100);
				}
				// jika belum berarti harganya masih normal
				else{
					$harga_fix = (float)$harga->nilai_harga;
				}
			}
		}else{
			$harga_fix = (float)$harga->nilai_harga;
		}


		if($price == 'reg') {
			$txt_ket = 'reguler';
		}else{
		    $harga_fix = $harga->nilai_harga;
			$txt_ket = 'eksklusif';
		}

		
		// Required
		$order_id = rand();
		$transaction_details = array(
		  'order_id' => $order_id,
		  'gross_amount' => $harga_fix, // no decimal allowed for creditcard
		);

		

		// Optional
		$item1_details = array(
		  'id' => 'a1',
		  'price' => $harga_fix,
		  'quantity' => 1,
		  'name' => "Workshop Online"
		);

		// Optional
		// $item2_details = array(
		//   'id' => 'a2',
		//   'price' => 20000,
		//   'quantity' => 2,
		//   'name' => "Orange"
		// );

		// Optional
		$item_details = array ($item1_details);

		// Optional
		$billing_address = array(
		  'first_name'    => $first_name,
		  'last_name'     => $last_name,
		  'address'       => "Mangga 20",
		  'city'          => "Jakarta",
		  'postal_code'   => "16602",
		  'phone'         => "081122334455",
		  'country_code'  => 'IDN'
		);

		// Optional
		$shipping_address = array(
		  'first_name'    => "Obet",
		  'last_name'     => "Supriadi",
		  'phone'         => "08113366345",
		  'country_code'  => 'IDN'
		);

		// Optional
		$customer_details = array(
		  'first_name'    => $first_name,
		  'last_name'     => $last_name,
		  'email'         => $email,
		  'phone'         => $telp,
		  'billing_address'  => $billing_address,
		  'shipping_address' => $shipping_address
		);
		
		//inserting data customer
		$nama_lengkap = $first_name.' '.$last_name;
		$kode_agen = $this->m_user->get_kode_agen();
		$data = array(
			'nama'  => $nama_lengkap,
			'email' => $email,
			'telp'  => $telp,
			// 'keterangan' => $txt_ket,
			'harga'     => $harga_fix,
			'order_id'  => $order_id,
			'kode_agen' => $kode_agen,
			'created_at' => $timestamp
		);
		$simpan = $this->m_global->store($data, 't_checkout');
		
		$input = array(
			'id_role' => 3, // role agen
			'username' => $username,
			'password' => $hash_password,
			'status' => '1',
			'kode_user' => $this->m_user->get_kode_user(),
			'kode_agen' => $kode_agen,
			'nama_lengkap' => $nama_lengkap,
			'no_telp' => $telp,
			'created_at' => $timestamp,
			'email' => $email,
// 			'bank' => $bank,
// 			'rekening' => $norek,
			'created_at' => $timestamp
		);

		$insert_user = $this->m_user->save($input);

// 		if($insert_user) {
// 			//login
// 			$user_exist = $this->m_global->single_row('*',['username' => $username,'password' => $hash_password, 'deleted_at' => null ], 'm_user', NULL);

// 			if($user_exist){
// 				$this->session->set_userdata(
// 					[
// 						'username' => $user_exist->username,
// 						'id_user' => $user_exist->id,
// 						'last_login' => $user_exist->last_login,
// 						'id_role' => $user_exist->id_role,
// 						'logged_in' => true,
// 						'is_agen' => true
// 					]
// 				);
// 			}
// 		}
		// Data yang akan dikirim untuk request redirect_url.
        $credit_card['secure'] = true;
        //ser save_card true to enable oneclick or 2click
        //$credit_card['save_card'] = true;

        $time = time();
        $custom_expiry = array(
            'start_time' => date("Y-m-d H:i:s O",$time),
            'unit' => 'minute', 
            'duration'  => 2
        );
        
        $transaction_data = array(
            'transaction_details'=> $transaction_details,
            'item_details'       => $item_details,
            'customer_details'   => $customer_details,
            'credit_card'        => $credit_card,
            'expiry'             => $custom_expiry
        );

		error_log(json_encode($transaction_data));
		$snapToken = $this->midtrans->getSnapToken($transaction_data);
		error_log($snapToken);
		echo $snapToken;
	}
	
	
}
