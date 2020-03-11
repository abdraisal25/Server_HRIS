<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class JobdescServer extends REST_Controller{

    var $tujuan = 'tujuan';
    var $wewenang = 'wewenang';
    var $hasil = 'hasil_kerja';
    var $kualifikasi = 'kualifikasi';
    var $khusus = 'tj_khusus';
    var $umum = 'tj_umum';
    private $db_jobdesc,$db_jabatan;

    function __construct(){
        parent::__construct();
        $this->load->model('M_Data');
        $this->db_jobdesc = $this->load->database('jobdesc', TRUE);
        $this->db_jabatan = $this->load->database('perusahaan', TRUE);
    }

    function jobdesc_get(){
        $where = [
            'key_jabatan' => $this->get('key_jabatan')
        ];
        $data = [
            'tujuan' => $this->M_Data->view_detail($this->db_jobdesc,$this->tujuan,$where),
            'wewenang' => $this->M_Data->view_detail($this->db_jobdesc,$this->wewenang,$where),
            'hasil' => $this->M_Data->view_detail($this->db_jobdesc,$this->hasil,$where),
            'kualifikasi' => $this->M_Data->view_detail($this->db_jobdesc,$this->kualifikasi,$where),
            'khusus' => $this->M_Data->view_detail($this->db_jobdesc,$this->khusus,$where),
            'umum' => $this->M_Data->view_detail($this->db_jobdesc,$this->umum,$where)
        ];
        if(empty($data)){
            $response = [
                'status' => 502,
                'error' => true,
                'data' => $data,
                'msg' => 'Data Tidak Ditemukan'
            ];
        }else{
            $response = [
                'status' => 200,
                'error' => false,
                'data' => $data
            ];
        }
        $this->response($response);
    }

    function jabatan_get(){
        $table = [
            'table_1' => 'jabatan',
            'table_2' => 'master_data.perusahaan_jabatan',
            'table_3' => 'master_data.perusahaan_departement',
            'table_4' => 'master_data.perusahaan_divisi'
        ];
        $join = [
            'join_2' => 'jabatan.id_jabatan = master_data.perusahaan_jabatan.id_jabatan',
            'join_3' => 'master_data.perusahaan_jabatan.id_departement = master_data.perusahaan_departement.id_departement',
            'join_4' => 'master_data.perusahaan_departement.id_divisi = master_data.perusahaan_divisi.id_divisi'
        ];
        $where = [
            'jabatan.key_jabatan' => $this->get('key_jabatan')
        ];
        $data = $this->M_Data->view_join($this->db_jabatan,$table,$join,$where);
        if(empty($data)){
            $response = [
                'status' => 502,
                'error' => true,
                'data' => $data,
                'msg' => 'Data Tidak Ditemukan'
            ];
        }else{
            $response = [
                'status' => 200,
                'error' => false,
                'data' => $data
            ];
        }
        $this->response($response);
    }
}

?>