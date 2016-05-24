<?php

class linh_vuc_thong_ke_Controller extends Controller {

    function __construct() {
        parent::__construct('admin','linh_vuc_thong_ke');
        $this->check_login();
        $this->model->goback_url = $this->view->get_controller_url();
        $this->view->show_left_side_bar = FALSE;
        $this->view->arr_count_article = $this->model->gp_qry_count_article();
        //$this->view->template->show_div_website = FALSE;
        
        session::init();
        $v_lang_id = session::get('session_lang_id');
        $this->view->arr_all_lang = $this->model->qry_all_lang();
        $this->view->arr_all_grant_website = $this->model->gp_qry_all_website_by_user($v_lang_id);
        if(session::check_permission('QL_LINH_VUC_THONG_KE')==FALSE)
        {
            die('Bạn không có quyền thực hiện chức năng này !!!');
        }
    }
    public function main() {
        $this->qry_all_linh_vuc_thong_ke();
    }

    public function qry_all_linh_vuc_thong_ke() 
    {
        $VIEW_DATA['arr_all_linh_vuc_thong_ke'] = $this->model->qry_all_linh_vuc_thong_ke();
        $this->view->render('dsp_all_linh_vuc_thong_ke',$VIEW_DATA);
    }

    public function dsp_single_linh_vuc_thong_ke($v_id_linh_vuc_thong_ke) 
    {
        is_id_number($v_id_linh_vuc_thong_ke) OR $v_id_linh_vuc_thong_ke = 0;
        $VIEW_DATA['arr_single_linh_vuc_thong_ke']                                = $this->model->qry_single_linh_vuc_thong_ke($v_id_linh_vuc_thong_ke);
        $this->view->render('dsp_single_linh_vuc_thong_ke',$VIEW_DATA);
    }
    
    public function update_linh_vuc_thong_ke() 
    {
        $this->model->update_linh_vuc_thong_ke();
    }

    public function delete_linh_vuc_thong_ke() 
    {
        $this->model->delete_linh_vuc_thong_ke();
    }
    

}
?>

