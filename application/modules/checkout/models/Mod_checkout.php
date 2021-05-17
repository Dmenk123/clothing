<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mod_checkout extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		//alternative load library from config
		$this->load->database();
	}

	public function add_pesan($data)
	{
		$this->db->insert('tbl_pesan', $data);
		return $this->db->insert_id();
	}

	public function get_db_cart($token)
	{
		$this->db->select('tbl_checkout.*, tbl_provinsi_ongkir.nama_provinsi, tbl_kota_ongkir.nama_kota');
		$this->db->from('tbl_checkout');
		$this->db->join('tbl_provinsi_ongkir', 'tbl_checkout.id_prov = tbl_provinsi_ongkir.id_provinsi', 'left');
		$this->db->join('tbl_kota_ongkir', 'tbl_checkout.id_kota = tbl_kota_ongkir.id_kota', 'left');
		$this->db->where('tbl_checkout.token', $token);
		$query = $this->db->get();
		return $query->row();
	}

	public function get_data_user($id_user)
	{
		$this->db->select('tbl_user.id_user,
						   tbl_user.email,
						   tbl_user.password,
						   tbl_user.fname_user,
						   tbl_user.lname_user,
						   tbl_user.alamat_user,
						   tbl_user.no_telp_user,
						   tbl_user.id_provinsi,
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
		return $query->result();
	}

	public function get_alamat_checkout($id, $type)
	{
		$this->db->select('tbl_alamat_checkout.id,
						   tbl_alamat_checkout.id_user,
						   tbl_alamat_checkout.fname,
						   tbl_alamat_checkout.lname,
						   tbl_alamat_checkout.id_provinsi,
						   tbl_provinsi.nama_provinsi,
						   tbl_alamat_checkout.id_kota,
						   tbl_kota.nama_kota,
						   tbl_alamat_checkout.id_kecamatan,
						   tbl_kecamatan.nama_kecamatan,
						   tbl_alamat_checkout.id_kelurahan,
						   tbl_kelurahan.nama_kelurahan,						   
						   tbl_alamat_checkout.kdpos,
						   tbl_alamat_checkout.telp,
						   ');
		$this->db->from('tbl_alamat_checkout');
		$this->db->join('tbl_provinsi', 'tbl_alamat_checkout.id_provinsi = tbl_provinsi.id_provinsi', 'left');
		$this->db->join('tbl_kota', 'tbl_alamat_checkout.id_kota = tbl_kota.id_kota', 'left');
		$this->db->join('tbl_kecamatan', 'tbl_alamat_checkout.id_kecamatan = tbl_kecamatan.id_kecamatan', 'left');
		$this->db->join('tbl_kelurahan', 'tbl_alamat_checkout.id_kelurahan = tbl_kelurahan.id_kelurahan', 'left');
		$this->db->where('tbl_alamat_checkout.id', $id);
		$this->db->where('tbl_alamat_checkout.type', $type);

		$query = $this->db->get();
		return $query->result();
	}

	public function get_data_produk($id_checkout)
	{
		$this->db->select('tbl_checkout.*, tbl_checkout_detail.qty, tbl_checkout_detail.harga_satuan, tbl_checkout_detail.sess_row_id, tbl_produk.nama_produk, tbl_gambar_produk.nama_gambar, tbl_stok.ukuran_produk, tbl_stok.berat_satuan');
		$this->db->from('tbl_checkout');
		$this->db->join('tbl_checkout_detail', 'tbl_checkout.id_checkout = tbl_checkout_detail.id_checkout', 'left');
		$this->db->join('tbl_stok', 'tbl_checkout_detail.id_stok = tbl_stok.id_stok', 'left');
		$this->db->join('tbl_produk', 'tbl_checkout_detail.id_produk = tbl_produk.id_produk', 'left');
		$this->db->join('tbl_gambar_produk', 'tbl_produk.id_produk = tbl_gambar_produk.id_produk', 'left');
		$this->db->where('tbl_checkout.id_checkout', $id_checkout);
		$this->db->where('tbl_gambar_produk.jenis_gambar', 'display');
	
		$query = $this->db->get();
		return $query->result();
	}

	public function get_checkout_det_by_orderid($orderid)
	{
		$this->db->select('
			tbl_checkout.*, 
			tbl_checkout_detail.qty, 
			tbl_checkout_detail.harga_satuan,
			tbl_checkout_detail.sess_row_id
		');
		$this->db->from('tbl_checkout');
		$this->db->join('tbl_checkout_detail', 'tbl_checkout.id_checkout = tbl_checkout_detail.id_checkout', 'left');
		$this->db->where('tbl_checkout.order_id', $orderid);
		
		$query = $this->db->get();
		return $query->result();
	}
	
	function getKodeUser(){
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

    function getKodeCheckout($method){
        $q = $this->db->query("SELECT MAX(RIGHT(id_checkout,5)) as kode_max from tbl_checkout WHERE DATE_FORMAT(tgl_checkout, '%Y-%m') = DATE_FORMAT(CURRENT_DATE(), '%Y-%m') AND id_checkout like '%$method%'");
            $kd = "";
            if($q->num_rows()>0){
                foreach($q->result() as $k){
                    $tmp = ((int)$k->kode_max)+1;
                    $kd = sprintf("%05s", $tmp);
                }
            }else{
                $kd = "00001";
            }
            return "$method".date('my').$kd;
    }

    public function simpan_data($data_header, $data_item_detail)
	{
		//insert into tbl_checkout 
		$this->db->insert('tbl_checkout',$data_header);

		//insert batch into tbl_checkout_detail 
		$this->db->insert_batch('tbl_checkout_detail',$data_item_detail);
	}

    public function lookup_data_provinsi($keyword = "")
	{
		$this->db->select('id_provinsi, nama_provinsi');
		$this->db->from('tbl_provinsi_ongkir');
		$this->db->like('nama_provinsi',$keyword);
		//$this->db->limit(25);
		$this->db->order_by('nama_provinsi', 'ASC');
	
		$query = $this->db->get();
		return $query->result();
	}

	public function lookup_data_kotakabupaten($keyword = "", $id_provinsi)
	{
		$this->db->select('id_kota, nama_kota');
		$this->db->from('tbl_kota_ongkir');
		$this->db->where('id_provinsi',$id_provinsi);
		$this->db->like('nama_kota',$keyword);
		//$this->db->limit(25);
		$this->db->order_by('nama_kota', 'ASC');
		
		$query = $this->db->get();
		return $query->result();
	}

	public function lookup_data_kecamatan($keyword = "", $id_kota)
	{
		$this->db->select('id_kecamatan, nama_kecamatan');
		$this->db->from('tbl_kecamatan');
		$this->db->where('id_kota',$id_kota);
		$this->db->like('nama_kecamatan',$keyword);
		//$this->db->limit(25);
		$this->db->order_by('nama_kecamatan', 'ASC');
		
		$query = $this->db->get();
		return $query->result();
	}

	public function lookup_data_kelurahan($keyword = "", $id_kecamatan)
	{
		$this->db->select('id_kelurahan, nama_kelurahan');
		$this->db->from('tbl_kelurahan');
		$this->db->where('id_kecamatan',$id_kecamatan);
		$this->db->like('nama_kelurahan',$keyword);
		//$this->db->limit(25);
		$this->db->order_by('nama_kelurahan', 'ASC');
		
		$query = $this->db->get();
		return $query->result();
	}

	public function notif_count($id_user) 
	{
        $this->db->from('tbl_checkout');
        $this->db->where('id_user', $id_user);
        $this->db->where('status', "aktif");
        $query = $this->db->get();
        return $query->num_rows();
    }

	public function single_row($table, $where)
	{
		$this->db->select('*');
		$this->db->from($table);
        $this->db->where($where);
		$query = $this->db->get();
		return $query->row();
	}

	public function insert_data($table, $data)
	{
		$this->db->insert($table, $data);
		return $this->db->insert_id();
	}

	public function update_data($table=NULL, $data=NULL, $array_where=NULL){
        $this->db->where($array_where);
        $this->db->update($table, $data);
        return $this->db->affected_rows();
    }

}
