<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mod_register extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		//alternative load library from config
		$this->load->database();
	}

	public function add_data_register($data)
	{
		$this->db->insert('tbl_user', $data);
	}

	public function lookup_data_provinsi($keyword = "")
	{
		$this->db->select('id_provinsi, nama_provinsi');
		$this->db->from('tbl_provinsi');
		$this->db->like('nama_provinsi',$keyword);
		//$this->db->limit(25);
		$this->db->order_by('nama_provinsi', 'ASC');
	
		$query = $this->db->get();
		return $query->result();
	}

	public function lookup_data_kotakabupaten($keyword = "", $id_provinsi)
	{
		$this->db->select('id_kota, nama_kota');
		$this->db->from('tbl_kota');
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
	
}