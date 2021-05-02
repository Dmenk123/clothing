<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mod_faq extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		//alternative load library from config
		$this->load->database();
	}
	
}