<?php class Upload_model extends CI_Model {
    
    public function __construct() {
        $this->load->database();
    }
    
    // insert items
    public function setIcon($data = array()){
        $insert = $this->db->insert('favicon', $data);
        if($insert){
            return $this->db->insert_id();
        }else{
            return false;    
        }
    }
    
    // get last 10 public items 
    public function lastFavicon() {
        $this->db->select('*');
        $this->db->from('favicon');
        $this->db->where('public', 1);
        $this->db->order_by('id', 'DESC');
        $this->db->limit(30);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    // get otal favicon generated
    public function getTotalFavicon(){
        return $this->db->count_all('favicon');
    }
    
}