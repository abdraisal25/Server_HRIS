<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class DivisiServer extends REST_Controller{

    var $divisi = 'perusahaan_divisi';
    
    private $master;
    function __construct(){
        parent::__construct();
        $this->load->model('M_Data');
        $this->master = $this->load->database('master', TRUE);
    }

    function divisi_get(){
        $where = [
            $this->divisi.'.id_jenus' => $this->get('id_jenus')
        ];
        $table = [
            'table_1' => $this->divisi,
            'table_2' => 'perusahaan_jenis'
        ];
        $join = [
            'join_2' => 'perusahaan_jenis.id_jenus = perusahaan_divisi.id_jenus'
        ];
        if($this->get('id_jenus') == NULL){
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

    function divisi_detail_get(){
        $where = [
            'id_divisi' => $this->get('id_divisi')
        ];
        $data = $this->M_Data->view_detail($this->master,$this->divisi,$where);
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

    function divisi_post(){
        $data = [
            'divisi_nama' => $this->post('nama'),
            'id_jenus' => $this->post('jenus')
        ];
        if($this->M_Data->insert_data($this->master,$this->divisi,$data) > 0){
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

    function divisi_put(){
        $data = [
            'divisi_nama' => $this->put('nama')
        ];
        $where = [
            'id_divisi' => $this->put('id_divisi')
        ];
        if($this->M_Data->update_data($this->master,$this->divisi,$data,$where) > 0){
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
 
    function divisi_delete(){
        $where = [
            'id_divisi' => $this->delete('id_divisi')
        ];
        if($this->M_Data->delete_data($this->master,$this->divisi,$where) > 0){
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
        $data = $this->M_Data->view_detail($this->master,$this->divisi,$where);
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