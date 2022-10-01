<?php
defined('BASEPATH') or exit('No direct script access allowed');

Header('Access-Control-Allow-Origin: *');
Header('Access-Control-Allow-Headers: *');
class Login extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
    }

    public function index()
    {

        if ($this->session->userdata('login') == 1)
            redirect(base_url() . 'main/dashboard', 'refresh');


        $this->load->view('backend/login');
    }

    function auth($id = '')
    {
        $akses = decrypt_url($id);
        if ($akses == 'islogins') {
            // $email = $this->input->post('email');
            // $credential = array('email' => $email);
            // $cek = $this->db->get_where('useradmin',$credential);
            // if($cek->num_rows() > 0){
            //     $row = $cek->row();
            //     $password = $row->password;
            //     if(password_verify($this->input->post('password'),$password)){
            //         echo $password;
            //     }else{
            //         echo "Password Salah";
            //     }
            // }else{
            //     echo "Salah";
            // }
            // $response   = array();
            // $pass       = $this->input->post('password');
            // $email      = $this->input->post('email');
            // //$password   = md5($pass);

            // $login_status = $this->validate_login($email, $pass);
            // $response['login_status'] = $login_status;
            // if ($login_status == 'success') {
            //     // $response['redirect_url'] = '';
            //     // $this->index();
            //     echo json_encode($login_status);
            // }else{
            //    // $this->load->view('backend/login');
            //    redirect(base_url());
            // }
            // //echo json_encode($email);
            $login_status = $this->validation();
            // if($login_status == 'success'){
            //     //$this->index();
            //     //redirect(base_url().'main/dashboard','refresh');
            //     echo json_encode($login_status);
            // }else{
            //     //
            //     echo json_encode($login_status);
            //     //redirect(base_url());
            // }
            echo json_encode($login_status);
        } elseif ($akses == 'islogouts') {
            $this->logout();
        } else {
            return 'false';
        }
    }

    function validation()
    {
        $email = $this->input->post('email');
        $query = $this->db->get_where('useradmin', array('email' => $email));
        if ($query->num_rows() == 1) {
            $row = $query->row();
            if ($row->locked == 2) {
                $response = '207';
            } else {
                if ($row->status == 1) {
                    $pass = $row->password;
                    if (password_verify($this->input->post('password'), $pass)) {
                        $this->session->set_userdata('login', '1');
                        $this->session->set_userdata('login_user_id', $row->idadminuser);
                        $this->session->set_userdata('name', $row->nama);
                        $this->session->set_userdata('group', $row->groups);
                        $response = '200';
                    } else {
                        $cekError = $this->db->get_where('lockusers', array('email' => $email));
                        if ($cekError->num_rows() == 3) {
                            $update = array(
                                'locked' => 2
                            );
                            $this->db->where('email', $email);
                            $lock = $this->db->update('useradmin', $update);
                            if ($lock) {
                                $response = '206';
                            }
                        } else {
                            $ins = array(
                                'email' => $email,
                                'err'   => 1
                            );
                            $this->db->insert('lockusers', $ins);
                            $response = '202';
                        }
                    }
                } else {
                    $response = '208';
                }
            }
        } else {
            $response = '201';
        }
        return $response;
    }

    function validate_login($email = '', $pass = '')
    {
        $credential = array('email' => $email);
        // Checking login credential for admin
        $query = $this->db->get_where('useradmin', $credential);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            if ($row->status == 1) {
                $passwords = $row()->password;
                if (password_verify($pass, $passwords)) {
                    $this->session->set_userdata('login', '1');
                    $this->session->set_userdata('admin_login', '1');
                    $this->session->set_userdata('admin_id', $row->idadminuser);
                    $this->session->set_userdata('login_user_id', $row->idadminuser);
                    $this->session->set_userdata('name', $row->nama);
                    return 'success';
                } else {
                    return 'false';
                }
            } else {
                return 'false';
            }
        }
    }

    function logout()
    {
        $this->session->sess_destroy();
        $this->session->set_flashdata('logout_notification', 'logged_out');
        redirect(base_url(), 'refresh');
    }
}
