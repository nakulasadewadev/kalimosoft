<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Client extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        date_default_timezone_set('Asia/Jakarta');

        //load uploads
        $this->load->library('upload');
    }

    function auth($id = '')
    {
        $akses = decrypt_url($id);

        if ($akses == 'isregister') {
            $page['provinsi'] = $this->db->get('provinsi')->result();
            $page['page'] = 'client/daftar';
            $this->load->view('backend/index', $page);
        } elseif ($akses == 'isclient') {
            $this->db->join('kota_kabupaten', 'kota_kabupaten.id = dbcustomer.kota');
            $this->db->select('*, kota_kabupaten.nama as nama_kota');
            $page['list'] = $this->db->get_where('dbcustomer', array('show' => 1))->result_array();
            $page['page'] = 'client/data';
            $this->load->view('backend/index', $page);
        } elseif ($akses == 'is_send_ajax') {
            $this->is_send_ajax();
        } elseif ($akses == 'isprosesadd') {
            $this->registrasi();
        } elseif ($akses == 'isaddlink') {
            $page['produk'] = $this->db->get_where('product', array('status' => '1'))->result_array();
            $page['page'] = 'client/baru';
            $this->load->view('backend/index', $page);
        } elseif ($akses == 'isfindid') {
            $this->is_find();
        } elseif ($akses == 'isupdate') {
            $this->update();
        } else {
            $page['page'] = 'notfound';
            $this->load->view('backend/index', $page);
        }
    }

    function is_send_ajax()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
            echo json_encode('OK');
        } else {
            $page['page'] = 'notfound';
            $this->load->view('backend/index', $page);
        }
    }

    function add_ajax_kab($id_prov)
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
            $query = $this->db->get_where('kota_kabupaten', array('provinsi_id' => $id_prov));
            $data = "<option value=''>- Select Kota / Kabupaten -</option>";
            foreach ($query->result() as $value) {
                $data .= "<option value='" . $value->id . "'>" . $value->nama . "</option>";
            }
            echo $data;
        } else {
            $page['page'] = 'notfound';
            $this->load->view('backend/index', $page);
        }
    }

    function add_ajax_kec($id_kab)
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
            $query = $this->db->get_where('kecamatan', array('kab_kota_id' => $id_kab));
            $data = "<option value=''> - Pilih Kecamatan - </option>";
            foreach ($query->result() as $value) {
                $data .= "<option value='" . $value->id . "'>" . $value->nama . "</option>";
            }
            echo $data;
        } else {
            $page['page'] = 'notfound';
            $this->load->view('backend/index', $page);
        }
    }

    function add_ajax_des($id_kec)
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
            $query = $this->db->get_where('kelurahan', array('kecamatan_id' => $id_kec));
            $data = "<option value=''> - Pilih Kelurahan / Desa - </option>";
            foreach ($query->result() as $value) {
                $data .= "<option value='" . $value->id . "'>" . $value->nama . "</option>";
            }
            echo $data;
        } else {
            $page['page'] = 'notfound';
            $this->load->view('backend/index', $page);
        }
    }



    function registrasi()
    {
        $input = $this->input->post();

        if (!empty($input)) {
            $nik  = $input['nik'];
            $this->db->where('nik', $nik);
            $cek  = $this->db->get('dbcustomer');
            if ($cek->num_rows() == 1) {
                $respone['status']  = 201;
                $respone['title']   = 'error';
                $respone['message'] = 'NIK Sudah Terdaftar, User Sudah Teregistrasi';
            } else {

                try {
                    $cid = $this->nouser();
                    //upload ktp
                    if (!is_dir('uploads/ktp/' . $cid)) {
                        mkdir('./uploads/ktp/' . $cid, 0777, TRUE);
                    }

                    $filename = @$_FILES['ktp']['name'];
                    if ($filename != '') {
                        $config['upload_path'] = 'uploads/ktp/' . $cid;
                        $config['allowed_types'] = '*';

                        $new_name = $filename;
                        $config['file_name'] = $new_name;

                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);

                        if (!$this->upload->do_upload('ktp')) {
                            redirect($_SERVER['HTTP_REFERER']);
                        } else {
                            $dataFile  = $this->upload->data();
                            $filename = $dataFile['file_name'];
                        }

                        $input['ktp'] = $filename;
                    }

                    $input['create_at'] = date('Y-m-d H:i:s');
                    $input['cid'] = $cid;
                    $input['show'] = 1;

                    $data = $this->security->xss_clean($input);
                    $in = $this->db->insert('dbcustomer', $data);
                    if ($in) {
                        $respone['status']  = 200;
                        $respone['title']   = 'success';
                        $respone['message'] = 'Registrasi Berhasil Di Lakukan';
                    } else {
                        $respone['status']  = 202;
                        $respone['title']   = 'error';
                        $respone['message'] = 'Gagal Melakukan Registrasi, Silakan Coba Lagi';
                    }
                } catch (\Throwable $th) {
                    $respone['status']  = 201;
                    $respone['title']   = 'error';
                    $respone['message'] = $th;
                }
            }
            $this->session->set_flashdata('msg', $respone);
            return redirect('client/auth/' . encrypt_url('isregister'));
            // echo json_encode($respone);
        } else {
            $page['page'] = 'notfound';
            $this->load->view('backend/index', $page);
        }
    }

    function is_find()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
            $nik = $this->input->post('cari');
            $this->db->where('nik', $nik);
            $cari = $this->db->get('dbcustomer');
            if ($cari->num_rows() == 1) {
                $respone['status']  = 200;
                $respone['title']   = 'success';
                $respone['message'] = 'Data Member Di Temukan Silakan , Lanjutkan Transaksi Daftar Pemasangan Baru';
            } else {
                $respone['status']  = 201;
                $respone['title']   = 'error';
                $respone['message'] = 'NIK / ID Identitas Tidak Di Temukan, Silakan Lakukan Pendaftaran Member';
            }

            echo json_encode($respone);
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

    function update()
    {
        $input = $this->input->post();

        if (!empty($input)) {
            $cid = $input['cid'];
            $this->db->where('cid', $cid);
            $data = $this->db->get('dbcustomer');
            if ($data->num_rows() == 1) {
                $nik = $input['nik'];

                //upload ktp
                if (!is_dir('uploads/ktp/' . $cid)) {
                    mkdir('./uploads/ktp/' . $cid, 0777, TRUE);
                }

                $filename = @$_FILES['ktp']['name'];
                if ($filename != '') {
                    $config['upload_path'] = 'uploads/ktp/' . $cid;
                    $config['allowed_types'] = '*';

                    $new_name = $filename;
                    $config['file_name'] = $new_name;

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    if (!$this->upload->do_upload('ktp')) {
                        redirect($_SERVER['HTTP_REFERER']);
                    } else {
                        $dataFile  = $this->upload->data();
                        $filename = $dataFile['file_name'];
                    }

                    $input['ktp'] = $filename;
                }

                $update = $this->security->xss_clean($input);
                $this->db->where('cid', $cid);
                $upt = $this->db->update('dbcustomer', $update);
                if ($upt) {
                    $respone['status']  = 200;
                    $respone['title']   = 'success';
                    $respone['message'] = 'Berhasil, Data Customer Berhasil Di Update';
                } else {
                    $respone['status']  = 201;
                    $respone['title']   = 'error';
                    $respone['message'] = 'Gagal, Update Data Customer';
                }
            } else {
                $respone['status']  = 201;
                $respone['title']   = 'error';
                $respone['message'] = 'Gagal, Update Data Customer';
            }

            $this->session->set_flashdata('msg', $respone);
            return redirect('client/edit/' . encrypt_url($cid));
            // echo json_encode($respone);
        } else {
            $page['page'] = 'notfound';
            $this->load->view('backend/index', $page);
        }
    }

    function isdeleted($id)
    {
        $id = decrypt_url($id);
        $this->db->where('cid', $id);
        $dbcustomer = $this->db->get('dbcustomer', 1)->row();
        if ($dbcustomer) {
            // $network_deleted = $this->db->delete('dbnetwork', array('cid' => $id));

            $updated = [
                'show' => 0
            ];
            //hidden customer
            $this->db->where('cid', $id);
            $deleted = $this->db->update('dbcustomer', $updated);

            //hidden network
            $update_network = [
                'netstatus' => 2,
                'show'  => 0
            ];
            $this->db->where('cid', $id);
            $deleted_network = $this->db->update('dbnetwork', $update_network);

            //hidden transaksi
            $this->db->where('member', $id);
            $deleted_transaksi = $this->db->update('transaksi', $updated);

            //hidden billing
            $this->db->where('client', $id);
            $deleted_billing = $this->db->update('billing', $updated);

            //hidden invoice
            $this->db->where('client', $id);
            $deleted_invoice = $this->db->update('invoice', $updated);

            //hidden payment
            $this->db->where('client', $id);
            $deleted_payment = $this->db->update('payment', $updated);


            if ($deleted) {
                $respone['status'] = 200;
                $respone['icon']   = 'success';
                $respone['title']  = 'Berhasil, Data Client Berhasil Di Hapus';
            } else {
                $respone['status'] = 201;
                $respone['icon']   = 'error';
                $respone['title']  = 'Gagal, Hapus Data Client';
            }
            echo json_encode($respone);
        } else {
            $page['page'] = 'notfound';
            $this->load->view('backend/index', $page);
        }
    }

    function nouser()
    {
        $q = $this->db->query("SELECT MAX(RIGHT(cid,4)) AS kd_max FROM dbcustomer WHERE DATE(create_at)=CURDATE()");
        $kd = "";
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $tmp = ((int)$k->kd_max) + 1;
                $kd = sprintf("%04s", $tmp);
            }
        } else {
            $kd = "0001";
        }
        date_default_timezone_set('Asia/Jakarta');
        return date('dmy') . $kd;
    }

    function edit($id = '')
    {

        $noid = decrypt_url($id);
        $page['list']       = $this->db->get_where('dbcustomer', array('cid' => $noid))->result_array();
        $page['provinsi']   = $this->db->get('provinsi')->result();
        $page['page']       = 'client/edit';
        $this->load->view('backend/index', $page);
    }

    function is_set_aktif()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
            $id = $this->input->post('id');
            $this->db->where('cid', $id);
            $data = $this->db->get('dbcustomer');
            if ($data->num_rows() == 1) {
                $cekStatus = $this->db->get_where('dbcustomer', array('cid' => $id))->row()->status;
                if ($cekStatus == 1) {
                    $upt = array(
                        'status' => 2
                    );
                    $this->db->where('cid', $id);
                    $up = $this->db->update('dbcustomer', $upt);
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
                    $this->db->where('cid', $id);
                    $up = $this->db->update('dbcustomer', $upt);
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
}
