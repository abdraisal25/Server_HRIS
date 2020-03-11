<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class WewenangServer extends REST_Controller{

    var $wewenang = 'wewenang';

    private $db_jobdesc;

    function __construct(){
        parent::__construct();
        $this->load->model('M_Data');
        $this->db_jobdesc = $this->load->database('jobdesc', TRUE);
    }

    function wewenang_detail_get(){
        $where = [
            'id_wewenang' => $this->get('id_wewenang')
        ];
        $data = $this->M_Data->view_detail($this->db_jobdesc,$this->wewenang,$where);
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

    function wewenang_post(){
        $data = [
            'jobdesc_wewenang' => $this->post('wewenang'),
            'key_jabatan' => $this->post('key_jabatan')
        ];
        if($this->M_Data->insert_data($this->db_jobdesc,$this->wewenang,$data) > 0){
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

    function wewenang_put(){
        $data = [
            'jobdesc_wewenang' => $this->put('wewenang')
        ];
        $where = [
            'id_wewenang' => $this->put('id')
        ];
        if($this->M_Data->update_data($this->db_jobdesc,$this->wewenang,$data,$where) > 0){
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
    
    function wewenang_delete(){
        $where = [
            'id_wewenang' => $this->delete('id')
        ];
        if($this->M_Data->delete_data($this->db_jobdesc,$this->wewenang,$where) > 0){
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