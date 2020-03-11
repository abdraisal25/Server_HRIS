<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class HasilServer extends REST_Controller{

    var $hasil = 'hasil_kerja';

    private $db_jobdesc;

    function __construct(){
        parent::__construct();
        $this->load->model('M_Data');
        $this->db_jobdesc = $this->load->database('jobdesc', TRUE);
    }

    function hasil_detail_get(){
        $where = [
            'id_hasil' => $this->get('id_hasil')
        ];
        $data = $this->M_Data->view_detail($this->db_jobdesc,$this->hasil,$where);
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

    function hasil_post(){
        $data = [
            'hasil_tujuan' => $this->post('tujuan'),
            'hasil_periode' => $this->post('periode'),
            'hasil_judul' => $this->post('hasil'),
            'key_jabatan' => $this->post('key_jabatan')
        ];
        if($this->M_Data->insert_data($this->db_jobdesc,$this->hasil,$data) > 0){
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

    function hasil_put(){
        $data = [
            'hasil_tujuan' => $this->put('tujuan'),
            'hasil_periode' => $this->put('periode'),
            'hasil_judul' => $this->put('hasil')
        ];
        $where = [
            'id_hasil' => $this->put('id')
        ];
        if($this->M_Data->update_data($this->db_jobdesc,$this->hasil,$data,$where) > 0){
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
    
    function hasil_delete(){
        $where = [
            'id_hasil' => $this->delete('id')
        ];
        if($this->M_Data->delete_data($this->db_jobdesc,$this->hasil,$where) > 0){
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