<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mod_profil extends CI_Model
{
	// declare array variable to search datatable
	var $column_search = array(
			'tbl_checkout.tgl_checkout',
			'tbl_checkout.method_checkout',
			'tbl_checkout.harga_total_produk',
			'tbl_checkout.jasa_ekspedisi',
			'tbl_checkout.pilihan_paket',
			'tbl_checkout.estimasi_datang',
			'tbl_checkout.ongkos_kirim',
			'tbl_checkout.ongkos_total',
			'tbl_checkout.kode_ref',
			);

	public function __construct()
	{
		parent::__construct();
		//alternative load library from config
		$this->load->database();
	}

	public function get_data_profil($id_user)
	{
		$this->db->select('tbl_user.id_user,
						   tbl_user.email,
						   tbl_user.password,
						   tbl_user.fname_user,
						   tbl_user.lname_user,
						   tbl_user.alamat_user,
						   tbl_user.no_telp_user,
						   tbl_user.id_provinsi,
						   tbl_user.id_level_user,
						   tbl_provinsi.nama_provinsi,
						   tbl_user.id_kota,
						   tbl_kota.nama_kota,
						   tbl_user.id_kecamatan,
						   tbl_kecamatan.nama_kecamatan,
						   tbl_user.id_kelurahan,
						   tbl_kelurahan.nama_kelurahan,
						   tbl_user.kode_pos,
						   tbl_user.tgl_lahir_user,
						   tbl_user.last_login,
						   tbl_user.foto_user,
						   ');
		$this->db->from('tbl_user');
		$this->db->join('tbl_provinsi', 'tbl_user.id_provinsi = tbl_provinsi.id_provinsi', 'left');
		$this->db->join('tbl_kota', 'tbl_user.id_kota = tbl_kota.id_kota', 'left');
		$this->db->join('tbl_kecamatan', 'tbl_user.id_kecamatan = tbl_kecamatan.id_kecamatan', 'left');
		$this->db->join('tbl_kelurahan', 'tbl_user.id_kelurahan = tbl_kelurahan.id_kelurahan', 'left');
		$this->db->where('tbl_user.id_user', $id_user);

		$query = $this->db->get();
		return $query->row();
	}

	public function getKodeUser()
	{
            $q = $this->db->query("select MAX(RIGHT(id_user,5)) as kode_max from tbl_user");
            $kd = "";
            if($q->num_rows()>0){
                foreach($q->result() as $k){
                    $tmp = ((int)$k->kode_max)+1;
                    $kd = sprintf("%05s", $tmp);
                }
            }else{
                $kd = "00001";
            }
            return "USR".$kd;
    }
	
	public function update_data_profil($where, $data)
	{
		$this->db->update('tbl_user', $data, $where);
		return $this->db->affected_rows();
	}

	private function _get_data_checkout_query($term='', $id_user) //term is value of $_REQUEST['search']
	{
		$column = array(
			'tbl_checkout.tgl_checkout',
			'tbl_checkout.method_checkout',
			'tbl_checkout.harga_total_produk',
			'tbl_checkout.jasa_ekspedisi',
			'tbl_checkout.pilihan_paket',
			'tbl_checkout.estimasi_datang',
			'tbl_checkout.ongkos_kirim',
			'tbl_checkout.ongkos_total',
			'tbl_checkout.kode_ref',
			null,
			);

		$this->db->select('
			tbl_checkout.id_checkout,
			tbl_checkout.id_user,
			tbl_checkout.tgl_checkout,
			tbl_checkout.method_checkout,
			tbl_checkout.status,
			tbl_checkout.harga_total_produk,
			tbl_checkout.jasa_ekspedisi,
			tbl_checkout.pilihan_paket,
			tbl_checkout.estimasi_datang,
			tbl_checkout.ongkos_kirim,
			tbl_checkout.ongkos_total,
			tbl_checkout.kode_ref,
			tbl_checkout_detail.id,
			tbl_produk.nama_produk,
			tbl_satuan.nama_satuan,
			COUNT(tbl_checkout_detail.id_checkout) AS jml
			');

		$this->db->from('tbl_checkout');
		//join 'tbl', on 'tbl = tbl' , type join
		$this->db->join(
			'tbl_checkout_detail',
			'tbl_checkout.id_checkout = tbl_checkout_detail.id_checkout','left');
		$this->db->join(
			'tbl_produk',
			'tbl_checkout_detail.id_produk = tbl_produk.id_produk','left');
		$this->db->join(
			'tbl_satuan',
			'tbl_checkout_detail.id_satuan = tbl_satuan.id_satuan','left');
		$this->db->where('tbl_checkout.status', "aktif");
		$this->db->where('tbl_checkout.id_user', $id_user);
		$this->db->group_by('tbl_checkout.id_checkout');
		
		$i = 0;
		// loop column 
		foreach ($this->column_search as $item) 
		{
			// if datatable send POST for search
			if($_POST['search']['value']) 
			{
				// first loop
				if($i===0) 
				{
					// open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->group_start();
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}
				//last loop
				if(count($this->column_search) - 1 == $i) 
					$this->db->group_end(); //close bracket
			}
			$i++;
		}

		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($column[$_REQUEST['order']['0']['column']], $_REQUEST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_data_checkout($id_user)
	{
		$term = $_REQUEST['search']['value'];
		$this->_get_data_checkout_query($term, $id_user);

		if($_REQUEST['length'] != -1)
		$this->db->limit($_REQUEST['length'], $_REQUEST['start']);

		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered($id_user)
	{
		$term = $_REQUEST['search']['value'];
		$this->_get_data_checkout_query($term, $id_user);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from('tbl_checkout');
		return $this->db->count_all_results();
	}

	public function get_detail_checkout($id)
	{
		$this->db->select(' tbl_checkout_detail.id,
							tbl_checkout_detail.id_checkout,
							tbl_checkout_detail.id_produk,
							tbl_checkout_detail.id_stok,
							tbl_produk.nama_produk,
							tbl_stok.ukuran_produk,
							tbl_stok.berat_satuan,
							tbl_produk.harga,
							tbl_satuan.nama_satuan,
							tbl_checkout_detail.qty');
		$this->db->from('tbl_checkout_detail');
		$this->db->join('tbl_produk', 'tbl_checkout_detail.id_produk = tbl_produk.id_produk','left');
		$this->db->join('tbl_satuan', 'tbl_checkout_detail.id_satuan = tbl_satuan.id_satuan','left');
		$this->db->join('tbl_stok', 'tbl_checkout_detail.id_stok = tbl_stok.id_stok','left');
        $this->db->where('tbl_checkout_detail.id_checkout', $id);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
	}

	public function get_detail_checkout_header($id)
	{
		$this->db->select(' tbl_checkout.id_checkout,
							tbl_checkout.tgl_checkout,
							tbl_checkout.method_checkout,
							tbl_checkout.harga_total_produk,
							tbl_checkout.jasa_ekspedisi,
							tbl_checkout.pilihan_paket,
							tbl_checkout.estimasi_datang,
							tbl_checkout.ongkos_kirim,
							tbl_checkout.ongkos_total,
							tbl_checkout.kode_ref,
							tbl_checkout.alamat_kirim,
							tbl_checkout.fname_kirim,
							tbl_checkout.lname_kirim,
							tbl_user.fname_user,
							tbl_user.lname_user');
		$this->db->from('tbl_checkout');
		$this->db->join('tbl_user', 'tbl_checkout.id_user = tbl_user.id_user','left');
        $this->db->where('tbl_checkout.id_checkout', $id);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
	}

	public function update_nonaktif_checkout($where, $data)
	{
		$this->db->update("tbl_checkout", $data, $where);
		return $this->db->affected_rows();
	}

	public function insert_data_pembelian($data)
	{
		$this->db->insert("tbl_pembelian", $data);
	}

	public function get_sisa_stok($id)
	{
		$this->db->select("stok_sisa");
		$this->db->from('tbl_stok');
		$this->db->where('id_stok', $id);
		
		$query = $this->db->get();
		return $query->row();
	}

	function getKodePembelian(){
        $q = $this->db->query("SELECT MAX(RIGHT(id_pembelian,5)) as kode_max from tbl_pembelian WHERE DATE_FORMAT(tgl_pembelian, '%Y-%m') = DATE_FORMAT(CURRENT_DATE(), '%Y-%m')");
            $kd = "";
            if($q->num_rows()>0){
                foreach($q->result() as $k){
                    $tmp = ((int)$k->kode_max)+1;
                    $kd = sprintf("%05s", $tmp);
                }
            }else{
                $kd = "00001";
            }
            return "PBL".date('my').$kd;
    }
}