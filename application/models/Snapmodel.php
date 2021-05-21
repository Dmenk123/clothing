  
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Snapmodel extends CI_Model
{

    public $table = 'tbl_requesttransaksi';
    public $primaryKey = 'id';

    function __construct()
    {
        parent::__construct();
    }

    function insert($data) {
        return $this->db->insert($this->table, $data);
    }
}