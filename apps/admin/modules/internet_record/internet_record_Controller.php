<?php
 
if (!defined('SERVER_ROOT'))
    exit('No direct script access allowed');

class internet_record_Controller extends Controller
{

    /**
     *
     * @var \record_type_Model 
     */
    public $model;

    /**
     *
     * @var \View 
     */
    public $view;

    function __construct()
    {
        parent::__construct('admin', 'internet_record');
        //Kiem tra session
        session::init();
        $this->check_login();
        
        //khoi tao goback_url
        $this->model->goback_url = $this->view->get_controller_url();
        
        $this->view->show_left_side_bar = FALSE;
        $this->view->arr_count_article = $this->model->gp_qry_count_article();
        
        $v_lang_id = session::get('session_lang_id');
        $this->view->arr_all_lang = $this->model->qry_all_lang();
        $this->view->arr_all_grant_website = $this->model->gp_qry_all_website_by_user($v_lang_id);
        
        if(session::check_permission('QL_DANH_DANH_HO_SO_NOP_TRUC_TUYEN',FALSE)==FALSE)
        {
            die('Bạn không có quyền thực hiện chức năng này !!!');
        }
    }

    private function _save_filter()
    {
        $v_filter        = $this->get_post_var('txt_filter','');
        $v_status        = $this->get_post_var('sel_status',-1);
        $v_member        = $this->get_post_var('sel_member',0);
        $v_internet      = $this->get_post_var('chk_internet',0);
        
        $v_rows_per_page = $this->get_post_var('sel_rows_per_page', _CONST_DEFAULT_ROWS_PER_PAGE);
        $v_page          = $this->get_post_var('sel_goto_page', 1);

        return array(
            'txt_filter'        => $v_filter,
            'sel_rows_per_page' => $v_rows_per_page,
            'sel_goto_page'     => $v_page,
            'sel_status'        => $v_status,
            'sel_member'        => $v_member,
            'chk_internet'      => $v_internet,
        );
    }

    public function main()
    {
        $this->dsp_all_record();
    }
    /**
     * hien thi danh sach ho so nop truc tuyen
     */
    public function dsp_all_record()
    {
        $record_type_id = get_post_var('hdn_record_type_id','');
        $member_id      = get_post_var('sel_member','');
        
        $VIEW_DATA['arr_all_record'] = $this->model->qry_all_record($record_type_id,$member_id);
        $VIEW_DATA['arr_all_notice'] = $this->model->qry_all_notice($member_id);
        $VIEW_DATA['arr_all_member'] = $this->model->qry_all_member();
        
        $this->view->render('dsp_all_record',$VIEW_DATA);
    }
    /**
     * hien thi chi tiet hs 
     */
    public function dsp_single_record()
    {
        $v_record_id = get_post_var('hdn_item_id',0);
        $VIEW_DATA['arr_single_record'] = $this->model->qry_single_record($v_record_id);
        $this->view->render('dsp_single_record',$VIEW_DATA);
    }
    /**
     * Xoa hs nop truc tuyen
     */
    public function do_delete_record()
    {
        $v_list_delete = get_post_var('hdn_item_id_list','');
        $this->model->do_delete_record($v_list_delete);
    }
    /**
     * thuc hien xac thuc hs 
     */
    public function do_confirm_record()
    {
        set_time_limit(0);
        ini_set("default_socket_timeout", 6000);
        ini_set("memory_limit","256M");
        //include class mail
        require SERVER_ROOT. DS . 'libs' . DS . 'mail_sender.php' ;
        
        $v_record_id = get_post_var('hdn_item_id',0);
        $this->model->do_confirm_record($v_record_id);
        
        //chuyen ho so ve 1 cua
        //lay xml data
        $arr_data = $this->model->get_xml_record_data($v_record_id);
        $ws_location    = $arr_data['ws_location'];
        $ws_uri         = $arr_data['ws_uri'];
        try {
            $client = new SoapClient($ws_location.'?wsdl', array('location' => $ws_location,
                                                'uri' => $ws_uri));
            $i = 0;
            while($i < 100)
            {
                $receive_record_result = $this->model->do_confirm($v_record_id,$client);
                if($receive_record_result)
                {
                    break;
                }
                $i++;
            }
        } catch (Exception $ex) {
            
        }
        
        $this->model->exec_done($this->model->goback_url);
    }
//end func
}