<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order extends CI_Controller
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

        if ($akses == 'isorder') {
            $data = $this->uri->segment(4);
            $users = $this->uri->segment(6);
            $nik  = base64_decode($users);
            $kode = base64_decode($data);
            $getUser    = $this->db->get_where('dbcustomer', array('nik' => $nik))->result_array();
            $getProduk  = $this->db->get_where('product', array('noproduct' => $kode))->result_array();
            $page['provinsi']   = $this->db->get('provinsi')->result();
            $page['nomor']      = $this->generatePIN(4);
            $page['odc']        = $this->db->get('dbodc')->result_array();
            $page['odp']        = $this->db->get('dbodp')->result_array();
            $page['olt']        = $this->db->get('dbolt')->result_array();
            $page['netid']      = $this->idnumber();
            $page['produk']     = $getProduk;
            $page['user']       = $getUser;
            $page['page']       = 'order/tambah';
            $this->load->view('backend/index', $page);
        } elseif ($akses == 'isprocess') {
            $this->isaddnetwork();
        } else {
            $page['page'] = 'notfound';
            $this->load->view('backend/index', $page);
        }
    }

    function isaddnetwork()
    {
        date_default_timezone_set('Asia/Jakarta');
        $staf   =  $this->session->userdata('login_user_id');
        $date   = date('Y-m-d H:i:s');
        $netid  = $this->input->post('netid');
        $this->db->where('netid', $netid);
        $ketemu = $this->db->get('dbnetwork');
        if ($ketemu->num_rows() == 1) {
            $response['status']  = 201;
            $response['title']   = 'error';
            $response['message'] = 'NET.ID Sudah Di Pergunakan, Silakan Refresh Halaman.';
        } else {
            $insert = array(
                'netid'     => $netid,
                'noorder'   => $this->input->post('nomor'),
                'cid'       => $this->input->post('cid'),
                'create_at' => $date,
                'username'  => $this->input->post('username'),
                'password'  => $this->input->post('password'),
                'productid' => $this->input->post('idproduct'),
                'location'  => $this->input->post('location'),
                'address'   => $this->input->post('address'),
                'oltid' => $this->input->post('olt'),
                'odcid' => $this->input->post('odc'),
                'odcport' => $this->input->post('odc') . ':',
                'odpid' => $this->input->post('odp'),
                // 'latitude'  => $this->input->post('latitude'),
                // 'longitude' => $this->input->post('longitude'),
                'staf'      => $staf,
                'note'      => $this->input->post('note'),
                'show'      => 1
            );
            $data = $this->security->xss_clean($insert);
            $in = $this->db->insert('dbnetwork', $data);
            if ($in) {
                $input = array(
                    'no_order'  => $this->input->post('nomor'),
                    'create_at' => $date,
                    'netid'     => $netid,
                    'product'   => $this->input->post('idproduct'),
                    'member'    => $this->input->post('cid'),
                    'biaya'     => preg_replace('/[^0-9]/', '', $this->input->post('biaya')),
                    'biayalain' => preg_replace('/[^0-9]/', '', $this->input->post('biayalain')),
                    'keterangan' => $this->input->post('infolain'),
                    'staf'      => $staf,
                    'show'      => 1
                );

                $ins = $this->security->xss_clean($input);
                $inp = $this->db->insert('transaksi', $ins);
                if ($inp) {
                    $response['icon']   = 'success';
                    $response['message'] = 'Penambahan Data Pemasangan Baru Berhasil Di Lakukan';
                } else {
                    $response['icon']   = 'error';
                    $response['message'] = 'Penambahan Data Gagal Di Lakukan, Silakan Coba Lagi';
                }
            }
        }

        echo json_encode($response);
    }

    function generatePIN($digits = 4)
    {
        $date = date('dmy');
        $i = 0; //counter
        $pin = ""; //our default pin is blank.
        while ($i < $digits) {
            $pin .= mt_rand(0, 9);
            $i++;
        }

        return "T-" . $date . $pin;
    }

    function idnumber()
    {
        $month = date('m');
        $year  = date('Y');
        $q = $this->db->query("SELECT MAX(RIGHT(netid,5)) AS kd_max FROM dbnetwork WHERE MONTH(create_at)='$month'");
        $kd = "";
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $tmp = ((int)$k->kd_max) + 1;
                $kd = sprintf("%05s", $tmp);
            }
        } else {
            $kd = "00001";
        }
        date_default_timezone_set('Asia/Jakarta');
        return date('my') . $kd;
    }

    //detail for print
    //data client dan data produk yang dipilihnya
    public function detail($id)
    {
        $akses = decrypt_url($id);

        //order
        $this->db->join('dbcustomer', 'dbcustomer.cid = dbnetwork.cid');
        $this->db->join('product', 'product.noproduct = dbnetwork.productid');
        $order = $this->db->get_where('dbnetwork', array('noorder' => $akses), 1)->row();

        $page['order'] = $order;
        $page['page'] = 'order/detail';
        $this->load->view('backend/index', $page);
    }
}
