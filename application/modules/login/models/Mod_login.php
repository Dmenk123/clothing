<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mod_login extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		//alternative load library from config
		$this->load->database();
	}

	public function login($data){
		$this->db->select('*');
		$this->db->from('tbl_user');
		$this->db->where('email', $data['data_email']);
		$this->db->where('password', $data['data_password']);
		$this->db->where('status', '1');
		$query = $this->db->get();
		return $query->result_array();
	}

	//dibutuhkan di contoller login untuk set last login
	public function set_lastlogin($id){
		$this->db->where('id_user',$id)
				->update('tbl_user',array('last_login'=>date('Y-m-d H:i:s')));			
	}

	public function getByEmail($email){
		$this->db->select('id_user, email, password');
	  	$this->db->where('email',$email);
	  	$this->db->from('tbl_user');
	  	$query = $this->db->get();
	  	return $query;
	}
	 
	public function simpanToken($data){
	  	$this->db->insert('tbl_forgot_pass', $data);
	  	return $this->db->affected_rows();
	}
	 
	public function cekToken($token){
	  	$this->db->where('token',$token);
	  	$query = $this->db->get('tbl_forgot_pass');
	  	return $query;
	}

	public function update_data_user($where, $data)
	{
		$this->db->update("tbl_user", $data, $where);
		return $this->db->affected_rows();
	}
	
}