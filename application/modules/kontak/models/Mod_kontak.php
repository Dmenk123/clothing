<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mod_kontak extends CI_Model
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