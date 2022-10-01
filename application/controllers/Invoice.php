<?php

use Escpos\EscposImage;
use Escpos\PrintConnectors\WindowsPrintConnector;
use Escpos\Printer;

defined('BASEPATH') or exit('No direct script access allowed');

class Invoice extends CI_Controller
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

        if ($akses == 'isinvoice') {
            //filter
            $tgl = @$_REQUEST['reportrange'];
            $statinvoice = @$_REQUEST['statinvoice'];

            $page['value'] = [
                'tgl' => $tgl,
                'statinvoice' => $statinvoice
            ];
            //endfilter
            $page['list'] = $this->data($tgl, $statinvoice);
            $page['page'] = 'invoice/data';
            $this->load->view('backend/index', $page);
        } elseif ($akses == 'resend_invoice') {
            $this->resend_invoice();
        } else {
            $page['page'] = 'notfound';
            $this->load->view('backend/index', $page);
        }
    }

    function data($tgl = null, $statinvoice = null)
    {
        //get data from table invoice
        //daterange column = create_at
        //status column = statinvoice

        date_default_timezone_set('Asia/Jakarta');
        if (!empty($tgl)) {
            $tgl = explode(" - ", $tgl);

            $tgl_awal = $tgl[0];
            $tgl_akhir = $tgl[1];
            $this->db->where("DATE_FORMAT(create_at,'%m/%d/%Y') >='$tgl_awal'");
            $this->db->where("DATE_FORMAT(create_at,'%m/%d/%Y') <='$tgl_akhir'");
        } else {
            $month = date('m');
            $year  = date('Y');
            $this->db->where('MONTH(create_at)', $month);
            $this->db->where('YEAR(create_at)', $year);
        }

        if (!empty($statinvoice)) {
            $this->db->where('statinvoice', $statinvoice);
        }

        $this->db->order_by('create_at', 'desc');
        $this->db->where('invoice.show', 1);
        $data = $this->db->get('invoice')->result_array();
        //         $data  = $this->db->query("SELECT * FROM invoice WHERE YEAR(create_at)='$year' AND MONTH(create_at)='$month' ORDER BY create_at DESC")->result_array();
        return $data;
    }

    function detail($id = '')
    {
        $akses = decrypt_url($id);

        $page['list']   = $this->db->get_where('invoice', array('no_invoice' => $akses))->result_array();

        $this->db->join('useradmin', 'useradmin.nik = payment.staf');
        $page['admin'] = $this->db->get_where('payment', array('no_invoice' => $akses), 1)->row();
        $page['page']   = 'invoice/detail';
        $this->load->view('backend/index', $page);
    }

    public function cetak($id = '')
    {
        $akses = decrypt_url($id);

        $this->db->join('product', 'product.noproduct = invoice.product');
        $this->db->join('dbcustomer', 'dbcustomer.cid = invoice.client');
        $data = $this->db->get_where('invoice', array('invoice.no_invoice' => $akses), 1)->row();


        // me-load library escpos
        $this->load->library('escpos');

        //load image
        // $imagePath = base_url('assets/images/favicon.png');
        // $img = new Escpos\EscposImage($imagePath);

        //fucntion make table
        // membuat fungsi untuk membuat 1 baris tabel, agar dapat dipanggil berkali-kali dgn mudah
        function buatBaris2Kolom($kolom1, $kolom2)
        {
            // Mengatur lebar setiap kolom (dalam satuan karakter)
            $lebar_kolom_1 = 24;
            $lebar_kolom_2 = 24;

            // Melakukan wordwrap(), jadi jika karakter teks melebihi lebar kolom, ditambahkan \n 
            $kolom1 = wordwrap($kolom1, $lebar_kolom_1, "\n", true);
            $kolom2 = wordwrap($kolom2, $lebar_kolom_2, "\n", true);
            // Merubah hasil wordwrap menjadi array, kolom yang memiliki 2 index array berarti memiliki 2 baris (kena wordwrap)
            $kolom1Array = explode("\n", $kolom1);
            $kolom2Array = explode("\n", $kolom2);

            // Mengambil jumlah baris terbanyak dari kolom-kolom untuk dijadikan titik akhir perulangan
            $jmlBarisTerbanyak = max(count($kolom1Array), count($kolom2Array));

            // Mendeklarasikan variabel untuk menampung kolom yang sudah di edit
            $hasilBaris = array();

            // Melakukan perulangan setiap baris (yang dibentuk wordwrap), untuk menggabungkan setiap kolom menjadi 1 baris 
            for ($i = 0; $i < $jmlBarisTerbanyak; $i++) {

                // memberikan spasi di setiap cell berdasarkan lebar kolom yang ditentukan, 
                $hasilKolom1 = str_pad((isset($kolom1Array[$i]) ? $kolom1Array[$i] : ""), $lebar_kolom_1, " ");
                $hasilKolom2 = str_pad((isset($kolom2Array[$i]) ? $kolom2Array[$i] : ""), $lebar_kolom_2, " ");

                // Menggabungkan kolom tersebut menjadi 1 baris dan ditampung ke variabel hasil (ada 1 spasi disetiap kolom)
                $hasilBaris[] = $hasilKolom1 . " " . $hasilKolom2;
            }

            // Hasil yang berupa array, disatukan kembali menjadi string dan tambahkan \n disetiap barisnya.
            return implode($hasilBaris, "\n") . "\n";
        }
        //endtable

        // membuat connector printer ke shared printer bernama "POS-80" (yang telah disetting sebelumnya)
        $connector = new Escpos\PrintConnectors\WindowsPrintConnector("TM-U220 Receipt Office");
        $printer = new Escpos\Printer($connector);


        ///BODY
        ///HEADER
        $printer->initialize();
        $printer->setJustification(Escpos\Printer::JUSTIFY_CENTER);
        $printer->selectPrintMode(Escpos\Printer::MODE_EMPHASIZED);
        $printer->text($data->no_invoice);
        $printer->text("\n");
        $printer->feed(2); // mencetak 2 baris kosong, agar kertas terangkat ke atas
        ///HEADER

        ///DETAIL
        $printer->initialize();
        $printer->text("Periode: " . date('M-Y') . " \n");
        $printer->text("Net ID : " . $data->netid . " \n");
        $printer->text("\n");
        $printer->text("To: " . $data->name . " \n");
        $printer->text("Produk: " . $data->nmproduk . " \n");
        $printer->text("\n");
        $printer->feed();
        ///DETAIL


        // Membuat tabel
        $printer->initialize(); // Reset bentuk/jenis teks
        $printer->text("-------------------------------------------\n");
        $printer->text(buatBaris2Kolom("Tagihan", ": Rp. " . number_format($data->bill, 2, ',', '.')));
        $printer->text(buatBaris2Kolom("Potongan", ": Rp. " . number_format($data->tax, 2, ',', '.')));
        $printer->text(buatBaris2Kolom("Biaya Lainnya", ": Rp. " . number_format($data->other_bill, 2, ',', '.')));
        $printer->text("----------------------------------------\n");
        $printer->text(buatBaris2Kolom("Total", ": Rp. " . number_format($data->totalbill, 2, ',', '.')));
        $printer->text("\n");
        // end membuat table


        /* ---------------------------------------------------------
         * Menyelesaikan printer
         */
        $printer->feed(4); // mencetak 2 baris kosong, agar kertas terangkat ke atas
        $printer->cut();
        $printer->close();

        header('Location: ' . base_url('/'));
    }

    function resend_invoice()
    {
        $no_invoice = $this->input->post('no_invoice');
        $cid = $this->input->post('client');
        $no_product = $this->input->post('product');

        //SEND EMAIL
        $this->load->library('mailer');

        //get invoice
        $invoice = $this->db->get_where('invoice', array('no_invoice' => $no_invoice), 1)->row();

        if (!empty($invoice)) {
            ///get member
            $client = $this->db->get_where('dbcustomer', array('cid' => $cid), 1)->row();

            $product = $this->db->get_where('product', array('noproduct' =>  $no_product), 1)->row();

            $body_mail = [
                'client' => $client,
                'invoice' => $invoice,
                'product' => $product
            ];

            $body = body_mail($body_mail);
            $periode =  date("d-m-Y", strtotime($invoice->period));


            $data = [
                'email_penerima' => $client->email, //client email
                'subjek' => 'Pengingat! Tagihan Pembayaran Kalimosoft Period ' . $periode, //subject
                'content' => $body //body
            ];

            $mailer = new Mailer;
            $send =  $mailer->send($data);

            $respone['status']  = 200;
            $respone['title']   = 'success';
            $respone['message'] = 'Invoice Berhasil Di Kirim Ulang';
        } else {
            $respone['status']  = 201;
            $respone['title']   = 'error';
            $respone['message'] = 'Invoice tidak ditemukan';
        }

        echo json_encode($respone);
        //ENDSENDEMAIL
    }

    public function print($id = '')
    {
        $akses = decrypt_url($id);

        $this->db->join('product', 'product.noproduct = invoice.product');
        $this->db->join('dbcustomer', 'dbcustomer.cid = invoice.client');
        $page['data'] = $this->db->get_where('invoice', array('invoice.no_invoice' => $akses), 1)->row();

        $this->db->join('useradmin', 'useradmin.nik = payment.staf');
        $page['admin'] = $this->db->get_where('payment', array('payment.no_invoice' => $akses), 1)->row();

        $page['page']   = 'invoice/print-invoice';
        $this->load->view('backend/invoice/print-invoice', $page);
    }
}
