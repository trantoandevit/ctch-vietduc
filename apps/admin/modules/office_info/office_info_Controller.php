<?php
if (!defined('SERVER_ROOT')) exit('No direct script access allowed');

class office_info_Controller extends Controller {

    function __construct() 
    {
        parent::__construct('admin','office_info');
        $this->check_login();
        $this->model->goback_url                  = $this->view->get_controller_url();
        $this->view->template->show_left_side_bar = FALSE;
        $this->view->template->arr_count_article  = $this->model->gp_qry_count_article();
        //$this->view->template->show_div_website = FALSE;

        session::init();
        $v_lang_id                                   = session::get('session_lang_id');
        $this->view->template->arr_all_lang          = $this->model->qry_all_lang();
        $this->view->template->arr_all_grant_website = $this->model->gp_qry_all_website_by_user($v_lang_id);
        if(session::check_permission('XEM_DANH_SACH_THONG_TIN',0) == FALSE)
        {
            die('Bạn không có quyền thực hiện chức năng này !!!');
        }
        
    }
    
    function main() {
        $this->dsp_all_office_info();
    }
    /**
     * hien thi danh sach thong tin toa soan
     */
    function dsp_all_office_info()
    {
        $VIEW_DATA['arr_all_office_info'] = $this->model->qry_all_office_info();
        $this->view->render('dsp_all_office_info',$VIEW_DATA);
    }
    
    /**
     * lay du lieu cho tiet cua thong tin toa soan
     */
    function dsp_single_office_info()
    {
        $VIEW_DATA['arr_single_office_info'] = $this->model->qry_single_office_info();
        $this->view->render('dsp_single_office_info',$VIEW_DATA);
    }
    /**
     * cap nhat thong tin
     */
    function update_office_info()
    {
        $this->model->update_office_info();
    }
    /**
     * xoa thong tin toa soan
     */
    function delete_office_info()
    {
        if(session::check_permission('XOA_THONG_TIN',0) == FALSE)
        {
            die('Bạn không có quyền thực hiện chức năng này !!!');
        }
        
        $this->model->delete_office_info();
    }
}
?>