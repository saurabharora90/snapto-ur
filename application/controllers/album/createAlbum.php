<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI

class createAlbum extends CI_Controller {

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
     $this->load->view('user/album/createAlbum_view', $data);
 }

 function uploadImages()
 {
     //var_dump($_FILES);
     $this->load->model('album/createAlbumModel');
     $data = $this->getSessionData();
     $data['albumName'] = $this->input->post('albumName');
     $data['privacy'] = $this->input->post('privacy');

     $this->createAlbumModel->uploadImages($data);
 }
}
?>