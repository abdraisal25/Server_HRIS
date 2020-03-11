<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class KhususServer extends REST_Controller{

    var $khusus = 'tj_Khusus';

    private $db_jobdesc;

    function __construct(){
        parent::__construct();
        $this->load->model('M_Data');
        $this->db_jobdesc = $this->load->database('jobdesc', TRUE);
        $this->db_master = $this->load->database('master', TRUE);
    }

    function khusus_get(){
        $data = $this->M_Data->view_data($this->db_master,$this->khusus);
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
    
    function khusus_detail_get(){
        $where = [
            'id_khusus' => $this->get('id_khusus')
        ];
        $data = $this->M_Data->view_detail($this->db_jobdesc,$this->khusus,$where);
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

    function khusus_post(){
        $data = [
            'khusus_skala' => $this->post('periode'),
            'khusus_tj' => $this->post('khusus'),
            'key_jabatan' => $this->post('key_jabatan')
        ];
        if($this->M_Data->insert_data($this->db_jobdesc,$this->khusus,$data) > 0){
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
    
    function khusus_delete(){
        $where = [
            'id_khusus' => $this->delete('id')
        ];
        if($this->M_Data->delete_data($this->db_jobdesc,$this->khusus,$where) > 0){
            $response  =[
                'status' => 200,
                'error' => false,
                'msg' => 'Data Berhasil Dihapus'
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