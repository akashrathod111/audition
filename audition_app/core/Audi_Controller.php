<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH . 'libraries/REST_Controller.php');

use \Firebase\JWT\JWT;

class Audi_Controller extends REST_Controller {
    private $jwt_token;
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->jwt_token = $this->input->get_request_header('era-token');
    }

    protected function check_token(){
        try{
            $valid_data = JWT::decode($this->jwt_token, JWT_KEY, array('HS512'));
            $valid_data = $valid_data->data;
            if(!empty($valid_data->userId)){
                $this->db->where('user_id',$valid_data->userId);
                $this->db->set('user_lastactive', date('Y-m-d H:i:s'));
                $this->db->set('user_online', '1');
                $this->db->update('users');
            }
        }catch(Exception $e){
            $valid_data = $e->getMessage();
        }
        return $valid_data;
    }
}
