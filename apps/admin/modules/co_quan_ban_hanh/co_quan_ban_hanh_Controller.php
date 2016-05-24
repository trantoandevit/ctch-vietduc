<?php

class co_quan_ban_hanh_Controller extends Controller {

    function __construct() {
        parent::__construct('admin','co_quan_ban_hanh');
        $this->check_login();
        $this->model->goback_url = $this->view->get_controller_url();
        $this->view->show_left_side_bar = FALSE;
        $this->view->arr_count_article = $this->model->gp_qry_count_article();
        //$this->view->template->show_div_website = FALSE;
        
        session::init();
        $v_lang_id = session::get('session_lang_id');
        $this->view->arr_all_lang = $this->model->qry_all_lang();
        $this->view->arr_all_grant_website = $this->model->gp_qry_all_website_by_user($v_lang_id);
        if(session::check_permission('QL_CO_QUAN_BAN_HANH')==FALSE)
        {
            die('Bạn không có quyền thực hiện chức năng này !!!');
        }
    }
    public function main() {
        $this->qry_all_co_quan_ban_hanh();
    }

    public function qry_all_co_quan_ban_hanh() 
    {
        $VIEW_DATA['arr_all_co_quan_ban_hanh'] = $this->model->qry_all_co_quan_ban_hanh();
        $this->view->render('dsp_all_co_quan_ban_hanh',$VIEW_DATA);
    }

    public function dsp_single_co_quan_ban_hanh($v_id_co_quan_ban_hanh) 
    {
        is_id_number($v_id_co_quan_ban_hanh) OR $v_id_co_quan_ban_hanh = 0;
        $VIEW_DATA['arr_single_co_quan_ban_hanh']                                = $this->model->qry_single_co_quan_ban_hanh($v_id_co_quan_ban_hanh);
        $this->view->render('dsp_single_all_co_quan_ban_hanh',$VIEW_DATA);
    }
    
    public function update_co_quan_ban_hanh() 
    {
        $this->model->update_co_quan_ban_hanh();
    }

    public function delete_co_quan_ban_hanh() 
    {
        $this->model->delete_co_quan_ban_hanh();
    }
    

}
?>

