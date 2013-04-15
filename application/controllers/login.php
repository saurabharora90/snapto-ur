<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	 function __construct()
     {
        parent::__construct();
     }
    
    public function index()
	{
        if($this->session->userdata('logged_in'))
            redirect('user','refresh');
        $this->load->helper(array('form'));
        $this->load->view("login_view");
	}

    public function verify()
    {
        $this->load->model('Login_model','',TRUE);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_check_database');

        if($this->form_validation->run() == FALSE)
        {
            //Field validation failed.&nbsp; User redirected to login page
            $this->load->view('login_view');
        }
        else
        {
            //Go to private area
            redirect('user', 'refresh');
        }
    }

    function check_database($password)
    {
        //Field validation succeeded.&nbsp; Validate against database
        $username = $this->input->post('username');

        //query the database
        $result = $this->Login_model->login_verify($username, $password);

        if($result)
        {
            $sess_array = array();
            foreach($result as $row)
            {
                $sess_array = array(
                'username' => $row->email,
                'name' => $row->name
            );
            $this->session->set_userdata('logged_in', $sess_array);
        }
        return TRUE;
        }
        else
        {
            $this->form_validation->set_message('check_database', 'Invalid username or password');
            return false;
        }
    }
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */
?>
