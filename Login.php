<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct(){

		parent::__construct();
	}

	function index() {

		$this->load->view('header');
		$this->load->view('login');
		$this->load->view('footer');
	}

	function auth() {

		$email = $this->input->post('email');
		$password = $this->input->post('password');

		$info = $this->db->select('*')
						->from('customer')
						->where('email', $email)
						->where('password', $password)
						->get()->row_array();

		if($info) {

			$this->session->set_userdata('is_logged_in', true);
			$this->session->set_userdata('customer_id', $info['id']);
			redirect('Home');
		}
		else {

			$data['error']='Sorry, email or password is wrong';
			$this->load->view('header');
			$this->load->view('login', $data);
			$this->load->view('footer');
		}
	}

	function logout() {

		$this->session->sess_destroy();
		redirect('Home');
	}
}
