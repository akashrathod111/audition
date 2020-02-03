<?php

class User_model extends CI_Model
{
/* ----------------------------------------------------------------------------------------------

this mathod insert new user in db */

    public function check_email($email, $phone)
    {
        $query = $this->db->select('*')
            ->where('user_email', $email)
            ->or_where('user_contact', $phone)
            ->get('user_registration');
        $result = $query->row_array();
        return $result;
    }

    public function create_user($data)
    {
        $this->db->insert('user_registration', $data);
        return $this->db->insert_id();
    }
    public function user_image($data)
    {
        $query = $this->db->insert('user_photos', $data);
        return $query;
    }
}
?>
