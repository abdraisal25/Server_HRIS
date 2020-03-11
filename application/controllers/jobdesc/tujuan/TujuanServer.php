<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class TujuanServer extends REST_Controller{

    var $tujuan = 'tujuan';

    private $db_jobdesc;

    function __construct(){
        parent::__construct();
        $this->load->model('M_Data');
        $this->db_jobdesc = $this->load->database('jobdesc', TRUE);
    }

    function tujuan_detail_get(){
        $where = [
            'id_tujuan' => $this->get('id_tujuan')
        ];
        $data = $this->M_Data->view_detail($this->db_jobdesc,$this->tujuan,$where);
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
            'jobdesc_tujuan' => $this->post('tujuan'),
            'key_jabatan' => $this->post('key_jabatan')
        ];
        if($this->M_Data->insert_data($this->db_jobdesc,$this->tujuan,$data) > 0){
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

    function tujuan_put(){
        $data = [
            'jobdesc_tujuan' => $this->put('tujuan')
        ];
        $where = [
            'id_tujuan' => $this->put('id')
        ];
        if($this->M_Data->update_data($this->db_jobdesc,$this->tujuan,$data,$where) > 0){
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
            'id_tujuan' => $this->delete('id')
        ];
        if($this->M_Data->delete_data($this->db_jobdesc,$this->tujuan,$where) > 0){
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
}

?>