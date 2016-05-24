<?php

defined('DS') or die('no direct access');

class photo_gallery_Controller extends Controller
{

    function __construct()
    {
        parent::__construct('admin', 'photo_gallery');
        Session::init();
        Session::get('user_id') or $this->login_admin();
        Session::check_permission('QL_DANH_SACH_PHONG_SU_ANH') or $this->access_denied();
        
        $v_lang_id                                   = session::get('session_lang_id');
        $this->view->arr_all_lang          = $this->model->qry_all_lang();
        $this->view->arr_count_article     = $this->model->gp_qry_count_article();
        $this->view->arr_all_grant_website = $this->model->gp_qry_all_website_by_user($v_lang_id);
        $this->model->goback_url = $this->view->get_controller_url();
    }

    function main()
    {
        $this->dsp_all_gallery();
    }

    function dsp_all_gallery()
    {

        $other_clause = '';
        $user_id = Session::get('user_id');

        $other_clause = '';
        if ($other_clause_by_status = $this->get_other_clause_by_status())
        {
            $other_clause = " And ($other_clause_by_status)";
        }

        $data['arr_all_gallery'] = $this->model->qry_all_gallery($other_clause);
        $data['arr_all_user'] = $this->model->qry_all_user();
        $this->view->render('dsp_all_gallery', $data);
    }

    function dsp_single_gallery($gallery_id = 0)
    {
        $data['v_id'] = $gallery_id;
        $this->view->render('dsp_single_gallery', $data);
    }

    function dsp_general_info($gallery_id = 0)
    {
        $data['v_id'] = $gallery_id;

        if ($gallery_id)
        {

            $other_clause = '';
            if ($other_clause_by_status = $this->get_other_clause_by_status())
            {
                $other_clause = " And ($other_clause_by_status)";
            }
            $data['arr_single_gallery'] = $this->model->qry_single_gallery($gallery_id, $other_clause);
            if ($data['arr_single_gallery'] == null)
            {
                die(__('this object is nolonger available!'));
            }
        }
        else
        {

        }
        $this->view->set_layout(NULL)->render('dsp_general_info', $data);
    }

    function update_general_info()
    {
        $this->model->db->debug = true;
        $v_id = get_post_var('hdn_item_id');

        $other_clause = '';
        if ($other_clause_by_status = $this->get_other_clause_by_status())
        {
            $other_clause = " And ($other_clause_by_status)";
        }
        echo json_encode($this->model->update_general_info($other_clause));
    }

    function dsp_img_list($gallery_id = 0)
    {


        $gallery_id = intval($gallery_id);
        $data['v_id'] = $gallery_id;
        $other_clause = '';
        if ($other_clause_by_status = $this->get_other_clause_by_status())
        {
            $other_clause = " And ($other_clause_by_status)";
        }
        $data['arr_single_gallery'] = $this->model->qry_single_gallery($gallery_id, $other_clause);
        if (empty($data['arr_single_gallery']))
        {
            die(__('this object is nolonger available!'));
        }
        $data['arr_all_image'] = $this->model->qry_img_list($gallery_id);
        $this->view->set_layout(NULL)->render('dsp_img_list', $data);
    }

    function dsp_single_image($detail_id = 0)
    {

        $detail_id = intval($detail_id);
        $data['v_id'] = $detail_id;
        if ($detail_id > 0)
        {
            $data['arr_single_image'] = $this->model->qry_single_image($detail_id);
            if (!$data['arr_single_image'])
            {
                die(__('this object is nolonger available!'));
            }
        }

        $this->view->set_layout(NULL)->render('dsp_single_image', $data);
    }

    function update_image()
    {
        Session::check_permission('SUA_TIN_ANH') or $this->access_denied();
        $this->model->update_image();
    }

    function swap_image_order()
    {

        $item1 = intval(get_post_var('item1'));
        $item2 = intval(get_post_var('item2'));
        if ($item1 && $item2)
        {
            $this->model->swap_order(
                    't_web_photo_gallery_detail'
                    , 'PK_PHOTO_GALLERY_DETAIL'
                    , 'C_ORDER', $item1, $item2
            );
        }
    }

    function dsp_edit_gallery($gallery_id = 0)
    {
        $other_clause = '';
        if ($other_clause_by_status = $this->get_other_clause_by_status())
        {
            $other_clause = " And ($other_clause_by_status)";
        }
        $gallery_id = intval($gallery_id);
        $data['v_id'] = $gallery_id;
        $data['arr_single_gallery'] = $this->model->qry_single_gallery($gallery_id, $other_clause);
        if (empty($data['arr_single_gallery']))
        {
            die(__('this object is nolonger available!'));
        }
        $this->view->set_layout(NULL)->render('dsp_edit_gallery', $data);
    }

    function delete_image()
    {
        $other_clause = '';
        if ($other_clause_by_status = $this->get_other_clause_by_status())
        {
            $other_clause = " And ($other_clause_by_status)";
        }
        $this->model->delete_image($other_clause);
    }

    function delete_gallery()
    {
        $other_clause = '';
        if ($other_clause_by_status = $this->get_other_clause_by_status())
        {
            $other_clause = " And ($other_clause_by_status)";
        }
        $this->model->delete_gallery($other_clause);
    }

    function update_edited_gallery()
    {
        $other_clause = '';
        if ($other_clause_by_status = $this->get_other_clause_by_status())
        {
            $other_clause = " And ($other_clause_by_status)";
        }
        $this->model->update_edited_gallery($other_clause);
    }

    private function get_other_clause_by_status()
    {
        $arr_granted_group = Session::get('arr_all_grant_group_code');
        $other_clause_by_status = array();
        $user_id = Session::get('user_id');

        // if (in_array('TONG_BIEN_TAP', $arr_granted_group))
        // {
            // $other_clause_by_status[] = "PG.C_STATUS >= 2";
        // }
        // if (in_array('ADMINISTRATORS', $arr_granted_group))
        // {
            $other_clause_by_status[] = "1 = 1";
        // }
        // if (in_array('BIEN_TAP_VIEN', $arr_granted_group))
        // {
            // $other_clause_by_status[] = "PG.C_STATUS = 1";
        // }
        $other_clause_by_status[] = "(PG.C_STATUS = 0 And PG.FK_USER = $user_id)";
        if (count($other_clause_by_status))
        {
            $other_clause_by_status = implode(' Or ', $other_clause_by_status);
            return $other_clause_by_status;
        }
        return '';
    }

    /**
     * Tao cache
     */
    public function create_cache()
    {
        //kiem tra cachemode
        if (get_system_config_value(CFGKEY_CACHE) == 'false')
        {
            $this->model->exec_done($this->model->goback_url);
        }
        $website_id = session::get('session_website_id');

        $cache = New GP_Cache();
        $cache->create_new_photo_gallery_cache($website_id);
        $this->model->exec_done($this->model->goback_url, $_POST);
    }

}

?>
