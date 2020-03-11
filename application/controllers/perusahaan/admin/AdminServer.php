<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class AdminServer extends REST_Controller{

    var $jabatan = 'jabatan';
    var $user = 'data';
    
    private $db_perusahaan, $db_personalia, $db_master;
    function __construct(){
        parent::__construct();
        $this->load->model('M_Data');
        $this->db_perusahaan = $this->load->database('perusahaan', TRUE);
        $this->db_personalia = $this->load->database('personalia', TRUE);
    }

    function admin_get(){
        $where = [
            $this->jabatan.'.id_perusahaan' => $this->get('id_perusahaan'),
            'master_data.perusahaan_jabatan.id_level' => $this->get('id_level')
        ];
        $table = [
            'table_1' => $this->jabatan,
            'table_2' => 'master_data.perusahaan_jabatan',
            'table_3' => 'master_data.perusahaan_departement',
            'table_4' => 'master_data.perusahaan_divisi'
        ];
        $join = [
            'join_2' => 'master_data.perusahaan_jabatan.id_jabatan = jabatan.id_jabatan',
            'join_3' => 'master_data.perusahaan_departement.id_departement = master_data.perusahaan_jabatan.id_departement',
            'join_4' => 'master_data.perusahaan_divisi.id_divisi = master_data.perusahaan_departement.id_divisi'
        ];
        $data = $this->M_Data->view_join($this->db_perusahaan,$table,$join,$where);
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
  
    function member_get(){
        $where = [
            'key_jabatan' => $this->get('key_jabatan')
        ];
        $data = $this->M_Data->view_detail($this->db_personalia,$this->user,$where);
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
    
    function admin_user_get(){
        $where = [
            'id_jabatan' => $this->get('id_jabatan')
        ];
        $data = $this->M_Data->view_detail($this->db_personalia,$this->user,$where);
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

    function create_post(){
         $data = [
            'id_perusahaan' => $this->post('id_perusahaan'),
            'user_email' => $this->post('email'),
            'key_jabatan' => $this->post('key'),
            'user_status' => $this->post('status')
        ];
        $id = $this->M_Data->create_user($this->db_personalia,$this->user,$data);
        if(!empty($id)){
            $response  =[
                'status' => 200,
                'error' => false,
                'data' => $id,
                'msg' => 'Data Berhasil Dimasukan'
            ];
        }else{
            $response  =[
                'status' => 'ETAX - 10003',
                'error' => true,
                'data' => NULL,
                'msg' => 'Gagal Input Ke dalam Database'
            ];
        }
        $this->response($response);
    }
}

?>