<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class TasklistServer extends REST_Controller{

    var $tasklist = 'tasklist';
    var $progress = 'progress_tasklist';
    
    private $kpi;

    function __construct(){
        parent::__construct();
        $this->load->model('M_Data');
        $this->kpi = $this->load->database('kpi', TRUE);
        // $this->master = $this->load->database('master', TRUE);
    }

    function tasklist_get(){
        $or_where = [
            'tasklist_output' => $this->get('output')
        ];
        $where = [
            'tasklist_done' => NULL,
            'id_user' => $this->get('id_user'),
        ];
        // $data = $this->M_Data->view_detail($this->kpi,$this->tasklist,$where);
        $data = $this->M_Data->view_tasklist($this->kpi,$this->tasklist,$where,$or_where);
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

    function tasklist_pending_get(){
        $where = [
            'id_user' => $this->get('id_user'),
            'tasklist_status' => 'Belum Selesai',
        ];
        $data = $this->M_Data->view_detail($this->kpi,$this->tasklist,$where);
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

    function tasklist_detail_get(){
        $where = [
            'id_tasklist' => $this->get('id_tasklist')
        ];
        $data = $this->M_Data->view_detail($this->kpi,$this->tasklist,$where);
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
            'id_tasklist' => $this->get('id_tasklist')
        ];
        $data = $this->M_Data->view_progress($this->kpi,$this->progress,$where,'id_progress_tasklist');
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

    function tasklist_post(){
        $data = [
            'id_user' => $this->post('id_user'),
            'tasklist_nama' => $this->post('tasklist'),
            'tasklist_bobot' => $this->post('bobot'),
            'tasklist_catatan' => $this->post('catatan'),
            'tasklist_status' => $this->post('status'),
            'tasklist_create_at' => $this->post('at'),
            'tasklist_create_by' => $this->post('by'),
            'tasklist_output' => $this->post('output')
        ];
        if($this->M_Data->insert_data($this->kpi,$this->tasklist,$data) > 0){
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

    function progress_post(){
        $data = [
            'id_tasklist' => $this->post('tasklist'),
            'progress_tasklist' => $this->post('progress'),
            'progress_date' => $this->post('date'),
            'progress_catatan' => $this->post('catatan'),
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

    function tasklist_put(){
        $where = [
            'id_tasklist' => $this->put('tasklist')
        ];
        $data = [
            'tasklist_status' => $this->put('status'),
            'tasklist_done' => $this->put('done')
        ];
        if($this->M_Data->update_data($this->kpi,$this->tasklist,$data,$where) > 0){
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

    function tasklist_delete(){
        $where = [
            'id_tasklist' => $this->delete('tasklist')
        ];
        if($this->M_Data->delete_data($this->kpi,$this->tasklist,$where) > 0){
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