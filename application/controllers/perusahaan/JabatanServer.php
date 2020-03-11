<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class JabatanServer extends REST_Controller{

    var $table = 'perusahaan_jabatan';
    var $jabatan = 'jabatan';
    var $level = 'jabatan_level';
    var $jobdesc = 'jobdesc';
    private $db_perusahaan,$master;
    function __construct(){
        parent::__construct();
        $this->load->model('M_Data');
        $this->db_perusahaan = $this->load->database('perusahaan', TRUE);
        $this->master = $this->load->database('master', TRUE);
    }

    function jabatan_get(){
        $where = [
            'id_standart_level !=' => $this->get('id_standart_level'),
            'id_perusahaan' => $this->get('id_perusahaan')
        ];
        $data = $this->M_Data->view_detail($this->db_perusahaan,$this->jabatan,$where);
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

    function jabatan_full_get(){
        $where = [
            $this->jabatan.'.id_perusahaan' => $this->get('id_perusahaan')
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
    
    function jabatan_detail_get(){
        $where = [
            'key_jabatan' => $this->get('id_jabatan')
        ];
        $data = $this->M_Data->view_detail($this->db_perusahaan,$this->jabatan,$where);
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

    function new_jabatan_post(){
        $divisi = $this->post('divisi') == 0 ? $this->M_Data->create_user($this->master,'perusahaan_divisi',array('id_jenus' => $this->post('jenus'),'divisi_nama' => $this->post('divisi'))) : $this->post('divisi');
        $departement = $this->post('departement') == 0 ? $this->M_Data->create_user($this->master,'perusahaan_departement',array('id_divisi' => $divisi,'departement_nama' => $this->post('departement'))) : $this->post('departement');
        $jabatan = $this->post('jabatan') == 0 ? $this->M_Data->create_user($this->master,'perusahaan_jabatan',array('id_departement' => $departement,'parent_id' => $this->post('parent'),'jabatan_nama' => $this->post('jabatan'))) : $this->post('jabatan') ;
        $data = [
            'id_perusahaan' => $this->post('id_perusahaan'),
            'id_divisi' => $divisi,
            'id_departement' => $departement,
            'id_jabatan' => $jabatan
        ];
        if($this->M_Data->insert_data($this->db_perusahaan,$this->jabatan,$data) > 0){
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

    function jabatan_post(){
        $data = [
            // 'parent_id' => $this->post('member')
            'id_perusahaan' => $this->post('id_perusahaan'),
            // 'id_standart_level' => $this->post('level'),
            'id_divisi' => $this->post('divisi'),
            'id_departement' => $this->post('departement'),
            'id_jabatan' => $this->post('jabatan')
        ];
        if($this->M_Data->insert_data($this->db_perusahaan,$this->jabatan,$data) > 0){
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

    function jabatan_put(){
        $data = [
            // 'id_standart_level' => $this->put('level'),
            'jabatan_nama' => $this->put('nama'),
            'id_divisi' => $this->put('divisi'),
            'id_departement' => $this->put('departement'),
            'parent_id' => $this->put('member'),
        ];
        $where = [
            'id_jabatan' => $this->put('id_jabatan')
        ];
        if($this->M_Data->update_data($this->db_perusahaan,$this->jabatan,$data,$where) > 0){
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
    
    function jabatan_delete(){
        $where = [
            'key_jabatan' => $this->delete('id_jabatan')
        ];
        if($this->M_Data->delete_data($this->db_perusahaan,$this->jabatan,$where) > 0){
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

    function select_get(){
        $data = $this->M_Data->view_data($this->master,$this->table);
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

    function jabatan_join_get(){
        $table = [
            'table_1' => $this->jabatan,
            'table_2' => 'master_data.perusahaan_jabatan',
            'table_3' => 'master_data.perusahaan_departement',
            'table_4' => 'master_data.perusahaan_divisi'
        ];
        $join = [
            'join_2' => 'jabatan.id_jabatan = master_data.perusahaan_jabatan.id_jabatan',
            'join_3' => 'master_data.perusahaan_jabatan.id_departement = master_data.perusahaan_departement.id_departement',
            'join_4' => 'master_data.perusahaan_departement.id_divisi = master_data.perusahaan_divisi.id_divisi'
        ];
        $where = [
            $this->jabatan.'.key_jabatan' => $this->get('key_jabatan')
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

    function jabatan_user_get(){
        $table = [
            'table_1' => $this->jabatan,
            'table_2' => 'master_data.perusahaan_jabatan'
        ];
        $join = [
            'join_2' => 'jabatan.id_jabatan = master_data.perusahaan_jabatan.id_jabatan'
        ];
        $where = [
            $this->jabatan.'.id_departement' => $this->get('id_departement'),
            $this->jabatan.'.id_perusahaan' => $this->get('id_perusahaan'),
            'master_data.perusahaan_jabatan.id_level !=' => $this->get('id_level')
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
    
    function select_jabatan_get(){
        $table = [
            'table_1' => $this->jabatan,
            'table_2' => 'master_data.perusahaan_jabatan'
        ];
        $join = [
            'join_2' => 'jabatan.id_jabatan = master_data.perusahaan_jabatan.id_jabatan'
        ];
        $where = [
            $this->jabatan.'.id_perusahaan' => $this->get('id_perusahaan'),
            'master_data.perusahaan_jabatan.parent_id' => $this->get('id_jabatan')
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
    
    function select_user_get(){
        $table = [
            'table_1' => 'jabatan',
            'table_2' => 'cit_personalia.data',
            'table_3' => 'master_data.perusahaan_jabatan',
            'table_4' => 'master_data.perusahaan_departement'

        ];
        $join = [
            'join_2' => 'cit_personalia.data.key_jabatan = jabatan.key_jabatan',
            'join_3' => 'master_data.perusahaan_jabatan.id_jabatan = cit_perusahaan.jabatan.id_jabatan',
            'join_4' => 'master_data.perusahaan_jabatan.id_departement = master_data.perusahaan_departement.id_departement'
        ];
        $where = [
            // 'cit_perusahaan.jabatan.id_departement' => $this->get('id_departement'),
            'cit_perusahaan.jabatan.id_perusahaan' => $this->get('id_perusahaan'),
            'cit_personalia.data.user_status' => 1,
            'master_data.perusahaan_jabatan.parent_id' => $this->get('id_jabatan')
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
   
    function select_user_admin_get(){
        $table = [
            'table_1' => 'jabatan',
            'table_2' => 'cit_personalia.data',
            'table_3' => 'master_data.perusahaan_jabatan',
            'table_4' => 'master_data.perusahaan_departement'

        ];
        $join = [
            'join_2' => 'cit_personalia.data.key_jabatan = jabatan.key_jabatan',
            'join_3' => 'master_data.perusahaan_jabatan.id_jabatan = cit_perusahaan.jabatan.id_jabatan',
            'join_4' => 'master_data.perusahaan_jabatan.id_departement = master_data.perusahaan_departement.id_departement'
        ];
        $where = [
            // 'cit_perusahaan.jabatan.id_departement' => $this->get('id_departement'),
            'cit_perusahaan.jabatan.id_perusahaan' => $this->get('id_perusahaan'),
            'cit_personalia.data.user_status' => 1,
            // 'master_data.perusahaan_jabatan.id_level !=' => $this->get('id_level'),
            'master_data.perusahaan_jabatan.id_departement' => $this->get('id_departement')
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

    function level_get(){
        $where = [
            'parent_id' => $this->get('id_jabatan')
        ];
        $data = $this->M_Data->view_detail($this->master,'perusahaan_jabatan',$where);
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