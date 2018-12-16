<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller {

    public function cart(){
        $this->load->library('session');
        $this->load->library('user_agent');
        $this->load->database();

        $cart = $this->session->cart;
        if(empty($cart)) $cart = array();
        $data = array();
        $data['items'] = array();
        foreach ($cart as $id => $count){
            $i = $this->db->query("SELECT * FROM item WHERE id = $id")->result_array()[0];
            $i['count'] = $count;
            $data['items'][$id] = $i;
        }

        $refer = "http://" . base_url();
        if ($this->agent->is_referral())
        {
            $refer =  $this->agent->referrer();
        }
        $data['refer'] = $refer;

        $this->load->view('header');
        $this->load->view('cart', $data);
        $this->load->view('footer');
    }



    public function checkout(){
        $this->load->database();
        $data = array();

        $data['delivery'] = 60;
        $data['total'] = $this->input->post('total') + $data['delivery'];

        $promo_code = $this->input->post('promo_code');

        $sql = "SELECT * FROM promotion WHERE code = '$promo_code'";
        $result = $this->db->query($sql)->result_array();


        $data['discount'] = 0;
        $data['promo_applied'] = FALSE;
        if(sizeof($result)){
            $data['promo_applied'] = TRUE;
            $data['discount'] = $result[0]['amount'] / 100.0;
        }

        $this->load->view('header');
        $this->load->view('checkout', $data);
        $this->load->view('footer');
    }

    public function add_to_cart($id){
        $this->load->library('session');
        $cart = $this->session->cart;
        if(empty($cart)) $cart = array();
        if(!isset($cart["$id"])) $cart["$id"] = 0;
        $cart["$id"] += 1;
        $this->session->cart = $cart;
        redirect('http://' . base_url() . 'customer/cart/', "refresh");
    }

    public function remove_from_cart($id){
        $this->load->library('session');
        $cart = $this->session->cart;
        $cart["$id"] -= 1;
        if($cart["$id"] == 0) unset($cart["$id"]);
        $this->session->cart = $cart;
        redirect('http://' . base_url() . 'customer/cart/', "refresh");
    }


    public function complete(){
        $this->load->view('header');
        $this->load->view('complete');
        $this->load->view('footer');
    }
}
