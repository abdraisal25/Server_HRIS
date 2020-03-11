<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class DataServer extends REST_Controller{

    var $data = 'data';
    
    private $db_personalia;
    function __construct(){
        parent::__construct();
        $this->load->model('M_Data');
        $this->db_personalia = $this->load->database('personalia', TRUE);
    }

    function detail_get(){
        $where = [
            'id_user' => $this->get('id_user')
        ];
        $data = $this->M_Data->view_detail($this->db_personalia,$this->data,$where);
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

    function data_put(){
        $data = [
            'user_nama' => $this->put('nama'),
            'user_username' => $this->put('username'),
            'user_password' => $this->put('password'),
            'user_nip' => $this->put('nip'),
            'user_ktp' => $this->put('ktp'),
            'user_tempat_lahir' => $this->put('tpt_lahir'),
            'user_tanggal_lahir' => $this->put('tgl_lahir'),
            'user_telp' => $this->put('telp'),
            'user_kelamin' => $this->put('jekel'),
            'user_darah' => $this->put('darah'),
            'user_agama' => $this->put('agama'),
            'user_perkawinan' => $this->put('perkawinan'),
            'user_alamat' => $this->put('alamat'),
            'user_status' => $this->put('status')
        ];
        $where = [
            'id_user' => $this->put('id')
        ];
        if($this->M_Data->update_data($this->db_personalia,$this->data,$data,$where) > 0){
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

    function change_put(){
        $data = [
            'user_password' => $this->put('password'),
        ];
        $where = [
            'id_user' => $this->put('id_user')
        ];
        if($this->M_Data->update_data($this->db_personalia,$this->data,$data,$where) > 0){
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