<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Score extends REST_Controller {
	function __construct() { 
		header('Access-Control-Allow-Origin: *');
   		header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
		parent::__construct();
		$this->load->model('Mscore');
	}

	public function index_get() {

		$score = $this->Mscore->GetScore(1);

		if ($score) {
            $response['data'] = $score;
            $this->response($response, REST_Controller::HTTP_OK);
        } else {
            $this->response(null,REST_Controller::HTTP_NO_CONTENT);
        }

	}
}