<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class IndividuServer extends REST_Controller{

    var $corporate = 'corporate';
    private $kpi,$master;

    function __construct(){
        parent::__construct();
        $this->load->model('M_Data');
        $this->kpi = $this->load->database('kpi', TRUE);
        $this->master = $this->load->database('master', TRUE);
    }

    function indicator_persentase_get(){
        $data = $this->M_Data->view_data($this->master,'persentase');
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

    function indicator_kpi_get(){
        $data = $this->M_Data->view_data($this->master,'kpi_indikator');
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

    function scoring_get(){
        $data = [
            'corporate' => $this->corporate($this->get('id_user'),$this->get('output')),
            'tasklist' => $this->tasklist($this->get('id_user'),$this->get('output')),
            'sanksi' => $this->sanksi($this->get('id_user'),$this->get('output')),
        ];
        $data['total'] = $this->total($data['corporate'],$data['tasklist'],$data['sanksi']);
        $this->history($this->get('id_user'),$this->get('output'),$data['total']{'total'});
        $response = [
            'status' => 502,
            'error' => true,
            'data' => $data
        ];
        $this->response($response);
    }

    function corporate($user,$output){
        $table = [
            'table_1' => $this->corporate,
            'table_2' => 'master_data.kpi_corporate',
            'table_3' => 'master_data.kpi_kategori',
            'table_4' => 'nilai_corporate',
        ];
        $join = [
            'join_2' => 'master_data.kpi_corporate.id_corporate = corporate.id_corporate',      
            'join_3' => 'master_data.kpi_corporate.id_kategori = master_data.kpi_kategori.id_kategori',
            'join_4' => 'corporate.key_corporate = nilai_corporate.key_corporate'
        ];
        $where = [
            $this->corporate.'.id_user' => $user,
            $this->corporate.'.corporate_output' => $output
        ];
        $data = $this->nilai_corporate($this->M_Data->view_join($this->kpi,$table,$join,$where));
        return $data;
    }

    function tasklist($user,$output){
        $where = [
            'id_user' => $user,
            'tasklist_done' => $output
        ];
        return $this->M_Data->view_detail($this->kpi,'tasklist',$where);
    }

    function sanksi($user,$output){
        $where = [
            'sanksi.id_user' => $user,
            'sanksi.sanksi_output' => $output
        ];
        $table = [
            'table_1' => 'sanksi',
            'table_2' => 'master_sanksi'
        ];
        $join = [
            'join_2' => 'master_sanksi.id_master_sanksi = sanksi.id_master_sanksi'
        ];
        return $this->M_Data->view_join($this->kpi,$table,$join,$where);
    }

    function history($user,$output,$total){
        $periode = explode(' ', $this->get('output'));
        $where = [
            'id_user' => $user,
            'history_tahun' => $periode[1]
        ];
        $history = $this->M_Data->view_detail($this->kpi,'history',$where);
        if(empty($history)){
            $data = [
                'id_user' => $user,
                'history_'.$periode[0] => $total,
                'history_tahun' => $periode[1]
            ];
            $this->M_Data->insert_data($this->kpi,'history',$data);
        }else{
            $data = [
                'history_'.$periode[0] => $total
            ];
            $where = [
                'id_user' => $user,
                'history_tahun' => $periode[1],
            ];
            $this->M_Data->update_data($this->kpi,'history',$data,$where);
        }
    }

    function nilai_corporate($data){
        $indicator = $this->M_Data->view_data($this->master,'persentase');
        $arr = [];
        $kategori_nilai = [];
        foreach($data as $index => $n){
            $arr[$index] = $n;
            
            if($n->nilai_jenis == "Persentase"){
                $nilai = $n->corporate_tercapai / $n->corporate_target * 100;
            }else{
                $nilai = (float) $n->corporate_tercapai;
            }

            foreach ($n as $index_nilai => $value) {
                if(strpos($index_nilai, 'nilai_') !== false){
                    if($value != ""){
                        $kategori_nilai[$index][ str_replace('nilai_', '', $index_nilai)] = $value;
                    }
                }
            }

            unset($kategori_nilai[$index]["jenis"]);
            
            if($kategori_nilai[$index][4] < $kategori_nilai[$index][10]){
                arsort($kategori_nilai[$index]);
                foreach ($kategori_nilai[$index] as $standart => $x) {
                    if($nilai >= $x){
                        break;
                    }
                }
                $persentase = ($n->corporate_tercapai / $n->corporate_target) * 100;
            }else{
                krsort($kategori_nilai[$index]);
                foreach ($kategori_nilai[$index] as $standart => $x) {
                    if($nilai <= $x){
                        break;
                    }
                }
                if($n->corporate_target != 0){
                    $persentase = ($n->corporate_target - ($n->corporate_tercapai - $n->corporate_target)) / $n->corporate_target * 100;
                }else{
                    $persentase = null;
                }
            }
            $total = $standart * $n->corporate_bobot;
            foreach($indicator as $color){
                if(!empty($color->persentase_akhir)){
                    if($persentase >= $color->persentase_awal && $persentase <= $color->persentase_akhir){
                        $warna = $color->persentase_indikator;
                        break;
                    }
                }else if($persentase >= $color->persentase_awal){
                    $warna = $color->persentase_indikator;
                    break;
                }
            }
            $arr[$index]->color = $warna;
            $arr[$index]->total = $total;
            $arr[$index]->persentase = round($persentase);
        }
        return $arr;
    }

    function total($corporate,$tasklist,$sanksi){
        $indicator = $this->M_Data->view_data($this->master,'kpi_indikator');
        
        $total_corporate = 0;
        foreach($corporate as $n){
            $total_corporate += $n->total;
        }
        
        $total_tasklist = 0;
        foreach($tasklist as $n){
            $total_tasklist += $n->tasklist_bobot;
        }
    
        $total_seluruh = $total_corporate + $total_tasklist - (!empty($sanksi) ? $sanksi[0]->sanksi_nilai : 0);
        
        foreach($indicator as $n){
            if(!empty($n->indikator_akhir)){
                if($total_seluruh >= $n->indikator_awal && $total_seluruh <= $n->indikator_akhir){
                    $warna = $n->indikator_terminologi;
                    $terminologi = $n->indikator_nama;
                    break;
                }
            }else if($total_seluruh >= $n->indikator_awal){
                $warna = $n->indikator_terminologi;
                $terminologi = $n->indikator_nama;
                break;
            }
        }
        return $arr = [
            'total' => $total_seluruh,
            'warna' => $warna,
            'terminologi' => $terminologi
        ];
    }

    // function corporate_get(){
    //     $table = [
    //         'table_1' => $this->corporate,
    //         'table_2' => 'master_data.kpi_corporate',
    //         'table_3' => 'master_data.kpi_kategori',
    //         'table_4' => 'nilai_corporate',
    //     ];
    //     $join = [
    //         'join_2' => 'master_data.kpi_corporate.id_corporate = corporate.id_corporate',      
    //         'join_3' => 'master_data.kpi_corporate.id_kategori = master_data.kpi_kategori.id_kategori',
    //         'join_4' => 'corporate.key_corporate = nilai_corporate.key_corporate'
    //     ];
    //     $where = [
    //         $this->corporate.'.id_user' => $this->get('id_user'),
    //         $this->corporate.'.corporate_output' => $this->get('output')
    //     ];
    //     $data = $this->M_Data->view_join($this->kpi,$table,$join,$where);
    //     if(empty($data)){
    //         $response = [
    //             'status' => 502,
    //             'error' => true,
    //             'data' => $data,
    //             'msg' => 'Data Tidak Ditemukan'
    //         ];
    //     }else{
    //         $response = [
    //             'status' => 200,
    //             'error' => false,
    //             'data' => $data
    //         ];
    //     }
    //     $this->response($response);
    // }

    // function tasklist_get(){
    //     $where = [
    //         'id_user' => $this->get('id_user'),
    //         'tasklist_done' => $this->get('done')
    //     ];
    //     $data = $this->M_Data->view_detail($this->kpi,'tasklist',$where);
    //     if(empty($data)){
    //         $response = [
    //             'status' => 502,
    //             'error' => true,
    //             'data' => $data,
    //             'msg' => 'Data Tidak Ditemukan'
    //         ];
    //     }else{
    //         $response = [
    //             'status' => 200,
    //             'error' => false,
    //             'data' => $data
    //         ];
    //     }
    //     $this->response($response);
    // }

    // function sanksi_get(){
    //     $where = [
    //         'sanksi.id_user' => $this->get('id_user'),
    //         'sanksi.sanksi_output' => $this->get('output')
    //     ];
    //     $table = [
    //         'table_1' => 'sanksi',
    //         'table_2' => 'master_sanksi'
    //     ];
    //     $join = [
    //         'join_2' => 'master_sanksi.id_master_sanksi = sanksi.id_master_sanksi'
    //     ];
    //     $data = $this->M_Data->view_join($this->kpi,$table,$join,$where);
    //     if(empty($data)){
    //         $response = [
    //             'status' => 502,
    //             'error' => true,
    //             'data' => $data,
    //             'msg' => 'Data Tidak Ditemukan'
    //         ];
    //     }else{
    //         $response = [
    //             'status' => 200,
    //             'error' => false,
    //             'data' => $data
    //         ];
    //     }
    //     $this->response($response);
    // }
}

?>