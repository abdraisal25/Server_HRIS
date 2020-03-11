<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class CorporateServer extends REST_Controller{

    var $corporate = 'kpi_corporate';
    
    private $master;
    function __construct(){
        parent::__construct();
        $this->load->model('M_Data');
        $this->master = $this->load->database('master', TRUE);
    }

    function corporate_get(){
        $where = [
            $this->corporate.'.id_kategori' => $this->get('id_kategori'),
            $this->corporate.'.id_jenus' => $this->get('id_jenus')
        ];
        $table = [
            'table_1' => $this->corporate,
            'table_2' => 'kpi_kategori',
            'table_3' => 'perusahaan_jenis'
        ];
        $join = [
            'join_2' => 'kpi_kategori.id_kategori = kpi_corporate.id_kategori',
            'join_3' => 'perusahaan_jenis.id_jenus = kpi_corporate.id_jenus'
        ];
        if($this->get('id_kategori') == NULL){
            $data = $this->M_Data->view_join($this->master,$table,$join,null);
          }else{
            $data = $this->M_Data->view_join($this->master,$table,$join,$where);
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

    function corporate_detail_get(){
        $where = [
            'id_corporate' => $this->get('id_corporate')
        ];
        $data = $this->M_Data->view_detail($this->master,$this->corporate,$where);
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

    function corporate_post(){
        $data = [
            'corporate_nama' => $this->post('nama'),
            'id_jenus' => $this->post('jenus'),
            'id_kategori' => $this->post('kategori')
        ];
        if($this->M_Data->insert_data($this->master,$this->corporate,$data) > 0){
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

    function corporate_put(){
        $data = [
            'corporate_nama' => $this->put('nama')
        ];
        $where = [
            'id_corporate' => $this->put('id_corporate')
        ];
        if($this->M_Data->update_data($this->master,$this->corporate,$data,$where) > 0){
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
 
    function corporate_delete(){
        $where = [
            'id_corporate' => $this->delete('id_corporate')
        ];
        if($this->M_Data->delete_data($this->master,$this->corporate,$where) > 0){
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

    function select_get(){
        $where = [
            'id_jenus' => $this->get('id_jenus')
        ];      
        $data = $this->M_Data->view_detail($this->master,$this->corporate,$where);
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