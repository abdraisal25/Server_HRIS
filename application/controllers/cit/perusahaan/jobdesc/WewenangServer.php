<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class WewenangServer extends REST_Controller{

    var $wewenang = 'jobdesc_wewenang';
    
    private $master;
    function __construct(){
        parent::__construct();
        $this->load->model('M_Data');
        $this->master = $this->load->database('master', TRUE);
    }

    function wewenang_get(){
        $where = [
            'a.id_jabatan' => $this->get('id_jabatan')
        ];
        if($this->get('id_jabatan') == NULL){
            $data = $this->M_Data->view_join($this->master,$this->wewenang,'perusahaan_jabatan','id_jabatan',null);
        }else{
            $data = $this->M_Data->view_join($this->master,$this->wewenang,'perusahaan_jabatan','id_jabatan',$where);
        }
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

    function wewenang_detail_get(){
        $where = [
            'id_wewenang' => $this->get('id_wewenang')
        ];
        $data = $this->M_Data->view_detail($this->master,$this->wewenang,$where);
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
            'wewenang_nama' => $this->post('nama'),
            'id_jabatan' => $this->post('jabatan')
        ];
        if($this->M_Data->insert_data($this->master,$this->wewenang,$data) > 0){
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
        $this->response($data);
    }
 
    function wewenang_delete(){
        $where = [
            'id_wewenang' => $this->delete('id_wewenang')
        ];
        if($this->M_Data->delete_data($this->master,$this->wewenang,$where) > 0){
            $response  =[
                'status' => 200,
                'error' => false,
                'msg' => 'Data Berhasil Dihapuskan'
            ];
        }else{
            $response  =[
                'status' => 'ETAX - 10003',
                'error' => true,
                'msg' => 'Gagal Hapus di dalam Database'
            ];
        }
        $this->response($response);
    }
}

?>