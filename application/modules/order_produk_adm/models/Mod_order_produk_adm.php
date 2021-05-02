<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mod_order_produk_adm extends CI_Model
{
	var $column_search = array(
			'tbl_trans_order.id_trans_order',
			'tbl_user.fname_user',
			'tbl_supplier.nama_supplier',
			'tbl_trans_order.tgl_trans_order',
			null,
		);

	var $column_order = array(
			'tbl_trans_order.id_trans_order',
			'tbl_user.fname_user',
			'tbl_supplier.nama_supplier',
			'tbl_trans_order.tgl_trans_order',
			null,
		);

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatable_order_query($term='') //term is value of $_REQUEST['search']
	{
		$column = array(
				'tbl_trans_order.id_trans_order',
				'tbl_user.fname_user',
				'tbl_supplier.nama_supplier',
				'tbl_trans_order.tgl_trans_order',
				null,
			);

		$this->db->select('
				tbl_trans_order.id_trans_order,
				tbl_user.fname_user,
				tbl_user.lname_user,
				tbl_supplier.nama_supplier,
				tbl_trans_order.tgl_trans_order,
				COUNT(tbl_trans_order_detail.id_produk) AS jml
			');

		$this->db->from('tbl_trans_order');
		$this->db->join('tbl_user', 'tbl_trans_order.id_user = tbl_user.id_user', 'left');
		$this->db->join('tbl_supplier', 'tbl_trans_order.id_supplier = tbl_supplier.id_supplier', 'left');
		$this->db->join('tbl_trans_order_detail', 'tbl_trans_order.id_trans_order = tbl_trans_order_detail.id_trans_order','left');
		$this->db->group_by('tbl_trans_order.id_trans_order');
		$i = 0;
		foreach ($this->column_search as $item) 
		{
			if($_POST['search']['value']) 
			{
				if($i===0) 
				{
					$this->db->group_start();
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}
				if(count($this->column_search) - 1 == $i) 
					$this->db->group_end(); //close bracket
			}
			$i++;
		}

		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatable_order()
	{
		$term = $_REQUEST['search']['value'];
		$this->_get_datatable_order_query($term);

		if($_REQUEST['length'] != -1)
		$this->db->limit($_REQUEST['length'], $_REQUEST['start']);

		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered()
	{
		$term = $_REQUEST['search']['value'];
		$this->_get_datatable_order_query($term);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from('tbl_trans_order');
		return $this->db->count_all_results();
	}

	public function get_by_id($id)
	{
		$this->db->from('tbl_trans_order');
		$this->db->where('id_trans_order',$id);
		$query = $this->db->get();

		return $query->row();
	}

	public function lookup_data_size($id_prod)
	{
		$this->db->select('id_stok, ukuran_produk');
		$this->db->from('tbl_stok');
		$this->db->where('id_produk', $id_prod);
			
		$query = $this->db->get();
		return $query->result();
	}

	public function lookup_id_stok($size ,$id_prod)
	{
		$this->db->select('id_stok');
		$this->db->from('tbl_stok');
		$this->db->where('id_produk', $id_prod);
		$this->db->where('ukuran_produk', $size);
			
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
            $hasil = $query->row();
			return $hasil->id_stok;
        }
	}

	public function lookup_last_beli($id_prod)
	{
		$this->db->select('harga_satuan_beli');
		$this->db->from('tbl_trans_order_detail');
		$this->db->where('id_produk', $id_prod);
		$this->db->order_by('id_trans_order_detail', 'desc');
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
            $hasil = $query->row();
			return $hasil->harga_satuan_beli;
        }
	}

	public function simpan_data_order($data_order, $data_order_detail)
	{
		//insert into tbl_trans_order 
		$this->db->insert('tbl_trans_order',$data_order);

		//insert into tbl_trans_order_detail 
		$this->db->insert_batch('tbl_trans_order_detail',$data_order_detail);
		// return $this->db->insert_id();
	}

	public function update_data_header_order_detail($where, $data_header)
	{
		$this->db->update('tbl_trans_order', $data_header, $where);
		return $this->db->affected_rows();
	}

	public function insert_update_order($data_order_detail)
	{
		$this->db->insert_batch('tbl_trans_order_detail',$data_order_detail);
	}

	public function get_data_order_header($id_trans_order)
	{
		$this->db->select('tbl_trans_order.id_trans_order, tbl_user.fname_user, tbl_user.lname_user, tbl_trans_order.id_supplier, tbl_supplier.nama_supplier, tbl_supplier.alamat_supplier, tbl_trans_order.tgl_trans_order');
		$this->db->from('tbl_trans_order');
		$this->db->join('tbl_user', 'tbl_trans_order.id_user = tbl_user.id_user','left');
		$this->db->join('tbl_supplier', 'tbl_trans_order.id_supplier = tbl_supplier.id_supplier','left');
        $this->db->where('tbl_trans_order.id_trans_order', $id_trans_order);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
	}

	public function get_data_order_detail($id_trans_order)
	{
		$this->db->select('tbl_trans_order_detail.id_trans_order,
						   tbl_produk.nama_produk,
						   tbl_trans_order_detail.id_trans_order_detail,
						   tbl_trans_order_detail.id_produk,
						   tbl_satuan.nama_satuan,
						   tbl_trans_order_detail.id_satuan,
						   tbl_trans_order_detail.id_stok,
						   tbl_trans_order_detail.ukuran,
						   tbl_trans_order_detail.qty,
						   tbl_trans_order_detail.harga_prev_beli,
						   tbl_trans_order_detail.harga_satuan_beli,
						   tbl_trans_order_detail.harga_total_beli');
		$this->db->from('tbl_trans_order_detail');
		$this->db->join('tbl_produk', 'tbl_trans_order_detail.id_produk = tbl_produk.id_produk','left');
		$this->db->join('tbl_satuan', 'tbl_trans_order_detail.id_satuan = tbl_satuan.id_satuan','left');
        $this->db->where('tbl_trans_order_detail.id_trans_order', $id_trans_order);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
	}

	public function hapus_data_order_detail($id)
	{
		$this->db->where('id_trans_order', $id);
		$this->db->delete('tbl_trans_order_detail');
	}

	public function delete_data_order_produk($id)
	{
		//tbl header
		$this->db->where('id_trans_order', $id);
		$this->db->delete('tbl_trans_order');
		//tbl detaik
		$this->db->where('id_trans_order', $id);
		$this->db->delete('tbl_trans_order_detail');
	}
   
    function get_kode_order_produk(){
            $q = $this->db->query("SELECT MAX(RIGHT(id_trans_order,5)) as kode_max from tbl_trans_order WHERE DATE_FORMAT(tgl_trans_order, '%Y-%m') = DATE_FORMAT(CURRENT_DATE(), '%Y-%m')");
            $kd = "";
            if($q->num_rows()>0){
                foreach($q->result() as $k){
                    $tmp = ((int)$k->kode_max)+1;
                    $kd = sprintf("%05s", $tmp);
                }
            }else{
                $kd = "00001";
            }
            return "ORD".date('my').$kd;
    }

    function satuan(){
		$this->db->order_by('name','ASC');
		$namaSatuan= $this->db->get('tbl_satuan,tbl_barang');
		return $namaSatuan->result_array();
	}


	public function lookup_produk($keyword)
	{
		$this->db->select('tbl_produk.nama_produk, tbl_produk.id_produk, tbl_produk.harga, tbl_produk.id_satuan, tbl_satuan.nama_satuan');
		$this->db->from('tbl_produk');
		$this->db->join('tbl_satuan', 'tbl_produk.id_satuan = tbl_satuan.id_satuan', 'left');;
		$this->db->like('nama_produk',$keyword);
		$this->db->where('status', '1');
		$this->db->limit(5);
		$query = $this->db->get();
		return $query->result();
	}

	

}