<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_global extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	function store_id($data,$table){
        $this->db->insert($table,$data);
        return $this->db->insert_id();
    }
    
    function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    function store($data,$table){
        $this->db->insert($table,$data);
        return $this->db->affected_rows();
    }
    
    function update($table=NULL, $data=NULL, $array_where=NULL){
        $this->db->where($array_where);
        $this->db->update($table, $data);
        return $this->db->affected_rows();
    }

    function delete($array_where=NULL, $table=NULL){
        $this->db->where($array_where);
        $this->db->delete($table);
        return $this->db->affected_rows(); 
    }

    function single_row($select=NULL,$array_where=NULL,$table=NULL, $join=NULL, $order_by=NULL){
        $this->db->select($select);
		$this->db->from($table);
		if(isset($array_where)){
        	$this->db->where($array_where);
		}
		
		if(isset($join)) {
			foreach($join as $j) :
				$this->db->join($j["table"], $j["on"],'left');
			endforeach;
		}

		if(isset($order_by)){
        	$this->db->order_by($order_by);
        }
		
		$q = $this->db->get();
		
        return $q->row();
    }

    function multi_row($select=NULL, $array_where=NULL, $table=NULL, $join= NULL, $order_by=NULL, $limit=NULL){
		if($select != null) {
			$this->db->select($select);
		}else{
			$this->db->select('*');
		}
       
		$this->db->from($table);

		if(isset($array_where)){
        	$this->db->where($array_where);
		}
		
		if(isset($join)) {
			foreach($join as $j) :
				$this->db->join($j["table"], $j["on"],'left');
			endforeach;
		}

		if(isset($order_by)){
        	$this->db->order_by($order_by);
        }

        if(isset($$limit)) {
            $this->db->limit($limit);
        }
		
		$q = $this->db->get();
		
        return $q->result();
    }

    function rownum($where,$table){
		$this->db->select('*');
		$this->db->where($where);
		return $this->db->get($table)->num_rows();
	}
    
    function max($field, $table){
        $q =$this->db->select_max($field);
        $q = $this->db->get($table); 
        return $q->row();
	}

	public function getSelectedData($table,$datawhere,$data_like=null, $datawhere_or = null, $datawhere1=null,$wherein=null,$where_in=null,$in=null,$where_sekda=null,$datalike_or=null,$not_in=null,$not_like=null)
    {
        $this->db->select('*');
        if ($datawhere != null) {
            $this->db->where($datawhere);
        }
        if ($data_like != null) {
           $this->db->like($data_like,false,'after');
        }
        if ($datawhere_or != null) {
            $this->db->or_where($datawhere_or);
        }
        if ($datawhere1 != null) {
            $this->db->where($datawhere1);
        }
     //SEMENTARA UNTUK MENAMPILKAN KATEGORI SURAT YANG HANYA SUDAH ADA FORMNYA
        if ($wherein != null) {
            $this->db->where_in('id_kategori',$wherein);
        }

        if ($where_in != null) {
            $this->db->where_in('id_laporan',$where_in);
        }

        if ($in != null) {
            $this->db->where_in('id_detail',$in);
        }

        if ($where_sekda != null) {
            $this->db->where_in('id_jabatan',$where_sekda);
        }

        if ($datalike_or != null) {
            $this->db->or_like($datalike_or);
        }

        if($not_in != null){
            $this->db->where_not_in($not_in);
        }

        if($not_like != null){
            $this->db->not_like($not_like);
        }

        return $this->db->get($table);
    }

    public function save($data, $table)
	{
		return $this->db->insert($table, $data);	
	}
	
	// public function get_transaksi($order_id){
    //     $queri = $this->db->query("
    //                 SELECT 
    //                     r.order_id,
    //                     c.nama,
    //                     c.email,
    //                     c.keterangan,
    //                     r.transaction_status
    //                 FROM tbl_requesttransaksi r
    //                 JOIN t_checkout c ON r.order_id=c.order_id
    //                 WHERE r.order_id = '$order_id'
    //             ");
    //     return $queri;
    // }

    public function get_transaksi($order_id){
        $queri = $this->db->query("
                    SELECT 
                        c.order_id,
                        c.nama,
                        c.email,
                        r.transaction_status
                    FROM t_checkout c
                    LEFT JOIN tbl_requesttransaksi r on c.order_id = r.order_id
                    WHERE c.order_id = '$order_id'
                ");
        return $queri;
    }

    public function cek_sesi_agen($kode_affiliate)
	{
		$this->db->select('*');
		$this->db->from('m_user');
		$this->db->where('kode_affiliate', $kode_affiliate);
		$this->db->where('status', '1');
		$query = $this->db->get();
		return $query->row();
	}
	
	public function gen_uuid()
	{
		$data = openssl_random_pseudo_bytes(16);
		assert(strlen($data) == 16);

	    $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
	    $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10

	    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
	}   
		
}
