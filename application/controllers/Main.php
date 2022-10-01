<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Main extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
    }

    public function index()
    {
        if ($this->session->userdata('login') != 1)
            redirect(base_url() . 'login', 'refresh');
        if ($this->session->userdata('login') == 1)
            redirect(base_url() . 'main/dashboard', 'refresh');
    }

    public function test_body_email()
    {
        $this->load->view('test');
    }

    public function dashboard()
    {
        if ($this->session->userdata('login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        $page['error']    = $this->error();
        $page['billing']  = $this->billing();
        $page['area']     = $this->area();
        $page['tagihan']  = $this->tagihan();
        $page['pasang']   = $this->pemasangan();
        $page['customer'] = $this->pelanggan();
        $page['page']     = 'page/dashboard';
        $this->load->view('backend/index', $page);
    }

    function pelanggan()
    {
        date_default_timezone_set('Asia/Jakarta');
        $month = date('m');
        $year  = date('Y');

        // $jml  = $this->db->query("SELECT * FROM dbcustomer WHERE YEAR(create_at)='$year' AND MONTH(create_at)='$month' AND show=1")->num_rows();

        $this->db->where('show', 1);
        $this->db->where('YEAR(create_at)', $year);
        $this->db->where('MONTH(create_at)', $month);
        $jml = $this->db->get('dbcustomer')->num_rows();

        return $jml;
    }

    function pemasangan()
    {
        date_default_timezone_set('Asia/Jakarta');
        $month = date('m');
        $year  = date('Y');

        // $jml  = $this->db->query("SELECT * FROM dbnetwork WHERE YEAR(create_at)='$year' AND MONTH(create_at)='$month' AND netstatus='1'")->num_rows();

        $this->db->where('show', 1);
        $this->db->where('netstatus', 1);
        $this->db->where('YEAR(create_at)', $year);
        $this->db->where('MONTH(create_at)', $month);
        $jml = $this->db->get('dbnetwork')->num_rows();

        return $jml;
    }

    function tagihan()
    {
        date_default_timezone_set('Asia/Jakarta');
        $month = date('m');
        $year  = date('Y');

        // $jml  = $this->db->query("SELECT * FROM billing WHERE YEAR(end_at)='$year' AND MONTH(end_at)='$month'")->num_rows();

        $this->db->where('YEAR(end_at)', $year);
        $this->db->where('MONTH(end_at)', $month);
        $jml = $this->db->get('billing')->num_rows();

        return $jml;
    }

    function area()
    {
        date_default_timezone_set('Asia/Jakarta');
        $month = date('m');
        $year  = date('Y');
        $array_where = [
            'YEAR(create_at)' => $year,
            'MONTH(create_at)' => $month,
            'show' => 1
        ];
        $this->db->where($array_where);
        $this->db->order_by('create_at', 'desc');
        $data = $this->db->get('dbnetwork')->result_array();
        // $data  = $this->db->query("SELECT * FROM dbnetwork WHERE YEAR(create_at)='$year' AND MONTH(create_at)='$month' ORDER BY create_at DESC")->result_array();
        return $data;
    }

    function billing()
    {
        date_default_timezone_set('Asia/Jakarta');
        $month = date('m');
        $year  = date('Y');
        $array_where = [
            // 'YEAR(end_at)' => $year,
            // 'MONTH(end_at)' => $month,
            'dbcustomer.show' => 1,
            'dbnetwork.show' => 1,
            'billing.show' => 1,
        ];
        $this->db->join('dbcustomer', 'dbcustomer.cid = billing.client');
        $this->db->join('dbnetwork', 'dbnetwork.netid = billing.netid');
        $this->db->join('product', 'product.noproduct = billing.product');
        $this->db->where($array_where);
        $this->db->order_by('end_at', 'desc');
        $data = $this->db->get('billing')->result_array();
        // $data  = $this->db->query("SELECT * FROM billing WHERE YEAR(end_at)='$year' AND MONTH(end_at)='$month' ORDER BY end_at DESC")->result_array();
        return $data;
    }

    function error()
    {
        $this->db->join('dbnetwork', 'dbnetwork.netid = dbmaintenance.netid');
        $this->db->join('dberror', 'dberror.errorcode = dbmaintenance.errorcode');
        $this->db->where('dbmaintenance.status', 1);
        $data = $this->db->get('dbmaintenance')->result_array();
        return $data;
    }
}
