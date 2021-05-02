<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mod_retur_masuk_adm extends CI_Model
{
	var $column_search = array('tbl_retur_masuk.id_retur_masuk', 'tbl_user.fname_user', 'tbl_supplier.nama_supplier', 'tbl_retur_masuk.tgl_retur_masuk', null);

	var $column_order = array('tbl_retur_masuk.id_retur_masuk', 'tbl_user.fname_user', 'tbl_supplier.nama_supplier', 'tbl_retur_masuk.tgl_retur_masuk', null);

	var $order = array('tbl_retur_masuk.id_retur_masuk' => 'desc'); // default order 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	// ================================================================================================

	private function _get_datatable_rtr_msk_query($term='') //term is value of $_REQUEST['search']
	{
		$column = array(
				'tbl_retur_masuk.id_retur_masuk',
				'tbl_user.fname_user',
				'tbl_supplier.nama_supplier',
				'tbl_retur_masuk.tgl_retur_masuk',
				null,
			);

		$this->db->select('
				tbl_retur_masuk.id_retur_masuk,
				tbl_user.fname_user,
				tbl_user.lname_user,
				tbl_supplier.nama_supplier,
				tbl_retur_masuk.tgl_retur_masuk,
				COUNT(tbl_retur_masuk_detail.id_produk) AS jml
			');

		$this->db->from('tbl_retur_masuk');
		$this->db->join('tbl_user', 'tbl_retur_masuk.id_user = tbl_user.id_user', 'left');
		$this->db->join('tbl_supplier', 'tbl_retur_masuk.id_supplier = tbl_supplier.id_supplier', 'left');
		$this->db->join('tbl_retur_masuk_detail', 'tbl_retur_masuk.id_retur_masuk = tbl_retur_masuk_detail.id_retur_masuk','left');
		$this->db->group_by('tbl_retur_masuk_detail.id_retur_masuk');
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

	function get_datatable_rtr_masuk()
	{
		$term = $_REQUEST['search']['value'];
		$this->_get_datatable_rtr_msk_query($term);

		if($_REQUEST['length'] != -1)
		$this->db->limit($_REQUEST['length'], $_REQUEST['start']);

		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered_rtr_masuk()
	{
		$term = $_REQUEST['search']['value'];
		$this->_get_datatable_rtr_msk_query($term);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_rtr_masuk()
	{
		$this->db->from('tbl_trans_masuk');
		return $this->db->count_all_results();
	}

	// ================================================================================================

	public function get_kode_retur_masuk(){
            $q = $this->db->query("SELECT MAX(RIGHT(id_retur_masuk,5)) as kode_max from tbl_retur_masuk WHERE DATE_FORMAT(tgl_retur_masuk, '%Y-%m') = DATE_FORMAT(CURRENT_DATE(), '%Y-%m')");
            $kd = "";
            if($q->num_rows()>0){
                foreach($q->result() as $k){
                    $tmp = ((int)$k->kode_max)+1;
                    $kd = sprintf("%04s", $tmp);
                }
            }else{
                $kd = "0001";
            }
            return "RTRI".date('my').$kd;
    }

    public function get_kode_retur_keluar()
    {
    	$this->db->select('id_retur_keluar'); 
        $this->db->from('tbl_retur_keluar_detail');
        $this->db->where('status_retur_masuk', '0');
        $this->db->group_by('id_retur_keluar');
        $query = $this->db->get();
        return $query->result();
    }

    public function lookup_id_supplier_retout($idReturOut)
	{
		$this->db->select('tbl_retur_keluar.id_supplier, tbl_supplier.nama_supplier');
		$this->db->from('tbl_retur_keluar');
		$this->db->join('tbl_supplier', 'tbl_retur_keluar.id_supplier = tbl_supplier.id_supplier', 'left');
		$this->db->where('tbl_retur_keluar.id_retur_keluar', $idReturOut);
			
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
            return $query->row();
        }
	}

	public function get_data_retur_keluar_detail($id_retur_keluar)
	{
		$this->db->select('tbl_retur_keluar_detail.id_retur_keluar,
						   tbl_produk.nama_produk,
						   tbl_retur_keluar_detail.id_retur_keluar_detail,
						   tbl_retur_keluar_detail.id_produk,
						   tbl_satuan.nama_satuan,
						   tbl_retur_keluar_detail.id_satuan,
						   tbl_retur_keluar_detail.id_stok,
						   tbl_retur_keluar_detail.ukuran,
						   tbl_retur_keluar_detail.qty,
						   tbl_retur_keluar_detail.keterangan');
		$this->db->from('tbl_retur_keluar_detail');
		$this->db->join('tbl_produk', 'tbl_retur_keluar_detail.id_produk = tbl_produk.id_produk','left');
		$this->db->join('tbl_satuan', 'tbl_retur_keluar_detail.id_satuan = tbl_satuan.id_satuan','left');
        $this->db->where('tbl_retur_keluar_detail.id_retur_keluar', $id_retur_keluar);
        $this->db->where('tbl_retur_keluar_detail.status_retur_masuk', '0');

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
	}

	public function simpan_data_retur_masuk($data_retur_masuk, $data_retur_masuk_detail)
	{
		//insert into tbl_retur_masuk
		$this->db->insert('tbl_retur_masuk',$data_retur_masuk);
		//insert into tbl_retur_masuk_detail 
		$this->db->insert_batch('tbl_retur_masuk_detail',$data_retur_masuk_detail);
	}

	public function get_data_retur_masuk_header($id_retur_masuk)
	{
		$this->db->select('
			tbl_retur_masuk.id_retur_masuk,
			tbl_user.fname_user,
			tbl_user.lname_user,
			tbl_retur_masuk.id_supplier,
			tbl_supplier.nama_supplier,
			tbl_supplier.alamat_supplier,
			tbl_retur_masuk.tgl_retur_masuk,
			tbl_retur_masuk_detail.id_retur_keluar
		');
		$this->db->from('tbl_retur_masuk');
		$this->db->join('tbl_user', 'tbl_retur_masuk.id_user = tbl_user.id_user','left');
		$this->db->join('tbl_supplier', 'tbl_retur_masuk.id_supplier = tbl_supplier.id_supplier','left');
		$this->db->join('tbl_retur_masuk_detail', 'tbl_retur_masuk_detail.id_retur_masuk = tbl_retur_masuk.id_retur_masuk','left');
        $this->db->where('tbl_retur_masuk.id_retur_masuk', $id_retur_masuk);
        $this->db->group_by('tbl_retur_masuk_detail.id_retur_keluar');

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
	}

	public function get_data_retur_masuk_detail($id_retur_masuk)
	{
		$this->db->select('tbl_retur_masuk_detail.id_retur_masuk_detail,
						   tbl_retur_masuk_detail.id_retur_keluar_detail,
						   tbl_retur_masuk_detail.id_retur_masuk,
						   tbl_retur_masuk_detail.id_retur_keluar,
						   tbl_retur_masuk_detail.id_produk,
						   tbl_produk.nama_produk,
						   tbl_retur_masuk_detail.id_satuan,
						   tbl_satuan.nama_satuan,
						   tbl_retur_masuk_detail.id_stok,
						   tbl_retur_masuk_detail.ukuran,
						   tbl_retur_masuk_detail.qty,
						   tbl_retur_masuk_detail.keterangan,
						   tbl_retur_masuk_detail.timestamp');
		$this->db->from('tbl_retur_masuk_detail');
		$this->db->join('tbl_produk', 'tbl_retur_masuk_detail.id_produk = tbl_produk.id_produk','left');
		$this->db->join('tbl_satuan', 'tbl_retur_masuk_detail.id_satuan = tbl_satuan.id_satuan','left');
        $this->db->where('tbl_retur_masuk_detail.id_retur_masuk', $id_retur_masuk);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
	}

	public function hapus_data_retur_masuk_detail($id)
	{
		$this->db->where('id_retur_masuk', $id);
		$this->db->delete('tbl_retur_masuk_detail');
	}

	public function update_data_header_retur_masuk($where, $data_header)
	{
		$this->db->update('tbl_retur_masuk', $data_header, $where);
	}

	public function reinsert_retur_masuk_detail($data_retur_masuk_detail)
	{
		$this->db->insert_batch('tbl_retur_masuk_detail',$data_retur_masuk_detail);
	}

	public function update_data_status_retur_masuk($where, $nilai)
	{
		$this->db->update('tbl_retur_keluar_detail', $nilai, $where);
	}

	public function get_id_retur_keluar($id_retur_masuk)
	{
	 	$this->db->select('id_retur_keluar');
	 	$this->db->from('tbl_retur_masuk_detail');
	 	$this->db->where('id_retur_masuk', $id_retur_masuk);
	 	$this->db->group_by('id_retur_keluar');
	 	$query = $this->db->get();
	 	$hasil = $query->row();
	 	return $hasil->id_retur_keluar;
	}

	public function delete_data_retur_masuk($id_retur_masuk)
	{
		//tbl header
		$this->db->where('id_retur_masuk', $id_retur_masuk);
		$this->db->delete('tbl_retur_masuk');
		//tbl detail
		$this->db->where('id_retur_masuk', $id_retur_masuk);
		$this->db->delete('tbl_retur_masuk_detail');
	}

    /*public function get_qty_order_masuk(){
		 $query = $this->db->query("SELECT id_trans_order FROM tbl_trans_order_detail WHERE status_masuk='0' OR qty > ANY (SELECT qty FROM tbl_trans_masuk_detail)");
		 return $query->result();
	}*/	

}