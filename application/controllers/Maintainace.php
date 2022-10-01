<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Maintainace extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        date_default_timezone_set('Asia/Jakarta');
    }

    function auth($id = '')
    {
        $akses = decrypt_url($id);
        if ($akses == 'ismaintainace') {
            $page['list'] = $this->data();
            $page['page'] = 'maintainance/list';
            $this->load->view('backend/index', $page);
        } else {
            $page['page'] = 'notfound';
            $this->load->view('backend/index', $page);
        }
    }

    function data()
    {
        $this->db->join('dbnetwork', 'dbnetwork.netid = dbmaintenance.netid');
        $data = $this->db->get_where('dbmaintenance', array('status' => '1'))->result_array();
        return $data;
    }
}
