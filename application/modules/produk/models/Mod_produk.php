<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mod_produk extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		//alternative load library from config
		$this->load->database();
	}

	public function get_data_row($table, $where)
	{
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($where);
		$query = $this->db->get();
		return $query->row();
	}


	public function get_list_produk($limit, $start ,$sort, $id_sub, $key)
	{
		if($start != null) {
			$offset = ((int)$start - 1) * $limit;
		}else{
			$offset = null;
		}

		$this->db->select('tbl_produk.id_produk,
						   tbl_produk.id_sub_kategori,
						   tbl_produk.nama_produk,
						   tbl_produk.harga,
						   tbl_produk.slug,
						   tbl_gambar_produk.nama_gambar');	
		$this->db->from('tbl_produk');
		$this->db->join('tbl_gambar_produk', 'tbl_produk.id_produk = tbl_gambar_produk.id_produk', 'left');
		$this->db->where('tbl_produk.id_sub_kategori', $id_sub);
		$this->db->where('tbl_gambar_produk.jenis_gambar', "display");
		$this->db->where('tbl_produk.status', '1');
		$this->db->like('tbl_produk.nama_produk', $key);
		$this->db->order_by('tbl_produk.'.$sort, 'asc');
		$this->db->limit($limit, $offset);

		$query = $this->db->get();
		// echo $this->db->last_query();exit;
		
		return $query->result();
	}

	public function get_img_detail_thumb($idProduk)
	{
		$this->db->select('nama_gambar');	
		$this->db->from('tbl_gambar_produk');
		$this->db->where('id_produk', $idProduk);
		$this->db->where('jenis_gambar', "detail");
		
		$query = $this->db->get();
		return $query->result();
	}

	public function get_img_detail_big($idProduk)
	{
		$this->db->select('nama_gambar');	
		$this->db->from('tbl_gambar_produk');
		$this->db->where('id_produk', $idProduk);
		$this->db->where('jenis_gambar', "detail");
		$this->db->group_by('id_produk');

		$query = $this->db->get();
		return $query->result();
	}

	public function get_detail_produk($idProduk)
	{
		$this->db->select('tbl_produk.id_produk,
						   tbl_produk.id_sub_kategori,
						   tbl_produk.nama_produk,
						   tbl_produk.harga,
						   tbl_produk.bahan_produk,
						   tbl_produk.keterangan_produk,
						   tbl_gambar_produk.nama_gambar');	
		$this->db->from('tbl_produk');
		$this->db->join('tbl_gambar_produk', 'tbl_gambar_produk.id_produk = tbl_produk.id_produk', 'left');
		$this->db->where('tbl_produk.id_produk', $idProduk);
		//$this->db->where('tbl_gambar_produk.id_produk', $idProduk);
		$this->db->where('tbl_gambar_produk.jenis_gambar', "display");

		$query = $this->db->get();
		return $query->result();
	}

	public function get_data_size_produk($id_produk)
	{
		$this->db->select('ukuran_produk');
		$this->db->from('tbl_stok');
		$this->db->where('id_produk', $id_produk);

		$query = $this->db->get();
		return $query->result();
	}

	public function get_data_stok_produk($id_produk, $size_produk)
	{
		$this->db->select('id_stok, stok_sisa, berat_satuan');
		$this->db->from('tbl_stok');
		$this->db->where('id_produk', $id_produk);
		$this->db->where('ukuran_produk', $size_produk);

		$query = $this->db->get();
		return $query->result();
	}

	public function get_ukuran_produk($idProduk)
	{
		$this->db->select('*');	
		$this->db->from('tbl_stok');
		$this->db->where('id_produk', $idProduk);

		$query = $this->db->get();
		return $query->result();
	}

	public function get_list_produk_search($limit, $start ,$sort, $id_sub, $key)
	{
		$this->db->select('tbl_produk.id_produk,
						   tbl_produk.id_sub_kategori,
						   tbl_produk.nama_produk,
						   tbl_produk.harga,
						   tbl_gambar_produk.nama_gambar');	
		$this->db->from('tbl_produk');
		$this->db->join('tbl_gambar_produk', 'tbl_produk.id_produk = tbl_gambar_produk.id_produk', 'left');
		$this->db->where('tbl_produk.id_sub_kategori', $id_sub);
		$this->db->where('tbl_gambar_produk.jenis_gambar', "display");
		$this->db->where('tbl_produk.status', '1');
		$this->db->like('tbl_produk.nama_produk', $key);
		$this->db->order_by('tbl_produk.'.$sort, 'asc');
		$this->db->limit($limit, $start);

		$query = $this->db->get();
		return $query->result();
	}

	
	public function record_count($subKategori, $key)
	{
		$this->db->select('*');
		$this->db->from('tbl_produk');
		$this->db->where('id_sub_kategori', $subKategori);
		$this->db->where('status', '1');
		$this->db->like('nama_produk', $key);
		$query = $this->db->get();
		return $query->num_rows();
	}

	// Fetch data according to per_page limit.
    public function fetch_data($limit) {
        $this->db->limit($limit);
        // $this->db->where('id', $id);
        $query = $this->db->get("tbl_produk");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
         
            return $data;
        }
        return false;
   }

   public function get_data_page($id, $key)
    {	
    	$this->db->select('tbl_sub_kategori_produk.*');
    	$this->db->from('tbl_sub_kategori_produk');
		$this->db->join('tbl_produk', 'tbl_sub_kategori_produk.id_sub_kategori = tbl_produk.id_sub_kategori', 'right');
    	$this->db->where('tbl_sub_kategori_produk.id_sub_kategori', $id);
		$this->db->like('tbl_produk.nama_produk', $key);
    	$query = $this->db->get();
		return $query->result();
    }

    public function get_id_kategori($id_sub)
    {
    	$this->db->select('id_kategori');
    	$this->db->from('tbl_sub_kategori_produk');
    	$this->db->where('id_sub_kategori', $id_sub);

    	$query = $this->db->get();
    	return $query->result_array();
    } 

    public function get_produk_terlaris()
    {
    	$query = $this->db->query("
				SELECT tbl_checkout_detail.id_produk, sum(tbl_checkout_detail.qty) as jumlah, tbl_produk.nama_produk, tbl_produk.id_sub_kategori, tbl_produk.harga, tbl_gambar_produk.nama_gambar
				FROM tbl_checkout_detail
				LEFT JOIN tbl_produk ON tbl_checkout_detail.id_produk = tbl_produk.id_produk
				LEFT JOIN tbl_gambar_produk ON tbl_checkout_detail.id_produk = tbl_gambar_produk.id_produk
				WHERE tbl_gambar_produk.jenis_gambar = 'display'
				GROUP BY tbl_checkout_detail.id_produk
				ORDER BY jumlah DESC LIMIT 5
			");
		return $query->result();    
    }

	public function get_produk_random()
	{
		$query = $this->db->query("
		SELECT * FROM (
			SELECT
				tbl_produk.id_produk,
				tbl_produk.nama_produk,
				tbl_produk.id_sub_kategori,
				tbl_produk.harga,
				tbl_produk.slug,
				tbl_gambar_produk.nama_gambar 
			FROM
				tbl_produk
				LEFT JOIN tbl_gambar_produk ON tbl_produk.id_produk = tbl_gambar_produk.id_produk 
			WHERE
				tbl_gambar_produk.jenis_gambar = 'display' and tbl_produk.status = '1'
			ORDER BY 
				rand()
			LIMIT 5
		) as t1
		order by nama_produk
		");

		return $query->result();    
	}
}
