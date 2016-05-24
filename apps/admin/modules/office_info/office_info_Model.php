<?php
if (!defined('SERVER_ROOT')) exit('No direct script access allowed');

class office_info_Model extends Model {

    function __construct() {
        parent::__construct();
    }
    /**
     * update chi tiet thong tin toa soan
     */
    function update_office_info()
    {
        @session::init();
        $v_website_id  = session::get('session_website_id');
        
        $v_id         = get_post_var('hdn_item_id',0);
        $v_art_id     = get_post_var('hdn_article_id',0);
        $v_name       = get_post_var('txt_name','');
        
        $v_begin_date = get_post_var('txt_begin_date','');
        $v_begin_date = jwDate::ddmmyyyy_to_yyyymmdd($v_begin_date);
        
        $v_end_date   = get_post_var('txt_end_date','');
        $v_end_date   = jwDate::ddmmyyyy_to_yyyymmdd($v_end_date);
        
        $v_status     = isset($_POST['chk_status'])?1:0;
        $v_type       = isset($_POST['chk_default'])?1:0;
        
        //valid date
        if($v_art_id == 0 OR $v_name == '' OR $v_begin_date == '' OR $v_end_date == '') 
        {
            $this->exec_fail($this->goback_url, 'Dữ liệu truyền vào không đúng !!!');
        }
        
        //insert
        if($v_id == 0)
        {
            //kiem tra quyen
            if(session::check_permission('THEM_MOI_THONG_TIN',0) == FALSE)
            {
                die('Bạn không có quyền thực hiện chức năng này !!!');
            }
            
            //kiem tra default 
            if($v_type == 1)
            {
                $sql = "Update t_web_office_info Set C_TYPE = 0 Where FK_WEBSITE = $v_website_id";
                $this->db->Execute($sql);
            }
            
            $stmt = "insert into t_web_office_info(
                        FK_ARTICLE,FK_WEBSITE,C_NAME,C_STATUS,C_TYPE,C_BEGIN_DATE,C_END_DATE
                        )
                        VALUES
                        (?,?,?,?,?,?,?)
                        ";
            $arr_param = array($v_art_id,$v_website_id,$v_name,$v_status,$v_type,$v_begin_date,$v_end_date);
            
            $this->db->Execute($stmt,$arr_param);
        }
        //update
        else
        {
            //kiem tra quyen
            if(session::check_permission('SUA_THONG_TIN',0) == FALSE)
            {
                die('Bạn không có quyền thực hiện chức năng này !!!');
            }
            
             //kiem tra default 
            if($v_type == 1)
            {
                $sql = "Update t_web_office_info Set C_TYPE = 0 Where FK_WEBSITE = $v_website_id";
                $this->db->Execute($sql);
            }
            
            $stmt = "Update t_web_office_info Set
                        FK_ARTICLE = ?,FK_WEBSITE = ?,C_NAME = ?,C_STATUS = ?,C_TYPE = ?,C_BEGIN_DATE = ?,C_END_DATE = ?
                        Where PK_OFFICE_INFO = ? And FK_WEBSITE = ?";
            $arr_param = array($v_art_id,$v_website_id,$v_name,$v_status,$v_type,$v_begin_date,$v_end_date,$v_id,$v_website_id);
            
            $this->db->Execute($stmt,$arr_param);
        }
        //thuc hien exec done khi hoan thanh
        $this->exec_done($this->goback_url);
    }
    
    /**
     * lay du lieu chi tiet cua thong tin toa soan
     * @return type
     */
    public function qry_single_office_info()
    {
        @session::init();
        $v_website_id  = session::get('session_website_id');
        $v_id = get_post_var('hdn_item_id',0);
        
        //valide date
        if($v_id == 0)
        {
            return array();
        }
        
        //lay du lieu
        $stmt = "select
                    PK_OFFICE_INFO,
                    FK_ARTICLE,
                    FK_WEBSITE,
                    C_NAME,
                    C_STATUS,
                    C_TYPE,
                    (Select C_TITLE From t_web_article Where PK_ARTICLE = OI.FK_ARTICLE) as C_ART_TITLE,
                    DATE_FORMAT(C_BEGIN_DATE,'%d/%m/%Y') as C_BEGIN_DATE,
                    DATE_FORMAT(C_END_DATE,'%d/%m/%Y') as C_END_DATE
                  from t_web_office_info OI
                  where FK_WEBSITE = ? And PK_OFFICE_INFO = ?";
        $arr_param = array($v_website_id,$v_id);
        
        return $this->db->getRow($stmt,$arr_param);
    }
    
    /**
     * lay danh sach thong tin toa soan
     * @return type
     */
    public function qry_all_office_info()
    {
        @session::init();
        $v_website_id  = session::get('session_website_id');
        
        $stmt = "select
                    PK_OFFICE_INFO,
                    FK_ARTICLE,
                    FK_WEBSITE,
                    C_NAME,
                    C_STATUS,
                    C_TYPE,
                    DATE_FORMAT(C_BEGIN_DATE,'%d/%m/%Y') as C_BEGIN_DATE,
                    DATE_FORMAT(C_END_DATE,'%d/%m/%Y') as C_END_DATE
                  from t_web_office_info
                  where FK_WEBSITE = ?
                  order by C_BEGIN_DATE";
        return $this->db->getAll($stmt,array($v_website_id));
    }
    /**
     * xoa thong tin toa soan
     */
    public function delete_office_info()
    {
        $v_list_id = get_post_var('hdn_item_id_list','');
        
        $sql = "Delete From t_web_office_info Where PK_OFFICE_INFO in ($v_list_id)";
        
        $this->db->Execute($sql);
        
        $this->exec_done($this->goback_url);
    }
}

?>