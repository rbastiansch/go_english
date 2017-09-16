<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Muser extends CI_Model {
    public function __construct() {
        parent::__construct();
        // carregamos o helper que irá fazer o gerenciamento da criptografia da senha
        $this->load->helper('passw_service');
    }
    /*
     * Método que irá listar todos os usu
     ários
     * recebe como parâmetro os campos a serem retornados
     */
    public function GetAll($fields = null){
        $this->db->select($fields)
        ->from('USER')
        ->order_by('id','ASC');
        return $this->db->get()->result_array();
    }
    /*
     * Método que irá fazer a validação dos dados e processar o insert na tabela
     * recebe como parâmetro o array com os dados vindos do formulário
     */
    function Insert($dados) {
        if (!isset($dados)) {
            $response['status'] = false;
            $response['message'] = "Dados não informados.";
        } else {
            // setamos os dados que devem ser validados
            $this->form_validation->set_data($dados);
            // definimos as regras de validação
            $this->form_validation->set_rules('name','Name','required|min_length[3]|trim');
            $this->form_validation->set_rules('account','Account','required|min_length[6]|trim');
            $this->form_validation->set_rules('email','Email','required|valid_email|is_unique[users.email]|trim');
            $this->form_validation->set_rules('password','Password','required|min_length[6]|trim');
            // executamos a validação e verificamos o seu retorno
            // caso haja algum erro de validação, define no array $response
            // o status e as mensagens de erro
            if ($this->form_validation->run() === false) {
                $response['status'] = false;
                $response['message'] = validation_errors();
            } else {
                // criptografamos a senha
                $dados['password'] = EncryptPassw($dados['password']);
                //executamos o insert
                $status = $this->db->insert('users', $dados);
                // verificamos o status do insert
                if ($status) {
                    $response['status'] = true;
                    $response['message'] = "Usuário inserido com sucesso.";
                } else {
                    $response['status'] = false;
                    $response['message'] = $this->db->error_message();
                }
            }
        }
        // retornamos as informações sobre o insert
        return $response;
    }
}