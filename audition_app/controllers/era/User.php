<?php

use \Firebase\JWT\JWT;

class User extends Audi_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');

    }
/* ----------------------------------------------------------------------------------------------
this method for create new user in db */
    public function create_user_post()
    {
        $this->form_validation->set_data($this->post());
        if ($this->form_validation->run('user_detail') === true) {
            $email = $this->post('user_email');
            $phone = $this->post('user_contact');
            $checkemail = $this->user_model->check_email($email, $phone);

            if (!empty($checkemail)) {
                $response = [
                    'status' => false,
                    'message' => 'This email-id or phone number is already registered.',
                ];
                $this->response($response, REST_Controller::HTTP_OK);
            } else {
                $data['user_contact'] = $this->post('user_contact');
                $data['user_email'] = $this->post('user_email');
                $data['user_state'] = $this->post('user_state');
                $data['user_name'] = $this->post('user_name');

                $result = $this->user_model->create_user($data);
                $user_image = $this->product_image_post($result);
                if (empty($user_image['status'])) {
                    $response = [
                        'status' => false,
                        'message' => 'User Registration completed but image not uploaded.',
                    ];
                    $this->response($response, REST_Controller::HTTP_OK);
                }

                if (!empty($result)) {
                    $response = [
                        'status' => true,
                        'message' => 'User create successful.',
                    ];
                } else {
                    $response = [
                        'status' => false,
                        'message' => 'Problem in creating user.',
                    ];
                }
            }
            $this->response($response, REST_Controller::HTTP_OK);
        } else {
            $response = [
                'status' => false,
                'message' => validation_errors(),
            ];
            $this->response($response, REST_Controller::HTTP_OK);
        }
    }

    public function product_image_post($id)
    {
        /* print_r($id);die; */
            $this->load->library('upload');
            $dataInfo = array();
            $files = $_FILES;
            $cpt = count($_FILES['user_image']['name']);
            $result = [];
            for ($i = 0; $i < $cpt; $i++) {
                $_FILES['userfile']['name'] = $files['user_image']['name'][$i];
                $_FILES['userfile']['type'] = $files['user_image']['type'][$i];
                $_FILES['userfile']['tmp_name'] = $files['user_image']['tmp_name'][$i];
                $_FILES['userfile']['error'] = $files['user_image']['error'][$i];
                $_FILES['userfile']['size'] = $files['user_image']['size'][$i];

                $this->upload->initialize($this->set_upload_options());
                $this->upload->do_upload();
                $dataInfo = $this->upload->data();
                $images[] = $dataInfo['file_name'];

                $data['user_id'] = $id;
                $data['user_photo'] = $dataInfo['file_name'];

                /* split image name */
                $str_arr = explode(".", $data['user_photo']);
                $extension = end($str_arr); /* get last extension */
                /* split image name */

                /* check image extension */
                if ($extension == 'gif' || $str_arr[1] == 'jpg' || $str_arr[1] == 'png' || $str_arr[1] == 'jpeg') {
                    $result = $this->user_model->user_image($data);
                } else {
                    return false;
                }
                /* check image extension */
            }

            if (!empty($result)) {
                $data1['error'] = "success";
                $data1['status'] = true;
                return $data1;
            } else {
                $data1['error'] = $this->upload->display_errors();
                $data1['status'] = false;
                return $data1;
            }
    }

    private function set_upload_options()
    {
        //upload an image options
        $config = array();
        $config['upload_path'] = './audition_asset/images/user_images/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = '0';
        $config['overwrite'] = false;

        return $config;
    }
}