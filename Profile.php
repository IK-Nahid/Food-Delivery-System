<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

	function __construct(){

		parent::__construct();
	}

	function index() {

		$customer_id = $this->session->userdata('customer_id');

		if(!$customer_id) {

			redirect('Login');
		}

		$data['info'] = $this->db->select('*')
								->from('customer')
								->where('id', $customer_id)
								->get()->row_array();

		$this->load->view('header');
		$this->load->view('profile', $data);
		$this->load->view('footer');
	}
}
