<?php

class linh_vuc_thong_ke_Model extends Model {
	/**
	 * 
	 * @var \ADOConnection
	 */
	public $db;
	
    function __construct() {
        parent::__construct();
    }

    public function qry_all_linh_vuc_thong_ke() 
    {
       return $this->db->GetAll('SELECT *
                            FROM t_ps_linh_vuc_thong_ke
                            
                            ORDER BY C_ORDER ASC');
    }
    public function delete_linh_vuc_thong_ke() 
    {
        $v_linh_vuc_thong_ke_list = get_post_var('hdn_item_id_list');
        $stmt="Delete From t_ps_linh_vuc_thong_ke Where PK_LINH_VUC_VAN_BAN IN ($v_linh_vuc_thong_ke_list)";
        $this->db->Execute($stmt);       
        $this->exec_done($this->goback_url);
    }

    public function qry_single_linh_vuc_thong_ke($v_id_linh_vuc_thong_ke=0) 
    {
        return $this->db->GetRow("SELECT *
                                    FROM t_ps_linh_vuc_thong_ke
                                    WHERE PK_LINH_VUC_VAN_BAN = ?
                                        ",array($v_id_linh_vuc_thong_ke));
    
    }
    public function qry_all_category_on_web($v_id_linh_vuc_thong_ke)
    {
        @session::init();
        $v_website_id = session::get('session_website_id');
        $stmt="Select FK_WEBSITE From t_ps_linh_vuc_thong_ke where FK_WEBSITE = ? and PK_BANNER = ?";
        $v_website_id_of_linh_vuc_thong_ke = $this->db->getOne($stmt,array($v_website_id,$v_id_linh_vuc_thong_ke));
        if($v_website_id_of_linh_vuc_thong_ke == $v_website_id)
        {        	
             $stmt = "select *,(select COUNT(*)from t_ps_linh_vuc_thong_ke_category where FK_CATEGORY=PK_CATEGORY and FK_BANNER not in (?)) as C_DEPEND 
                	from t_ps_category where FK_WEBSITE = ? order by C_INTERNAL_ORDER";
             return $this->db->getAll($stmt,array($v_id_linh_vuc_thong_ke,$v_website_id));
        }
        else
        {
        		/* Hiện danh sách các chuyên mục của chuyên trang hiện tại khi thêm mới.*/
        		 $stmt = "select *,(select COUNT(*)from t_ps_linh_vuc_thong_ke_category where FK_CATEGORY=PK_CATEGORY and FK_BANNER not in (?)) as C_DEPEND 
              	from t_ps_category  where FK_WEBSITE = ? order by C_INTERNAL_ORDER";        	
        		return $this->db->getAll($stmt,array($v_id_linh_vuc_thong_ke,$v_website_id));
        		
        }
       return array();
    }
    
    function update_linh_vuc_thong_ke($v_id = 0)
    {
        
        $txt_name  = get_post_var('txt_name','');
        $txt_order  = get_post_var('txt_order',0);
        $chk_status = isset($_POST['chk_status']) ? 1 : 0;
        $v_id       =  get_post_var('hdn_item_id',$v_id);
        
       if($v_id == 0)
       {
           
           $sql = "
                    INSERT INTO t_ps_linh_vuc_thong_ke 
                                (
                                C_NAME, 
                                C_ORDER, 
                                C_STATUS
                                )
                                VALUES
                                (
                                ?,
                                ?,
                                ?
                                )";
           $this->db->Execute($sql,array($txt_name,$txt_order,$chk_status));
       }
       else
       {
           $sql = "UPDATE t_ps_linh_vuc_thong_ke 
                            SET
                            C_NAME = ?, 
                            C_ORDER = ?, 
                            C_STATUS = ?
                            WHERE
                            PK_LINH_VUC_VAN_BAN = ? ;
                    ";
           $this->db->Execute($sql,array($txt_name,$txt_order,$chk_status,$v_id));
       }
        $this->exec_done($this->goback_url, '');
    }
}
?>