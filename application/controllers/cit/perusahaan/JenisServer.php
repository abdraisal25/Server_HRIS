<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class JenisServer extends REST_Controller{

    var $jenus = 'perusahaan_jenis';
    
    private $master;
    function __construct(){
        parent::__construct();
        $this->load->model('M_Data');
        $this->master = $this->load->database('master', TRUE);
    }

    function jenis_get(){
        $data = $this->M_Data->view_data($this->master,$this->jenus);
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

    function jenis_detail_get(){
        $where = [
            'id_jenus' => $this->get('id_jenus')
        ];
        $data = $this->M_Data->view_detail($this->master,$this->jenus,$where);
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

    function jenis_post(){
        $data = [
            'jenus_nama' => $this->post('nama')
        ];
        if($this->M_Data->insert_data($this->master,$this->jenus,$data) > 0){
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

    function jenis_put(){
        $data = [
            'jenus_nama' => $this->put('nama')
        ];
        $where = [
            'id_jenus' => $this->put('id_jenus')
        ];
        if($this->M_Data->update_data($this->master,$this->jenus,$data,$where) > 0){
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
 
    function jenis_delete(){
        $where = [
            'id_jenus' => $this->delete('id_jenus')
        ];
        if($this->M_Data->delete_data($this->master,$this->jenus,$where) > 0){
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
            $this->jenus.'.id_jenus' => $this->get('id_jenus')
        ];
        $table = [
            'table_1' => $this->jenus,
            'table_2' => 'perusahaan_divisi',
            'table_3' => 'perusahaan_departement',
            'table_4' => 'perusahaan_jabatan'
        ];
        $join = [
            'join_2' => 'perusahaan_jenis.id_jenus = perusahaan_divisi.id_jenus',
            'join_3' => 'perusahaan_divisi.id_divisi = perusahaan_departement.id_divisi',
            'join_4' => 'perusahaan_departement.id_departement = perusahaan_jabatan.id_departement'
        ];
        $data = $this->M_Data->view_join($this->master,$table,$join,$where);
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