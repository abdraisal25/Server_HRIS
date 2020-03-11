<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class PendidikanServer extends REST_Controller{

    var $pendidikan = 'pendidikan';
    
    private $db_personalia;
    function __construct(){
        parent::__construct();
        $this->load->model('M_Data');
        $this->db_personalia = $this->load->database('personalia', TRUE);
    }

    function detail_get(){
        $where = [
            'id_pendidikan' => $this->get('id_pendidikan')
        ];
        $data = $this->M_Data->view_detail($this->db_personalia,$this->pendidikan,$where);
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

    function pendidikan_post(){
        $data = [
            'id_user' => $this->post('id'),
            'pendidikan_level' => $this->post('jenjang'),
            'pendidikan_institusi' => $this->post('nama'),
            'pendidikan_kota' => $this->post('kota'),
            'pendidikan_jurusan' => $this->post('jurusan'),
            'pendidikan_mulai' => $this->post('mulai'),
            'pendidikan_selesai' => $this->post('mulai'),
            'pendidikan_ipk' => $this->post('nilai')
        ];
        if($this->M_Data->insert_data($this->db_personalia,$this->pendidikan,$data) > 0){
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
    
    function pendidikan_delete(){
        $where = [
            'id_pendidikan' => $this->delete('key')
        ];
        if($this->M_Data->delete_data($this->db_personalia,$this->pendidikan,$where) > 0){
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