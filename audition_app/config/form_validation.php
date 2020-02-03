<?php
$config = array(
    'user_detail' => array(
        array(
                'field' => 'user_contact',
                'label' => 'Contact',
                'rules' => 'required|min_length[10]|max_length[10]'
        ),
        array(
                'field' => 'user_email',
                'label' => 'Email',
                'rules' => 'required',
        ),
        array(
                'field' => 'user_state',
                'label' => 'State',
                'rules' => 'required'
        ),
        array(
                'field' => 'user_name',
                'label' => 'Name',
                'rules' => 'required'
        ),
),
);

?>