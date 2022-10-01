<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function auth($id = '')
    {
        $akses = decrypt_url($id);

        if ($akses == 'isproduct') {
            $page['produk'] = $this->db->get_where('product', array('show' => 1))->result_array();
            $page['page'] = 'produk/data';
            $this->load->view('backend/index', $page);
        } elseif ($akses == 'isaddproduct') {
            $page['page'] = 'produk/tambah';
            $this->load->view('backend/index', $page);
        } elseif ($akses == 'isprosesadd') {
            $this->isaddproduk();
        } elseif ($akses == 'isupdate') {
            $this->isupdate();
        } else {
            $page['page'] = 'notfound';
            $this->load->view('backend/index', $page);
        }
    }

    function isaddproduk()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
            $kode = $this->input->post('kode');
            $this->db->where('kode', $kode);
            $cek = $this->db->get('product');
            if ($cek->num_rows() == 1) {
                $respone['status']  = 201;
                $respone['title']   = 'error';
                $respone['message'] = 'Kode Produk Sudah Di Pergunakan, Silakan Gunakan Kode Produk Lain';
            } else {
                $insert = array(
                    'kode'          => $kode,
                    'nmproduk'      => $this->input->post('nama'),
                    'keterangan'    => $this->input->post('keterangan'),
                    'harga'         => preg_replace('/[^0-9]/', '', $this->input->post('harga')),
                    'noproduct'     => $this->generatePIN(2)
                );

                $data = $this->security->xss_clean($insert);
                $in = $this->db->insert('product', $data);
                if ($in) {
                    $respone['status']  = 200;
                    $respone['title']   = 'success';
                    $respone['message'] = 'Produk Berhasil Di Tambahkan';
                } else {
                    $respone['status']  = 201;
                    $respone['title']   = 'error';
                    $respone['message'] = 'Gagal, Tambah Produk. Silakan Coba Lagi';
                }
            }

            echo json_encode($respone);
        } else {
            $page['page'] = 'notfound';
            $this->load->view('backend/index', $page);
        }
    }

    function detail($id = '')
    {
        $akses = decrypt_url($id);
        $page['list'] = $this->db->get_where('product', array('noproduct' => $akses))->result_array();
        $page['page'] = 'produk/detail';
        $this->load->view('backend/index', $page);
    }

    function isupdate()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
            $id = $this->input->post('id');
            $this->db->where('noproduct', $id);
            $data = $this->db->get('product');
            if ($data->num_rows() == 1) {
                $update = array(
                    'kode'       => $this->input->post('kode'),
                    'nmproduk'   => $this->input->post('nama'),
                    'keterangan' => $this->input->post('keterangan'),
                    'harga'      => preg_replace('/[^0-9]/', '', $this->input->post('harga'))
                );

                $ups = $this->security->xss_clean($update);
                $this->db->where('noproduct', $id);
                $up  = $this->db->update('product', $ups);
                if ($up) {
                    $respone['status']  = 200;
                    $respone['title']   = 'success';
                    $respone['message'] = 'Produk Berhasil Di Ubah';
                } else {
                    $respone['status']  = 201;
                    $respone['title']   = 'error';
                    $respone['message'] = 'Gagal, Ubah Produk. Silakan Coba Lagi';
                }
            }

            echo json_encode($respone);
        } else {
            $page['page'] = 'notfound';
            $this->load->view('backend/index', $page);
        }
    }

    function isdeleted($id)
    {
        $id = decrypt_url($id);
        $this->db->where('idproduct', $id);
        $product = $this->db->get('product', 1)->row();
        if ($product) {
            $updated = [
                'show' => 2
            ];
            $this->db->where('idproduct', $id);
            $deleted = $this->db->update('product', $updated);
            if ($deleted) {
                $respone['status'] = 200;
                $respone['icon']   = 'success';
                $respone['title']  = 'Berhasil, Data Produk Berhasil Di Hapus';
            } else {
                $respone['status'] = 201;
                $respone['icon']   = 'error';
                $respone['title']  = 'Gagal, Hapus Data Produk';
            }
            echo json_encode($respone);
        } else {
            $page['page'] = 'notfound';
            $this->load->view('backend/index', $page);
        }
    }

    function is_set_aktif()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
            $id = $this->input->post('id');
            $this->db->where('noproduct', $id);
            $data = $this->db->get('product');
            if ($data->num_rows() == 1) {
                $cekStatus = $this->db->get_where('product', array('noproduct' => $id))->row()->status;
                if ($cekStatus == 1) {
                    $upt = array(
                        'status' => 2
                    );
                    $this->db->where('noproduct', $id);
                    $up = $this->db->update('product', $upt);
                    if ($up) {
                        $respone['status'] = 200;
                        $respone['icon']   = 'success';
                        $respone['title']  = 'Status Berhasil Di Ubah';
                    } else {
                        $respone['status'] = 201;
                        $respone['icon']   = 'error';
                        $respone['title']  = 'Gagal Update Data';
                    }
                    echo json_encode($respone);
                } else {
                    $upt = array(
                        'status' => 1
                    );
                    $this->db->where('noproduct', $id);
                    $up = $this->db->update('product', $upt);
                    if ($up) {
                        $respone['status'] = 202;
                        $respone['icon']   = 'success';
                        $respone['title']  = 'Status Berhasil Di Ubah';
                    } else {
                        $respone['status'] = 201;
                        $respone['icon']   = 'error';
                        $respone['title']  = 'Gagal Update Data';
                    }
                    echo json_encode($respone);
                }
            }
        } else {
            $page['page'] = 'notfound';
            $this->load->view('backend/index', $page);
        }
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

        return $date . $pin;
    }
}
