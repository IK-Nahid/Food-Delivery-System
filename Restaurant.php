<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Restaurant extends CI_Controller {

    public function show($restaurant_id)
    {
        $this->load->database();

        $query = "
            SELECT *
            FROM item
            WHERE restaurant_id='$restaurant_id'  
        ";
        $data['items'] = $this->db->query($query)->result_array();
        $data['restaurant'] = $this->db->query("SELECT * FROM restaurant WHERE id = $restaurant_id")->result_array()[0];


        $this->load->view('header');
        $this->load->view('restaurant', $data);
        $this->load->view('footer');
    }


    public function search($type)
    {
        $this->load->library('session');
        $this->load->database();



        $text = $this->input->post('text');


        $data['type'] = $type;
        $data['text'] = $text;
        $data['restaurants'] = $this->db->query("SELECT * FROM restaurant WHERE LOWER(name) LIKE '%$text%'")->result_array();

        $data['name'] = 'active';
        $data['location'] = '';

        if($type == 'location'){
            $data['name'] = '';
            $data['location'] = 'active';
            $data['restaurants'] = $this->db->query("SELECT * FROM restaurant WHERE LOWER(location) LIKE '%$text%'")->result_array();


        }
        $this->load->view('header');
        $this->load->view('search', $data);
        $this->load->view('footer');
    }

    public function offer()
    {
        $this->load->view('header');
        $this->load->view('offers');
        $this->load->view('footer');
    }
}
