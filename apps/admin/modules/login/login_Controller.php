<?php if (!defined('SERVER_ROOT')) exit('No direct script access allowed');

class login_Controller extends Controller {
     function __construct() {
        parent::__construct('admin', 'login');
        $this->model->goback_url = $this->view->get_controller_url();
    }

    public function main()
    {
        $this->dsp_login();
    }

    public function dsp_login()
    {
        $this->view->set_layout('pop_win_layout')->render('dsp_login');
    }

    public function do_login()
    {
        $this->model->goback_url = $this->view->get_controller_url();
        $this->model->do_login();
    }
    public function do_logout(){
        @session::init();
        session::destroy();
        $this->dsp_login();
    }
}