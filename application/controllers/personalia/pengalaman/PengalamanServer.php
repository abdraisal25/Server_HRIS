<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class PengalamanServer extends REST_Controller{

    var $pengalaman = 'pengalaman';
    
    private $db_personalia;
    function __construct(){
        parent::__construct();
        $this->load->model('M_Data');
        $this->db_personalia = $this->load->database('personalia', TRUE);
    }

    function detail_get(){
        $where = [
            'id_pengalaman' => $this->get('id_pengalaman')
        ];
        $data = $this->M_Data->view_detail($this->db_personalia,$this->pengalaman,$where);
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

    function pengalaman_post(){
        $data = [
            'id_user' => $this->post('id'),
            'pengalaman_mulai' => $this->post('mulai'),
            'pengalaman_selesai' => $this->post('selesai'),
            'pengalaman_perusahaan' => $this->post('perusahaan'),
            'pengalaman_jenus' => $this->post('jenus'),
            'pengalaman_alamat' => $this->post('alamat'),
            'pengalaman_jabatan' => $this->post('jabatan'),
            'pengalaman_gaji' => $this->post('gaji'),
            'pengalaman_jabatan_atasan' => $this->post('jabatan_atasan'),
            'pengalaman_berhenti' => $this->post('berhenti'),
            'pengalaman_atasan' => $this->post('nama')
        ];
        if($this->M_Data->insert_data($this->db_personalia,$this->pengalaman,$data) > 0){
            $response  =[
                'status' => 200,
                'error' => false,
                'msg' => 'Data Berhasil Dimasukan'
            ];
        }else{
            $response  =[
                'status' => 'ETAX - 10003',
                'error' => true,
                'msg' => 'Gagal Inpost Ke dalam Database'
            ];
        }
        $this->response($response);
    }
    
    function pengalaman_delete(){
        $where = [
            'id_pengalaman' => $this->delete('key')
        ];
        if($this->M_Data->delete_data($this->db_personalia,$this->pengalaman,$where) > 0){
            $response  =[
                'status' => 200,
                'error' => false,
                'msg' => 'Data Berhasil Dimasukan'
            ];
        }else{
            $response  =[
                'status' => 'ETAX - 10003',
                'error' => true,
                'msg' => 'Gagal Inpost Ke dalam Database'
            ];
        }
        $this->response($response);
    }
}

?>