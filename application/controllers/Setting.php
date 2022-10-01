<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        date_default_timezone_set('Asia/Jakarta');
    }

    function auth($id=''){
        $akses = decrypt_url($id);

        if($akses == 'iserros'){
            $page['list'] = $this->db->get('dberror')->result_array();
            $page['page'] = 'setting/error';
            $this->load->view('backend/index',$page);
        }elseif($akses == 'isadderrors'){
            $page['page'] = 'setting/adderror';
            $this->load->view('backend/index',$page);
        }elseif($akses == 'isproseserror'){
            $this->isadderror();
        }elseif($akses == 'isupdateserror'){
            $this->isupdate();
        }elseif($akses == 'isapplication'){
            $page['kota'] = $this->db->get('kota_kabupaten')->result_array();
            $page['list'] = $this->application();
            $page['page'] = 'setting/application';
            $this->load->view('backend/index',$page);
        }elseif($akses == 'isupdatesetting'){
            $this->updatesetting();
        }
        else{
            $page['page'] = 'notfound';
            $this->load->view('backend/index',$page);
        }
    }

    function isadderror(){
        $code = $this->input->post('errorcode');
        $this->db->where('errorcode',$code);
        $data = $this->db->get('dberror');
        if($data->num_rows() == '1'){
            $respone['status']  = 201;
            $respone['title']   = 'error';
            $respone['message'] = 'Kode Error Sudah Ada, Silakan Pergunakan Kode Yang Lain';
        }else{
            $insert = array(
                'errorcode'     => $code,
                'errorname'     => $this->input->post('errorname'),
                'description'   => $this->input->post('desk'),
                'note'          => $this->input->post('note')
            );

            $inp = $this->security->xss_clean($insert);
            $in  = $this->db->insert('dberror',$inp);
            if($in){
                $respone['status']  = 200;
                $respone['title']   = 'success';
                $respone['message'] = 'Data Error Berhasil Di Tambah';
            }else{
                $respone['status']  = 202;
                $respone['title']   = 'error';
                $respone['message'] = 'Kode Error Gagal DI Tambah, Silakan Coba Lagi';
            } 
        }

        echo json_encode($respone);
    }

    function detail($id=''){
        $akses = decrypt_url($id);
        $page['list'] = $this->db->get_where('dberror',array('Id'=>$akses))->result_array();
        $page['page'] = 'setting/editerror';
        $this->load->view('backend/index',$page);
    }

    function isupdate(){
        $code = $this->input->post('errorcode');
        $this->db->where('errorcode',$code);
        $data = $this->db->get('dberror');
        if($data->num_rows() == '1'){
            $insert = array(
                'errorcode'     => $code,
                'errorname'     => $this->input->post('errorname'),
                'description'   => $this->input->post('desk'),
                'note'          => $this->input->post('note')
            );
            $inp = $this->security->xss_clean($insert);

            $this->db->where('errorcode',$code);
            $in = $this->db->update('dberror',$insert);
            if($in){
                $respone['status']  = 200;
                $respone['title']   = 'success';
                $respone['message'] = 'Data Error Berhasil Di Ubah';
            }else{
                $respone['status']  = 202;
                $respone['title']   = 'error';
                $respone['message'] = 'Kode Error Gagal Di Ubah, Silakan Coba Lagi';
            } 
        }else{
            $respone['status']  = 201;
            $respone['title']   = 'error';
            $respone['message'] = 'Kode Error Tidak Di Temukan';
        }

        echo json_encode($respone);        
    }

    function application(){
        $data = $this->db->get('setting');
        return $data->result_array();
    }


    function updatesetting(){
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
            $id = $this->input->post('id');
            $this->db->where('idsetting',$id);
            $data = $this->db->get('setting');
            if($data->num_rows() == 1){
                $update = array(
                    'perusahaan' => $this->input->post('perusahaan'),
                    'alamat'     => $this->input->post('alamat'),
                    'kota'       => $this->input->post('kota'),
                    'email'      => $this->input->post('email'),
                    'phone'      => $this->input->post('phone'),
                    'whatsapp'   => $this->input->post('whatsapp'),
                    'telegram'   => $this->input->post('telegram')
                );

                $upn = $this->security->xss_clean($update);
                $this->db->where('idsetting',$id);
                $up  = $this->db->update('setting',$upn);
                if($up){
                    $respone['status']  = 200;
                    $respone['title']   = 'success';
                    $respone['message'] = 'Data Setting Berhasil Di Ubah';
                }else{
                    $respone['status']  = 202;
                    $respone['title']   = 'error';
                    $respone['message'] = 'Setting Gagal Di Ubah, Silakan Coba Lagi';
                }
            }else{
                $respone['status']  = 201;
                $respone['title']   = 'error';
                $respone['message'] = 'ID Setting Tidak Di Temukan';
            }

            echo json_encode($respone);
        }else{
            $page['page'] = 'notfound';
            $this->load->view('backend/index',$page);
        }
    }

}