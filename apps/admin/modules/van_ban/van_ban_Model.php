<?php

class van_ban_Model extends Model {
	/**
	 * 
	 * @var \ADOConnection
	 */
	public $db;
	
    function __construct() {
        parent::__construct();
    }

    public function qry_all_van_ban() 
    {
        // get arrData
        $condition = "";
        $txt_title = get_post_var('txt_title','');
        $txt_cqbh = get_post_var('sel_cqbh','');
        $txt_lvtk = get_post_var('sel_lvtk','');
        $txt_loai_vb = get_post_var('sel_loai_vb','');
        
        if(!empty($txt_title)){
            $condition .= " AND (C_TITLE LIKE '%".$txt_title."%' OR C_SO_HIEU_VAN_BAN LIKE '%".$txt_title."%')";
        }
        
        if(!empty($txt_cqbh)){
            $condition .= " AND FK_CO_QUAN_BAN_HANH = '$txt_cqbh'";
        }
        
        if(!empty($txt_lvtk)){
            $condition .= " AND FK_LINH_VUC_VAN_BAN = '$txt_lvtk'";
        }
        
        if(!empty($txt_loai_vb)){
            $condition .= " AND C_LOAI_VAN_BAN = '$txt_loai_vb'";
        }
        
        
        page_calc($v_start, $v_end);
        $v_start = $v_start -1;
        $v_limit = $v_end - $v_start;
        $v_start = ($v_start > 0 ) ? $v_start : 0;
        $v_limit = $v_limit > 0 ? $v_limit : 10;
       return $this->db->GetAll("SELECT
                                    (select count(PK_VAN_BAN) from t_ps_van_ban  ORDER BY C_NGAY_BAN_HANH DESC) as TOTAL_RECORD,
                                    vb.*,
                                    bh.C_NAME AS C_NAME_CO_QUAN_BAN_HANH,
                                    tk.C_NAME AS C_NAME_LINH_VUC_BAN_HANH
                                  FROM t_ps_van_ban vb
                                    LEFT JOIN t_ps_co_quan_ban_hanh bh
                                      ON PK_CO_QUAN_BAN_HANH = FK_CO_QUAN_BAN_HANH
                                    LEFT JOIN t_ps_linh_vuc_thong_ke tk
                                      ON PK_LINH_VUC_VAN_BAN = FK_LINH_VUC_VAN_BAN
                                      where (1=1) $condition
                            ORDER BY C_NGAY_BAN_HANH DESC limit $v_start,$v_limit");
    }
    public function delete_van_ban() 
    {
        $v_van_ban_list = get_post_var('hdn_item_id_list');
        $stmt="Delete From t_ps_van_ban Where PK_LINH_VUC_VAN_BAN IN ($v_van_ban_list)";
        $this->db->Execute($stmt);       
        $this->exec_done($this->goback_url);
    }

    public function qry_single_van_ban($v_id_van_ban=0) 
    {
        return $this->db->GetRow("SELECT *
                                    FROM t_ps_van_ban
                                    WHERE PK_VAN_BAN = ?
                                        ",array($v_id_van_ban));
    
    }
    public function qry_all_category_on_web($v_id_van_ban)
    {
        @session::init();
        $v_website_id = session::get('session_website_id');
        $stmt="Select FK_WEBSITE From t_ps_van_ban where FK_WEBSITE = ? and PK_BANNER = ?";
        $v_website_id_of_van_ban = $this->db->getOne($stmt,array($v_website_id,$v_id_van_ban));
        if($v_website_id_of_van_ban == $v_website_id)
        {        	
             $stmt = "select *,(select COUNT(*)from t_ps_van_ban_category where FK_CATEGORY=PK_CATEGORY and FK_BANNER not in (?)) as C_DEPEND 
                	from t_ps_category where FK_WEBSITE = ? order by C_INTERNAL_ORDER";
             return $this->db->getAll($stmt,array($v_id_van_ban,$v_website_id));
        }
        else
        {
        		/* Hiện danh sách các chuyên mục của chuyên trang hiện tại khi thêm mới.*/
        		 $stmt = "select *,(select COUNT(*)from t_ps_van_ban_category where FK_CATEGORY=PK_CATEGORY and FK_BANNER not in (?)) as C_DEPEND 
              	from t_ps_category  where FK_WEBSITE = ? order by C_INTERNAL_ORDER";        	
        		return $this->db->getAll($stmt,array($v_id_van_ban,$v_website_id));
        		
        }
       return array();
    }
    
    function update_van_ban($v_id = 0)
    {
        $v_id       =  get_post_var('hdn_item_id',$v_id);
        $txt_name   = get_post_var('txt_name','');
        $txt_so_hieu_van_ban   = get_post_var('txt_so_hieu_van_ban','');
        $sel_co_quan_ban_hanh   = get_post_var('sel_co_quan_ban_hanh',0);
        $sel_linh_vuc_thong_ke   = get_post_var('sel_linh_vuc_thong_ke',0);
        $txt_loai_van_ban   = get_post_var('txt_loai_van_ban','');
        $txt_ngay_ban_hanh   = get_post_var('txt_ngay_ban_hanh','');
        $txt_ngay_ban_hanh   = ($txt_ngay_ban_hanh != '') ? jwDate::yyyymmdd_to_ddmmyyyy($txt_ngay_ban_hanh) : NULL;
        
        $txt_ngay_co_hieu_luc   = get_post_var('txt_ngay_co_hieu_luc','');
        $txt_ngay_co_hieu_luc   = ($txt_ngay_co_hieu_luc != '') ? jwDate::yyyymmdd_to_ddmmyyyy($txt_ngay_co_hieu_luc) : NULL;
        
        $chk_status = isset($_POST['chk_status']) ? 1 : 0;
        $arr_attachment = get_request_var('hdn_attachment', array(), false);

        
       if($v_id == 0)
       {
           
           $sql = "
                INSERT INTO t_ps_van_ban 
                        (
                        C_TITLE, 
                        C_SO_HIEU_VAN_BAN, 
                        FK_CO_QUAN_BAN_HANH, 
                        FK_LINH_VUC_VAN_BAN, 
                        C_LOAI_VAN_BAN, 
                        C_NGAY_BAN_HANH, 
                        C_NGAY_HIEU_LUC, 
                        C_STATUS
                        )
                        VALUES
                        ( 
                        ?, 
                        ?, 
                        ?, 
                        ?, 
                        ?, 
                        ?, 
                        ?, 
                        ?
                        );
                ";
           $this->db->Execute($sql,array($txt_name
                                        ,$txt_so_hieu_van_ban
                                        ,$sel_co_quan_ban_hanh
                                        ,$sel_linh_vuc_thong_ke
                                        ,$txt_loai_van_ban
                                        ,$txt_ngay_ban_hanh
                                        ,$txt_ngay_co_hieu_luc
                                        ,$chk_status)
                            );
            $v_id = $this->db->GetOne("select max(PK_VAN_BAN) from t_ps_van_ban ");
           
        }
       else
       {
           $sql = "
                UPDATE t_ps_van_ban 
                        SET
                        C_TITLE = ? , 
                        C_SO_HIEU_VAN_BAN = ? , 
                        FK_CO_QUAN_BAN_HANH = ? , 
                        FK_LINH_VUC_VAN_BAN = ? , 
                        C_LOAI_VAN_BAN = ? , 
                        C_NGAY_BAN_HANH = ? , 
                        C_NGAY_HIEU_LUC = ? , 
                        C_STATUS = ?
                        WHERE
                        PK_VAN_BAN = ? ;";
           $this->db->Execute($sql,array($txt_name
                                        ,$txt_so_hieu_van_ban
                                        ,$sel_co_quan_ban_hanh
                                        ,$sel_linh_vuc_thong_ke
                                        ,$txt_loai_van_ban
                                        ,$txt_ngay_ban_hanh
                                        ,$txt_ngay_co_hieu_luc
                                        ,$chk_status
                                        ,$v_id));

       }
       
        //cap nhat file dinh kem
        $this->update_attachment($v_id, $arr_attachment);
       
       $this->exec_done($this->goback_url, '');
    }
    
    
    public function qry_all_co_quan_ban_hanh()
    {
        return $this->db->GetAll("select C_NAME, PK_CO_QUAN_BAN_HANH from t_ps_co_quan_ban_hanh where C_STATUS  =1  ");
    }
    public function qry_all_linh_vuc_thong_ke()
    {
        return $this->db->GetAll("select C_NAME, PK_LINH_VUC_VAN_BAN from t_ps_linh_vuc_thong_ke where C_STATUS  =1  ");
    }
    
    function update_attachment($article_id, $arr_attachment)
    {
        $article_id = intval($article_id);
        
        $sql        = 'Delete From t_ps_van_ban_dinh_kem Where FK_VAN_BAN = ' . $article_id . ';';
        $this->db->Execute($sql);
        
        $param      = array();
        
        $sql = '';
        if (!empty($arr_attachment))
        {
            $sql .= 'Insert Into t_ps_van_ban_dinh_kem(FK_VAN_BAN, C_FILE_NAME) Values';
            $first_att = str_replace('\\', '/', array_shift($arr_attachment));
            $sql .= "($article_id, ?)";
            $param[]   = $first_att;
            if (!empty($arr_attachment))
            {
                foreach ($arr_attachment as $val)
                {
                    $val     = str_replace('\\', '/', $val);
                    $sql .= ",($article_id, ?)";
                    $param[] = $val;
                }
            }
            $this->db->Execute($sql, $param);
        }
    }
    
    function qry_all_attachment($id)
    {
        $id  = intval($id);
        $sql = 'Select C_FILE_NAME
                From t_ps_van_ban_dinh_kem
                Where FK_VAN_BAN =' . $id;
        return $this->db->getAll($sql);
    }
    
     public function qry_all_statistics()
    {
        return $this->db->getAll("SELECT *,
                                (SELECT COUNT(*) FROM t_ps_van_ban WHERE t_ps_van_ban.FK_LINH_VUC_VAN_BAN = PK_LINH_VUC_VAN_BAN AND VB.C_STATUS=1) AS C_TOTAL
                                FROM t_ps_linh_vuc_thong_ke tk
                                  LEFT JOIN t_ps_van_ban vb
                                    ON tk.PK_LINH_VUC_VAN_BAN = vb.FK_LINH_VUC_VAN_BAN
                                    WHERE vb.C_STATUS=1
                                GROUP BY tk.PK_LINH_VUC_VAN_BAN");
    }
    
    public function qry_all_organization()
    {
        return $this->db->getAll("SELECT *,
                                (SELECT COUNT(*) FROM t_ps_van_ban WHERE t_ps_van_ban.FK_CO_QUAN_BAN_HANH = PK_CO_QUAN_BAN_HANH AND VB.C_STATUS=1) AS C_TOTAL
                                FROM t_ps_co_quan_ban_hanh cqbh
                                  LEFT JOIN t_ps_van_ban vb
                                    ON cqbh.PK_CO_QUAN_BAN_HANH = vb.FK_CO_QUAN_BAN_HANH
                                    WHERE vb.C_STATUS=1
                                GROUP BY cqbh.PK_CO_QUAN_BAN_HANH");
    }
    
    public function qry_all_doc_type()
    {
        return $this->db->getAll("SELECT DISTINCT C_LOAI_VAN_BAN FROM t_ps_van_ban");
    }
    
}
?>