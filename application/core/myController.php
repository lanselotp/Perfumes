<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MyController extends CI_Controller
{
    public function sessionData() {
        $hasSessionId = $this->session->userdata('id');
        $role = (int)$this->session->userdata('role');
        
        if(is_null($hasSessionId)) {
            return false;
        }
        
        return array(
            'id' => $hasSessionId,
            'role' => $role
        );
    }
    
    // inherite user/admin method 
    public function permission($redirect = false) {
        $is_empty = $this->mainModel->validationUser();

        if($is_empty !== false){
            $sessionData = array(
                    'id' => $is_empty[0]->id,
                    'first_name' => $is_empty[0]->first_name,
                    'last_name' => $is_empty[0]->last_name,
                    'fullName' => $is_empty[0]->first_name.' '.$is_empty[0]->last_name,
                    'email' => $is_empty[0]->email,
                    'role' => $is_empty[0]->role,
                    'password' => $is_empty[0]->password,
                );            
                
                // user found
                $this->session->set_userdata($sessionData);

                if((int)$is_empty[0]->role === ADMIN){
                     redirect('admin/productPage');
                }
                if((int)$is_empty[0]->role === USER){
                    redirect('index');
                }
        }   
        else {
            $this->session->set_flashdata('error','Email or Password not match!');
            redirect(!$redirect ? 'login' : 'admin');
        }
    }
    
    public function currentPage($page, $message = '') {
        $this->load->view('header');
        $this->load->view($page, $message);
        $this->load->view('footer');
    }
    
    public function adminPage($page, $message = '') {
        $this->load->view('admin/header');
        $this->load->view($page, $message);
    }
    
}
    