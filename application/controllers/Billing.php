<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Billing extends CI_Controller
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

        if ($akses == 'isbilling') {
            //filter
            $tgl = @$_REQUEST['reportrange'];
            $statbilling = @$_REQUEST['statbilling'];

            $page['value'] = [
                'tgl' => $tgl,
                'statbilling' => $statbilling
            ];
            //endfilter
            $page['list'] = $this->data($tgl, $statbilling);
            $page['page'] = 'billing/data';
            $this->load->view('backend/index', $page);
        } elseif ($akses == 'iscalculation') {
            $this->hitung();
        } elseif ($akses == 'isaddinvoice') {
            $this->addinvoice();
        } else {
            $page['page'] = 'notfound';
            $this->load->view('backend/index', $page);
        }
    }

    function data($tgl = null, $statbilling = null)
    {
        //get data from table billing
        //daterange column = end_at
        //status column = statbilling

        date_default_timezone_set('Asia/Jakarta');
        if (!empty($tgl)) {
            $tgl = explode(" - ", $tgl);

            $tgl_awal = $tgl[0];
            $tgl_akhir = $tgl[1];
            $this->db->where("DATE_FORMAT(end_at,'%m/%d/%Y') >='$tgl_awal'");
            $this->db->where("DATE_FORMAT(end_at,'%m/%d/%Y') <='$tgl_akhir'");
        } else {
            $month = date('m');
            $year  = date('Y');
            $this->db->where('MONTH(end_at)', $month);
            $this->db->where('YEAR(end_at)', $year);
        }

        if (!empty($statbilling)) {
            $this->db->where('statbilling', $statbilling);
        }

        $this->db->where('stat', 1);
        $this->db->where('dbnetwork.show', 1);
        $this->db->where('billing.show', 1);
        $this->db->order_by('end_at', 'desc');
        $this->db->join('dbnetwork', 'dbnetwork.netid = billing.netid');
        $this->db->join('dbcustomer', 'dbcustomer.cid = billing.client');
        $this->db->join('product', 'product.noproduct = billing.product');
        $data = $this->db->get('billing')->result_array();
        //         $data  = $this->db->query("SELECT * FROM billing WHERE YEAR(end_at)='$year' AND MONTH(end_at)='$month' ORDER BY start_at DESC")->result_array();
        return $data;
    }

    function hitung()
    {
        $tagihan  = preg_replace('/[^0-9]/', '', $this->input->post('tagihan'));
        $potongan = preg_replace('/[^0-9]/', '', $this->input->post('hpp'));
        $biaya    = preg_replace('/[^0-9]/', '', $this->input->post('margin'));
        if (!empty($potongan) && empty($biaya)) {
            $bayar = $tagihan - $potongan;
        } elseif (!empty($biaya) && empty($potongan)) {
            $bayar = $tagihan + $biaya;
        } elseif (!empty($potongan) && !empty($biaya)) {
            $sub   = $biaya - $potongan;
            $bayar = $tagihan + $sub;
        } else {
            $bayar = $tagihan;
        }

        $jumlah = number_format($bayar, 0, ',', '.');
        echo json_encode($jumlah);
    }

    function detail($id = '')
    {
        $akses = decrypt_url($id);
        $page['number'] = $this->generatePIN(5);
        $page['list']   = $this->db->get_where('billing', array('netid' => $akses))->result_array();
        $page['page']   = 'billing/detail';
        $this->load->view('backend/index', $page);
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

        return "INF-" . $date . $pin;
    }


    function addinvoice()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d H:i:s');
        $user = $this->session->userdata('login_user_id');
        $noid = $this->input->post('noid');
        $this->db->where('no_invoice', $noid);
        $data = $this->db->get('invoice');

        if ($data->num_rows() == 1) {
            $respone['status']  = 201;
            $respone['title']   = 'error';
            $respone['message'] = 'No.Invoice Sudah Di Proses';
        } else {
            $member = $this->input->post('client');
            $email  = $this->db->get_where('dbcustomer', array('cid' => $member))->row()->email;
            $phone  = $this->db->get_where('dbcustomer', array('cid' => $member))->row()->handphone;
            $insert = array(
                'no_invoice' => $noid,
                'create_at'  => $date,
                'netid'      => $this->input->post('netid'),
                'client'     => $member,
                'email'      => $email,
                'period'     => $this->input->post('period'),
                'statinvoice' => '1',
                'product'    => $this->input->post('product'),
                'phone'      => $phone,
                'totalbill'  => preg_replace('/[^0-9]/', '', $this->input->post('total_bayar')),
                'bill'       => preg_replace('/[^0-9]/', '', $this->input->post('bill')),
                'tax'        => preg_replace('/[^0-9]/', '', $this->input->post('potongan')),
                'other_bill' => preg_replace('/[^0-9]/', '', $this->input->post('biayalain')),
                'info'       => $this->input->post('infolain'),
                'staf_send'  => $user,
                'show' => 1
            );

            $inp = $this->security->xss_clean($insert);
            $in  = $this->db->insert('invoice', $inp);
            $in = true;

            if ($in) {
                $respone['status']  = 200;
                $respone['title']   = 'success';
                $respone['message'] = 'Invoice Berhasil Di Proses, Silakan Cek Data Invoice';

                $netid = $this->input->post('netid');
                $up = array(
                    'stat' => '2',
                );
                $this->db->where('netid', $netid);
                $this->db->update('billing', $up);

                //SEND EMAIL
                $this->load->library('mailer');

                ///get member
                $client = $this->db->get_where('dbcustomer', array('cid' => $member), 1)->row();
                //get invoice
                $invoice = $this->db->get_where('invoice', array('no_invoice' => $noid), 1)->row();

                $product = $this->db->get_where('product', array('noproduct' =>  $this->input->post('product')), 1)->row();

                $body_mail = [
                    'client' => $client,
                    'invoice' => $invoice,
                    'product' => $product
                ];

                $body = body_mail($body_mail);
                $periode =  date("d-m-Y", strtotime($date));


                $data = [
                    'email_penerima' => $client->email, //client email
                    'subjek' => 'Tagihan Pembayaran Kalimosoft Period ' . $periode, //subject
                    'content' => $body //body
                ];

                $mailer = new Mailer;
                $send =  $mailer->send($data);
                //ENDSENDEMAIL
            } else {
                $respone['status']  = 201;
                $respone['title']   = 'error';
                $respone['message'] = 'Invoice Gagal Di Proses, Silakan Coba Lagi';
            }
        }

        echo json_encode($respone);
    }
}
