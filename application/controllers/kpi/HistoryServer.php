<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class HistoryServer extends REST_Controller{

    var $history = 'history';
    private $kpi;

    function __construct(){
        parent::__construct();
        $this->load->model('M_Data');
        $this->kpi = $this->load->database('kpi', TRUE);
    }

    function history_user_get(){
        $where = [
            'id_user' => $this->get('id_user')
        ];
        $data = $this->M_Data->view_detail($this->kpi,$this->history,$where);
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
    

    function history_get(){
        $where = [
            'id_user' => $this->get('id_user'),
            'history_tahun' => $this->get('tahun')
        ];
        $data = $this->M_Data->view_detail($this->kpi,$this->history,$where);
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
    
    function history_post(){
        $data = [
            'id_user' => $this->post('id_user'),
            'history_tahun' => $this->post('tahun'),
            'history_'.$this->post('bulan') => $this->post('history')
        ];
        if($this->M_Data->insert_data($this->kpi,$this->history,$data) > 0){
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
    
    function history_put(){
        $where = [
            'id_user' => $this->put('id_user'),
            'history_tahun' => $this->put('tahun')
        ];
        $data = [
            'history_'.$this->put('bulan') => $this->put('history')
        ];
        if($this->M_Data->update_data($this->kpi,$this->history,$data,$where) > 0){
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
}

?>