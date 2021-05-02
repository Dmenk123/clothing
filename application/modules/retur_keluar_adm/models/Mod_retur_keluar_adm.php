<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mod_retur_keluar_adm extends CI_Model
{
	var $column_search = array('tbl_retur_keluar.id_retur_keluar', 'tbl_user.fname_user', 'tbl_supplier.nama_supplier', 'tbl_retur_keluar.tgl_retur_keluar', null);

	var $column_order = array('tbl_retur_keluar.id_retur_keluar', 'tbl_user.fname_user', 'tbl_supplier.nama_supplier', 'tbl_retur_keluar.tgl_retur_keluar', null);

	var $order = array('tbl_retur_keluar.id_retur_keluar' => 'desc'); // default order 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	// ================================================================================================

	private function _get_datatable_rtr_keluar_query($term='') //term is value of $_REQUEST['search']
	{
		$column = array(
				'tbl_retur_keluar.id_retur_keluar',
				'tbl_user.fname_user',
				'tbl_supplier.nama_supplier',
				'tbl_retur_keluar.tgl_retur_keluar',
				null,
			);

		$this->db->select('
				tbl_retur_keluar.id_retur_keluar,
				tbl_user.fname_user,
				tbl_user.lname_user,
				tbl_supplier.nama_supplier,
				tbl_retur_keluar.tgl_retur_keluar,
				COUNT(tbl_retur_keluar_detail.id_produk) AS jml
			');

		$this->db->from('tbl_retur_keluar');
		$this->db->join('tbl_user', 'tbl_retur_keluar.id_user = tbl_user.id_user', 'left');
		$this->db->join('tbl_supplier', 'tbl_retur_keluar.id_supplier = tbl_supplier.id_supplier', 'left');
		$this->db->join('tbl_retur_keluar_detail', 'tbl_retur_keluar.id_retur_keluar = tbl_retur_keluar_detail.id_retur_keluar','left');
		$this->db->group_by('tbl_retur_keluar_detail.id_retur_keluar');
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

	function get_datatable_rtr_keluar()
	{
		$term = $_REQUEST['search']['value'];
		$this->_get_datatable_rtr_keluar_query($term);

		if($_REQUEST['length'] != -1)
		$this->db->limit($_REQUEST['length'], $_REQUEST['start']);

		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered_rtr_keluar()
	{
		$term = $_REQUEST['search']['value'];
		$this->_get_datatable_rtr_keluar_query($term);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_rtr_keluar()
	{
		$this->db->from('tbl_trans_masuk');
		return $this->db->count_all_results();
	}

	// ================================================================================================

	public function get_kode_trans_retur_keluar(){
            $q = $this->db->query("SELECT MAX(RIGHT(id_retur_keluar,5)) as kode_max from tbl_retur_keluar WHERE DATE_FORMAT(tgl_retur_keluar, '%Y-%m') = DATE_FORMAT(CURRENT_DATE(), '%Y-%m')");
            $kd = "";
            if($q->num_rows()>0){
                foreach($q->result() as $k){
                    $tmp = ((int)$k->kode_max)+1;
                    $kd = sprintf("%04s", $tmp);
                }
            }else{
                $kd = "0001";
            }
            return "RTRO".date('my').$kd;
    }

    public function get_kode_penerimaan()
    {
    	$this->db->select('id_trans_masuk'); 
        $this->db->from('tbl_trans_masuk');
        $query = $this->db->get();
        return $query->result();
    }

    public function lookup_id_supplier_penerimaan($idPenerimaan)
	{
		$this->db->select('tbl_trans_masuk.id_supplier, tbl_supplier.nama_supplier');
		$this->db->from('tbl_trans_masuk');
		$this->db->join('tbl_supplier', 'tbl_trans_masuk.id_supplier = tbl_supplier.id_supplier', 'left');
		$this->db->where('tbl_trans_masuk.id_trans_masuk', $idPenerimaan);
			
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
            return $query->row();
        }
	}

	public function get_data_penerimaan_detail($idPenerimaan)
	{
		$this->db->select('tbl_trans_masuk_detail.id_trans_masuk,
						   tbl_produk.nama_produk,
						   tbl_trans_masuk_detail.id_trans_masuk_detail,
						   tbl_trans_masuk_detail.id_produk,
						   tbl_satuan.nama_satuan,
						   tbl_trans_masuk_detail.id_satuan,
						   tbl_trans_masuk_detail.id_stok,
						   tbl_trans_masuk_detail.ukuran,
						   tbl_trans_masuk_detail.qty,
						   tbl_trans_masuk_detail.keterangan');
		$this->db->from('tbl_trans_masuk_detail');
		$this->db->join('tbl_produk', 'tbl_trans_masuk_detail.id_produk = tbl_produk.id_produk','left');
		$this->db->join('tbl_satuan', 'tbl_trans_masuk_detail.id_satuan = tbl_satuan.id_satuan','left');
        $this->db->where('tbl_trans_masuk_detail.id_trans_masuk', $idPenerimaan);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
	}

	public function simpan_data_retur_keluar($data_retur_keluar, $data_retur_keluar_detail)
	{
		//insert into tbl_retur_keluar
		$this->db->insert('tbl_retur_keluar',$data_retur_keluar);
		//insert into tbl_retur_keluar_detail 
		$this->db->insert_batch('tbl_retur_keluar_detail',$data_retur_keluar_detail);
	}

	public function get_data_retur_keluar_header($id_retur_keluar)
	{
		$this->db->select('
			tbl_retur_keluar.id_retur_keluar,
			tbl_user.fname_user,
			tbl_user.lname_user,
			tbl_retur_keluar.id_supplier,
			tbl_supplier.nama_supplier,
			tbl_supplier.alamat_supplier,
			tbl_retur_keluar.tgl_retur_keluar,
			tbl_retur_keluar_detail.id_trans_masuk');
		$this->db->from('tbl_retur_keluar');
		$this->db->join('tbl_user', 'tbl_retur_keluar.id_user = tbl_user.id_user','left');
		$this->db->join('tbl_supplier', 'tbl_retur_keluar.id_supplier = tbl_supplier.id_supplier','left');
		$this->db->join('tbl_retur_keluar_detail', 'tbl_retur_keluar.id_retur_keluar = tbl_retur_keluar_detail.id_retur_keluar', 'left');
		$this->db->group_by('tbl_retur_keluar_detail.id_retur_keluar');
        $this->db->where('tbl_retur_keluar.id_retur_keluar', $id_retur_keluar);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
	}

	public function get_data_retur_keluar_detail($id_retur_keluar)
	{
		$this->db->select('tbl_retur_keluar_detail.id_retur_keluar_detail,
						   tbl_retur_keluar_detail.id_trans_masuk_detail,
						   tbl_retur_keluar_detail.id_retur_keluar,
						   tbl_retur_keluar_detail.id_trans_masuk,
						   tbl_retur_keluar_detail.id_produk,
						   tbl_produk.nama_produk,
						   tbl_retur_keluar_detail.id_satuan,
						   tbl_satuan.nama_satuan,
						   tbl_retur_keluar_detail.id_stok,
						   tbl_retur_keluar_detail.ukuran,
						   tbl_retur_keluar_detail.qty,
						   tbl_retur_keluar_detail.keterangan');
		$this->db->from('tbl_retur_keluar_detail');
		$this->db->join('tbl_produk', 'tbl_retur_keluar_detail.id_produk = tbl_produk.id_produk','left');
		$this->db->join('tbl_satuan', 'tbl_retur_keluar_detail.id_satuan = tbl_satuan.id_satuan','left');
        $this->db->where('tbl_retur_keluar_detail.id_retur_keluar', $id_retur_keluar);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
	}

	public function hapus_data_retur_keluar_detail($id)
	{
		$this->db->where('id_retur_keluar', $id);
		$this->db->delete('tbl_retur_keluar_detail');
	}

	public function update_data_header_retur_keluar($where, $data_header)
	{
		$this->db->update('tbl_retur_keluar', $data_header, $where);
	}

	public function reinsert_data_retur_keluar_detail($data_retur_keluar_detail)
	{
		$this->db->insert_batch('tbl_retur_keluar_detail',$data_retur_keluar_detail);
	}

	public function delete_data_retur_keluar($id)
	{
		//tbl header
		$this->db->where('id_retur_keluar', $id);
		$this->db->delete('tbl_retur_keluar');
		//tbl detail
		$this->db->where('id_retur_keluar', $id);
		$this->db->delete('tbl_retur_keluar_detail');
	}

    /*public function get_qty_order_masuk(){
		 $query = $this->db->query("SELECT id_trans_order FROM tbl_trans_order_detail WHERE status_masuk='0' OR qty > ANY (SELECT qty FROM tbl_trans_masuk_detail)");
		 return $query->result();
	}*/

	

	public function get_by_id($id)
	{
		$this->db->from('tbl_trans_masuk');
		$this->db->where('id_trans_masuk',$id);
		$query = $this->db->get();

		return $query->row();
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