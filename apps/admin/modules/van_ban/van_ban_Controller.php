<?php

class van_ban_Controller extends Controller {

    function __construct() {
        parent::__construct('admin','van_ban');
        $this->check_login();
        $this->model->goback_url = $this->view->get_controller_url();
        $this->view->show_left_side_bar = FALSE;
        $this->view->arr_count_article = $this->model->gp_qry_count_article();
        //$this->view->template->show_div_website = FALSE;
        
        session::init();
        $v_lang_id = session::get('session_lang_id');
        $this->view->arr_all_lang = $this->model->qry_all_lang();
        $this->view->arr_all_grant_website = $this->model->gp_qry_all_website_by_user($v_lang_id);
        if(session::check_permission('QL_VAN_BAN')==FALSE)
        {
            die('Bạn không có quyền thực hiện chức năng này !!!');
        }
    }
    public function main() {
        $this->qry_all_van_ban();
    }

    public function qry_all_van_ban() 
    {
        $VIEW_DATA['arrStatistics'] =  $this->model->qry_all_statistics(); // linh vuc thong ke
        $VIEW_DATA['arrOrganization'] =  $this->model->qry_all_organization(); // co quan ban hanh
        $VIEW_DATA['arrDocType'] =  $this->model->qry_all_doc_type(); // co quan ban hanh
        $VIEW_DATA['arr_all_van_ban'] = $this->model->qry_all_van_ban();
        
        $this->view->render('dsp_all_van_ban',$VIEW_DATA);
    }

    public function dsp_single_van_ban($v_id_van_ban) 
    {
        is_id_number($v_id_van_ban) OR $v_id_van_ban = 0;
        $VIEW_DATA['arr_single_van_ban']  = $this->model->qry_single_van_ban($v_id_van_ban);
        
        $VIEW_DATA['arr_all_co_quan_ban_hanh']      = $this->model->qry_all_co_quan_ban_hanh($v_id_van_ban);
        $VIEW_DATA['arr_all_linh_vuc_thong_ke']     = $this->model->qry_all_linh_vuc_thong_ke($v_id_van_ban);
        $VIEW_DATA['arr_all_attachment']            = $this->model->qry_all_attachment($v_id_van_ban);
        
        $this->view->render('dsp_single_van_ban',$VIEW_DATA);
    }
    
    public function update_van_ban() 
    {
        $this->model->update_van_ban();
    }

    public function delete_van_ban() 
    {
        $this->model->delete_van_ban();
    }
    

}
?>

