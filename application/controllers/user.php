
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI

class User extends CI_Controller {

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
 
    $this->load->model('userModel');
    $data['album_infos'] = $this->userModel->getAlbums($data['username']);

    $this->load->view('user/user_view', $data);
 }

 function logout()
 {
   $this->session->unset_userdata('logged_in');
   session_destroy();
   redirect('home', 'refresh');
 }

 function createAlbum()
 {
     $this->load->helper(array('form', 'url'));
     $data = $this->getSessionData();
     $data['error']= '';
     $this->load->view('user/createAlbum_view', $data);
 }

 function uploadImages()
 {
     
 }

}

?>