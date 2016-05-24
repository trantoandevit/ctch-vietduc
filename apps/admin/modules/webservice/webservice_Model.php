<?php if (!defined('SERVER_ROOT')) exit('No direct script access allowed');

class webservice_Model extends Model {

    function __construct()
    {
        parent::__construct();
    }
    
    public function get_data_of_member()
    {
         $sql = "SELECT
                    PK_MEMBER,
                    C_NAME
                  FROM t_ps_member
                  WHERE (FK_MEMBER < 1
                       OR FK_MEMBER IS null) AND C_STATUS = 1";
        $arr_all_district = $this->db->getAll($sql);
        
        $sql = "SELECT
                    PK_MEMBER,
                    C_NAME,
                    FK_MEMBER
                  FROM t_ps_member
                  WHERE FK_MEMBER > 0 AND C_STATUS = 1";
        $arr_all_village = $this->db->getAll($sql);
        
        //tao array return
        $arr_return = array();
        foreach($arr_all_district as $arr_district)
        {
            $v_name = $arr_district['C_NAME'];
            $v_id   = $arr_district['PK_MEMBER'];
            array_push($arr_return, array('C_CODE'=>$v_id,'C_NAME'=>$v_name));
                    
            foreach($arr_all_village as $key => $arr_village)
            {
               $v_village_name = $arr_village['C_NAME'];
               $v_village_id   = $arr_village['PK_MEMBER'];
               $v_parent_id    = $arr_village['FK_MEMBER'];
               if($v_parent_id != $v_id)
               {
                   continue;
               }
               array_push($arr_return, array('C_CODE'=>$v_village_id,'C_NAME'=>'--- '.$v_village_name));
               unset($arr_all_village[$key]);
            }
        }
        return $arr_return;
    }
}