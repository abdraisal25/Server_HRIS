<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class TujuanServer extends REST_Controller{

    var $tujuan = 'jobdesc_tujuan';
    
    private $master;
    function __construct(){
        parent::__construct();
        $this->load->model('M_Data');
        $this->master = $this->load->database('master', TRUE);
    }

    function tujuan_get(){
        $where = [
            'a.id_jabatan' => $this->get('id_jabatan')
        ];
        if($this->get('id_jabatan') == NULL){
            $data = $this->M_Data->view_join($this->master,$this->tujuan,'perusahaan_jabatan','id_jabatan',null);
        }else{
            $data = $this->M_Data->view_join($this->master,$this->tujuan,'perusahaan_jabatan','id_jabatan',$where);
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

    function tujuan_detail_get(){
        $where = [
            'id_tujuan' => $this->get('id_tujuan')
        ];
        $data = $this->M_Data->view_detail($this->master,$this->tujuan,$where);
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

    function tujuan_post(){
        $data = [
            'tujuan_nama' => $this->post('nama'),
            'id_jabatan' => $this->post('jabatan')
        ];
        if($this->M_Data->insert_data($this->master,$this->tujuan,$data) > 0){
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

    function tujuan_put(){
        $data = [
            'tujuan_nama' => $this->put('nama')
        ];
        $where = [
            'id_tujuan' => $this->put('id_tujuan')
        ];
        if($this->M_Data->update_data($this->master,$this->tujuan,$data,$where) > 0){
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
 
    function tujuan_delete(){
        $where = [
            'id_tujuan' => $this->delete('id_tujuan')
        ];
        if($this->M_Data->delete_data($this->master,$this->tujuan,$where) > 0){
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