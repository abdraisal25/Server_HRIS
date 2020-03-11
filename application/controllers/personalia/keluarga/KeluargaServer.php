<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class KeluargaServer extends REST_Controller{

    var $keluarga = 'keluarga';
    
    private $db_personalia;
    function __construct(){
        parent::__construct();
        $this->load->model('M_Data');
        $this->db_personalia = $this->load->database('personalia', TRUE);
    }

    function detail_get(){
        $where = [
            'id_keluarga' => $this->get('id_keluarga')
        ];
        $data = $this->M_Data->view_detail($this->db_personalia,$this->keluarga,$where);
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

    function keluarga_post(){
        $data = [
            'id_user' => $this->post('id'),
            'keluarga_nama' => $this->post('nama'),
            'keluarga_tempat_lahir' => $this->post('tpt_lahir'),
            'keluarga_tanggal_lahir' => $this->post('tgl_lahir'),
            'keluarga_telp' => $this->post('telp'),
            'keluarga_kelamin' => $this->post('jekel'),
            'keluarga_pendidikan' => $this->post('pendidikan'),
            'keluarga_hubungan' => $this->post('hubungan'),
        ];
        if($this->M_Data->insert_data($this->db_personalia,$this->keluarga,$data) > 0){
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
    
    function keluarga_delete(){
        $where = [
            'id_keluarga' => $this->delete('key')
        ];
        if($this->M_Data->delete_data($this->db_personalia,$this->keluarga,$where) > 0){
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