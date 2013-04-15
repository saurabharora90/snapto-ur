<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI

class Createalbum extends CI_Controller {

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

 function index()
 {
     $data = $this->getSessionData();
     $data['error']= '';
     $this->load->view('user/album/createalbum_view', $data);
 }

 function storeAlbum()
 {
     //can only be called via a ajax request
     if($this->input->is_ajax_request())
     {
         $this->load->model('album/Createalbum_model');
         $data = $this->getSessionData();
         $data['albumName'] = $this->input->post('albumName');
         $data['privacy'] = $this->input->post('privacy');

         if(!$this->Createalbum_model->createAlbumDatabase($data))
            echo "You already have an album with this name";
     }
     else
        show_404('album/createalbum/storeAlbum');
 }
}
?>