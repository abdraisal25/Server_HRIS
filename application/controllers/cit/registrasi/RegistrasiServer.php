<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class RegistrasiServer extends REST_Controller{

    var $perusahaan = 'data';
    var $user = 'data';
    
    private $db_perusahaan, $db_user;
    function __construct(){
        parent::__construct();
        $this->load->model('M_Data');
        $this->db_perusahaan = $this->load->database('perusahaan', TRUE);
        $this->db_user = $this->load->database('personalia', TRUE);
    }

    function cek_email_get(){
        $where = [
            'perusahaan_email' => $this->get('email')
        ];
        $data = $this->M_Data->view_detail($this->db_perusahaan,$this->perusahaan,$where);
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

    function registrasi_get(){
        $data = $this->M_Data->view_data($this->db_perusahaan,$this->perusahaan);
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

    function registrasi_perusahaan_detail_get(){
        $where = [
            'id_perusahaan' => $this->get('id_perusahaan'),
            'perusahaan_status' => $this->get('status')
        ];
        $data = $this->M_Data->view_detail($this->db_perusahaan,$this->perusahaan,$where);
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

    function registrasi_user_detail_get(){
        $where = [
            'id_perusahaan' => $this->get('id_perusahaan')
        ];
        $data = $this->M_Data->view_detail($this->db_user,$this->user,$where);
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

    function registrasi_post(){
        $data = [
            'perusahaan_email' => $this->post('email'),
            'id_jenus' => $this->post('jenis'),
            'perusahaan_nama' => $this->post('nama'),
            'perusahaan_telp' => $this->post('telp'),
            'perusahaan_alamat' => $this->post('alamat'),
            'perusahaan_logo' => $this->post('logo'),
            'perusahaan_status' => $this->post('status'),
            'perusahaan_auth' => substr(md5($this->post('nama')),-8)
        ];
        $data = $this->M_Data->registrasi_perusahaan($this->db_perusahaan,$this->perusahaan,'keys',$data); 
        if(!empty($data)){
            $response  =[
                'status' => 200,
                'error' => false,
                'data' => $data,
                'msg' => 'Data Berhasil Dimasukan'
            ];
        }else{
            $response  =[
                'status' => 'ETAX - 10003',
                'error' => true,
                'data' => 'GAGAL',
                'msg' => 'Gagal Input Ke dalam Database'
            ];
        }
        $this->response($response);
    }

    function registrasi_user_post(){
        $data = [
            'id_perusahaan' => $this->post('id'),
            'user_nama' => $this->post('nama'),
            'user_email' => $this->post('email'),
            'user_nama' => $this->post('nama'),
            'user_telp' => $this->post('telp'),
            'user_username' => $this->post('username'),
            'user_password' => $this->post('password'),
            'user_status' => $this->post('status'),
        ]; 
        if($this->M_Data->insert_data($this->db_user,$this->user,$data) > 0){
            $response  =[
                'status' => 200,
                'error' => false,
                'data' => $data,
                'msg' => 'Data Berhasil Dimasukan'
            ];
        }else{
            $response  =[
                'status' => 'ETAX - 10003',
                'error' => true,
                'data' => 'GAGAL',
                'msg' => 'Gagal Input Ke dalam Database'
            ];
        }
        $this->response($response);
    }

    function registrasi_put(){
        $data = [
            'perusahaan_username' => $this->put('username'),
            'perusahaan_password' => $this->put('password'),
            'perusahaan_status' => $this->put('status')
        ];
        $where = [
            'id_perusahaan' => $this->put('id')
        ];
        if($this->M_Data->update_data($this->db_perusahaan,$this->perusahaan,$data,$where) > 0){
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
}

?>