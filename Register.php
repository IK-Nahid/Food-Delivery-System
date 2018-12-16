<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

	function __construct(){

		parent::__construct();
	}

	function index() {

		$this->load->view('header');
		$this->load->view('register');
		$this->load->view('footer');
	}

	function save_customer() {

		$email = $this->input->post('email');

		$info = $this->db->select('*')
			->from('customer')
			->where('email', $email)
			->get()->row_array();

		if(!$info) {

			$data = array(

				'name'	=> $this->input->post('name'),
				'email'	=> $this->input->post('email'),
				'password'=> $this->input->post('password'),
				'address'=> $this->input->post('address'),
				'reg_time'=>time()
			);

			$this->db->insert('customer', $data);

			$info = $this->db->select('*')
				->from('customer')
				->where('email', $email)
				->get()->row_array();

			if ($info) {

				$this->session->set_userdata('is_logged_in', true);
				$this->session->set_userdata('customer_id', $info['id']);
			}

			redirect('Home');

		}
		else {

			$data['error']='Sorry, email is already used';
			$this->load->view('header');
			$this->load->view('register', $data);
			$this->load->view('footer');
		}
	}
}
