<?php
defined('BASEPATH') or exit('No direct script access allowed');
Header('Access-Control-Allow-Origin: *');
Header('Access-Control-Allow-Headers: *');

class Users extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->database();
    }

    function auth($id = '')
    {
        // $akses = decrypt_url($id);
        $explode_akses = explode("/", decrypt_url($id));
        $akses = $explode_akses[0];

        if ($akses == 'isusers') {
            $page['user']   = $this->db->get_where('useradmin', array('show' => 1))->result_array();
            $page['groups'] = $this->db->get('groups_menu')->result_array();
            if (count($explode_akses) > 1) {
                $page['tab'] = $explode_akses[1];
            } else {
                $page['tab'] = null;
            }
            $page['page']   = 'users/data';
            $this->load->view('backend/index', $page);
        } elseif ($akses == 'isdetail') {
            if (count($explode_akses) > 1) {
                $id = $explode_akses[1];
                $page['ls'] = $this->db->get_where('useradmin', ['idadminuser' => $id], 1)->row();
            }
            $page['groups'] = $this->db->get('groups_menu')->result_array();
            $page['page']   = 'users/detail';
            $this->load->view('backend/index', $page);
        } elseif ($akses == 'istambahgroup') {
            $this->is_send_group();
        } elseif ($akses == 'isaddusers') {
            $page['id_user']    = $this->generatePIN(6);
            $page['groups'] = $this->db->get('groups_menu')->result_array();
            $page['page']   = 'users/tambah';
            $this->load->view('backend/index', $page);
        } elseif ($akses == 'isprosesadd') {
            $this->is_send_add();
        } elseif ($akses == 'isupdateprofile') {
            $this->isupdate();
        } else {
            $page['page'] = 'notfound';
            $this->load->view('backend/index', $page);
        }
    }

    /** Edit Users **/
    function edit($id = '')
    {
        $akses = decrypt_url($id);
        $page['list'] = $this->db->get_where('useradmin', array('nik' => $akses))->result_array();
        $page['page'] = 'users/profile';
        $this->load->view('backend/index', $page);
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

    function is_send_group()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
            $group = $this->input->post('group');
            $this->db->where('groups', $group);
            $data = $this->db->get('groups_menu');
            if ($data->num_rows() == 1) {
                $respone['status'] = '201';
            } else {
                $insert = array(
                    'groups' => $group
                );

                $ins = $this->db->insert('groups_menu', $insert);
                if ($ins) {
                    $respone['status'] = '200';
                } else {
                    $respone['status'] = '202';
                }
            }

            echo json_encode($respone);
        } else {
            $page['page'] = 'notfound';
            $this->load->view('backend/index', $page);
        }
    }

    function is_send_add()
    {
        $email = $this->input->post('email');
        $this->db->where('email', $email);
        $data = $this->db->get('useradmin');
        if ($data->num_rows() == 1) {
            $respone['status']  = 201;
            $respone['title']   = 'error';
            $respone['message'] = 'Email Sudah Di Pergunakan, Silakan Gunakan Email Lain';
        } else {
            $nama = $this->input->post('nama');
            $this->db->where('nama', $nama);
            $ketemu = $this->db->get('useradmin');
            if ($ketemu->num_rows() == 1) {
                $respone['status']  = 202;
                $respone['title']   = 'error';
                $respone['message'] = 'Nama Sudah Sudah Di Pergunakan, Silakan Gunakan Nama Lain';
            } else {
                $pass = $this->input->post('password');
                $insert = array(
                    'nik'       => $this->input->post('idusers'),
                    'nama'      => $nama,
                    'email'     => $email,
                    'groups'    => $this->input->post('groups'),
                    'password'  => password_hash($pass, PASSWORD_DEFAULT)
                );

                $in = $this->db->insert('useradmin', $insert);
                if ($in) {
                    $respone['status']  = 200;
                    $respone['title']   = 'success';
                    $respone['message'] = 'User Baru Berhasil Di Buat';
                } else {
                    $respone['status'] = 204;
                    $respone['title']   = 'error';
                    $respone['message'] = 'Gagal Tambah User, Silakan Coba Lagi';
                }
            }
        }

        echo json_encode($respone);
    }

    function isupdate()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
            $idadminuser = $this->input->post('idusers');
            $this->db->where('idadminuser', $idadminuser);
            $password = $this->input->post('password');
            if ($password != '') {
                $update = array(
                    'password' => password_hash($password, PASSWORD_DEFAULT),
                    'email' => $this->input->post('email'),
                    'groups' => $this->input->post('groups')
                );
                $this->db->where('idadminuser', $idadminuser);
                $up = $this->db->update('useradmin', $update);
                if ($up) {
                    $respone['status']  = 200;
                    $respone['title']   = 'success';
                    $respone['message'] = 'Profile Berhasil Di Update';
                } else {
                    $respone['status']  = 201;
                    $respone['title']   = 'error';
                    $respone['message'] = 'Gagal Update Profile';
                }
            } else {
                $update = array(
                    'email' => $this->input->post('email'),
                    'groups' => $this->input->post('groups')
                );
                $this->db->where('idadminuser', $idadminuser);
                $up = $this->db->update('useradmin', $update);
                if ($up) {
                    $respone['status']  = 200;
                    $respone['title']   = 'success';
                    $respone['message'] = 'Profile Berhasil Di Update';
                } else {
                    $respone['status']  = 201;
                    $respone['title']   = 'error';
                    $respone['message'] = 'Gagal Update Profile';
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
        $this->db->where('idadminuser', $id);
        $user = $this->db->get('useradmin', 1)->row();
        if ($user) {
            $updated = [
                'show' => 2
            ];
            $this->db->where('idadminuser', $id);
            $deleted = $this->db->update('useradmin', $updated);
            if ($deleted) {
                $respone['status'] = 200;
                $respone['icon']   = 'success';
                $respone['title']  = 'Berhasil, Data User Berhasil Di Hapus';
            } else {
                $respone['status'] = 201;
                $respone['icon']   = 'error';
                $respone['title']  = 'Gagal, Hapus Data User';
            }
            echo json_encode($respone);
        } else {
            $page['page'] = 'notfound';
            $this->load->view('backend/index', $page);
        }
    }

    function is_set_aktif()
    {
        if ($this->input->post('id')) {
            $id = $this->input->post('id');
            $this->db->where('idadminuser', $id);
            $data = $this->db->get('useradmin');
            if ($data->num_rows() == 1) {
                $cekStatus = $this->db->get_where('useradmin', array('idadminuser' => $id))->row()->status;
                if ($cekStatus == 1) {
                    $upt = array(
                        'status' => 2
                    );
                    $this->db->where('idadminuser', $id);
                    $up = $this->db->update('useradmin', $upt);
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
                    $this->db->where('idadminuser', $id);
                    $up = $this->db->update('useradmin', $upt);
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
    /** Role Group **/

    function role_group()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
            $id      = $this->input->post('id');
            $group   = $this->input->post('group');
            $jml     = strlen($id);
            $idgroup = $this->db->get_where('groups_menu', array('groups' => $group))->row()->idgroups;
            if ($jml >= 3) {
                $idgroups = $idgroup;
                $potong   = substr($id, -2);
                $idmenus  = trim($potong, ',');
                $kat      = $this->db->get_where('menus', array('idmenus' => $idmenus))->row()->kategori;
                $idsub    = substr($id, 0, 3);
                $sub      = trim($idsub, ',');
            } else {
                $idgroups = $idgroup;
                $idmenus  = $id;
                $kat      = $this->db->get_where('menus', array('idmenus' => $id))->row()->kategori;
                $sub      = '';
            }
            $respone = array(
                'idgroups'  => $idgroups,
                'idmenu'    => $idmenus,
                'idkatmenu' => $kat,
                'submenu'   => $sub
            );
            $this->db->insert('role_menu', $respone);
            echo json_encode($respone);
        } else {
            $page['page'] = 'notfound';
            $this->load->view('backend/index', $page);
        }
    }

    function editgroups($id = '')
    {
        $akses = decrypt_url($id);
        $page['list'] = $this->db->get_where('groups_menu', array('idgroups' => $akses))->result_array();
        $page['page'] = 'users/editgroup';
        $this->load->view('backend/index', $page);
    }

    function delete_role_group()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
            $id      = $this->input->post('id');
            $group   = $this->input->post('group');
            $jml     = strlen($id);
            $idgroup = $this->db->get_where('groups_menu', array('groups' => $group))->row()->idgroups;
            if ($jml >= 3) {
                $idgroups = $idgroup;
                $potong   = substr($id, -2);
                $idmenus  = trim($potong, ',');
                $kat      = $this->db->get_where('menus', array('idmenus' => $idmenus))->row()->kategori;
                $idsub    = substr($id, 0, 3);
                $sub      = trim($idsub, ',');
            } else {
                $idgroups = $idgroup;
                $idmenus  = $id;
                $kat      = $this->db->get_where('menus', array('idmenus' => $id))->row()->kategori;
                $sub      = '';
            }

            $this->db->where('idgroups', $idgroups)
                ->where('idmenu', $idmenus)
                ->where('idkatmenu', $kat)
                ->where('submenu', $sub);
            $del = $this->db->delete('role_menu');
            if ($del) {
                $respone = 200;
            } else {
                $respone = 201;
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
}
