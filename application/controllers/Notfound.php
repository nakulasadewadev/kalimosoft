<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notfound extends CI_Controller {
    
    public function index(){

        $page['page'] = 'notfound';
        $this->load->view('backend/index',$page);
    }
}