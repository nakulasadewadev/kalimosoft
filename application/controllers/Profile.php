<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        date_default_timezone_set('Asia/Jakarta');
    }

    function auth($id=''){
        $akses = decrypt_url($id);

        if($akses == 'isprofile'){
            $id     = $this->session->userdata('login_user_id');
            $page['list'] = $this->db->get_where('useradmin',array('idadminuser'=>$id))->result_array();
            $page['page'] = 'profile/edit';
            $this->load->view('backend/index',$page);
        }elseif($akses == 'isupdateprofile'){
            $this->updateprofile();
        }elseif($akses == 'isupdatepassword'){
            $this->updatepassword();
        }else{
            $page['page'] = 'notfound';
            $this->load->view('backend/index',$page);
        }
    }


    function updateprofile(){
        $id = $this->input->post('id');
        $this->db->where('idadminuser',$id);
        $data = $this->db->get('useradmin');

        if($data->num_rows() == 1){
            $update = array(
                'nama'  => $this->input->post('nama'),
                'email' => $this->input->post('email'),
            );

            $upt = $this->security->xss_clean($update);
            $this->db->where('idadminuser',$id);
            $up  = $this->db->update('useradmin',$upt);
            if($up){
                $respone['status'] = 200;
                $respone['icon']   = 'success';
                $respone['title']  = 'Profile Berhasil Di Ubah';
            }else{
                $respone['status'] = 201;
                $respone['icon']   = 'error';
                $respone['title']  = 'Gagal, Update Profile';
            }

        }else{
            $respone['status'] = 201;
            $respone['icon']   = 'error';
            $respone['title']  = 'Gagal, Update Profile';
        }

        echo json_encode($respone);
    }

    function updatepassword(){
        $id = $this->input->post('id');
        $this->db->where('idadminuser',$id);
        $data = $this->db->get('useradmin');

        if($data->num_rows() == 1){
            $pass   = $this->input->post('pass');
            $update = array(
                'password'  => password_hash($pass,PASSWORD_DEFAULT),
            );
            $this->db->where('idadminuser',$id);
            $up  = $this->db->update('useradmin',$update);

            if($up){
                $respone['status'] = 200;
                $respone['icon']   = 'success';
                $respone['title']  = 'Password Berhasil Di Ubah';
            }else{
                $respone['status'] = 201;
                $respone['icon']   = 'error';
                $respone['title']  = 'Gagal, Ganti Password.';
            }

        }else{
            $respone['status'] = 201;
            $respone['icon']   = 'error';
            $respone['title']  = 'Gagal, Ganti Password.';
        }

        echo json_encode($respone);
    }

}