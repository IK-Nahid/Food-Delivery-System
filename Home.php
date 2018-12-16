<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function index()
	{
	    $this->load->database();
	    $data['restaurants'] = $this->db->query('SELECT * FROM restaurant')->result_array();
		$this->load->view('header');
		$this->load->view('home', $data);
		$this->load->view('footer');
	}

	public function about(){
        $this->load->database();
        $data['restaurants'] = $this->db->query('SELECT * FROM restaurant')->result_array();
        $this->load->view('header');
        $this->load->view('about', $data);
        $this->load->view('footer');
    }
}
