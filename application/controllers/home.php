<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class home extends CI_Controller {

	public function index()
	{
		$this->load->view('home_view.php');
	}
}

/* End of file home.php */
/* Location: ./application/controllers/welcome.php */