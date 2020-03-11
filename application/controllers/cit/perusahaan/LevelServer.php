<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class LevelServer extends REST_Controller{

    var $level = 'perusahaan_level';
    
    private $master;
    function __construct(){
        parent::__construct();
        $this->load->model('M_Data');
        $this->master = $this->load->database('master', TRUE);
    }

    function level_get(){
        $where = [
            $this->level.'.id_jenus' => $this->get('id_jenus')
        ];
        $table = [
            'table_1' => $this->level,
            'table_2' => 'perusahaan_jenis'
        ];
        $join = [
            'join_2' => 'perusahaan_jenis.id_jenus = perusahaan_level.id_jenus'
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

    function level_detail_get(){
        $where = [
            'id_level' => $this->get('id_level')
        ];
        $data = $this->M_Data->view_detail($this->master,$this->level,$where);
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

    function level_post(){
        $data = [
            'id_jenus' => $this->post('jenus'),
            'level_nama' => $this->post('nama')
        ];
        if($this->M_Data->insert_data($this->master,$this->level,$data) > 0){
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

    function level_put(){
        $data = [
            'level_nama' => $this->put('nama')
        ];
        $where = [
            'id_level' => $this->put('id_level')
        ];
        if($this->M_Data->update_data($this->master,$this->level,$data,$where) > 0){
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
 
    function level_delete(){
        $where = [
            'id_level' => $this->delete('id_level')
        ];
        if($this->M_Data->delete_data($this->master,$this->level,$where) > 0){
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
        $data = $this->M_Data->view_data($this->master,$this->level);
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