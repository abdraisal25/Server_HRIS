<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class SanksiServer extends REST_Controller{

    var $master = 'master_sanksi';
    var $sanksi = 'sanksi';
    
    private $kpi;
    function __construct(){
        parent::__construct();
        $this->load->model('M_Data');
        $this->kpi = $this->load->database('kpi', TRUE);
        }

    function sanksi_get(){
        $where = [
            'id_perusahaan' => $this->get('id_perusahaan')
        ];
        $data = $this->M_Data->view_detail($this->kpi,$this->master,$where);
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

    function sanksi_detail_get(){
        $where = [
            'id_master_sanksi' => $this->get('id_sanksi')
        ];
        $data = $this->M_Data->view_detail($this->kpi,$this->master,$where);
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

    function sanksi_member_get(){
        $where = [
            $this->sanksi.'.id_user' => $this->get('id_user'),
            $this->sanksi.'.sanksi_output' => $this->get('output')
        ];
        $table = [
            'table_1' => $this->sanksi,
            'table_2' => $this->master
        ];
        $join = [
            'join_2' => 'sanksi.id_master_sanksi = master_sanksi.id_master_sanksi'
        ];
        $data = $this->M_Data->view_join($this->kpi,$table,$join,$where);
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

    function sanksi_member_detail_get(){
        $where = [
            $this->sanksi.'.id_sanksi' => $this->get('id_sanksi')
        ];
        $table = [
            'table_1' => $this->sanksi,
            'table_2' => $this->master
        ];
        $join = [
            'join_2' => 'sanksi.id_master_sanksi = master_sanksi.id_master_sanksi'
        ];
        $data = $this->M_Data->view_join($this->kpi,$table,$join,$where);
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

    function sanksi_post(){
         $data = [
            'id_perusahaan' => $this->post('id_perusahaan'),
            'sanksi_nama' => $this->post('nama'),
            'sanksi_nilai' => $this->post('nilai'),
            'sanksi_keterangan' => $this->post('keterangan')
        ];
        if($this->M_Data->insert_data($this->kpi,$this->master,$data) > 0){
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

    function sanksi_member_post(){
         $data = [
            'id_master_sanksi' => $this->post('sanksi'),
            'id_user' => $this->post('id_user'),
            'sanksi_catatan' => $this->post('catatan'),
            'sanksi_create_at' => $this->post('at'),
            'sanksi_create_by' => $this->post('by'),
            'sanksi_output' => $this->post('output')
        ];
        if($this->M_Data->insert_data($this->kpi,$this->sanksi,$data) > 0){
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

    function sanksi_delete(){
        $data = [
            'id_master_sanksi' => $this->delete('id_sanksi')
        ];
        if($this->M_Data->delete_data($this->kpi,$this->master,$data) > 0){
            $response  =[
                'status' => 200,
                'error' => false,
                'msg' => 'Data Berhasil Dihapus'
            ];
        }else{
            $response  =[
                'status' => 'ETAX - 10003',
                'error' => true,
                'msg' => 'Gagal Hapus Database'
            ];
        }
        $this->response($response);
    }

    function sanksi_member_delete(){
        $data = [
            'id_sanksi' => $this->delete('id_sanksi')
        ];
        if($this->M_Data->delete_data($this->kpi,$this->sanksi,$data) > 0){
            $response  =[
                'status' => 200,
                'error' => false,
                'msg' => 'Data Berhasil Dihapus'
            ];
        }else{
            $response  =[
                'status' => 'ETAX - 10003',
                'error' => true,
                'msg' => 'Gagal Hapus Database'
            ];
        }
        $this->response($response);
    }
}

?>