<?php

class Slider_model extends CI_Model
{
    public function add_slider($data)
    {
        $this->db->insert('audition_slider', $data);
        return $this->db->insert_id();
    }
    public function change_slider_image($id, $data)
    {
        $image = $this->db->select('slider_photo')
            ->from('audition_slider')
            ->where('id', $id)
            ->get()
            ->result_array();
        if (!empty($image)) {
            @unlink('./audition_asset/images/slider_images/' . $image[0]['slider_photo']);
        }
        $query = $this->db
            ->where('id', $id)
            ->update('audition_slider', $data);
        return $query;
    }
}
