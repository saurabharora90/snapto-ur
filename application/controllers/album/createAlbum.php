
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
     $this->load->helper('form');
     $this->load->view('user/album/createAlbum_view', $data);
 }

 function uploadImages()
 {
    $userfiles[] = $this->input->post('userfiles[]');
    return $userfiles;
    $config['upload_path'] = './uploads/images/';
    $config['allowed_types'] = 'gif|jpg|png';
	$config['max_size']	= 0; //limit upload size to php.ini
	//$config['max_width']  = '1024';
	//$config['max_height']  = '768';

	$this->load->library('upload', $config);
    //foreach($userfile in $userfiles[])
    //{
    //    if ( ! $this->upload->do_upload())
	   // {   
		  //  $error = array('error' => $this->upload->display_errors());
    //        //$this->load->view('upload_form', $error);
    //        return $error;
	   // }   
    //}

	$data = array('upload_data' => $this->upload->data());
    //$this->load->view('upload_success', $data);
    return $data;
 }

}

?>