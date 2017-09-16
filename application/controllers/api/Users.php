<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Users extends REST_Controller {
	function __construct() { 
		header('Access-Control-Allow-Origin: *');
   		header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
		parent::__construct();
		$this->load->model('Muser');
	}

	public function index_get() {
	    // Lista os usuários
        $users = $this->Muser->GetAll('id, name, account, email, password');
        // verifica se existem usuários e faz o retorno da requisição
        // usando os devidos cabeçalhos
        if ($users) {
            $response['data'] = $users;
            $this->response($response, REST_Controller::HTTP_OK);
        } else {
            $this->response(null,REST_Controller::HTTP_NO_CONTENT);
        }
	}

	/*
     * Essa função vai responder pela rota /api/usuarios sob o método POST
     */
    public function index_post()
    {
        // recupera os dados informado no formulário
        $user = $this->post();
        // processa o insert no banco de dados
        $insert = $this->Muser->Insert($user);
        // define a mensagem do processamento
        $response['message'] = $insert['message'];
        // verifica o status do insert para retornar o cabeçalho corretamente
        // e a mensagem
        if ($insert['status']) {
            $this->response($response, REST_Controller::HTTP_OK);
        } else {
            $this->response($response, REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}

