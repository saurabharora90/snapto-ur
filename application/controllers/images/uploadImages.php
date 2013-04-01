<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI

class uploadImages extends CI_Controller {

 function __construct()
 {
   parent::__construct();

   if($this->session->userdata('logged_in'));
   else
   {
       //If no session, redirect to login page
     redirect('login', 'refresh');
   }
 }

 private function getSessionData()
 {
     $session_data = $this->session->userdata('logged_in');
     $data['username'] = $session_data['username'];
     $data['name'] = $session_data['name'];
     return $data;
 }

 function upload()
 {
     //can only be access by a ajax request
     if($this->input->is_ajax_request())
     {
         $this->load->model('images/uploadImagesModel');
         $data = $this->getSessionData();
         $data['albumName'] = $this->input->post('albumName');
         $data['privacy'] = $this->input->post('privacy');

         $this->uploadImagesModel->uploadImages($data);
     }
     else
        show_404('images/uploadimages/upload');
 }
}
?>