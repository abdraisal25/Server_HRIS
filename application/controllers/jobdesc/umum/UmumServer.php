<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class UmumServer extends REST_Controller{

    var $master_umum = 'jobdesc_tj_umum';
    var $umum = 'tj_umum';

    private $db_jobdesc;

    function __construct(){
        parent::__construct();
        $this->load->model('M_Data');
        $this->db_jobdesc = $this->load->database('jobdesc', TRUE);
        $this->db_master = $this->load->database('master', TRUE);
    }

    function umum_get(){
        $where = [
            'id_jabatan' => $this->get('id_jabatan')
        ];
        $data = $this->M_Data->view_detail($this->db_master,$this->master_umum,$where);
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
        $data = $this->M_Data->view_detail($this->db_jobdesc,$this->umum,$where);
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
            'umum_tj' => $this->post('umum'),
            'key_jabatan' => $this->post('key_jabatan')
        ];
        if($this->M_Data->insert_data($this->db_jobdesc,$this->umum,$data) > 0){
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
    
    function umum_delete(){
        $where = [
            'id_umum' => $this->delete('id')
        ];
        if($this->M_Data->delete_data($this->db_jobdesc,$this->umum,$where) > 0){
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