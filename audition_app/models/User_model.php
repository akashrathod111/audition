<?php

class User_model extends CI_Model
{
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
    public function get_all_participants()
    {
        $users = $this->db->select('u.*,p.user_photo')
        ->from('user_registration u')
        ->join('user_photos p', 'p.user_id = u.id')
        ->get()
        ->result_array();
        return $users;
    }
    public function user_image($data)
    {
        $query = $this->db->insert('user_photos', $data);
        return $query;
    }
}
?>
