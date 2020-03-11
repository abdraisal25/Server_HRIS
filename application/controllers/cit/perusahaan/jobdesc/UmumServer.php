<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class UmumServer extends REST_Controller{

    var $umum = 'jobdesc_tj_umum';
    
    private $master;
    function __construct(){
        parent::__construct();
        $this->load->model('M_Data');
        $this->master = $this->load->database('master', TRUE);
    }

    function umum_get(){
        $where = [
            'a.id_jabatan' => $this->get('id_jabatan')
        ];
        if($this->get('id_jabatan') == NULL){
            $data = $this->M_Data->view_join($this->master,$this->umum,'perusahaan_jabatan','id_jabatan',null);
        }else{
            $data = $this->M_Data->view_join($this->master,$this->umum,'perusahaan_jabatan','id_jabatan',$where);
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

    function umum_detail_get(){
        $where = [
            'id_umum' => $this->get('id_umum')
        ];
        $data = $this->M_Data->view_detail($this->master,$this->umum,$where);
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

    function umum_post(){
        $data = [
            'umum_nama' => $this->post('nama'),
            'id_jabatan' => $this->post('jabatan')
        ];
        if($this->M_Data->insert_data($this->master,$this->umum,$data) > 0){
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
 
    function umum_delete(){
        $where = [
            'id_umum' => $this->delete('id_umum')
        ];
        if($this->M_Data->delete_data($this->master,$this->umum,$where) > 0){
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