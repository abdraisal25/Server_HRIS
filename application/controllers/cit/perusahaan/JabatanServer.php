<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class JabatanServer extends REST_Controller{

    var $jabatan = 'perusahaan_jabatan';
    
    private $master;
    function __construct(){
        parent::__construct();
        $this->load->model('M_Data');
        $this->master = $this->load->database('master', TRUE);
    }

    function jabatan_get(){
        $where = [
            $this->jabatan.'.id_departement' => $this->get('id_departement')
        ];
        $table = [
            'table_1' => $this->jabatan,
            'table_2' => 'perusahaan_departement',
            'table_3' => 'perusahaan_divisi',
            'table_4' => 'perusahaan_jenis'
        ];
        $join = [
            'join_2' => 'perusahaan_departement.id_departement = perusahaan_jabatan.id_departement',
            'join_3' => 'perusahaan_divisi.id_divisi = perusahaan_departement.id_divisi',
            'join_4' => 'perusahaan_jenis.id_jenus = perusahaan_divisi.id_jenus'    
        ];
        if($this->get('id_departement') == NULL){
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

    function jabatan_detail_get(){
        $where = [
            $this->jabatan.'.id_jabatan' => $this->get('id_jabatan')
        ];
        $table = [
            'table_1' => $this->jabatan,
            'table_2' => 'perusahaan_departement',
            'table_3' => 'perusahaan_divisi',
            'table_4' => 'perusahaan_jenis'
        ];
        $join = [
            'join_2' => 'perusahaan_departement.id_departement = perusahaan_jabatan.id_departement',
            'join_3' => 'perusahaan_divisi.id_divisi = perusahaan_departement.id_divisi',
            'join_4' => 'perusahaan_jenis.id_jenus = perusahaan_divisi.id_jenus'    
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

    function jabatan_post(){
        $data = [
            'jabatan_nama' => $this->post('nama'),
            'parent_id' => $this->post('parent'),
            'id_departement' => $this->post('departement')
        ];
        if($this->M_Data->insert_data($this->master,$this->jabatan,$data) > 0){
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

    function jabatan_put(){
        $data = [
            'jabatan_nama' => $this->put('nama')
        ];
        $where = [
            'id_jabatan' => $this->put('id_jabatan')
        ];
        if($this->M_Data->update_data($this->master,$this->jabatan,$data,$where) > 0){
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
 
    function jabatan_delete(){
        $where = [
            'id_jabatan' => $this->delete('id_jabatan')
        ];
        if($this->M_Data->delete_data($this->master,$this->jabatan,$where) > 0){
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
        $data = $this->M_Data->view_data($this->master,$this->jabatan);
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