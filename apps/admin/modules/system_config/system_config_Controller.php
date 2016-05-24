<?php

defined('DS') or die('no direct access');

class system_config_Controller extends Controller
{

    function __construct()
    {
        parent::__construct('admin', 'system_config');
        Session::init();
        Session::get('user_id') or $this->login_admin();
        if(session::check_permission('QL_HE_THONG',FALSE)==FALSE)
        {
            die('Bạn không có quyền thực hiện chức năng này !!!');
        }
        $v_lang_id                                   = session::get('session_lang_id');
        $this->view->arr_all_lang          = $this->model->qry_all_lang();
        $this->view->arr_all_grant_website = $this->model->gp_qry_all_website_by_user($v_lang_id);
        $this->view->arr_count_article     = $this->model->gp_qry_count_article();
    }

    function main()
    {
        $data['xml_data'] = $this->model->qry_data();
        
        $this->view->render('dsp_main', $data);
    }
    
    function update_options()
    {
        $this->model->update_options();
    }

}

?>
