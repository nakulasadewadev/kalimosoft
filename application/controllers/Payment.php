<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Payment extends CI_Controller
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

        if ($akses == 'istransaction') {
            $page['users'] = $this->db->get('useradmin')->result_array();
            $page['list']  = $this->data();
            $page['page']  = 'payment/proses';
            $this->load->view('backend/index', $page);
        } elseif ($akses == 'isproses') {
            $this->proses();
        } else {
            $page['page'] = 'notfound';
            $this->load->view('backend/index', $page);
        }
    }

    function data()
    {
        // $data  = $this->db->query("SELECT * FROM invoice WHERE statinvoice='1' AND show='1'")->result_array();

        $this->db->where('show', 1);
        $this->db->where('statinvoice', 1);
        $data = $this->db->get('invoice')->result_array();
        return $data;
    }

    function cari()
    {
        $noid = $this->input->post('noid');
        $data = $this->db->get_where('invoice', array('no_invoice' => $noid))->result_array();
        if ($data) {
            foreach ($data as $ls) {
                $client     = $this->db->get_where('dbcustomer', array('cid' => $ls['client']))->row()->name;
                $lokasi     = $this->db->get_where('dbnetwork', array('netid' => $ls['netid']))->row()->address;
                $product    = $this->db->get_where('product', array('noproduct' => $ls['product']))->row()->kode;
                $respone['status'] = 200;
                $respone['result'] = array(
                    'noid'      => $ls['no_invoice'],
                    'netid'     => $ls['netid'],
                    'client'    => ucwords($client),
                    'lokasi'    => ucwords($lokasi),
                    'period'    => date('M-Y', strtotime($ls['period'])),
                    'produk'    => strtoupper($product),
                    'bill'      => number_format($ls['bill'], 0, ',', '.'),
                    'totbill'   => number_format($ls['totalbill'], 0, ',', '.'),
                    'tax'       => number_format($ls['tax'], 0, ',', '.'),
                    'lainnya'   => number_format($ls['other_bill'], 0, ',', '.'),
                    'infolain'  => $ls['info']
                );
            }
        } else {
            $respone['status'] = 201;
            $respone['result'] = [];
        }

        echo json_encode($respone);
    }

    function proses()
    {
        if ($this->input->post()) {
            $user   = $this->session->userdata('login_user_id');
            date_default_timezone_set('Asia/Jakarta');
            $date   = date('Y-m-d H:i:s');
            $noid   = $this->input->post('idinvoice');
            $netid  = $this->input->post('netids');
            $period = $this->db->get_where('invoice', array('no_invoice' => $noid))->row()->period;
            $member = $this->db->get_where('dbnetwork', array('netid' => $netid))->row()->cid;
            $bayar  = $this->input->post('tglbayar');
            $endat  = $this->db->get_where('billing', array('netid' => $netid))->row()->end_at;
            $startat = $this->db->get_where('billing', array('netid' => $netid))->row()->start_at;
            $insert = array(
                'no_invoice' => $noid,
                'netid'      => $netid,
                'create_at'  => $date,
                'period'     => $period,
                'start_at'   => $startat,
                'end_at'     => $endat,
                'client'     => $member,
                'pembayaran' => 1,
                'nominal'    =>  preg_replace('/[^0-9]/', '', $this->input->post('nominal')),
                'staf'       => $this->input->post('terima'),
                'paid_date'  => date('Y-m-d H:i:s', strtotime($bayar)),
                'users'      => $user
            );

            $period_subject = $period;

            $ins = $this->db->insert('payment', $insert);
            if ($ins) {
                $enddate = $this->db->get_where('billing', array('netid' => $netid))->row()->end_at;
                $end     = date('Y-m-d H:i:s', strtotime("+30 day", strtotime($enddate)));
                $produk  = $this->db->get_where('billing', array('netid' => $netid))->row()->product;
                $harga   = $this->db->get_where('product', array('noproduct' => $produk))->row()->harga;
                $period  = date('Y-m-d', strtotime($end));

                $update  = array(
                    'start_at'      => $enddate,
                    'end_at'        => $end,
                    'period'        => $period,
                    'statbilling'   => 1,
                    'stat'          => 2,
                    'bill'          => $harga
                );
                $this->db->where('netid', $netid);
                $up = $this->db->update('billing', $update);
                if ($up) {


                    $respone['status']  = 200;
                    $respone['title']   = 'success';
                    $respone['message'] = 'Payment Berhasil Di Proses';

                    $upinvoice = array(
                        'payment' => $date,
                        'statinvoice' => 2
                    );

                    $this->db->where('no_invoice', $noid);
                    $this->db->update('invoice', $upinvoice);


                    //SEND EMAIL
                    $this->load->library('mailer');

                    ///get member
                    $client = $this->db->get_where('dbcustomer', array('cid' => $member))->row();
                    //get invoice
                    $invoice = $this->db->get_where('invoice', array('no_invoice' => $noid))->row();

                    $product = $this->db->get_where('product', array('noproduct' => $invoice->product))->row();

                    $body_mail = [
                        'client' => $client,
                        'invoice' => $invoice,
                        'product' => $product
                    ];

                    $body = body_mail($body_mail);
                    $periode =  date("d-m-Y", strtotime($period_subject));


                    $data = [
                        'email_penerima' => $client->email, //client email
                        'subjek' => 'Pembayaran Berhasil dilakukan | periode : ' . $periode, //subject
                        'content' => $body //body
                    ];

                    $mailer = new Mailer;
                    $send =  $mailer->send($data);
                    //ENDSENDEMAIL
                } else {
                    $respone['status']  = 201;
                    $respone['title']   = 'error';
                    $respone['message'] = 'Payment Gagal Di Proses ,  Silakan Coba Lagi';
                }
            } else {
                $respone['status']  = 201;
                $respone['title']   = 'error';
                $respone['message'] = 'Payment Gagal Di Proses ,  Silakan Coba Lagi';
            }

            echo json_encode($respone);
        } else {
            $page['page'] = 'notfound';
            $this->load->view('backend/index', $page);
        }
    }
}
