<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reporting extends CI_Controller
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

        if ($akses == 'isreportbilling') {
            //filter
            $tgl = @$_REQUEST['reportrange'];
            $pembayaran = @$_REQUEST['pembayaran'];

            $page['value'] = [
                'tgl' => $tgl,
                'pembayaran' => $pembayaran
            ];
            //endfilter
            $page['list'] = $this->databilling($tgl, $pembayaran);
            $page['page'] = 'reporting/payment';
            $this->load->view('backend/index', $page);
        } elseif ($akses == 'isreportregistration') {
            //filter
            $tgl = @$_REQUEST['reportrange'];
            $statnetwork = @$_REQUEST['statnetwork'];

            $page['value'] = [
                'tgl' => $tgl,
                'statnetwork' => $statnetwork
            ];
            //endfilter
            $page['list'] = $this->dataregistration($tgl, $statnetwork);
            $page['page'] = 'reporting/registration';
            $this->load->view('backend/index', $page);
        } elseif ($akses == 'isreportclient') {
            //filter
            $status = @$_REQUEST['status'];

            $page['value'] = ['status' => $status];
            //endfilter
            $page['list'] = $this->member($status);
            $page['page'] = 'reporting/client';
            $this->load->view('backend/index', $page);
        } elseif ($akses == 'isreportmaintainace') {
            //filter
            $tgl = @$_REQUEST['reportrange'];
            $errorcode = @$_REQUEST['errorcode'];

            $page['value'] = [
                'tgl' => $tgl,
                'errorcode' => $errorcode
            ];
            //endfilter
            $page['error'] = $this->db->get('dberror')->result_array();
            $page['list'] = $this->datamaintenance($tgl, $errorcode);
            $page['page']  = 'reporting/maintainace';
            $this->load->view('backend/index', $page);
        } else {
            $page['page'] = 'notfound';
            $this->load->view('backend/index', $page);
        }
    }

    function databilling($tgl = null, $pembayaran = null)
    {
        //get data from table = payment
        //daterange column = create_at
        //status column = pembayaran

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

        if (!empty($pembayaran)) {
            $this->db->where('pembayaran', $pembayaran);
        }

        $this->db->order_by('create_at', 'desc');
        $this->db->where('show', 1);
        $data = $this->db->get('payment')->result_array();
        // $data  = $this->db->query("SELECT * FROM payment WHERE YEAR(create_at)='$year' AND MONTH(create_at)='$month' ORDER BY create_at DESC")->result_array();
        return $data;
    }

    function dataregistration($tgl, $statnetwork)
    {
        //get data from table = transaksi
        //daterange column = create_at
        //status column = transaksi

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

        if (!empty($statnetwork)) {
            $this->db->where('statnetwork', $statnetwork);
        }

        $this->db->order_by('create_at', 'desc');
        $this->db->where('show', 1);
        $data = $this->db->get('transaksi')->result_array();
        //         $data  = $this->db->query("SELECT * FROM transaksi WHERE YEAR(create_at)='$year' AND MONTH(create_at)='$month' ORDER BY create_at DESC")->result_array();
        return $data;
    }

    function member($filter_status = null)
    {
        //get data from table = dbnetwork
        //status column = netstatus

        if (!empty($filter_status)) {
            $this->db->where('netstatus', $filter_status);
        }
        $this->db->where('show', 1);
        $data = $this->db->get('dbnetwork')->result_array();
        return $data;
    }

    function datamaintenance($tgl = null, $errorcode = null)
    {
        //get data from table = dbmaintenance
        //daterange column = dbmaintenance.date
        //status column = errorcode

        $this->db->join('dberror', 'dberror.errorcode = dbmaintenance.errorcode');
        if (!empty($tgl)) {
            $tgl = explode(" - ", $tgl);

            $tgl_awal = $tgl[0];
            $tgl_akhir = $tgl[1];
            $this->db->where("DATE_FORMAT(dbmaintenance.date,'%m/%d/%Y') >='$tgl_awal'");
            $this->db->where("DATE_FORMAT(dbmaintenance.date,'%m/%d/%Y') <='$tgl_akhir'");
        } else {
            $month = date('m');
            $year  = date('Y');
            $this->db->where('MONTH(dbmaintenance.date)', $month);
            $this->db->where('YEAR(dbmaintenance.date)', $year);
        }

        if (!empty($errorcode)) {
            $this->db->where('dberror.errorcode', $errorcode);
        }

        $this->db->order_by('dbmaintenance.date', 'desc');
        $data = $this->db->get('dbmaintenance')->result_array();
        return $data;
    }
}
