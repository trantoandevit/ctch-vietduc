<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of member_Model
 *
 * @author Tam Viet
 */
class member_Model extends Model
{
    public function __construct() 
    {
        parent:: __construct();
    }
     /**
     * Update neu Id= !0 or Inser neu id = 1
      * 
     * @param int $v_member_id Ma cua member
     * @return bool  True if success else False 
     */
    public function update_member($arr_post = array())
    {
        if(sizeof($arr_post) <0)
        {
             $this->model->exec_fail($this->view->get_controller_url(),'Dữ liệu chưa hợp lệ xin kiểm tra lại!');
        }
        $v_member_id         = $arr_post['member_id'];
        $v_member_name       = $arr_post['txt_member_name'];
        $v_member_code       = mb_strtoupper(trim($arr_post['txt_member_code']));
        $v_member_address    = $arr_post['txt_member_address'];
        $v_member_email      = $arr_post['txt_member_email'];
        $rad_level           = $arr_post['rad_level'];
        $v_member_parent_id  = $arr_post['sel_member_parent'];
        $v_status            = $arr_post['chk_status'];
        $v_xml_data          = html_entity_decode($arr_post['XmlData']);
        $v_hdn_single_method = $arr_post['hdn_dsp_single_method'];
        $v_short_code        = $arr_post['txt_short_code'];
        $v_rad_village       = $arr_post['rad_village'];
        
        //kiem tra ma don vi
        if($this->_check_exists_member_code($v_member_code,$v_member_id) > 0)
        {
            $v_back_url = $this->goback_url.$v_hdn_single_method."/$v_member_id";
            $message    = 'Mã đơn vị đã tồn tại! Xin kiểm tra lại!';
            $this->exec_fail($v_back_url,$message,$arr_post);
            exit();
        }
        //
        if($rad_level != 2 && $this->_check_exist_exchange_email($v_member_email,$v_member_id) > 0)
        {
            $v_back_url = $this->goback_url.$v_hdn_single_method."/$v_member_id";
            $message    = 'Email trao đổi thông tin đã tồn tại !';
            $this->exec_fail($v_back_url,$message,$arr_post);
            exit();
        }
        //neu la cap xa => lấy thông tin từ huyện
        if($rad_level == 2)
        {
            $arr_info = $this->qry_single_member($v_member_parent_id);

            $v_member_email = $arr_info['C_EXCHANGE_EMAIL'];
            $v_xml_data     = $arr_info['C_XML_DATA'];
            $v_short_code   = $arr_info['C_SHORT_CODE'];

        }
        if($v_member_id == 0)//insert
        {
            //  Insert
            $stmt = "INSERT INTO t_ps_member 
                            ( 
                            C_NAME, 
                            C_CODE, 
                            C_SHORT_CODE,
                            C_ADDRESS, 
                            C_EXCHANGE_EMAIL, 
                            C_SCOPE, 
                            C_XML_DATA,
                            C_STATUS,
                            FK_MEMBER,
                            FK_VILLAGE_ID
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
                            ?,
                            ?,
                            ?
                            )";
            $params = array($v_member_name,$v_member_code,
                            $v_short_code,$v_member_address,
                            $v_member_email,$rad_level,
                            $v_xml_data,$v_status,
                            $v_member_parent_id,($v_rad_village == '')?NULL:$v_rad_village);
            $this->db->Execute($stmt, $params);
        }
        else //update
        {
            //check child
            if((int)$this->_check_exists_member_child($v_member_id) >0 && $rad_level == 2)
            {
                $this->exec_fail($this->goback_url.$v_hdn_single_method,'Cần phải loại bỏ hết đơn vị cấp xã trực thuộc mới có thể thay đổi cấp đơn vị',array('hdn_item_id'=> $v_member_id));
                exit();
            }
            $stmt = " UPDATE    t_ps_member  SET 
                                C_NAME              = ?, 
                                C_CODE              = ?, 
                                C_SHORT_CODE        = ?, 
                                C_ADDRESS           = ?, 
                                C_EXCHANGE_EMAIL    = ?, 
                                C_SCOPE             = ?, 
                                C_XML_DATA          = ?,
                                C_STATUS            = ?,
                                FK_MEMBER           = ?,
                                FK_VILLAGE_ID       = ?
                        WHERE               
                                PK_MEMBER           = ?
                    ";
            $params = array($v_member_name,$v_member_code,$v_short_code,
                            $v_member_address,$v_member_email,
                            $rad_level,$v_xml_data,$v_status,$v_member_parent_id,
                            ($v_rad_village == '')?NULL:$v_rad_village,$v_member_id);
            $this->db->Execute($stmt, $params);
        }
        if($this->db->ErrorNo() == 0)
        {
            $this->exec_done($this->goback_url);
        }
        $this->exec_fail($this->goback_url.$v_hdn_single_method,'Xảy ra lỗi trong quá trình cập nhật. Xin vui lòng thử lại!',array('hdn_item_id'=> $v_member_id));
    }
    
    /**
     * Dem so don vi cap con thuoc don vi dang kiem tra theo id
     * 
     * @return int So don vi truc thuoc la don vi cap con
     */
    private function _check_exists_member_child($v_memeber_id)
    {
        $stmt = "SELECT COUNT(PK_MEMBER) FROM t_ps_member WHERE FK_MEMBER = ?";
        return $this->db->GetOne($stmt,array($v_memeber_id));
    }
    private function _check_exist_exchange_email($v_exchange_email,$v_member_id = 0)
    {
         $v_condition = '';
        if((int)$v_member_id >0 )
        {
            $v_condition = " And PK_MEMBER <> '$v_member_id' ";
        }
        return $this->db->getOne("SELECT COUNT(PK_MEMBER) FROM t_ps_member WHERE (1=1) And C_EXCHANGE_EMAIL = ? AND C_SCOPE IN (0,1) $v_condition ",array($v_exchange_email));
    }
    /**
     * Kiem tra su ton tai ma cua don vi truc thuoc
     * 
     * @param int $v_code_member Ma cua member them moi hoac sua doi
     * @return int Khong ton tai return >0, Neu khong ton tai return = 0
     */
    private function _check_exists_member_code($v_code_member,$v_member_id = 0)
    {
        $v_condition = '';
        if((int)$v_member_id >0 )
        {
            $v_condition = " And PK_MEMBER <> '$v_member_id' ";
        }
        return $this->db->getOne("SELECT COUNT(PK_MEMBER) FROM t_ps_member WHERE (1=1) $v_condition And C_CODE = ?",array($v_code_member));
    }
    
    /**
     * Lay thong tin chi tiet mot member theo ID
     * 
     * @param int $v_member_id  Ma cua member can lay ID
     * @return array            Mang  chua thong tin chi tiet member theo id 
     */
    public function qry_single_member($v_member_id = 0)
    {
       
        if((int)$v_member_id == 0)
        {
            return array();
        }
        
        $stmt = "Select * From t_ps_member where PK_MEMBER = ?";
        $results = $this->db->GetRow($stmt,array($v_member_id));
        
        if($this->db->ErrorNo() ==0 )
        {
            return $results;
        }
        $this->exec_fail($this->goback_url,'Đã xảy ra lỗi. Xin vui lòng thử lại!');
    }
    
    /**
     * Lay tat ca cac don vi truc thuoc theo dieu kien loc 
     * 
     * @param array() $arr_filter Mang chua noi dung loc
     * @return array() mang chua danh sach cac don vi truoc thuoc
     */
    public function qry_all_member($arr_filter = array())
    {
        $condition = '';
        if(sizeof($arr_filter) >0 && trim(replace_bad_char($arr_filter['txt_filter'])) != '')
        {
            $v_filter  = trim(replace_bad_char($arr_filter['txt_filter']));
            $condition = " And (C_NAME like '%$v_filter%' OR C_CODE like '%$v_filter%') ";
            $stmt   = "SELECT
                    pm.*,
                    '' as C_XML_MEMBER_CHILD 
                  FROM t_ps_member pm
                  WHERE (1=1)
                      $condition
                  ORDER BY C_NAME ASC";
        }
        else 
        {
            $stmt   = "SELECT
                        (SELECT
                           CONCAT('<data>'
                                      , GROUP_CONCAT('<row '
                                      , CONCAT(' PK_MEMBER =\"',PK_MEMBER,'\" ')
                                      , CONCAT(' C_NAME =\"',C_NAME,'\" ')
                                      , CONCAT(' C_CODE=\"',C_CODE,'\" ')
                                      , CONCAT(' C_SCOPE=\"',C_SCOPE,'\" ')
                                      , CONCAT(' FK_MEMBER=\"',FK_MEMBER,'\" ')	
                                      , CONCAT(' C_STATUS=\"',C_STATUS,'\" ')	
                                      ,'/>' 
                                      SEPARATOR '')
                                 ,'</data>')
                         FROM t_ps_member
                         WHERE FK_MEMBER = pm.PK_MEMBER 
                         ORDER BY C_NAME ASC) AS C_XML_MEMBER_CHILD,
                        pm.*
                      FROM t_ps_member pm
                      WHERE FK_MEMBER = 0
                      ORDER BY C_NAME ASC";
        }
        
        return $this->db->getAll($stmt);
    }
    
    /**
     * Lay danh sach tat ca ca quan huyen
     * 
     * @return array Mang chua danh sách Quan/Huyen 
     */
    public function qry_all_member_level_1($v_member_id = 0)
    {
        $v_condition = '';
        if((int)$v_member_id > 0)
        {
            $v_condition = " And PK_MEMBER <> '$v_member_id' ";
        }
        $stmt = "Select
                        PK_MEMBER,
                        C_NAME,
                        C_CODE
                      From t_ps_member
                      Where C_SCOPE = 1
                            $v_condition
                            And C_STATUS =1";
        return $this->db->GetAll($stmt);
    }
    /**
     * xoa member
     * @param type $v_list_id
     */
    function delete_member($v_list_id = '')
    {
        if(trim($v_list_id) != '')
        {
            //xoa member
            $this->db->Execute("DELETE FROM t_ps_member WHERE PK_MEMBER IN ($v_list_id)");
            
            //xoa thu tuc internet member tiep nhan
            $this->db->Execute("DELETE FROM t_ps_record_type_member WHERE FK_MEMBER IN ($v_list_id)");
            //xoa can bo danh gia thuoc member
//            $this->db->Execute("DELETE
//                                FROM t_cores_list
//                                WHERE FK_LISTTYPE = (SELECT
//                                                       PK_LISTTYPE
//                                                     FROM t_cores_listtype
//                                                     WHERE C_CODE = '"._CONST_CAN_BO_DANH_GIA."')
//                                    AND ExtractValue(C_XML_DATA,'//item[@id=\"ddl_member\"]/value') NOT IN ($v_list_id)");
        }
        $this->exec_done($this->goback_url);
    }
    /**
     * lay toan bo xa truc thuoc cua huyen
     * @param type $distric_id
     * @return type
     */
    public function qry_all_village_of_district($distric_id)
    {
        $v_district_code = $this->db->getOne("SELECT C_CODE FROM t_ps_member WHERE PK_MEMBER = $distric_id");
        $sql = "SELECT DISTINCT
                    FK_VILLAGE_ID,
                    C_VILLAGE_NAME
                  FROM t_ps_record_history_stat
                  WHERE C_UNIT_CODE = '$v_district_code'
                      AND COALESCE(FK_VILLAGE_ID,0) > 0
                  ORDER BY C_VILLAGE_NAME";
        $arr_village = $this->db->GetAssoc($sql);
        return $arr_village;
    }
    
    public function do_synchronize()
    {
        $sql = "SELECT C_XML_DATA
                    FROM t_ps_member
                    WHERE C_SCOPE <> 2";
        $arr_all_unit = $this->db->getCol($sql);
        foreach($arr_all_unit as $xml_data)
        {
            $dom = simplexml_load_string($xml_data);
            $location = xpath($dom,'//item[@id="location"]/value',XPATH_STRING);
            $uri = xpath($dom,'//item[@id="uri"]/value',XPATH_STRING);
            try
            {
                $client = new SoapClient($location.'?wsdl', array('location' => $location,
                                                    'uri' => $uri));
                $result = $client->__soapCall('progress_report', array());

                $xml_district        = html_entity_decode($result->district_info);
                $xml_village         = html_entity_decode($result->village_info);
                $xml_internet_record = html_entity_decode($result->internet_record_info);

                //insert thong tin xu ly ho so cua tung don vi
                $this->insert_member_info($xml_district,$xml_village);
                //insert thong tin tinh trang xu ly ho so internet
                $this->insert_internet_record_info($xml_internet_record);
            }
            catch (Exception $ex)
            {
                //continue
            }
            
        }
    }
    
    public function insert_member_info($xml_district,$xml_village)
    {
        $sql_tmp = "INSERT INTO t_ps_record_history_stat
                            (C_UNIT_CODE,
                             C_SPEC_CODE,
                             C_HISTORY_DATE,
                             C_COUNT_TONG_TIEP_NHAN,
                             C_COUNT_TONG_TIEP_NHAN_TRONG_THANG,
                             C_COUNT_DANG_THU_LY,
                             C_COUNT_DANG_CHO_TRA_KET_QUA,
                             C_COUNT_DA_TRA_KET_QUA,
                             C_COUNT_DANG_THU_LY_DUNG_TIEN_DO,
                             C_COUNT_DANG_THU_LY_CHAM_TIEN_DO,
                             C_COUNT_DA_TRA_KET_QUA_TRUOC_HAN,
                             C_COUNT_DA_TRA_KET_QUA_DUNG_HAN,
                             C_COUNT_DA_TRA_KET_QUA_QUA_HAN,
                             C_COUNT_CONG_DAN_RUT,
                             C_COUNT_TU_CHOI,
                             C_COUNT_BO_SUNG,
                             C_COUNT_THU_LY_QUA_HAN,
                             C_COUNT_THUE,
                             C_COUNT_LUY_KE,
                             C_VILLAGE_NAME,
                             FK_VILLAGE_ID)
                VALUES ";
        //insert cho don vi cap huyen
        $dom_district = simplexml_load_string($xml_district);
        if(!empty($dom_district))
        {
            $unit_code = xpath($dom_district,'//unit_code',XPATH_STRING);
            $date = xpath($dom_district,'//date',XPATH_STRING);
            $arr_row = $dom_district->xpath('//row');
            $sql_item = '';
            foreach($arr_row as $row)
            {
                if($sql_item != '')
                {
                    $sql_item .= ', ';
                }
                $sql_item .= '(';
                $sql_item .= "'$unit_code'";//C_UNIT_CODE
                $sql_item .= ", '$row->spec_code'";//C_SPEC_CODE
                $sql_item .= ", '$date'";//C_HISTORY_DATE
                $sql_item .= ", '$row->count_tong_tiep_nhan'";//C_COUNT_TONG_TIEP_NHAN
                $sql_item .= ", '$row->count_tong_tiep_nhan_trong_thang'";//C_COUNT_TONG_TIEP_NHAN_TRONG_THANG
                $sql_item .= ", '$row->count_dang_thu_ly'";//C_COUNT_DANG_THU_LY
                $sql_item .= ", '$row->count_dang_cho_tra_ket_qua'";//C_COUNT_DANG_CHO_TRA_KET_QUA
                $sql_item .= ", '$row->count_da_tra_ket_qua'";//C_COUNT_DA_TRA_KET_QUA
                $sql_item .= ", '$row->count_dang_thu_ly_dung_tien_do'";//C_COUNT_DANG_THU_LY_DUNG_TIEN_DO
                $sql_item .= ", '$row->count_dang_thu_ly_cham_tien_do'";//C_COUNT_DANG_THU_LY_CHAM_TIEN_DO
                $sql_item .= ", '$row->count_da_tra_ket_qua_truoc_han'";//C_COUNT_DA_TRA_KET_QUA_TRUOC_HAN
                $sql_item .= ", '$row->count_da_tra_ket_qua_dung_han'";//C_COUNT_DA_TRA_KET_QUA_DUNG_HAN
                $sql_item .= ", '$row->count_da_tra_ket_qua_qua_han'";//C_COUNT_DA_TRA_KET_QUA_QUA_HAN
                $sql_item .= ", '$row->count_cong_dan_rut'";//C_COUNT_CONG_DAN_RUT
                $sql_item .= ", '$row->count_tu_choi'";//C_COUNT_TU_CHOI
                $sql_item .= ", '$row->count_bo_sung'";//C_COUNT_BO_SUNG
                $sql_item .= ", '$row->count_thu_ly_qua_han'";//C_COUNT_THU_LY_QUA_HAN
                $sql_item .= ", '$row->count_thue'";//C_COUNT_THUE
                $sql_item .= ", '$row->count_luy_ke'";//C_COUNT_LUY_KE
                $sql_item .= ", ''";//C_VILLAGE_NAME
                $sql_item .= ", '0'";//FK_VILLAGE_ID
                $sql_item .= ')';
            }
            
            
            $sql = "Delete From t_ps_record_history_stat 
                    WHERE FK_VILLAGE_ID = 0
                        AND C_UNIT_CODE = '$unit_code'
                        AND DATEDIFF(C_HISTORY_DATE,'$date') = 0";
            $this->db->Execute($sql);
            $sql = $sql_tmp . $sql_item;
            $this->db->Execute($sql);
        }
        //insert cho don vi cap xa
        $dom_village = simplexml_load_string($xml_village);
        if(!empty($dom_village))
        {
            $unit_code = xpath($dom_village,'//unit_code',XPATH_STRING);
            $date = xpath($dom_village,'//date',XPATH_STRING);
            $arr_row = $dom_village->xpath('//row');
            $sql_item = '';
            foreach($arr_row as $row)
            {
                if($sql_item != '')
                {
                    $sql_item .= ', ';
                }
                $sql_item .= '(';
                $sql_item .= "'$unit_code'";//C_UNIT_CODE
                $sql_item .= ", '$row->spec_code'";//C_SPEC_CODE
                $sql_item .= ", '$date'";//C_HISTORY_DATE
                $sql_item .= ", '$row->count_tong_tiep_nhan'";//C_COUNT_TONG_TIEP_NHAN
                $sql_item .= ", '$row->count_tong_tiep_nhan_trong_thang'";//C_COUNT_TONG_TIEP_NHAN_TRONG_THANG
                $sql_item .= ", '$row->count_dang_thu_ly'";//C_COUNT_DANG_THU_LY
                $sql_item .= ", '$row->count_dang_cho_tra_ket_qua'";//C_COUNT_DANG_CHO_TRA_KET_QUA
                $sql_item .= ", '$row->count_da_tra_ket_qua'";//C_COUNT_DA_TRA_KET_QUA
                $sql_item .= ", '$row->count_dang_thu_ly_dung_tien_do'";//C_COUNT_DANG_THU_LY_DUNG_TIEN_DO
                $sql_item .= ", '$row->count_dang_thu_ly_cham_tien_do'";//C_COUNT_DANG_THU_LY_CHAM_TIEN_DO
                $sql_item .= ", '$row->count_da_tra_ket_qua_truoc_han'";//C_COUNT_DA_TRA_KET_QUA_TRUOC_HAN
                $sql_item .= ", '$row->count_da_tra_ket_qua_dung_han'";//C_COUNT_DA_TRA_KET_QUA_DUNG_HAN
                $sql_item .= ", '$row->count_da_tra_ket_qua_qua_han'";//C_COUNT_DA_TRA_KET_QUA_QUA_HAN
                $sql_item .= ", '$row->count_cong_dan_rut'";//C_COUNT_CONG_DAN_RUT
                $sql_item .= ", '$row->count_tu_choi'";//C_COUNT_TU_CHOI
                $sql_item .= ", '$row->count_bo_sung'";//C_COUNT_BO_SUNG
                $sql_item .= ", '$row->count_thu_ly_qua_han'";//C_COUNT_THU_LY_QUA_HAN
                $sql_item .= ", '$row->count_thue'";//C_COUNT_THUE
                $sql_item .= ", '$row->count_luy_ke'";//C_COUNT_LUY_KE
                $sql_item .= ", '$row->village_name'";//C_VILLAGE_NAME
                $sql_item .= ", '$row->village_id'";//FK_VILLAGE_ID
                $sql_item .= ')';
            }
            
            
            $sql = "Delete From t_ps_record_history_stat 
                    WHERE FK_VILLAGE_ID <> 0 
                        AND C_UNIT_CODE = '$unit_code'
                        AND DATEDIFF(C_HISTORY_DATE,'$date') = 0";
            $this->db->Execute($sql);
            $sql = $sql_tmp . $sql_item;
            $this->db->Execute($sql);
        }
        
    }
    
    public function insert_internet_record_info($xml_internet_record)
    {
        $dom = simplexml_load_string($xml_internet_record);
        
        $processing     = xpath($dom,'//data/processing',XPATH_STRING);
        $arr_processing = json_decode(htmlspecialchars_decode($processing));
        
        $today_return     = xpath($dom,'//data/today_return',XPATH_STRING);
        $arr_today_return = json_decode(htmlspecialchars_decode($today_return));
        
        //Danh sach ho so dang xu ly
        foreach($arr_processing as $processing)
        {
            $sql = "UPDATE t_ps_record ";
            $sql .= " SET ";
            $sql .= " FK_RECORD_TYPE = '" . $processing["FK_RECORD_TYPE"] . "'";
            $sql .= ",C_RECORD_NO = '" . $processing["C_RECORD_NO"] . "'";
            $sql .= ",C_RECEIVE_DATE = '" . $processing["C_RECEIVE_DATE"] . "'";
            $sql .= ",C_RETURN_DATE = '" . $processing["C_RETURN_DATE"] . "'";
            $sql .= ",C_RETURN_PHONE_NUMBER = '" . $processing["C_RETURN_PHONE_NUMBER"] . "'";
            $sql .= ",C_XML_DATA = '" . $processing["C_XML_DATA"] . "'";
            $sql .= ",C_XML_PROCESSING = '" . $processing["C_XML_PROCESSING"] . "'";
            $sql .= ",C_DELETED = '" . $processing["C_DELETED"] . "'";
            $sql .= ",C_CLEAR_DATE = '" . $processing["C_CLEAR_DATE"] . "'";
            $sql .= ",C_XML_WORKFLOW = '" . $processing["C_XML_WORKFLOW"] . "'";
            $sql .= ",C_RETURN_EMAIL = '" . $processing["C_RETURN_EMAIL"] . "'";
            $sql .= ",C_REJECTED = '" . $processing["C_REJECTED"] . "'";
            $sql .= ",C_CITIZEN_NAME = '" . $processing["C_CITIZEN_NAME"] . "'";
            $sql .= ",C_REJECT_DATE = '" . $processing["C_REJECT_DATE"] . "'";
            $sql .= ",FK_VILLAGE_ID = '" . $processing["FK_VILLAGE_ID"] . "'";
            $sql .= ",C_BIZ_DAYS_EXCEED = '" . $processing["C_BIZ_DAYS_EXCEED"] . "'";
            $sql .= ",C_REJECT_REASON = '" . $processing["C_REJECT_REASON"] . "'";
            $sql .= ",C_BIZ_DONE_DATE = '" . $processing["C_BIZ_DONE_DATE"] . "'";
            $sql .= " WHERE C_RECORD_NO = '" . $processing["C_RECORD_NO"] . "'";
            
            $this->db->Execute($sql);
        }
        //Danh sach ho moi tra ket qua trong ngay
        foreach($arr_today_return as $today_return)
        {
            $sql = "UPDATE t_ps_record ";
            $sql .= " SET ";
            $sql .= " FK_RECORD_TYPE = '" . $today_return["FK_RECORD_TYPE"] . "'";
            $sql .= ",C_RECORD_NO = '" . $today_return["C_RECORD_NO"] . "'";
            $sql .= ",C_RECEIVE_DATE = '" . $today_return["C_RECEIVE_DATE"] . "'";
            $sql .= ",C_RETURN_DATE = '" . $today_return["C_RETURN_DATE"] . "'";
            $sql .= ",C_RETURN_PHONE_NUMBER = '" . $today_return["C_RETURN_PHONE_NUMBER"] . "'";
            $sql .= ",C_XML_DATA = '" . $today_return["C_XML_DATA"] . "'";
            $sql .= ",C_XML_PROCESSING = '" . $today_return["C_XML_PROCESSING"] . "'";
            $sql .= ",C_DELETED = '" . $today_return["C_DELETED"] . "'";
            $sql .= ",C_CLEAR_DATE = '" . $today_return["C_CLEAR_DATE"] . "'";
            $sql .= ",C_XML_WORKFLOW = '" . $today_return["C_XML_WORKFLOW"] . "'";
            $sql .= ",C_RETURN_EMAIL = '" . $today_return["C_RETURN_EMAIL"] . "'";
            $sql .= ",C_REJECTED = '" . $today_return["C_REJECTED"] . "'";
            $sql .= ",C_CITIZEN_NAME = '" . $today_return["C_CITIZEN_NAME"] . "'";
            $sql .= ",C_REJECT_DATE = '" . $today_return["C_REJECT_DATE"] . "'";
            $sql .= ",FK_VILLAGE_ID = '" . $today_return["FK_VILLAGE_ID"] . "'";
            $sql .= ",C_BIZ_DAYS_EXCEED = '" . $today_return["C_BIZ_DAYS_EXCEED"] . "'";
            $sql .= ",C_REJECT_REASON = '" . $today_return["C_REJECT_REASON"] . "'";
            $sql .= ",C_BIZ_DONE_DATE = '" . $today_return["C_BIZ_DONE_DATE"] . "'";
            $sql .= " WHERE C_RECORD_NO = '" . $today_return["C_RECORD_NO"] . "'";
            $this->db->Execute($sql);
        }
    }
}

?>
