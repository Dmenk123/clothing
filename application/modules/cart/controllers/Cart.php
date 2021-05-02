<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('produk/mod_produk');
		$this->load->model('homepage/mod_homepage','mod_hpg');
		$this->load->model('mod_cart');
		$this->load->library('cart');
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

		$results =$this->mod_cart->get_all_data();

		$data = array(
			'content' => 'cart/view_list_cart',
			'count_kategori' => $count_kategori,
			'submenu' => $submenu,
			'menu_navbar' => $menu_navbar,
			'results' => $results,
			'js' => 'cart/jsCart',
			'menu_select_search' => $menu_select_search,
		);

        $this->load->view('temp',$data);
	}

	function add_to_cart()
	{
		$id_produk = $this->input->post('idProduk');
        $id_satuan_produk = $this->mod_cart->get_satuan_produk($id_produk);
        foreach ($id_satuan_produk as $value) {
            $id_satuan = $value->id_satuan;
        }
        $nama_produk = $this->input->post('namaProduk'); 
        $harga_produk = $this->input->post('hargaProduk'); 
        $size_produk = $this->input->post('sizeProduk');
        $qty_produk = $this->input->post('qtyProduk');
        $gambar_produk = $this->input->post('gambarProduk');
        $stok_produk = $this->mod_produk->get_data_stok_produk($id_produk, $size_produk);
        foreach ($stok_produk as $value) {
            $id_stok = $value->id_stok;
            $stok_length = $value->stok_sisa;
            $berat_satuan = $value->berat_satuan;
        }

        //store to array index with reserved word in cart library
        $data = array(
            'id' => $id_produk,
            'qty' => $qty_produk,
            'price' => $harga_produk,   
            'name' => $nama_produk, 
            'options' => array(
                            'Size_produk' => $size_produk, 
                            'Gambar_produk' => $gambar_produk,
                            'Berat_produk' => $berat_satuan, 
                            'Stok_produk' => $stok_length,
                            'Id_stok_produk' => $id_stok,
                            'Id_satuan_produk' => $id_satuan
                        ) 
        );
        $this->cart->insert($data);
        
        echo json_encode(array(
			"status" => TRUE,
			"pesan" => 'Produk '.$nama_produk.' Ukuran '.$size_produk.' Ditambahkan pada keranjang belanja'
		));
    }

    function show_cart()
    {
        //deklarasi variabel
        $output = '';
        $beratTotal=0;
        foreach ($this->cart->contents() as $items) {
        	$link_img = $items['options']['Gambar_produk'];
            $output .='
                <tr>
                	<td><img src="'.site_url("assets/img/produk/$link_img").'"></td>
                    <td>'.$items['name'].'</td>
                    <td>'.$items['options']['Size_produk'].'</td>
                    <td> 
	            		<select style="width:40px;" id="'.$items['rowid'].'" class="cart_qty">';
	            			for ($i=1; $i <= $items['options']['Stok_produk']; $i++) {
	            				if ($i == $items['qty']) {
	            					$output .='<option value="'.$i.'" selected>'.$i.'</option>';
	            				}else{
	            					$output .='<option value="'.$i.'">'.$i.'</option>';	
	            				}
	                    	}	
	                    $output .='</select>
                    </td>
                    <td>'.$items['options']['Berat_produk'].' gram</td>
                    <td>'.$items['options']['Berat_produk'] * $items['qty'].' gram</td>
                    <td>Rp. '.number_format($items['price'],0,",",".").'</td>
                    <td>Rp. '.number_format($items['subtotal'],0,",",".").'</td>
                    <td><button type="button" id="'.$items['rowid'].'" class="btn btn-danger btn-xs hapus_cart"><i class="fa fa-trash-o"></i></button></td>
                </tr>
            ';
        }

        //hitung berat total
        foreach($this->cart->contents() as $item)
        {
           $beratTotal += $item['options']['Berat_produk'] * $item['qty'];
        }

        //lanjutkan variabel output
        $output .= '
            <tr>
                <th colspan="5">Berat Total</th>
                <th colspan="4">'.number_format($beratTotal,0,",",".").' gram </th>
            </tr>
            <tr>
                <th colspan="7"><span style="font-size:20px;">Total Belanja</span></th>
                <th colspan="2">
                    <span style="font-size:20px; text-decoration:underline;">
                        Rp. '.number_format($this->cart->total(),0,",",".").'
                    </span>
                </th>
            </tr>
        ';
        return $output;
    }
 
    function load_cart(){ //load data cart
        echo $this->show_cart();
    }

    function show_summary()
    { 
        foreach ($this->cart->contents() as $items) {
            $link_img = $items['options']['Gambar_produk'];

            $output = '
                <tr>
                    <td>Total belanja</td>
                    <th width="100px">Rp. '.number_format($this->cart->total(),0,",",".").'</th>
                </tr>
                <tr>
                    <td>Biaya Pengiriman</td>
                    <th width="100px"> - </th>
                </tr>
                <tr>
                    <td>Biaya Total</td>
                    <th width="100px">Rp. '.number_format($this->cart->total(),0,",",".").'</th>
                </tr>
            ';
        }
        if (isset($output)) 
        {
            return $output;
        }
        else
        {
            $output = "Daftar Belanja Anda Kosong";
            return $output;
        }
        
    }

    function load_summary(){ //load data cart
        echo $this->show_summary();
    }
 
    function hapus_cart(){ 
        $data = array(
            'rowid' => $this->input->post('row_id'), 
            'qty' => 0, 
        );
        $this->cart->update($data);
        echo $this->show_cart();
    }

     function update_cart(){ 
        $data = array(
            'rowid' => $this->input->post('row_id'), 
            'qty' => $this->input->post('qty'), 
        );
        $this->cart->update($data);
        echo $this->show_cart();
    }

}
