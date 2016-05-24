<?php

if (!defined('SERVER_ROOT'))
    exit('No direct script access allowed');

class category_Model extends Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function qry_all_category($other_clause = '')
    {
        $website_id = intval(Session::get('session_website_id'));
        $extend     = '';
        $sql        = 'Select 
                        C.PK_CATEGORY, C.C_ORDER, C.C_INTERNAL_ORDER, C.C_SLUG
                        , C.C_NAME, C.C_STATUS, C.FK_PARENT';

        $sql .= ',(Select Count(*) From t_ps_category CC 
                Where CC.FK_PARENT =  C.PK_CATEGORY) as C_COUNT_CHILD_CAT';
        $sql .= ', (Select Count(*) From t_ps_category_article CACA
                Where CACA.FK_CATEGORY = C.PK_CATEGORY) as C_COUNT_CHILD_ART';


        $sql .= ' From t_ps_category C
            Where 1 = 1
                        ' . $other_clause . '
                        Order by C.C_INTERNAL_ORDER';
        return $this->db->getAll($sql);
    }

    public function swap_category_order($item1, $item2)
    {
        $item1        = replace_bad_char($item1);
        $item2        = replace_bad_char($item2);
        $this->swap_order('t_ps_category', 'PK_CATEGORY', 'C_ORDER', $item1, $item2);
        $website      = Session::get('session_website_id');
        $other_clause = ' And FK_WEBSITE =' . $website;
        $this->build_internal_order(
                't_ps_category', 'PK_CATEGORY', 'FK_PARENT'
                , 'C_ORDER', 'C_INTERNAL_ORDER', '-1', $other_clause
        );

        if ($this->db->ErrorNo() == 0)
            echo 'Thanh cong';
    }

    public function qry_single_category($id)
    {
        return $this->db->getRow(
                        'Select 
                            *
                        From t_ps_category
                        Where PK_CATEGORY = ?
                        And FK_WEBSITE = ' . Session::get('session_website_id')
                        , array($id)
        );
    }

    public function update_category()
    {
        $data['id']         = intval(get_request_var('hdn_item_id', 0));
        $data['name']       = strval(get_request_var('txt_name', ''));
        $data['slug']       = auto_slug(strval(get_request_var('txt_slug', '')));
        $data['parent']     = intval(get_request_var('sel_category', '0'));
        $data['is_video']   = intval(get_request_var('chk_is_video',0));
        $data['is_radio']   = intval(get_request_var('chk_is_radio',0));
        
        $data['status']     = isset($_POST['sel_status'])?1:0;
        $data['controller'] = strval(get_request_var('controller'));
        $data['order']      = intval(get_request_var('txt_order', 1));
        $data['website-id'] = (Session::get('session_website_id')) ? Session::get('session_website_id') : 0;
        $data['rd_type']   = get_request_var('rd_type');
        
        
        
        if ($data['slug'] == '')
        {
        	$data['slug']       = auto_slug($data['name']);
        }
        //validate
        if (empty($data['name']) OR empty($data['slug']))
        {
            $this->exec_fail($data['controller'], __('invalid request data'));
        }

        //verify
        $count_website = $this->db->getOne(
                'Select Count(*) From t_ps_website Where PK_WEBSITE = ?'
                , array($data['website-id'])
        );

        if ($data['parent'] > 0)
        {
            $count_cat = $this->db->getOne(
                    'Select Count(*) From t_ps_category Where PK_CATEGORY = ?'
                    , array($data['parent'])
            );
        }
        else
        {
            $data['parent'] = 0;
            $count_cat      = 1;
        }


        if ($count_cat == 0 OR $count_website == 0)
            $this->exec_fail($data['controller'], __('invalid request data'));

        //exec
        //update
        
        $link_adv = get_request_var('txt_link_adv');
        $arr_attachment = get_request_var('hdn_attachment', array(), false);
        $arr_attachment = is_array($arr_attachment) ? $arr_attachment : array();
        
        $v_file_name = '';
        if(count($arr_attachment)  == 1)
        {
            $v_file_name = isset($arr_attachment[0]) ? $arr_attachment[0] : '';
        }
        if ($data['id'] > 0)
        {
            $sql = 'Update t_ps_category
            Set C_NAME = ?
            , C_SLUG = ?
            , FK_PARENT = ?
            , C_STATUS = ?
            , C_ORDER = ?
            , C_IS_VIDEO = ?
             ,C_FILE_NAME = ?
             ,C_LINK_ADV = ?
             ,C_IS_RADIO = ?
             ,C_TYPE = ?
            Where PK_CATEGORY = ?
            And FK_WEBSITE = ' . Session::get('session_website_id');

            $param = array(
                $data['name'], $data['slug'], $data['parent']
                , $data['status'], $data['order'], $data['is_video'], $v_file_name,$link_adv,$data['is_radio'],$data['rd_type'],$data['id']
            );

            $this->db->Execute($sql, $param);
        }
        //insert
        else
        {
            $sql = 'Insert Into t_ps_category
            (C_NAME, C_SLUG, FK_PARENT, FK_WEBSITE, C_STATUS, C_ORDER, C_IS_VIDEO,C_FILE_NAME,C_LINK_ADV,C_IS_RADIO, C_TYPE)
            Values(?, ?, ?, ?, ?, ?, ?,?,? ,? , ?)';

            $param = array(
                $data['name'], $data['slug'], $data['parent']
                , $data['website-id'], $data['status'], $data['order'], $data['is_video'],$v_file_name,$link_adv,$data['is_radio'] ,$data['rd_type']
            );
            
            
            $this->db->Execute($sql, $param);
        }

        //exec done
        if ($this->db->ErrorNo() == 0)
        {
            $other_clause = ' And FK_WEBSITE =' . Session::get('session_website_id');
            $this->ReOrder('t_ps_category', 'PK_CATEGORY', 'C_ORDER', $data['id'], $data['order']);
            $this->build_internal_order(
                    't_ps_category', 'PK_CATEGORY', 'FK_PARENT'
                    , 'C_ORDER', 'C_INTERNAL_ORDER', 'NULL', $other_clause
            );
            $this->exec_done($data['controller']);
        }
        else
        {
            $this->exec_fail($data['controller'], __('update fail') . ':' . $this->db->ErrorMsg());
        }
    }

    public function delete_category()
    {
        $arr_item = isset($_POST['chk']) ? $_POST['chk'] : array();
        $controller = get_request_var('hdn_controller');
        if (empty($arr_item)) return false;

        //validate
        $n          = count($arr_item);
        for ($i = 0; $i < $n; $i++)
        {
            //verify
            $arr_item[$i]  = intval($arr_item[$i]);
            $arr_child_cat = $this->qry_all_category(' And FK_PARENT = ' . $arr_item[$i]);
            if (count($arr_child_cat))
                $this->exec_fail($controller, __('invalid request data'));
        }
        
        $arr_item      = implode(', ', $arr_item);
        //delete fk
        $arr_fk        = array('T_PS_USER_CATEGORY', 'T_PS_BANNER_CATEGORY', 't_ps_group_category');
        $sql = '';
        foreach ($arr_fk as $val)
        {
            $sql .= "Delete From $val Where FK_CATEGORY In($arr_item)";
            $this->db->Execute($sql);
        }
        $sql = 'Delete From t_ps_category 
                          Where PK_CATEGORY In(' . $arr_item . ')
                          And FK_WEBSITE = ' . Session::get('session_website_id');
        $this->db->Execute($sql);
        
    }

    public function qry_all_featured()
    {
        $website_id = intval(Session::get('session_website_id'));
        $sql        = '
            Select C.PK_CATEGORY, C.C_NAME, C.C_STATUS, H.PK_HOMEPAGE_CATEGORY, H.C_ORDER
            From t_ps_category C
            Inner join t_ps_homepage_category H
            On H.FK_CATEGORY = C.PK_CATEGORY
            Where H.FK_WEBSITE = ' . $website_id
                . ' Order By H.C_ORDER';
        return $this->db->getAll($sql);
    }

    public function qry_all_website()
    {
        $sql = 'Select C_NAME, PK_WEBSITE From t_ps_website Order by C_ORDER';
        return $this->db->getAll($sql);
    }

    public function insert_featured_category()
    {
        $arr_category = isset($_POST['category']) ? $_POST['category'] : array();
        $website_id = Session::get('session_website_id');
        $n          = count($arr_category);

        if (!empty($arr_category))
        {
            for ($i = 0; $i < $n; $i++)
            {
                $arr_category[$i] = $arr_category[$i]['id'];
            }
            $arr_category     = replace_bad_char(implode(',', $arr_category));
            $sql              = "Insert Into t_ps_homepage_category (FK_WEBSITE, FK_CATEGORY)
                    Select $website_id As FK_WEBSITE, PK_CATEGORY
                    From t_ps_category C
                    Where C.PK_CATEGORY In($arr_category)
                    And C.PK_CATEGORY Not In (
                        Select FK_CATEGORY From t_ps_homepage_category 
                        Where FK_WEBSITE = $website_id
                    )";
            $this->db->Execute($sql);
            $other_clause = " AND FK_WEBSITE = $website_id";
            $this->build_order('t_ps_homepage_category', 'PK_HOMEPAGE_CATEGORY', 'C_ORDER',$other_clause);
        }
    }

    public function delete_featured_category()
    {
        $arr_delete = isset($_POST['chk']) ? $_POST['chk'] : array();
        if (empty($arr_delete))
        {
            die('nothing added');
        }

        $arr_delete = replace_bad_char(implode(',', $arr_delete));
        $website_id = Session::get('session_website_id');
        $sql        = "Delete From t_ps_homepage_category
                       Where PK_HOMEPAGE_CATEGORY In($arr_delete)
                       And FK_WEBSITE = $website_id";
        $this->db->Execute($sql);
    }

    public function swap_featured_order()
    {
        $item1 = intval(get_request_var('item1', 0));
        $item2 = intval(get_request_var('item2', 0));

        $this->swap_order(
                't_ps_homepage_category', 'PK_HOMEPAGE_CATEGORY'
                , 'C_ORDER', $item1, $item2);
    }

    function qry_granted_category()
    {
        $user_id       = Session::get('user_id');
        $granted_group = Session::get('arr_all_grant_group_code');
        $sql           = 'Select FK_CATEGORY From T_PS_USER_CATEGORY Where FK_USER = ' . $user_id;
        if ($granted_group)
        {
            $granted_group = "'" . implode(" ', '", $granted_group) . "'";
            $sql .= ' Union All(
                            Select GC.FK_CATEGORY From t_ps_group_category GC
                            Inner Join T_CORES_GROUP G On G.PK_GROUP = GC.FK_GROUP
                            Where G.C_CODE In (' . $granted_group . ')
                        )';
        }

        return $this->db->getCol($sql);
    }
}

?>