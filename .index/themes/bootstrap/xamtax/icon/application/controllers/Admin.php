<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        if(!$this->ion_auth->is_admin()) {
            redirect('admin/login');
        }
        
        $data['title'] = 'Admin';
        $data['desc'] = 'Area Admin';
        $data['all'] = $this->admin_model->getAll();
        $this->load->view('themes/default/header', $data);
        $this->load->view('themes/default/admin/index', $data);
    }
    
    // login
	public function login() {
		$data['title'] =  'Login - Admin';
        $data['desc'] = 'Login for Admin Area';
		//validate form input
		$this->form_validation->set_rules('identity', str_replace(':', '', $this->lang->line('login_identity_label')), 'required');
		$this->form_validation->set_rules('password', str_replace(':', '', $this->lang->line('login_password_label')), 'required');

		if ($this->form_validation->run() == true) {
			// check to see if the user is logging in
			// check for "remember me"
			$remember = (bool) $this->input->post('remember');

			if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember)) {
				//if the login is successful
				//redirect them back to the home page
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect('admin/index', 'refresh');
			} else {
				// if the login was un-successful
				// redirect them back to the login page
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect('admin/login', 'refresh'); // use redirects instead of loading views for compatibility with MY_Controller libraries
			}
		} else {
			// the user is not logging in so display the login page
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$this->data['identity'] = array('name' => 'identity',
				'id'    => 'identity',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('identity'),
			);
			$this->data['password'] = array('name' => 'password',
				'id'   => 'password',
				'type' => 'password',
			);
            $this->load->view('themes/default/header', $data);
			$this->load->view('themes/default/admin/login', $data);
            $this->load->view('themes/default/footer');
		}
	}
    
    // logout 
    public function logout() {
		$logout = $this->ion_auth->logout();
		$this->session->set_flashdata('message', $this->ion_auth->messages());
		redirect('admin/login', 'refresh');
	}
    
    // edit account
	public function account() {
		$data['title'] = 'Account - Administrator';
        $data['desc'] = 'Area Admin';
        
        if(!$this->ion_auth->logged_in()) {
			redirect('admin/login');
		}

        // get current user
		$user = $this->ion_auth->user()->row();

		// validate form input
		$this->form_validation->set_rules('email', 'Email', 'required');

		if (isset($_POST) && !empty($_POST)) {
			// do we have a valid request?
			if ($this->_valid_csrf_nonce() === FALSE) {
				show_error($this->lang->line('error_csrf'));
			}

			// update the password if it was posted
			if ($this->input->post('password')) {
				$this->form_validation->set_rules('password', 'New Password', 'required|min_length[5]|matches[password_confirm]');
				$this->form_validation->set_rules('password_confirm', 'Confirm New Password', 'required');
			}

			if ($this->form_validation->run() === TRUE) {
				$data = array(
					'email' => $this->input->post('email'),
				);

				// update the password if it was posted
				if($this->input->post('password')) {
					$data['password'] = $this->input->post('password');
				}

                
			    if($this->ion_auth->update($user->id, $data)){
                    $this->session->set_flashdata("message","<div class='alert alert-success'>Updated successfully!</div>"); 
                } else {
                    $this->session->set_flashdata("message","<div class='alert alert-danger'>We found errors, try again.</div>"); 
                }
                redirect('admin/account', 'refresh');

			}
		}

		// display the edit user form
		$data['csrf'] = $this->_get_csrf_nonce();

		// set the flash data error message if there is one
		$data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		// pass the user to the view
		$data['user'] = $user;

		$data['email'] = array(
			'name'  => 'email',
			'id'    => 'email',
			'type'  => 'email',
			'value' => $this->form_validation->set_value('email', $user->email),
            'placeholder' => 'Email',
            'class' => 'form-control'
		);
		$data['password'] = array(
			'name' => 'password',
			'id'   => 'password',
			'type' => 'password',
            'placeholder' => 'New Password',
            'class' => 'form-control'
		);
		$data['password_confirm'] = array(
			'name' => 'password_confirm',
			'id'   => 'password_confirm',
			'type' => 'password',
            'placeholder' => 'Repeat New Password',
            'class' => 'form-control'
		);

        $this->load->view('themes/default/header', $data);
		$this->load->view('themes/default/admin/account', $data);
        $this->load->view('themes/default/footer');
	}
    
    public function _get_csrf_nonce() {
		$this->load->helper('string');
		$key   = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);

		return array($key => $value);
	}

	public function _valid_csrf_nonce() {
		$csrfkey = $this->input->post($this->session->flashdata('csrfkey'));
		if ($csrfkey && $csrfkey == $this->session->flashdata('csrfvalue'))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
    
    // delete items
    public function delete($image_name) {
        
        if (!$this->ion_auth->is_admin()) {
			redirect('admin/login');
		}
        
        $path = './upload/'.$image_name.".ico";

        if(file_exists($path)) {
            unlink($path);
            $this->db->delete('favicon', array('image_name' => $image_name));
            $this->session->set_flashdata("message","<div class='ui green message'>This obituary has been successfully deleted!</div>"); 
        } else {
            echo "Errors have been found, try again!";
        }
        redirect('admin/index');
    }
    
    // update status active/inactive
    public function status($image_name) {
        
        if (!$this->ion_auth->is_admin()) {
			redirect('admin/login');
		}
        
        // get specific items to get the status value
        $item = $this->admin_model->find($image_name);
        
        if($item['public'] == 1) { //if active
            $data = array(
                'public' => 2,
            );
            $this->db->update('favicon', $data, array('image_name' => $image_name)); //update
            redirect('admin/index'); //and redirect
        } elseif($item['public'] == 2) { //if inactive
            $data = array(
                'public' => 1,
            );
            $this->db->update('favicon', $data, array('image_name' => $image_name)); //update
            redirect('admin/index'); //and redirect
        } else {
            redirect('admin/index');
        }
    } 
    
    
}