<?php

class medical_register_Controller extends Controller {

    function __construct() {
        parent::__construct('admin','medical_register');
        $this->check_login();
        $this->model->goback_url = $this->view->get_controller_url();
        $this->view->show_left_side_bar = FALSE;
        $this->view->arr_count_article = $this->model->gp_qry_count_article();
        //$this->view->template->show_div_website = FALSE;
        
        session::init();
        $v_lang_id = session::get('session_lang_id');
        $this->view->arr_all_lang = $this->model->qry_all_lang();
        $this->view->arr_all_grant_website = $this->model->gp_qry_all_website_by_user($v_lang_id);
        if(session::check_permission('QL_MEDICAL_REGISTER') == FALSE)
        {
            die('Bạn không có quyền thực hiện chức năng này !!!');
        }
    }
    public function main() {
        $this->view->render('dsp_main');
    }
    
}

