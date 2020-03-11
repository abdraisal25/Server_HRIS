<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class PersonaliaServer extends REST_Controller{

    var $data = 'data';
    var $keluarga = 'keluarga';
    var $lain = 'lain';
    var $organisasi = 'organisasi';
    var $pendidikan = 'pendidikan';
    var $pengalaman = 'pengalaman';
    
    public $db_personalia;
    
    function __construct(){
        parent::__construct();
        $this->load->model('M_Data');
        $this->db_personalia = $this->load->database('personalia', true);
    }

    function cek_akun_get(){
        $where = [
            'id_perusahaan' => $this->get('id_perusahaan'),
            'user_email' => $this->get('email')
        ];
        $data = $this->M_Data->view_detail($this->db_personalia,$this->data,$where);
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

    function view_get(){
        $where = [
            'id_user' => $this->get('id_user')
        ];
        $data = [
            'data' => $this->M_Data->view_detail($this->db_personalia,$this->data,$where),
            'keluarga' => $this->M_Data->view_detail($this->db_personalia,$this->keluarga,$where),
            'lain' => $this->M_Data->view_detail($this->db_personalia,$this->lain,$where),
            'organisasi' => $this->M_Data->view_detail($this->db_personalia,$this->organisasi,$where),
            'pendidikan' => $this->M_Data->view_detail($this->db_personalia,$this->pendidikan,$where),
            'pengalaman' => $this->M_Data->view_detail($this->db_personalia,$this->pengalaman,$where)
        ];
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

    function view_member_get(){
        $table = [
            'table_1' => $this->data,
            'table_2' => 'cit_perusahaan.jabatan',
            'table_3' => 'master_data.perusahaan_jabatan'
        ];
        $join = [
            'join_2' => 'cit_perusahaan.jabatan.key_jabatan = data.key_jabatan',
            'join_3' => 'master_data.perusahaan_jabatan.id_jabatan = cit_perusahaan.jabatan.id_jabatan'
        ];
        $where = [
            'cit_perusahaan.jabatan.id_departement' => $this->get('id_departement'),
            'cit_perusahaan.jabatan.id_perusahaan' => $this->get('id_perusahaan'),
            'master_data.perusahaan_jabatan.id_level !=' => $this->get('id_level')
        ];
        $data = $this->M_Data->view_join($this->db_personalia,$table,$join,$where);
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
        $id = $this->M_Data->create_user($this->db_personalia,$this->data,$data);
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













    function register_post(){
        $data = [
            'user_email' => $this->post('email'),
            'id_perusahaan' => $this->post('id_perusahaan'),
            'user_nama' => $this->post('nama'),
            'user_username' => $this->post('username'),
            'user_password' => md5($this->post('password')),
            'user_nip' => $this->post('nip')
        ];
        if($this->M_Data->insert_data($this->db_personalia,$this->data,$data) > 0){
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

    function cek_user_get(){
        $where = [
            'id_perusahaan' => $this->get('id_perusahaan'),
            'user_username' => $this->get('username'),
            'user_password' => md5($this->get('password')),
            'user_status' => $this->get('status')
        ];
        $data = $this->M_Data->view_detail($this->db_personalia,$this->data,$where);
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