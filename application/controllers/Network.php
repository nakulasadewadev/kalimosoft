<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Network extends CI_Controller
{

    function auth($id = '')
    {
        $akses = decrypt_url($id);

        if ($akses == 'isdatanetwork') {
            $this->db->join('dbcustomer', 'dbcustomer.cid = dbnetwork.cid');
            $this->db->join('dbodp', 'dbodp.odpid = dbnetwork.odpid', 'left');
            $this->db->join('product', 'product.noproduct = dbnetwork.productid', 'left');
            $this->db->where('dbnetwork.show', 1);
            $this->db->where('dbcustomer.show', 1);
            $page['list']   = $this->db->get('dbnetwork')->result_array();
            $page['page']   = 'network/data';
            $this->load->view('backend/index', $page);
        } elseif ($akses == 'isodcpage') {
            $page['list']   = $this->db->get('dbodc')->result_array();
            $page['page']   = 'odc/data';
            $this->load->view('backend/index', $page);
        } elseif ($akses == 'isaddodc') {
            $page['olt']    = $this->db->get('dbolt')->result_array();
            $page['noid']   = $this->idodc();
            $page['page']   = 'odc/tambah';
            $this->load->view('backend/index', $page);
        } elseif ($akses == 'isprosesodc') {
            $this->addodc();
        } elseif ($akses == 'isupdateodc') {
            $this->updateodc();
        } elseif ($akses == 'isodppage') {
            $page['list']   = $this->db->get('dbodp')->result_array();
            $page['page']   = 'odp/data';
            $this->load->view('backend/index', $page);
        } elseif ($akses == 'isaddodp') {
            $page['noid']   = $this->idodp();
            $page['page']   = 'odp/tambah';
            $this->load->view('backend/index', $page);
        } elseif ($akses == 'isprosesodp') {
            $this->addodp();
        } elseif ($akses == 'isupdateodp') {
            $this->updateodp();
        } elseif ($akses == 'isoltpage') {
            $page['list']   = $this->db->get('dbolt')->result_array();
            $page['page']   = 'olt/data';
            $this->load->view('backend/index', $page);
        } elseif ($akses == 'isaddolt') {
            $page['ont'] = $this->db->get('dbont')->result_array();
            $page['noid']   = $this->idolt();
            $page['page']   = 'olt/tambah';
            $this->load->view('backend/index', $page);
        } elseif ($akses == 'isprosesolt') {
            $this->addolt();
        } elseif ($akses == 'isupdateolt') {
            $this->updateolt();
        } elseif ($akses == 'isuppdatekosong') {
            $this->isupdatekosong();
        } elseif ($akses == 'isontpage') {
            $page['list']   = $this->db->get('dbont')->result_array();
            $page['page']   = 'ont/data';
            $this->load->view('backend/index', $page);
        } elseif ($akses == 'isaddont') {
            //$page['noid']   = $this->idolt();
            $page['page']   = 'ont/tambah';
            $this->load->view('backend/index', $page);
        } elseif ($akses == 'isprosesont') {
            $this->addont();
        } elseif ($akses == 'isupdateont') {
            $this->updateont();
        } else {

            $page['page'] = 'notfound';
            $this->load->view('backend/index', $page);
        }
    }

    /** DATA ODC **/
    function addodc()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
            $color1     = $this->input->post('color1');
            $color2     = $this->input->post('color2');
            $oltin      = $this->input->post('oltin');
            $port       = $this->input->post('port');
            $interface  = $oltin . "/" . $port;
            $insert = array(
                'odcid'        => $this->input->post('odcid'),
                'oltid'        => $oltin,
                'oltinterface' => $interface,
                'port'         => $this->input->post('port'),
                'colorcor'     => $color1 . ',' . $color2,
                'location'     => $this->input->post('location'),
                'note'         => $this->input->post('note'),
                'status'       => 1
            );

            $data = $this->security->xss_clean($insert);
            $in   = $this->db->insert('dbodc', $data);
            if ($in) {
                $response['status']  = 200;
                $response['title']   = 'success';
                $response['message'] = 'Data ODC Berhasil Di Tambah';
            } else {
                $response['status']  = 201;
                $response['title']   = 'error';
                $response['message'] = 'Gagal Tambah Data ODC, Silakan Coba Lagi';
            }

            echo json_encode($response);
        } else {
            $page['page'] = 'notfound';
            $this->load->view('backend/index', $page);
        }
    }

    function odcedit($id = '')
    {
        $akses = decrypt_url($id);

        $page['olt']  = $this->db->get('dbolt')->result_array();
        $page['list'] = $this->db->get_where('dbodc', array('Id' => $akses), 1)->row();
        $page['page'] = 'odc/edit';
        $this->load->view('backend/index', $page);
    }

    public function updateodc()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
            $id = $this->input->post('id');
            $data_odc = $this->db->get_where('dbodc', ['Id' => $id], 1)->row();


            $color1 = $this->input->post('color1');
            $color2 = $this->input->post('color2');
            $oltin  = $this->input->post('oltin');
            $port   = $this->input->post('port');
            $interface = $oltin . "/" . $port;
            $update = array(
                'odcid'        => $this->input->post('odcid'),
                'oltid'        => $oltin,
                'oltinterface' => $interface,
                'port'         => $this->input->post('port'),
                'colorcor'     => $color1,
                'color2'       => $color2,
                'location'     => $this->input->post('location'),
                'note'         => $this->input->post('note'),
                'status'       => 1
            );


            $data = $this->security->xss_clean($update);

            $data_network = $this->db->get_where('dbnetwork', ['odcid' => $data_odc->oltinterface], 1)->row();

            $this->db->where('odcid', $data_odc->oltinterface);
            $update_network = $this->db->update('dbnetwork', ['odcid' => $interface, 'odcport' => $interface . ':' . $data_network->port]);

            $this->db->where('Id', $id);
            $update_odc   = $this->db->update('dbodc', $data);
            if ($update_odc) {
                $response['status']  = 200;
                $response['title']   = 'success';
                $response['message'] = 'Data ODC Berhasil Di Ubah';
            } else {
                $response['status']  = 201;
                $response['title']   = 'error';
                $response['message'] = 'Gagal Ubah Data ODC, Silakan Coba Lagi';
            }

            echo json_encode($response);
        } else {
            $page['page'] = 'notfound';
            $this->load->view('backend/index', $page);
        }
    }

    function deleteodc($id = '')
    {
        $id_odc = decrypt_url($id);
        //get_data
        $data_odc = $this->db->get_where('dbodc', array('Id' => $id_odc), 1)->row();

        if (!empty($data_odc)) {

            $data_network = $this->db->get_where('dbnetwork', array('odcid' => $data_odc->oltinterface), 1)->row();

            if (!empty($data_network)) {
                //deleted
                $update_network = [
                    'odcid' => null,
                    'odcport' => null,
                    'port' => null,
                    'netstatus' => 2
                ];
                $this->db->where('netid', $data_network->netid);
                $delete_network = $this->db->update('dbnetwork', $update_network);
            }

            $this->db->where('Id', $id_odc);
            $delete_odc = $this->db->delete('dbodc');

            if ($delete_odc) {
                $response['status']  = 200;
                $response['title']   = 'success';
                $response['message'] = 'Data ODC Berhasil Di Hapus';
            } else {
                $response['status']  = 201;
                $response['title']   = 'error';
                $response['message'] = 'Gagal Hapus Data ODC, Silakan Coba Lagi';
            }

            echo json_encode($response);
        } else {
            $page['page'] = 'notfound';
            $this->load->view('backend/index', $page);
        }
    }


    /** DATA ODP **/

    function addodp()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {

            $insert = array(
                'odpid'        => $this->input->post('odpid'),
                'odpcode'      => $this->input->post('odpcode'),
                'wavelength'   => $this->input->post('wavelength'),
                'power'        => $this->input->post('power'),
                'location'     => $this->input->post('location'),
                'note'         => $this->input->post('note'),
                'status'       => 1
            );

            $data = $this->security->xss_clean($insert);
            $in   = $this->db->insert('dbodp', $data);
            if ($in) {
                $response['status']  = 200;
                $response['title']   = 'success';
                $response['message'] = 'Data ODP Berhasil Di Tambah';
            } else {
                $response['status']  = 201;
                $response['title']   = 'error';
                $response['message'] = 'Gagal Tambah Data ODP, Silakan Coba Lagi';
            }

            echo json_encode($response);
        } else {
            $page['page'] = 'notfound';
            $this->load->view('backend/index', $page);
        }
    }

    function odpedit($id = '')
    {
        $akses = decrypt_url($id);

        $page['list'] = $this->db->get_where('dbodp', array('odpid' => $akses), 1)->row();
        $page['page'] = 'odp/edit';
        $this->load->view('backend/index', $page);
    }

    function updateodp()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
            $id = $this->input->post('odpid');
            $insert = array(
                'odpid'        => $this->input->post('odpid'),
                'odpcode'      => $this->input->post('odpcode'),
                'wavelength'   => $this->input->post('wavelength'),
                'power'        => $this->input->post('power'),
                'location'     => $this->input->post('location'),
                'note'         => $this->input->post('note'),
                'status'       => 1
            );

            $data = $this->security->xss_clean($insert);
            $this->db->where('odpid', $id);
            $in   = $this->db->update('dbodp', $data);
            if ($in) {
                $response['status']  = 200;
                $response['title']   = 'success';
                $response['message'] = 'Data ODP Berhasil Di Ubah';
            } else {
                $response['status']  = 201;
                $response['title']   = 'error';
                $response['message'] = 'Gagal Ubah Data ODP, Silakan Coba Lagi';
            }

            echo json_encode($response);
        } else {
            $page['page'] = 'notfound';
            $this->load->view('backend/index', $page);
        }
    }

    function deleteodp($id = '')
    {
        $id_odp = decrypt_url($id);
        //get_data
        $data_odp = $this->db->get_where('dbodp', array('odpid' => $id_odp), 1)->row();

        if (!empty($data_odp)) {

            $data_network = $this->db->get_where('dbnetwork', array('odpid' => $data_odp->odpid), 1)->row();

            if (!empty($data_network)) {
                //deleted
                $update_network = [
                    'odpid' => null,
                    'odpport' => null,
                    'netstatus' => 2
                ];
                $this->db->where('netid', $data_network->netid);
                $delete_network = $this->db->update('dbnetwork', $update_network);
            }

            $this->db->where('odpid', $id_odp);
            $delete_odp = $this->db->delete('dbodp');

            if ($delete_odp) {
                $response['status']  = 200;
                $response['title']   = 'success';
                $response['message'] = 'Data ODP Berhasil Di Hapus';
            } else {
                $response['status']  = 201;
                $response['title']   = 'error';
                $response['message'] = 'Gagal Hapus Data ODP, Silakan Coba Lagi';
            }

            echo json_encode($response);
        } else {
            $page['page'] = 'notfound';
            $this->load->view('backend/index', $page);
        }
    }

    /** DATA OLT **/

    function addolt()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {

            $insert = array(
                'oltid'        => $this->input->post('oltid'),
                'oltinterface' => $this->input->post('oltinterface'),
                'intclientno'  => $this->input->post('intclientno'),
                'ontid'        => $this->input->post('ontid'),
                'status'       => 1
            );

            $data = $this->security->xss_clean($insert);
            $in   = $this->db->insert('dbolt', $data);
            if ($in) {
                $response['status']  = 200;
                $response['title']   = 'success';
                $response['message'] = 'Data OLT Berhasil Di Tambah';
            } else {
                $response['status']  = 201;
                $response['title']   = 'error';
                $response['message'] = 'Gagal Tambah Data OLT, Silakan Coba Lagi';
            }

            echo json_encode($response);
        } else {
            $page['page'] = 'notfound';
            $this->load->view('backend/index', $page);
        }
    }

    function oltedit($id = '')
    {
        $akses = decrypt_url($id);

        $page['ont'] = $this->db->get('dbont')->result_array();
        $page['list'] = $this->db->get_where('dbolt', array('Id' => $akses), 1)->row();
        $page['page'] = 'olt/edit';
        $this->load->view('backend/index', $page);
    }

    function updateolt()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
            $id = $this->input->post('id');
            $oltid       = $this->input->post('oltid');
            $oltinterface = $this->input->post('oltinterface');
            $intclientno = $this->input->post('intclientno');
            $ontid       = $this->input->post('ontid');

            $data_olt = $this->db->get_where('dbolt', ['Id' => $id], 1)->row();

            $data_odc = $this->db->get_where('dbodc', ['oltid' => 'gpon-olt_1/' . $data_olt->oltinterface], 1)->row();

            if (!empty($data_odc)) {
                $data_network = $this->db->get_where('dbnetwork', ['odcid' => $data_odc->oltinterface], 1)->row();

                if (!empty($data_network)) {
                    //update network
                    $update_network = [
                        'odcid' => 'gpon-olt_1/' . $oltinterface,
                        'odcport' => 'gpon-olt_1/' . $oltinterface . ':' . $data_network->port
                    ];
                    $update_network = $this->db->update('dbnetwork', $update_network, ['odcid' => $data_odc->oltinterface]);
                }

                //update odc
                $update_odc = [
                    'oltid' => 'gpon-olt_1/' . $oltinterface,
                    'oltinterface' => 'gpon-olt_1/' . $oltinterface . '/' . $data_odc->port,
                ];
                $update_odc = $this->db->update('dbodc', $update_odc, ['Id' => $data_odc->Id]);
            }

            $update = array(
                'oltid'        => $oltid,
                'oltinterface' => $oltinterface,
                'intclientno'  => $intclientno,
                'ontid'        => $ontid,
                'status'       => 1
            );

            $data = $this->security->xss_clean($update);
            $this->db->where('Id', $id);
            $update   = $this->db->update('dbolt', $data);

            if ($update) {
                $response['status']  = 200;
                $response['title']   = 'success';
                $response['message'] = 'Data OLT Berhasil Di Ubah';
            } else {
                $response['status']  = 201;
                $response['title']   = 'error';
                $response['message'] = 'Gagal Ubah Data OLT, Silakan Coba Lagi';
            }

            echo json_encode($response);
        } else {
            $page['page'] = 'notfound';
            $this->load->view('backend/index', $page);
        }
    }

    function deleteolt($id = '')
    {
        $id_olt = decrypt_url($id);
        //get_data
        $data_olt = $this->db->get_where('dbolt', array('oltid' => $id_olt), 1)->row();

        if (!empty($data_olt)) {
            $data_odc = $this->db->get_where('dbodc', array('oltid' => 'gpon-olt_1/' . $data_olt->oltinterface), 1)->row();

            $data_network = $this->db->get_where('dbnetwork', array('oltid' => $data_olt->oltid), 1)->row();

            if (!empty($data_odc)) {
                $this->db->where('odcid', $data_odc->odcid);
                $delete_odc = $this->db->delete('dbodc');
            }

            if (!empty($data_network)) {
                //deleted
                $update_network = [
                    'oltid' => null,
                    'odcid' => null,
                    'odcport' => null,
                    'port' => null,
                    'netstatus' => 2
                ];
                $this->db->where('netid', $data_network->netid);
                $delete_network = $this->db->update('dbnetwork', $update_network);
            }

            $this->db->where('oltid', $id_olt);
            $delete_olt = $this->db->delete('dbolt');

            if ($delete_olt) {
                $response['status']  = 200;
                $response['title']   = 'success';
                $response['message'] = 'Data OLT Berhasil Di Hapus';
            } else {
                $response['status']  = 201;
                $response['title']   = 'error';
                $response['message'] = 'Gagal Hapus Data OLT, Silakan Coba Lagi';
            }

            echo json_encode($response);
        } else {
            $page['page'] = 'notfound';
            $this->load->view('backend/index', $page);
        }
    }

    function oltview($id = '')
    {
        $akses = decrypt_url($id);

        $page['list'] = $this->db->get_where('dbolt', array('Id' => $akses))->result_array();
        $page['page'] = 'olt/detail';
        $this->load->view('backend/index', $page);
    }

    /** Data ONT */
    function addont()
    {
        if ($this->input->post()) {
            $serial = $this->input->post('serial');
            $this->db->where('serialnumber', $serial);
            $data = $this->db->get('dbont');
            if ($data->num_rows() == 1) {
                $response['status'] = 201;
                $response['icon']   = 'error';
                $response['title']  = 'Gagal, Serial Number Sudah Terdaftar';
            } else {
                $inet = $this->input->post('int') == 'on' ? 1 : 2;
                $tv = $this->input->post('tvkabel') == 'on' ? 1 : 2;
                $insert = array(
                    'ont'          => $this->idont(),
                    'serialnumber' => $serial,
                    'internet'     => $inet,
                    'tvkabel'      => $tv
                );

                $ins = $this->security->xss_clean($insert);
                $in  = $this->db->insert('dbont', $ins);
                if ($in) {
                    $response['status'] = 200;
                    $response['icon']   = 'success';
                    $response['title']  = 'Data ONT Berhasil Di Tambah';
                } else {
                    $response['status'] = 202;
                    $response['icon']   = 'error';
                    $response['title']  = 'Gagal, Silakan Coba Lagi';
                }
            }

            echo json_encode($response);
        } else {
            $page['page'] = 'notfound';
            $this->load->view('backend/index', $page);
        }
    }

    function editont($id = '')
    {
        $id_ont = decrypt_url($id);

        $page['list'] = $this->db->get_where('dbont', array('idont' => $id_ont), 1)->row();
        $page['page'] = 'ont/edit';
        $this->load->view('backend/index', $page);
    }

    function updateont()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
            $id = $this->input->post('idont');
            $inet = $this->input->post('int') == 'on' ? 1 : 2;
            $tv = $this->input->post('tvkabel') == 'on' ? 1 : 2;
            $update = array(
                'serialnumber' => $this->input->post('serial'),
                'internet' => $inet,
                'tvkabel'  => $tv
            );

            $data = $this->security->xss_clean($update);
            $this->db->where('idont', $id);
            $in   = $this->db->update('dbont', $data);
            if ($in) {
                $response['status']  = 200;
                $response['title']   = 'success';
                $response['message'] = 'Data ONT Berhasil Di Ubah';
            } else {
                $response['status']  = 201;
                $response['title']   = 'error';
                $response['message'] = 'Gagal Ubah Data ONT, Silakan Coba Lagi';
            }

            echo json_encode($response);
        } else {
            $page['page'] = 'notfound';
            $this->load->view('backend/index', $page);
        }
    }

    function deleteont($id = '')
    {
        $id_ont = decrypt_url($id);
        //get_data
        $data_ont = $this->db->get_where('dbont', array('idont' => $id_ont), 1)->row();

        if (!empty($data_ont)) {

            //get_data
            $data_olt = $this->db->get_where('dbolt', array('ontid' => $data_ont->ont), 1)->row();

            if (!empty($data_olt)) {

                $data_odc = $this->db->get_where('dbodc', array('oltid' => 'gpon-olt_1/' . $data_olt->oltinterface), 1)->row();

                if (!empty($data_odc)) {
                    $update_odc = [
                        'status' => 2
                    ];
                    $delete_odc = $this->db->update('dbodc', $update_odc, ['odcid' => $data_odc->odcid]);
                }

                $data_network = $this->db->get_where('dbnetwork', array('oltid' => $data_olt->oltid), 1)->row();

                if (!empty($data_network)) {
                    //deleted
                    $update_network = [
                        'ontid' => null,
                        'netstatus' => 2
                    ];
                    $this->db->where('netid', $data_network->netid);
                    $delete_network = $this->db->update('dbnetwork', $update_network);
                }

                $update_olt = [
                    'ontid' => null,
                    'status' => 2
                ];
                $this->db->where('ontid', $data_ont->ont);
                $delete_olt = $this->db->update('dbolt', $update_olt);
            }

            $delete_ont = $this->db->delete('dbont', array('idont' => $id_ont));

            if ($delete_ont) {
                $response['status']  = 200;
                $response['title']   = 'success';
                $response['message'] = 'Data ONT Berhasil Di Hapus';
            } else {
                $response['status']  = 201;
                $response['title']   = 'error';
                $response['message'] = 'Gagal Hapus Data ONT, Silakan Coba Lagi';
            }

            echo json_encode($response);
        } else {
            $page['page'] = 'notfound';
            $this->load->view('backend/index', $page);
        }
    }

    function detail($kode = '')
    {
        $akses = decrypt_url($kode);

        //network
        $this->db->join('dbodp', 'dbodp.odpid = dbnetwork.odpid', 'left');
        $this->db->join('dbont', 'dbont.ont = dbnetwork.ontid', 'left');
        $this->db->join('product', 'product.noproduct = dbnetwork.productid');
        $network = $this->db->get_where('dbnetwork', array('netid' => $akses), 1)->row();

        //customer
        $customer = $this->db->get_where('dbcustomer', array('cid' => $network->cid), 1)->row();

        //alamat_cust
        $city   = strtolower($this->db->get_where('kota_kabupaten', array('id' => $customer->kota))->row()->nama);
        $provice = $this->db->get_where('provinsi', array('id' => $customer->provinsi))->row()->nama;
        $kel    = strtolower($this->db->get_where('kelurahan', array('id' => $customer->kelurahan))->row()->nama);
        $kec    = strtolower($this->db->get_where('kecamatan', array('id' => $customer->kecamatan))->row()->nama);
        $alamat = $this->db->get_where('dbcustomer', array('cid' => $network->cid))->row()->address;

        $alamat_cust = $alamat . " , " . $kel . " - " . $kec . " , " . $city . " - " . $provice;


        $page['customer'] = $customer;
        $page['network'] = $network;
        $page['alamat_cust'] = $alamat_cust;
        $page['page'] = 'network/detail';
        $this->load->view('backend/index', $page);
    }

    function ishapus()
    {
        $id = $this->input->post('netid');

        if (!empty($id)) {
            //APABILA MENGHAPUS DATA NETWORK, MAKA DATA TRANSAKSI, BILLING, INVOICE, PAYMENT IKUT HILANG

            //deleted
            $update_network = [
                'netstatus' => 2,
                'show'  => 0
            ];
            //hidden network

            $this->db->where('netid', $id);
            $delete_network = $this->db->update('dbnetwork', $update_network);

            $updated = ['show' => 0];

            //hidden transaksi
            $this->db->where('netid', $id);
            $deleted_transaksi = $this->db->update('transaksi', $updated);

            //hidden billing
            $this->db->where('netid', $id);
            $deleted_billing = $this->db->update('billing', $updated);

            //hidden invoice
            $this->db->where('netid', $id);
            $deleted_invoice = $this->db->update('invoice', $updated);

            //hidden payment
            $this->db->where('netid', $id);
            $deleted_payment = $this->db->update('payment', $updated);

            if ($delete_network) {
                $response = 200;
            } else {
                $response = 201;
            }
        } else {
            $response = 202;
        }
        echo json_encode($response);
    }

    function edit($kode = '')
    {
        $akses = decrypt_url($kode);

        $page['ont']    = $this->db->get('dbont')->result_array();
        $page['produk'] = $this->db->get_where('product', ['status' => 1])->result_array();
        $page['olt']    = $this->db->get_where('dbolt', ['status' => 1])->result_array();
        $page['odp']    = $this->db->get_where('dbodp', ['status' => 1])->result_array();
        $page['odc']    = $this->db->get_where('dbodc', ['status' => 1])->result_array();
        $page['page']   = 'network/edit';
        $page['list']   = $this->db->get_where('dbnetwork', array('netid' => $akses))->result_array();
        $this->load->view('backend/index', $page);
    }

    function isupdatekosong()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date     = date('Y-m-d H:i:s');
        $netid    = $this->input->post('netid');
        $location = $this->input->post('location');
        $onlinedate = $this->input->post('onlinedate');

        $this->db->where('netid', $netid);
        $data = $this->db->get('dbnetwork');
        if ($data->num_rows() == 1) {
            $user = $this->session->userdata('login_user_id');
            $update = array(
                'teknisi'       => $user,
                'update_date'   => $date,
                'location'      => $location,
                'onlinedate'    => $onlinedate
            );

            $this->db->where('netid', $netid);
            $upt = $this->db->update('dbnetwork', $update);
            if ($upt) {
                $response['status'] = 200;
                $response['id'] = $netid;
            } else {
                $response = 201;
            }
        }

        echo json_encode($response);
    }

    function isupdateoffline()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d H:i:s');
        $netid = $this->input->post('netid');

        $this->db->where('netid', $netid);
        $data = $this->db->get('dbnetwork');
        if ($data->num_rows() == 1) {
            $user    = $this->session->userdata('login_user_id');
            $odc     = $this->input->post('odc');
            $port    = $this->input->post('odcport');
            $odcport = $odc . ":" . $port;
            $olt     = $this->input->post('olt');
            $ontid   = $this->db->get_where('dbolt', array('oltid' => $olt))->row()->ontid;
            $location = $this->input->post('location');
            $onlinedate = $this->input->post('onlinedate');

            $update  = array(
                'teknisi'       => $user,
                'update_date'   => $date,
                'odcid'         => $this->input->post('odc'),
                'odcport'       => $odcport,
                'port'          => $port,
                'oltid'         => $this->input->post('olt'),
                'ontid'         => $ontid,
                'odpid'         => $this->input->post('odp'),
                'location'      => $location,
                'onlinedate'    => $onlinedate
                // 'latitude'      => $this->input->post('latitude'),
                // 'longitude'     => $this->input->post('longitude'),
            );

            $this->db->where('netid', $netid);
            $upt = $this->db->update('dbnetwork', $update);
            if ($upt) {
                $response = 200;
            } else {
                $response = 201;
            }
        }

        echo json_encode($response);
    }

    function isupdateonline()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date   = date('Y-m-d H:i:s');
        $period = date('Y-m-d');
        $netid  = $this->input->post('netid');

        $this->db->where('netid', $netid);
        $data = $this->db->get('dbnetwork');
        if ($data->num_rows() == 1) {
            $user    = $this->session->userdata('login_user_id');
            $odc     = $this->input->post('odc');
            $port    = $this->input->post('odcport');
            $odcport = $odc . ":" . $port;
            $olt     = $this->input->post('olt');
            //$ontid   = $this->db->get_where('dbolt',array('oltid'=>$olt))->row()->ontid;
            $location = $this->input->post('location');
            $produk  = $this->input->post('produk');
            $ontid   = $this->input->post('ont');
            $onlinedate = $this->input->post('onlinedate');


            $update  = array(
                'teknisi'       => $user,
                'update_date'   => $date,
                'odcid'         => $this->input->post('odc'),
                'odcport'       => $odcport,
                'oltid'         => $this->input->post('olt'),
                'ontid'         => $ontid,
                'odpport'       => $this->input->post('odpport'),
                'port'          => $port,
                'location'      => $location,
                'productid'     => $produk,
                // 'internet'      => $this->input->post('int'),
                // 'tvkabel'       => $this->input->post('tv'),
                'odpid'         => $this->input->post('odp'),
                'onlinedate'    => $onlinedate,
                'netstatus'     => '1'
            );

            $this->db->where('netid', $netid);
            $upt = $this->db->update('dbnetwork', $update);
            if ($upt) {
                $this->db->where('netid', $netid);
                $cek = $this->db->get('billing');
                if ($cek->num_rows() == 1) {
                    $end     = date('Y-m-d H:i:s', strtotime("+30 day", strtotime($onlinedate)));
                    $bill = array(
                        'start_at'      => $onlinedate,
                        'end_at'        => $end,
                        'duration'      => 30,
                        'period'        => $onlinedate,
                        'statbilling'   => 1,
                        'show' => 1
                    );
                    $this->db->where('netid', $netid);
                    $insbill = $this->db->update('billing', $bill);
                    if ($insbill) {
                        $response = 200;
                    } else {
                        $response = 201;
                    }
                } else {
                    $product = $this->db->get_where('dbnetwork', array('netid' => $netid))->row()->productid;
                    $harga   = $this->db->get_where('product', array('noproduct' => $product))->row()->harga;
                    $end     = date('Y-m-d H:i:s', strtotime("+30 day", strtotime($onlinedate)));
                    $client  = $this->db->get_where('dbnetwork', array('netid' => $netid))->row()->cid;
                    $bill = array(
                        'netid'         => $netid,
                        'product'       => $product,
                        'start_at'      => $onlinedate,
                        'end_at'        => $end,
                        'duration'      => 30,
                        'client'        => $client,
                        'period'        => $onlinedate,
                        'bill'          => $harga,
                        'statbilling'   => 1,
                        'show' => 1
                    );

                    $insbill = $this->db->insert('billing', $bill);
                    if ($insbill) {
                        $response = 200;
                    } else {
                        $response = 201;
                    }
                }
            } else {
                $response = 201;
            }


            echo json_encode($response);
        }
    }

    function idodp()
    {
        // /** Cek Nomor **/
        $this->db->select('RIGHT(dbodp.odpid,3) as kode', false);
        $this->db->order_by('odpid', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('dbodp');
        if ($query->num_rows() <> 0) {
            $data = $query->row();
            $kode = intval($data->kode) + 1;
        } else {
            $kode = "ODP" . "001";
        }
        $kode_max   = "ODP" . str_pad($kode, 3, "0", STR_PAD_LEFT);
        $nomor      = $kode_max;

        return $nomor;
    }

    function idolt()
    {
        $this->db->select('RIGHT(dbolt.oltid,1) as kode', false);
        $this->db->order_by('oltid', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('dbolt');
        if ($query->num_rows() <> 0) {
            $data = $query->row();
            $kode = intval($data->kode) + 1;
        } else {
            $kode = "1";
        }
        $kode_max   = str_pad($kode, 1, "0", STR_PAD_LEFT);
        $nomor      = $kode_max;

        return $nomor;
    }

    function idodc()
    {
        $this->db->select('RIGHT(dbodc.odcid,4) as kode', false);
        $this->db->order_by('odcid', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('dbodc');
        if ($query->num_rows() <> 0) {
            $data = $query->row();
            $kode = intval($data->kode) + 1;
        } else {
            $kode = "1";
        }
        $kode_max   = str_pad($kode, 1, "0", STR_PAD_LEFT);
        $nomor      = $kode_max;

        return $nomor;
    }

    function idont()
    {
        $this->db->select('RIGHT(dbont.ont,4) as kode', false);
        $this->db->order_by('ont', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('dbont');
        if ($query->num_rows() <> 0) {
            $data = $query->row();
            $kode = intval($data->kode) + 1;
        } else {
            $kode = "1";
        }
        $kode_max   = str_pad($kode, 1, "0", STR_PAD_LEFT);
        $nomor      = $kode_max;

        return $nomor;
    }


    function setoffline()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
            date_default_timezone_set('Asia/Jakarta');
            $date  = date('Y-m-d H:i:s');
            $netid = $this->input->post('netid');
            $this->db->where('netid', $netid);
            $data = $this->db->get('dbnetwork');
            if ($data->num_rows() == 1) {
                $update = array(
                    'netstatus'   => '2',
                    'update_date' => $date
                );

                $this->db->where('netid', $netid);
                $up = $this->db->update('dbnetwork', $update);
                if ($up) {
                    $response = 200;
                } else {
                    $response = 201;
                }
            } else {
                $response = 202;
            }

            echo json_encode($response);
        } else {
            $page['page'] = 'notfound';
            $this->load->view('backend/index', $page);
        }
    }

    function setonline()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
            date_default_timezone_set('Asia/Jakarta');
            $date  = date('Y-m-d H:i:s');
            $netid = $this->input->post('netid');
            $this->db->where('netid', $netid);
            $data = $this->db->get('dbnetwork', 1)->row();

            if (!empty($data)) {
                // $odp = $this->db->get_where('dbnetwork', array('netid' => $netid))->row()->odpid;
                // $odc = $this->db->get_where('dbnetwork', array('netid' => $netid))->row()->odcid;
                // $olt = $this->db->get_where('dbnetwork', array('netid' => $netid))->row()->ontid;
                $this->db->where('netid', $netid);
                $cek = $this->db->get('billing');

                if ($cek->num_rows() == 1) {
                    $update = array(
                        'netstatus'   => '1',
                        'update_date' => $date
                    );
                    $this->db->where('netid', $netid);
                    $up = $this->db->update('dbnetwork', $update);
                    if ($up) {
                        $response = 200;
                    } else {
                        $response = 203;
                    }
                } else {
                    $update = array(
                        'netstatus'   => '1',
                        'update_date' => $date
                    );
                    $this->db->where('netid', $netid);
                    $up = $this->db->update('dbnetwork', $update);


                    $product = $this->db->get_where('dbnetwork', array('netid' => $netid))->row()->productid;
                    $harga   = $this->db->get_where('product', array('noproduct' => $data->productid))->row()->harga;
                    $end     = date('Y-m-d H:i:s', strtotime("+30 day", strtotime($date)));
                    $client  = $this->db->get_where('dbnetwork', array('netid' => $netid))->row()->cid;
                    $bill = array(
                        'netid'         => $netid,
                        'product'       => $product,
                        'start_at'      => $date,
                        'end_at'        => $end,
                        'duration'      => 30,
                        'client'        => $client,
                        'period'        => $date,
                        'bill'          => $harga,
                        'statbilling'   => 1,
                        'show' => 1
                    );

                    $insbill = $this->db->insert('billing', $bill);
                    if ($insbill) {
                        $response = 200;
                    } else {
                        $response = 201;
                    }
                }
            } else {
                $response = 202;
            }

            echo json_encode($response);
        } else {
            $page['page'] = 'notfound';
            $this->load->view('backend/index', $page);
        }
    }
}
