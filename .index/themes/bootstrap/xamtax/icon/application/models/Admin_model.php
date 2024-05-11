<?php
class Admin_model extends CI_Model {
    
    public function __construct() {
        $this->load->database();
    }
    
    // get result with status 1
    public function getAll() {
        $this->db->select('*');
        $this->db->from('favicon');
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function find($image_name) {
        $query = $this->db->get_where('favicon', array('image_name'=>$image_name));
        return $query->row_array();
    }
    
}