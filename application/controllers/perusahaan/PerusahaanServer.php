<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class PerusahaanServer extends REST_Controller{

    var $usaha_data = 'data';
    private $db_perusahaan;

    function __construct(){
        parent::__construct();
        $this->load->model('M_Data');
        $this->db_perusahaan = $this->load->database('perusahaan', TRUE);
    }

    function register_post(){
        $data = [
            'perusahaan_email' => $this->post('email'),
            'perusahaan_nama' => $this->post('nama'),
            'perusahaan_username' => $this->post('username'),
            'perusahaan_password' => md5($this->post('password')),
            'perusahaan_auth' => substr(md5($this->post('nama')),-8)
        ];
        if($this->M_Data->insert_auth($this->db_perusahaan,$this->usaha_data,'keys',$data) > 0){
            $response  =[
                'status' => 200,
                'error' => false,
                'msg' => 'Data Berhasil Dimasukan'
            ];
        }else{
            $response  =[
                'status' => 'ETAX - 10003',
                'error' => true,
                'msg' => 'Gagal Input Ke dalam Database'
            ];
        }
        $this->response($response);
    }

    function cek_perusahaan_get(){
        $where = [
            'perusahaan_username' => $this->get('username'),
            'perusahaan_password' => md5($this->get('password')),
            'perusahaan_status' => $this->get('status')
        ];
        $data = $this->M_Data->view_detail($this->db_perusahaan,$this->usaha_data,$where);
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