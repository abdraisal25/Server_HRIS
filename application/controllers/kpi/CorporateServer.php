<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class CorporateServer extends REST_Controller{

    var $corporate = 'corporate';
    var $progress = 'progress_corporate';
    var $nilai = 'nilai_corporate';
    private $kpi;

    function __construct(){
        parent::__construct();
        $this->load->model('M_Data');
        $this->kpi = $this->load->database('kpi', TRUE);
        $this->master = $this->load->database('master', TRUE);
    }

    function corporate_get(){
        $table = [
            'table_1' => $this->corporate,
            'table_2' => 'master_data.kpi_corporate',
            'table_3' => 'master_data.kpi_kategori'
        ];
        $join = [
            'join_2' => 'master_data.kpi_corporate.id_corporate = corporate.id_corporate',      
            'join_3' => 'master_data.kpi_corporate.id_kategori = master_data.kpi_kategori.id_kategori'
        ];
        $where = [
            'id_user' => $this->get('id_user'),
            'corporate_output' => $this->get('output')
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

    function corporate_detail_get(){
        $where = [
            $this->corporate.'.key_corporate' => $this->get('key_corporate')
        ];
        $table = [
            'table_1' => $this->corporate,
            'table_2' => $this->nilai,
        ];
        $join = [
            'join_2' => 'nilai_corporate.key_corporate = corporate.key_corporate'
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

    function progress_get(){
        $where = [
            'key_corporate' => $this->get('key_corporate')
        ];
        $data = $this->M_Data->view_progress($this->kpi,$this->progress,$where,'id_progress_corporate');
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
            'id_perusahaan' => $this->post('id_perusahaan'),
            'id_user' => $this->post('id_user'),
            'id_corporate' => $this->post('id_perspektife'),
            'corporate_target' => $this->post('target'),
            'corporate_satuan' => $this->post('satuan'),
            'corporate_bobot' => $this->post('bobot'),
            'corporate_keterangan' => $this->post('keterangan'),
            'corporate_create_at' => $this->post('at'),
            'corporate_create_by' => $this->post('by'),
            'corporate_output' => $this->post('output')
        ];
        $id = $this->M_Data->create_user($this->kpi,$this->corporate,$data);

        $standart = [
            'key_corporate' => $id,
            'nilai_jenis' => $this->post('penilaian'),
            'nilai_4' => $this->post('n1'),
            'nilai_5' => $this->post('n2'),
            'nilai_6' => $this->post('n3'),
            'nilai_7' => $this->post('n4'),
            'nilai_8' => $this->post('n5'),
            'nilai_9' => $this->post('n6'),
            'nilai_10' => $this->post('n7'),
            'nilai_11' => $this->post('n8'),
            'nilai_12' => $this->post('n9'),
            'nilai_13' => $this->post('n10')
        ];
        
        if($this->M_Data->insert_data($this->kpi,$this->nilai,$standart) > 0){
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

    function add_corporate_post(){
        $data = [
            'corporate_nama' => $this->post('nama'),
            'id_jenus' => $this->post('jenus'),
            'id_kategori' => $this->post('kategori')
        ];
        $id = $this->M_Data->create_user($this->master,'kpi_corporate',$data);
        if($id != null){
            $response  =[
                'status' => 200,
                'error' => false,
                'corporate' => $id,
                'msg' => 'Data Berhasil Dimasukan'
            ];
        }else{
            $response  =[
                'status' => 'ETAX - 10003',
                'error' => true,
                'corporate' => null,
                'msg' => 'Gagal Input Ke dalam Database'
            ];
        }
        $this->response($response);
    }

    function progress_post(){
        $data = [
            'key_corporate' => $this->post('key'),
            'progress_tercapai' => $this->post('tercapai'),
            'progress_keterangan' => $this->post('keterangan'),
            'progress_create_at' => $this->post('at'),
            'progress_create_by' => $this->post('by')
        ];
        if($this->M_Data->insert_data($this->kpi,$this->progress,$data) > 0){
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

    function tercapai_put(){
        $where = [
            'key_corporate' => $this->put('key')
        ];
        $data = [
            'corporate_tercapai' => $this->put('total')
        ];
        if($this->M_Data->update_data($this->kpi,$this->corporate,$data,$where) > 0){
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
            'key_corporate' => $this->delete('key')
        ];
        if($this->M_Data->delete_data($this->kpi,$this->corporate,$where) > 0){
            $response  =[
                'status' => 200,
                'error' => false,
                'msg' => 'Data Berhasil Dihapus'
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

    function graph_get(){
        $where = [
            'key_corporate' => $this->get('key_corporate')
        ];
        $data = $this->M_Data->graph($this->kpi,$this->progress,$where,$this->get('waktu'));
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