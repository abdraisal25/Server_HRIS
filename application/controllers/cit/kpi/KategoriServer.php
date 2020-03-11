<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class KategoriServer extends REST_Controller{

    var $kategori = 'kpi_kategori';
    
    private $master;
    function __construct(){
        parent::__construct();
        $this->load->model('M_Data');
        $this->master = $this->load->database('master', TRUE);
    }

    function kategori_get(){
        $data = $this->M_Data->view_data($this->master,$this->kategori);
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

    function kategori_detail_get(){
        $where = [
            'id_kategori' => $this->get('id_kategori')
        ];
        $data = $this->M_Data->view_detail($this->master,$this->kategori,$where);
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

    function kategori_post(){
        $data = [
            'kategori_nama' => $this->post('nama')
        ];
        if($this->M_Data->insert_data($this->master,$this->kategori,$data) > 0){
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

    function kategori_put(){
        $data = [
            'kategori_nama' => $this->put('nama')
        ];
        $where = [
            'id_kategori' => $this->put('id_kategori')
        ];
        if($this->M_Data->update_data($this->master,$this->kategori,$data,$where) > 0){
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
 
    function kategori_delete(){
        $where = [
            'id_kategori' => $this->delete('id_kategori')
        ];
        if($this->M_Data->delete_data($this->master,$this->kategori,$where) > 0){
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