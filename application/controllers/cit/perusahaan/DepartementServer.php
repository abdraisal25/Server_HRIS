<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class DepartementServer extends REST_Controller{

    var $departement = 'perusahaan_departement';
    
    private $master;
    function __construct(){
        parent::__construct();
        $this->load->model('M_Data');
        $this->master = $this->load->database('master', TRUE);
    }

    function departement_get(){
        $where = [
            $this->departement.'.id_divisi' => $this->get('id_divisi')
        ];
        $table = [
            'table_1' => $this->departement,
            'table_2' => 'perusahaan_divisi',
            'table_3' => 'perusahaan_jenis'
        ];
        $join = [
            'join_2' => 'perusahaan_divisi.id_divisi = perusahaan_departement.id_divisi',
            'join_3' => 'perusahaan_jenis.id_jenus = perusahaan_divisi.id_jenus'
        ];
        if($this->get('id_divisi') == NULL){
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

    function departement_detail_get(){
        $where = [
            $this->departement.'.id_departement' => $this->get('id_departement')
        ];
        $table = [
            'table_1' => $this->departement,
            'table_2' => 'perusahaan_divisi',
            'table_3' => 'perusahaan_jenis'
        ];
        $join = [
            'join_2' => 'perusahaan_divisi.id_divisi = perusahaan_departement.id_divisi',
            'join_3' => 'perusahaan_jenis.id_jenus = perusahaan_divisi.id_jenus'
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

    function departement_post(){
        $data = [
            'departement_nama' => $this->post('nama'),
            'id_divisi' => $this->post('divisi')
        ];
        if($this->M_Data->insert_data($this->master,$this->departement,$data) > 0){
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

    function departement_put(){
        $data = [
            'departement_nama' => $this->put('nama')
        ];
        $where = [
            'id_departement' => $this->put('id_departement')
        ];
        if($this->M_Data->update_data($this->master,$this->departement,$data,$where) > 0){
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
 
    function departement_delete(){
        $where = [
            'id_departement' => $this->delete('id_departement')
        ];
        if($this->M_Data->delete_data($this->master,$this->departement,$where) > 0){
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
        $data = $this->M_Data->view_data($this->master,$this->departement);
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