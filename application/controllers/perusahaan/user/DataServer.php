<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class DataServer extends REST_Controller{

    var $data = 'data';
    
    private $db_personalia;
    function __construct(){
        parent::__construct();
        $this->load->model('M_Data');
        $this->db_personalia = $this->load->database('personalia', TRUE);
    }

    function data_detail_get(){
        $where = [
            'id_user' => $this->get('id_user'),
            'user_status' => $this->get('status'),
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

    // function data_post(){
    //     $data = [
    //         'id_perusahaan' => $this->post('id_perusahaan'),
    //         'id_jabatan' => $this->post('id_jabatan'),
    //         'user_nip' => $this->post('nip'),
    //         'user_ktp' => $this->post('ktp'),
    //         'user_email' => $this->post('email'),
    //         'user_nama' => $this->post('nama'),
    //         'user_kelamin' => $this->post('jekel'),
    //         'user_darah' => $this->post('darah'),
    //         'user_tempat_lahir' => $this->post('tpt_lahir'),
    //         'user_tanggal_lahir' => $this->post('tgl_lahir'),
    //         'user_agama' => $this->post('agama'),
    //         'user_perkawinan' => $this->post('perkawinan'),
    //         'user_alamat' => $this->post('alamat'),
    //         'user_telp' => $this->post('telp')
    //     ];
    //     if($this->M_Data->insert_data($this->db_personalia,$this->data,$data) > 0){
    //         $response  =[
    //             'status' => 200,
    //             'error' => false,
    //             'msg' => 'Data Berhasil Dimasukan'
    //         ];
    //     }else{
    //         $response  =[
    //             'status' => 'ETAX - 10003',
    //             'error' => true,
    //             'msg' => 'Gagal Input Ke dalam Database'
    //         ];
    //     }
    //     $this->response($response);
    // }

    // function data_put(){
    //     $data = [
    //         'user_nama' => $this->put('nama'),
    //         'user_username' => $this->put('username'),
    //         'user_password' => $this->put('password'),
    //         'user_nip' => $this->put('nip'),
    //     ];
    //     $where = [
    //         'key_jabatan' => $this->put('key')
    //     ];
    //     if($this->M_Data->update_data($this->db_personalia,$this->data,$data,$where) > 0){
    //         $response  =[
    //             'status' => 200,
    //             'error' => false,
    //             'msg' => 'Data Berhasil Dimasukan'
    //         ];
    //     }else{
    //         $response  =[
    //             'status' => 'ETAX - 10003',
    //             'error' => true,
    //             'msg' => 'Gagal Input Ke dalam Database'
    //         ];
    //     }
    //     $this->response($response);
    // }
    
    // function level_delete(){
    //     $where = [
    //         'id_standart_level' => $this->delete('id_standart_level')
    //     ];
    //     if($this->M_Data->delete_data($this->db_perusahaan,$this->level,$where) > 0){
    //         $response  =[
    //             'status' => 200,
    //             'error' => false,
    //             'msg' => 'Data Berhasil Dihapus'
    //         ];
    //     }else{
    //         $response  =[
    //             'status' => 'ETAX - 10003',
    //             'error' => true,
    //             'msg' => 'Gagal Input Ke dalam Database'
    //         ];
    //     }
    //     $this->response($response);
    // }
}

?>