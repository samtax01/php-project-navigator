<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Upload extends CI_Controller {

	/**
    // LabNetwork Properties
    // Buy my scripts on https://codecanyon.net/user/labnetwork
    // ** You can not resell this work to a third party **
    **/
    public function __construct() {
        parent::__construct();
    }
    
	public function index() {
        // check if the image is missing
        if(empty($_FILES['image_name']['name'])) {
            $this->form_validation->set_rules('image_name', 'Image', 'required');
        }
        // check if the url is missing
        $this->form_validation->set_rules('url', 'Url', 'required|valid_url');

        if ($this->form_validation->run() === TRUE) {
            // if the fields are correct you will proceed
            $config['upload_path'] = './upload/';
            $config['allowed_types'] = 'gif|jpg|png|ico';
            $config['file_name'] = 'favicon.ico';
            $config['encrypt_name'] = TRUE;
            
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('image_name')) {
                echo $this->upload->display_errors();
                $this->load->view('index'); 
            } else {
                // get image data
                $image_data = $this->upload->data();
                $config['image_library'] = 'gd2';
                $config['source_image'] = $image_data['full_path'];
                $config['maintain_ratio'] = TRUE;
                $config['width'] = 16;
                $config['height'] = 16;
                
                $this->load->library('image_lib', $config);
                
                if (!$this->image_lib->resize()) {
                    echo $this->image_lib->display_errors();
                } else {
                    // the data is inserted into the database
                    $data = array(
                        'image_name' => $image_data['raw_name'],
                        'url' => prep_url($this->input->post('url')),
                        'ip_address' => $this->input->ip_address(),
                        'public' => $this->input->post('public') ? 1 : 2,
                        'created' => time()
                    );
                    $this->upload_model->setIcon($data);
                    
                    // Download the file to your desktop
                    //$path = $upload_data['full_path'];
                    //$this->zip->read_file($path);
                    //$this->zip->download('favicon.zip');
    
                    $data = array('upload_data' => $this->upload->data());
                    $this->load->view('themes/default/results', $data);
   
                }
            }   
        } else {
            $data['title'] = $this->lang->line('index_title');
            $data['desc'] = $this->lang->line('index_desc');
            // get last favicons
            $data['favicon'] = $this->upload_model->lastFavicon();
            $this->load->view('themes/default/header', $data);
            $this->load->view('index', $data);   
            $this->load->view('themes/default/footer');
        } 
    }
    
    public function download($image_name = null) {
        // if image_name is empty, redirect
        if (empty($image_name)) {
            redirect('');
        }
        // download zip 
        $path = './upload/'.$image_name;
        $this->zip->read_file($path);
        $this->zip->download('favicon.zip');       
    }
        
    
}