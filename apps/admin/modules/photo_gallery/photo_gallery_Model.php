<?php

defined('DS') or die('no direct access');

class photo_gallery_Model extends Model
{

    function __construct()
    {
        parent::__construct();
    }

    function qry_all_gallery($other_clause = '')
    {
        $website      = Session::get('session_website_id');
        //get data
        $v_begin_date = get_post_var('txt_begin_date');
        $v_begin_date = DateTime::createFromFormat('d/m/Y', $v_begin_date);
        if ($v_begin_date)
        {
            $v_begin_date = $v_begin_date->format('Y-m-d H:i');
        }
        $v_end_date   = get_post_var('txt_end_date');
        $v_end_date   = DateTime::createFromFormat('d/m/Y', $v_end_date);
        if ($v_end_date)
        {
            $v_end_date     = $v_end_date->format('Y-m-d H:i');
        }
        $v_status       = intval(get_post_var('sel_status', -1));
        $v_init_user_id = intval(get_post_var('sel_init_user'));
        $v_keywords     = get_post_var('txt_keyword');
        $v_title        = get_post_var('txt_title');
        if ($v_keywords)
        {
            $v_title = $v_keywords;
        }
        $user_id = Session::get('user_id');
        if(DATABASE_TYPE == 'MSSQL')
        {
            $sql     = "Select U.C_NAME as C_INIT_USER_NAME, PG.C_SLUG, PG.C_TITLE
                , PG.C_SUMMARY, PG.C_STATUS, PG.PK_PHOTO_GALLERY
                ,convert(varchar, PG.C_BEGIN_DATE, 103) as C_BEGIN_DATE
                , ROW_NUMBER() Over(Order By PG.C_BEGIN_DATE Desc) as RN
                , Count(*) Over(PARTITION By 1) as TOTAL_RECORD
                    From t_ps_photo_gallery PG
                    Inner Join t_cores_user U
                    On U.PK_USER = PG.FK_USER
                    Where PG.FK_WEBSITE = ?
                    And ((DateDiff(dd, ?, PG.C_BEGIN_DATE) >= 0) Or ? = '')
                    And ((DateDiff(dd, ?, PG.C_END_DATE)  <= 0) Or ? = '')
                    And (PG.C_STATUS = ? Or ? = '-1')
                    And (PG.FK_USER = ? Or ? = '0')
                    And (PG.C_TITLE Like ?)";
            $param   = array(
                $website
                , $v_begin_date, $v_begin_date
                , $v_end_date, $v_end_date
                , $v_status, $v_status
                , $v_init_user_id, $v_init_user_id
                , "%$v_title%"
            );
            $sql .= ' ' . $other_clause;

            page_calc($v_start, $v_end);
            $sql = "Select TEMP.* From ($sql) TEMP Where TEMP.RN Between $v_start And $v_end";
        }
        else if(DATABASE_TYPE == 'MYSQL')
        {
            //tinh toan phan trang
            page_calc($v_start, $v_end);
            $v_start = $v_start - 1;
            $v_limit = $v_end - $v_start;
            
            //lay du lieu
            $sql     = "Select U.C_NAME as C_INIT_USER_NAME
                                , PG.C_SLUG, PG.C_TITLE
                                , PG.C_SUMMARY, PG.C_STATUS, PG.PK_PHOTO_GALLERY
                                , DATE_FORMAT(PG.C_BEGIN_DATE,'%d-%m-%Y') as C_BEGIN_DATE
                        From t_ps_photo_gallery PG
                        Inner Join t_cores_user U
                        On U.PK_USER = PG.FK_USER
                        Where PG.FK_WEBSITE = ?
                        And ((DATEDIFF(PG.C_BEGIN_DATE,?) >= 0) Or ? = '') 
                        And ((DATEDIFF(PG.C_END_DATE,?) <= 0) Or ? = '')
                        And (PG.C_STATUS = ? Or ? = '-1')
                        And (PG.FK_USER = ? Or ? = '0')
                        And (PG.C_TITLE Like ?) $other_clause  ORDER BY C_BEGIN_DATE DESC LIMIT ?,?";
            //, Count(*) Over(PARTITION By 1) as TOTAL_RECORD
            //array param cho sql
            $param   = array(
                $website
                , $v_begin_date, $v_begin_date
                , $v_end_date, $v_end_date
                , $v_status, $v_status
                , $v_init_user_id, $v_init_user_id
                , "%$v_title%"
                ,$v_start,$v_limit
            );
        }
        
        return $this->db->getAll($sql, $param);
    }

    function qry_single_gallery($gallery_id, $other_clause = '')
    {
        $gallery_id = intval($gallery_id);
        $user_id    = Session::get('user_id');
        $sql        = "
            Select 
                PG.C_TITLE, PG.C_SLUG, PG.C_SUMMARY, PG.C_FILE_NAME As C_THUMBNAIL_FILE
                 ,DATE_FORMAT(PG.C_BEGIN_DATE,'%Y-%m-%d %H:%i:%s') as C_BEGIN_DATE
                 ,DATE_FORMAT(PG.C_END_DATE,'%Y-%m-%d %H:%i:%s') as C_END_DATE
                , PG.C_STATUS,U.C_NAME as C_INIT_USER_NAME 
            From t_ps_photo_gallery PG
            Left JOin t_cores_user U
            On PG.FK_USER = U.PK_USER
            Where PK_PHOTO_GALLERY = $gallery_id
            $other_clause
            And FK_WEBSITE =" . Session::get('session_website_id');
        return $this->db->getRow($sql);
    }

    function update_general_info($other_clause = '')
    {
        $this->db->debug = 0;
        $v_id            = intval(get_post_var('hdn_item_id'));
        $v_title         = get_post_var('txt_title');
        $v_summary       = $this->prepare_tinyMCE(get_post_var('txt_summary', '', false));
        $v_slug          = auto_slug(get_post_var('txt_slug'));
        $v_thumbnail     = get_post_var('hdn_thumbnail');
        if (!$v_thumbnail)
        {
            $v_thumbnail = NULL;
        }

        if (!$v_title or !$v_slug)
        {
            return $arr_msg = array(
                'msg'    => __('invalid request data'),
                'status' => 'update fail',
                'id'     => intval($v_id)
            );
        }

        if ($v_id > 0)
        {
            $website_id = Session::get('session_website_id');
            $sql        = "Update t_ps_photo_gallery PG Set
                C_TITLE = ?
                ,C_SUMMARY = '$v_summary'
                ,C_SLUG = ?
                ,C_FILE_NAME = ?
                Where PG.PK_PHOTO_GALLERY = $v_id 
                And PG.FK_WEBSITE = $website_id
                $other_clause
            ";
            $param      = array(
                $v_title,
                $v_slug,
                $v_thumbnail
            );
        }
        elseif ($v_id == 0)
        {
            $sql   = "Insert Into t_ps_photo_gallery (
                    C_TITLE, C_SUMMARY
                    , C_SLUG, C_FILE_NAME
                    , FK_WEBSITE, C_BEGIN_DATE
                    , C_END_DATE, C_STATUS
                    ,FK_USER
                )
                Values(
                    ?, ?, ?, ?
                    , ?, ?, ?, ?
                    ,?                    
                )";
            $param = array(
                $v_title, $v_summary,
                $v_slug, $v_thumbnail,
                Session::get('session_website_id'), date('Y-m-d H:i'),
                '2100-1-1', 0,
                Session::get('user_id')
            );
        }

        $this->db->Execute($sql, $param);
        if ($this->db->errorNo() == 0)
        {
            if ($v_id == 0)
            {
                $v_id    = $this->db->getOne("Select IDENT_CURRENT('t_ps_photo_gallery')");
            }
            $arr_msg = array(
                'msg'    => __('update success'),
                'status' => 'success',
                'id'     => intval($v_id)
            );
        }
        else
        {
            $arr_msg = array(
                'msg'    => __('update fail') . ':' . $this->db->errorMsg(),
                'status' => 'fail',
                'id'     => intval($v_id)
            );
        }
        return $arr_msg;
    }

    function qry_img_list($gallery_id)
    {
        $website = Session::get('session_website_id');
        $sql     = " Select PGD.PK_PHOTO_GALLERY_DETAIL, PGD.C_FILE_NAME
            From t_ps_photo_gallery_detail PGD
            Inner Join t_ps_photo_gallery PG
            On PG.PK_PHOTO_GALLERY = PGD.FK_PHOTO_GALLERY
            Where PGD.FK_PHOTO_GALLERY = $gallery_id
            And PG.FK_WEBSITE = $website
            Order by PGD.C_ORDER";
        return $this->db->getAll($sql);
    }

    function qry_all_user()
    {
        $sql = 'Select PK_USER, C_NAME From t_cores_user';
        return $this->db->getAll($sql);
    }

    function qry_single_image($detail_id)
    {
        $website = Session::get('session_website_id');
        $user_id = Session::get('user_id');
        $sql     = " Select 
                    PGD.PK_PHOTO_GALLERY_DETAIL, PGD.C_FILE_NAME, PGD.C_NOTE
                From t_ps_photo_gallery_detail PGD
                Inner Join t_ps_photo_gallery PG
                On PG.PK_PHOTO_GALLERY = PGD.FK_PHOTO_GALLERY
                Where PGD.PK_PHOTO_GALLERY_DETAIL = $detail_id
                And (PG.C_STATUS >= 1 Or(PG.C_STATUS = 0 And PG.FK_USER = $user_id)) 
                And PG.FK_WEBSITE = $website";
        return $this->db->getRow($sql);
    }

    function update_image()
    {
        $v_id         = intval(get_post_var('hdn_item_id'));
        $v_gallery_id = intval(get_post_var('hdn_gallery_id'));
        $v_file_name  = get_post_var('hdn_file_name');
        $v_desc       = get_post_var('txt_desc');
        $v_website    = Session::get('session_website_id');
        $user_id      = Session::get('user_id');

        if (!$v_gallery_id or !$v_file_name)
        {
            die(_('invalid request data'));
        }

        if ($v_id > 0)
        {
            
            if(DATABASE_TYPE == 'MSSQL')
            {
                $sql   = "Update t_ps_photo_gallery_detail Set
                    C_FILE_NAME = ?, C_NOTE = ?
                    From t_ps_photo_gallery_detail PGD
                    Inner join t_ps_photo_gallery PG
                    On PGD.FK_PHOTO_GALLERY = PG.PK_PHOTO_GALLERY
                    Where PGD.PK_PHOTO_GALLERY_DETAIL = ?
                    And PG.PK_PHOTO_GALLERY = ?
                    And (PG.C_STATUS >= 1 Or(PG.C_STATUS = 0 And PG.FK_USER = ?)) 
                    And PG.FK_WEBSITE = ?
                    ";
                $param = array($v_file_name, $v_desc, $v_id, $v_gallery_id, $user_id, $v_website);
            }
            else if(DATABASE_TYPE == 'MYSQL')
            {
                $sql = "select count(PK_PHOTO_GALLERY) from t_ps_photo_gallery where FK_WEBSITE = $v_website and PK_PHOTO_GALLERY = $v_gallery_id";
                if($this->db->getOne($sql)>0)
                {
                    $sql   = "Update t_ps_photo_gallery_detail Set
                    C_FILE_NAME = ?, C_NOTE = ?
                    Where PK_PHOTO_GALLERY_DETAIL = ?
                    ";
                $param = array($v_file_name, $v_desc, $v_id);
                }
            }
        }
        else
        {
            $sql   = " Insert Into t_ps_photo_gallery_detail
                (FK_PHOTO_GALLERY, C_FILE_NAME, C_NOTE)
                Select 
                    PK_PHOTO_GALLERY
                    , ? as C_FILE_NAME
                    , ? as C_NOTE
                From t_ps_photo_gallery
                Where PK_PHOTO_GALLERY = ?
                And FK_WEBSITE = ?";
            $param = array($v_file_name, $v_desc, $v_gallery_id, $v_website);
        }
        
        $this->db->Execute($sql, $param);
        
        if ($v_id == 0)
        {
            $this->build_order('t_ps_photo_gallery_detail', 'PK_PHOTO_GALLERY_DETAIL', 'C_ORDER');
        }
    }

    function delete_image($other_clause = '')
    {
        $v_website  = Session::get('session_website_id');
        $arr_delete = get_post_var('chk_img', array(), false);
        $user_id = Session::get('user_id');
        if (empty($arr_delete))
        {
            die(__('invalid request data'));
        }
        $arr_delete = replace_bad_char(implode(',', $arr_delete));

        $sql = "Delete From t_ps_photo_gallery_detail 
            Where PK_PHOTO_GALLERY_DETAIL In(
                SELECT TEMP.PK_PHOTO_GALLERY_DETAIL FROM (Select PK_PHOTO_GALLERY_DETAIL
                From t_ps_photo_gallery_detail PGD
                Inner JOin t_ps_photo_gallery PG
                On PGD.FK_PHOTO_GALLERY = PG.PK_PHOTO_GALLERY
                Where PGD.PK_PHOTO_GALLERY_DETAIL In ($arr_delete)
                And PG.FK_WEBSITE = $v_website
                $other_clause) TEMP
            )";
        $this->db->Execute($sql);
    }

    function delete_gallery($other_clause = '')
    {
        $v_website  = Session::get('session_website_id');
        $arr_delete = get_post_var('chk_item', array(), false);
        $arr_delete = replace_bad_char(implode(',', $arr_delete));
        if (empty($arr_delete))
        {
            die(__('invalid request data'));
        }
        $sql = "Delete From t_ps_photo_gallery
            Where PK_PHOTO_GALLERY In(SELECT TEMP.PK_PHOTO_GALLERY FROM (
                Select PK_PHOTO_GALLERY From t_ps_photo_gallery PG
                Where PG.PK_PHOTO_GALLERY IN($arr_delete)
                And FK_WEBSITE = $v_website
                $other_clause) TEMP
            )   
            ";
        $this->db->Execute($sql);
    }

    function update_edited_gallery($other_clause = '')
    {
        //get data
        $v_id         = intval(get_post_var('hdn_item_id', 0));
        $v_status     = intval(get_post_var('sel_status'));
        $v_begin_date = get_post_var('txt_begin_date');
        $v_begin_time = get_post_var('txt_begin_time');
        $v_end_date   = get_post_var('txt_end_date');
        $v_end_time   = get_post_var('txt_end_time');


        $arr_required_role = array('ADMINISTRATORS', 'TONG_BIEN_TAP', 'BIEN_TAP_VIEN');
        $arr_user_role = Session::get('arr_all_grant_group_code');
        $arr_intersect = array_intersect($arr_required_role, $arr_user_role);

        //3 quyen tren moi dc sua ngay
        if (empty($arr_intersect))
        {
            $v_begin_date = $v_begin_time = $v_end_date   = $v_end_time   = '';
        }
        else
        {
            $v_begin_date = DateTime::createFromFormat('d/m/Y H:i', $v_begin_date . ' ' . $v_begin_time);
            $v_end_date   = DateTime::createFromFormat('d/m/Y H:i', $v_end_date . ' ' . $v_end_time);

            if (!$v_begin_date or !$v_end_date)
            {
                die(__('invalid request data'));
            }
            $v_begin_date = $v_begin_date->format('Y-m-d H:i');
            $v_end_date   = $v_end_date->format('Y-m-d H:i');
        }

        //permission
        if ($v_status == 3)
        {
            $arr_required_role = array('ADMINISTRATORS', 'TONG_BIEN_TAP');
            $arr_user_role = Session::get('arr_all_grant_group_code');
            $arr_intersect = array_intersect($arr_required_role, $arr_user_role);
            if (empty($arr_intersect))
            {
                die(__('invalid request data'));
            }
        }
        if ($v_status == 2)
        {
            $arr_required_role = array('ADMINISTRATORS', 'TONG_BIEN_TAP', 'BIEN_TAP_VIEN');
            $arr_user_role = Session::get('arr_all_grant_group_code');
            $arr_intersect = array_intersect($arr_required_role, $arr_user_role);

            if (empty($arr_intersect))
            {
                die(__('invalid request data'));
            }
        }
        //end verify permission
        //update
        $sql = "Update t_ps_photo_gallery PG Set";
        $sql .= " C_STATUS = $v_status";
        if ($v_begin_date)
        {
            $sql .= ", C_BEGIN_DATE = '$v_begin_date'";
        }
        if ($v_end_date)
        {
            $sql .= ", C_END_DATE = '$v_end_date'";
        }
        $sql .= " 
            Where PK_PHOTO_GALLERY = $v_id
            $other_clause
            And FK_WEBSITE = " . Session::get('session_website_id');

        $this->db->Execute($sql);
    }

}

?>
