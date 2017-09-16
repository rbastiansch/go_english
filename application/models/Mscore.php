<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mscore extends CI_Model {
    public function __construct() {
        parent::__construct();
        // carregamos o helper que irá fazer o gerenciamento da criptografia da senha
        $this->load->helper('passw_service');
    }

    public function GetScore() {
    	return $this->db->select()
    		->from('SCORE')
    		->where(array('user_id' => 1))
    		->get()
    		->result();
    }
}