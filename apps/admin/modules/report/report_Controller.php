<?php
defined('DS') or die('no direct access');

class report_Controller extends Controller 
{
    function __construct() 
    {
        parent::__construct('admin', 'report');
         Session::init();
        Session::get('user_id') or $this->login_admin();
        $v_lang_id                                   = session::get('session_lang_id');
        $this->view->arr_all_lang          = $this->model->qry_all_lang();
        $this->view->arr_count_article     = $this->model->gp_qry_count_article();
        $this->view->arr_all_grant_website = $this->model->gp_qry_all_website_by_user($v_lang_id);

        $this->model->goback_url = $this->view->get_controller_url();
    }
    
    
    public function main()
    {
       $this->all_evaluation();
    }
    /*
     * Hien thi giao dien bao cao chi tiet tinh hình giai quyet thu tuc hanh chinh
     */
    public function report_single_recordtype()
    {
        $this->view->function_active = __FUNCTION__;
        if(session::check_permission('QL_BAO_CAO_CHI_TIET_GIAI_QUYET_THU_TUC_HANH_CHINH',FALSE)==FALSE)
        {
            die('Bạn không có quyền thực hiện chức năng này !!!');
        }
        
        $VIEW_DATA['arr_all_member']      = $this->model->qry_all_member();
        $VIEW_DATA['arr_year']            = $this->model->qry_all_year();
        $VIEW_DATA['arr_all_record_list_type'] = $this->model->qry_all_record_list_type();            
//        $VIEW_DATA['arr_all_record_type'] = $this->model->qry_all_record_type();            
        
        $this->view->render('report_single_recordtype',$VIEW_DATA);
    }
    /*
     * Hiển thị giao dien in bao cao chi tiết tinh hình giải quyết thủ tục hành chính
     */
    public function print_single_recordtype()
    {
        $v_district = get_request_var('district',0);
        $v_month    = get_request_var('month',0);
        $v_year     = get_request_var('year',date('Y'));
        $v_quarter  = get_request_var('quarter',0);
        $v_record_list_type = get_request_var('sel_record_list_type',0);
        
        $v_record_list_type = (intval($v_record_list_type) > 0) ? $v_record_list_type : 0;
        
        $arr_filter  = array(
                            'district' =>$v_district,
                            'month'    =>$v_month,
                            'year'     =>$v_year,
                            'quarter'  =>$v_quarter,
                            'sel_record_list_type' =>$v_record_list_type
        );
        
        
        $VIEW_DATA['arr_all_report_data'] = $this->model->qry_single_synthesis_record($arr_filter);
        
        $report_group      = 'PK_MEMBER';
        $report_group_name = 'C_NAME';
        $VIEW_DATA['report_group']      = $report_group;
        $VIEW_DATA['report_group_name'] = $report_group_name;
        
        $VIEW_DATA['report_title']      = 'BÁO CÁO CHI TIẾT GIẢI QUYẾT THỦ TỤC HÀNH CHÍNH';
        $VIEW_DATA['v_unit_name']       = mb_strtoupper(get_system_config_value(CFGKEY_UNIT_NAME),"UTF-8");
        $VIEW_DATA['begin_date_to_end_date']       = (($v_month >0) ? "Tháng $v_month" : (($v_quarter >0) ? "Quý $v_quarter" : '')) ? (($v_month >0) ? "Tháng $v_month" : (($v_quarter >0) ? "Quý $v_quarter" : ''))  . ' năm '.$v_year : ' Năm '.$v_year ;
        $VIEW_DATA['report_code']         = 'report_single_recordtype';
        $this->view->set_layout(null)->render('dsp_common_pdf_report',$VIEW_DATA);
    }

     /*
     * Hiển thị giao dien in bao cao tong hop tinh hình giải quyết thủ tục hành chính
     */
    public function print_all_recordtype()
    {
        $v_district = get_request_var('district',0);
        $v_month    = get_request_var('month',0);
        $v_year     = get_request_var('year',date('Y'));
        $v_quarter  = get_request_var('quarter',0);
        
        $arr_filter  = array(
                            'district' =>$v_district,
                            'month'    =>$v_month,
                            'year'     =>$v_year,
                            'quarter'  =>$v_quarter,
        );
        
        $VIEW_DATA['report_code']        = 'report_all_recordtype';
        $VIEW_DATA['arr_all_report_data'] = $this->model->qry_all_synthesis_record($arr_filter);
        $VIEW_DATA['report_title']      = 'BÁO CÁO TỔNG HỢP GIẢI QUYẾT THỦ TỤC HÀNH CHÍNH';
        $VIEW_DATA['v_unit_name']       = mb_strtoupper(get_system_config_value(CFGKEY_UNIT_NAME),"UTF-8");
        $VIEW_DATA['begin_date_to_end_date']       = (($v_month >0) ? "Tháng $v_month" : (($v_quarter >0) ? "Quý $v_quarter" : '')) ? (($v_month >0) ? "Tháng $v_month" : (($v_quarter >0) ? "Quý $v_quarter" : ''))  . ' năm '.$v_year : ' Năm '.$v_year ;
        $this->view->set_layout(null)->render('dsp_common_pdf_report',$VIEW_DATA);
    }
    
    /**
     * Hien thị giao dien bao cao tong hop tinh tinh giai quyet thu tuc hanh chinh
     */
    public function report_all_recordtype()
    {
        $this->view->function_active = __FUNCTION__;
        if(session::check_permission('QL_BAO_CAO_TONG_HOP_GIAI_QUYET_THU_TUC_HANH_CHINH',FALSE)==FALSE)
        {
            die('Bạn không có quyền thực hiện chức năng này !!!');
        }
        $VIEW_DATA = array();
        
        $VIEW_DATA['arr_all_member']         = $this->model->qry_all_member();
        $VIEW_DATA['arr_year']            = $this->model->qry_all_year();
        $this->view->render('report_all_recordtype',$VIEW_DATA);
    }
    
    public function single_evaluation()
    {
       $this->view->function_active = __FUNCTION__;
       $VIEW_DATA = array();
       $VIEW_DATA['arr_all_member']         = $this->model->qry_all_member();
       $this->view->render('dsp_report_single_evaluation',$VIEW_DATA);
        
    }
    public function print_evaluation_single()
    {
        if(session::check_permission('QL_BAO_CHI_TIET_DANH_GIA_CAN_BO',FALSE)==FALSE)
        {
            die('Bạn không có quyền thực hiện chức năng này !!!');
        }
        $v_district    = get_request_var('district',0);
        $v_begin_date  = get_request_var('txt_begin_date',date('d/m/Y'));
        $v_end_date    = get_request_var('txt_end_date',date('d/m/Y'));
        
        $arr_filter  = array(
                            'txt_begin_date' => $v_begin_date,
                            'txt_end_date'   => $v_end_date,
                            'district'       => $v_district
        );
       
        $VIEW_DATA = array();
        $VIEW_DATA['arr_all_report_data'] = $this->model->qry_single_evaluation($arr_filter);
        
        $report_group      = 'PK_MEMBER';
        $report_group_name = 'C_NAME_MEMBER';
        $VIEW_DATA['report_group']      = $report_group;
        $VIEW_DATA['report_group_name'] = $report_group_name;
            
        $VIEW_DATA['report_title']      = 'BÁO CÁO TỔNG HỢP TÌNH HÌNH ĐÁNH GIÁ CÁN BỘ';
        $VIEW_DATA['v_unit_name']       = mb_strtoupper(get_system_config_value(CFGKEY_UNIT_NAME),"UTF-8");
        $VIEW_DATA['begin_date_to_end_date']   = "Từ ngày: $v_begin_date đến: $v_end_date";
        $VIEW_DATA['report_code']        = 'report_evaluation_single';

        $this->view->set_layout(null)->render('dsp_common_pdf_report',$VIEW_DATA);
    }

    public function all_evaluation()
    {
        $this->view->function_active = __FUNCTION__;
        $VIEW_DATA = array();
        $VIEW_DATA['arr_all_member']   = $this->model->qry_all_member();
        $VIEW_DATA['arr_year']         = $this->model->qry_all_year_evaluation();
        $this->view->render('dsp_report_all_evaluation',$VIEW_DATA);
    }
    
    public function dsp_report_all_evaluation()
    {
        if(session::check_permission('QL_BAO_TONG_HOP_DANH_GIA_CAN_BO',FALSE)==FALSE)
        {
            die('Bạn không có quyền thực hiện chức năng này !!!');
        }
        $v_district = get_request_var('district',0);
        $v_month    = get_request_var('month',0);
        $v_year     = get_request_var('year',date('Y'));
        $v_quarter  = get_request_var('quarter',0);
        
        $arr_filter  = array(
                            'district' =>$v_district,
                            'month'    =>$v_month,
                            'year'     =>$v_year,
                            'quarter'  =>$v_quarter,
        );
        
        $VIEW_DATA = array();
        $VIEW_DATA['arr_all_report_data'] = $this->model->qry_all_evaluation($arr_filter);
        
        $VIEW_DATA['report_title']      = 'BÁO CÁO TỔNG HỢP ĐÁNH GIÁ CÁN BỘ';
        $VIEW_DATA['v_unit_name']       = mb_strtoupper(get_system_config_value(CFGKEY_UNIT_NAME),"UTF-8");
        $VIEW_DATA['begin_date_to_end_date']       = (($v_month >0) ? "Tháng $v_month" : (($v_quarter >0) ? "Quý $v_quarter" : '')) ? (($v_month >0) ? "Tháng $v_month" : (($v_quarter >0) ? "Quý $v_quarter" : ''))  . ' năm '.$v_year : ' Năm '.$v_year ;
        $VIEW_DATA['report_code']       = 'report_1';

        $this->view->set_layout(null)->render('dsp_common_pdf_report',$VIEW_DATA);
    }
	    
}

?>
