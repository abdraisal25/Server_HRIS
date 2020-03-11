<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class OrganisasiServer extends REST_Controller{

    var $organisasi = 'organisasi';
    
    private $db_personalia;
    function __construct(){
        parent::__construct();
        $this->load->model('M_Data');
        $this->db_personalia = $this->load->database('personalia', TRUE);
    }

    function detail_get(){
        $where = [
            'id_organisasi' => $this->get('id_organisasi')
        ];
        $data = $this->M_Data->view_detail($this->db_personalia,$this->organisasi,$where);
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

    function organisasi_post(){
        $data = [
            'id_user' => $this->post('id'),
            'organisasi_mulai' => $this->post('mulai'),
            'organisasi_selesai' => $this->post('selesai'),
            'organisasi_jabatan' => $this->post('jabatan'),
            'organisasi_nama' => $this->post('nama'),
            'organisasi_deskripsi' => $this->post('deskripsi')
        ];
        if($this->M_Data->insert_data($this->db_personalia,$this->organisasi,$data) > 0){
            $response  =[
                'status' => 200,
                'error' => false,
                'msg' => 'Data Berhasil Dimasukan'
            ];
        }else{
            $response  =[
                'status' => 'ETAX - 10003',
                'error' => true,
                'msg' => 'Gagal Inpost Ke dalam Database'
            ];
        }
        $this->response($response);
    }
    
    function organisasi_delete(){
        $where = [
            'id_organisasi' => $this->delete('key')
        ];
        if($this->M_Data->delete_data($this->db_personalia,$this->organisasi,$where) > 0){
            $response  =[
                'status' => 200,
                'error' => false,
                'msg' => 'Data Berhasil Dimasukan'
            ];
        }else{
            $response  =[
                'status' => 'ETAX - 10003',
                'error' => true,
                'msg' => 'Gagal Inpost Ke dalam Database'
            ];
        }
        $this->response($response);
    }
}

?>