<?php

require_once(SERVER_ROOT . DS . 'apps' . DS . 'frontend' . DS . 'themes' . DS . 'ctch-vietduc' . DS . 'recaptcha/recaptchalib.php');

class api_data_Controller extends Controller
{
    public function __construct()
    {
        parent::__construct('frontend', 'api_data');

        header("Content-Type: application/json");

        $this->model->db->debug = 0;
        
        $website_id = get_request_var('website_id', 0);

        if ($website_id == 0)
        {
            $website_id = $this->model->qry_default_website_id();
        }

        $this->website_id = $this->model->website_id = $website_id;
        
    }
    
    /**
     * lay danh sach tin bai noi bat
     */
    public function get_sticky()
    {
        $website_id = get_request_var('website_id', $this->website_id);

        $result = $this->model->qry_sticky($website_id);
        foreach ($result as $index => $article)
        {
            $result[$index]['C_SUMMARY'] = get_leftmost_words($article[C_SUMMARY], 40);
        }

        echo json_encode($result);
    }
    
    /**
     * chi tiet tin bai
     */
    public function get_article()
    {

        $website_id = get_request_var('website_id', $this->website_id);
        $category_id = get_request_var('category_id', 0);
        $article_id = get_request_var('article_id', 0);

        $result = $this->model->qry_single_article($website_id, $category_id, $article_id);
        echo json_encode($result);
    }
    
    /**
     * tin khac
     */
    public function get_other_article()
    {
        $category_id = get_request_var('category_id', '1330');
        $article_id = get_request_var('article_id', '116063');

        $result = $this->model->qry_all_other_article($category_id, $article_id);
        echo json_encode($result);
    }
    
    /**
     * lay danh sach tin bai thuoc chuyen muc
     */
    public function get_art_of_cat_by_page()
    {
        $arr_return = array();

        $page = get_request_var('page', 1);
        $website_id = get_request_var('website_id', $this->website_id);
        $category_id = get_request_var('category_id', '0');
        $key_word = get_request_var('key_word', '');

        if (!empty($website_id) && !empty($category_id))
        {
            $arr_return = $this->model->qry_art_of_cat_by_page($page, $website_id, $category_id, $key_word);
        }
        foreach ($arr_return['data'] as $index => $article)
        {
            $arr_return['data'][$index]['C_SUMMARY'] = get_leftmost_words($article[C_SUMMARY], 25);
        }
        echo json_encode($arr_return);
    }
    
    /**
     * lay danh sach cau hoi cong dan
     */
    public function get_all_cq()
    {
        $arr_return = array();
        $page = get_request_var('page', 1);
        $key_word = get_request_var('keyword', '');
        $arr_return = $this->model->qry_all_cq($page, $key_word);
        
        echo json_encode($arr_return);
    }
    
    /**
     * insert hoi dap
     */
    public function do_insert_cq()
    {
        require 'libs/recaptcha/recaptchav2.php';
        $name = replace_bad_char(get_post_var('txt_name', ''));
        $spec = get_post_var('selSpec', '');
        $title = replace_bad_char(get_post_var('txt_title', ''));
        $phone = get_post_var('txt_phone', '');
        $email = get_post_var('txt_email', '');
        $content = replace_bad_char(get_post_var('txt_content', ''));
        $recaptcha_answer = get_post_var("g-recaptcha-response","");
        $resp = recaptchav2::recaptcha_check_answer($recaptcha_answer);
        
        $data = array();
        if (!$resp->success)
        {
            $data['stt'] = 'false_captcha';
            $data['msg_error'] = 'Xác thực không hợp lệ!';
        }
        else
        {
            $data['stt'] = 'done';
            $data = $this->model->do_insert_cq($spec, $name, $title, $phone, $email, $content);
        }

        echo json_encode($data);
    }
    
    /**
     * chi tiet hoi dap
     */
    public function get_cq_detail()
    {
        $cq_id = get_request_var('cq_id', '');
        $result = $this->model->qry_cq_detail($cq_id);
        echo json_encode($result);
    }
    
    /**
     * lay danh sach menu
     */
    public function get_menu()
    {
        $arr_menu = array();
        if (!set_viewdata_data($this->website_id, 'menu', $arr_menu))
        {
            $arr_menu = $this->model->gp_qry_all_menu_position($this->website_id);
        }
        
        echo json_encode($arr_menu);
    }
    
    /**
     * lay danh sach chuyen muc va tin bai thuoc chuyen muc cua trang chu
     */
    public function get_homepage_category(){
        
        $arr_results = $this->model->gp_qry_all_featured_category($this->website_id);
        foreach($arr_results as $key => $cat_info)
        {
            foreach($cat_info['arr_articles'] as $index => $artile_info)
            {
                $arr_results[$key]['arr_articles'][$index]['C_TITLE'] = get_leftmost_words($artile_info['C_TITLE'], 12);
                $arr_results[$key]['arr_articles'][$index]['C_SUMMARY'] = get_leftmost_words($artile_info['C_SUMMARY'], 40);
            }
        }
        
        echo json_encode($arr_results);
    }
    
    /**
     * lay danh sach lien ket web
     */
    public function get_weblink(){
        $type_code = get_request_var('type_code', '');
        
        $arr_results = $this->model->qry_weblink($this->website_id, $type_code);
        echo json_encode($arr_results);
    }
    
    public function get_cq_field(){
        $result = $this->model->get_cq_field();
        echo json_encode($result);
    }
}