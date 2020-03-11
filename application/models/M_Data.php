<?php

Class M_Data extends CI_Model{
    
    function insert_data($db,$table,$data){
        $db->insert($table,$data);
        return $db->affected_rows();
    }

    function update_data($db,$table,$data,$where){
        $db->where($where);
        $db->update($table,$data);
        return $db->affected_rows();
    }

    function view_data($db,$table){
        return $db->get($table)->result();
    }

    function view_detail($db,$table,$where){
        return $db->get_where($table,$where)->result();
    }
    
    function view_tasklist($db,$table,$where,$or_where){
        $db->select('*');
        $db->from($table);
        $db->where($where);
        $db->or_where($or_where);
        return $db->get()->result();
    }
   
    function view_progress($db,$table,$where,$id){
        $db->order_by($id, 'DESC');
        return $db->get_where($table,$where)->result();
    }

    function delete_data($db,$table,$where){
        $db->where($where);
        $db->delete($table);
    }

    function view_join($db,$table,$join,$where){
        $db->select('*');
        $db->from($table['table_1']);
        $db->join($table['table_2'], $join['join_2']);
        if(count($table) >= 3){
            for($i=3; $i <= count($table); $i++){
                $db->join($table['table_'.$i], $join['join_'.$i]);
            }
        }
        if($where != null){
            $db->where($where);
        }
        return $db->get()->result();
    }
    
    function view_join_tiga($table_A,$table_B,$table_C,$id_A,$id_B,$where){
        $this->db->select('*');
        $this->db->from($table_A.' a');
        $this->db->join($table_B.' b', 'b.'.$id_A.'=a.'.$id_A);
        $this->db->join($table_C.' c', 'c.'.$id_B.'=a.'.$id_B);
        $this->db->where($where);
        return $this->db->get()->result();
    }

    function registrasi_perusahaan($db,$table_A,$table_B,$data){
        $db->insert($table_A,$data);
        $id = $db->insert_id();
        $result = [
            'user_id' => $id,
            'key' => $data['perusahaan_auth']
        ];
        $db->insert($table_B,$result);
        return $id;
    }
    
    function create_user($db,$table,$data){
        $db->insert($table,$data);
        $id = $db->insert_id();
        return $id;
    }
    
    function get_total($table,$id,$where){
        $this->db->select('sum('.$id.') as total');
        return $this->db->get_where($table,$where)->result();
    }

    function graph($db,$table,$where,$date){
        $db->select('progress_tercapai, progress_create_at');
        $db->like('progress_create_at', $date, 'before');
        return $db->get_where($table,$where)->result();
    }
}
?>