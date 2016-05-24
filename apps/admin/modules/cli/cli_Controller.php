<?php

class cli_Controller extends Controller
{

    public function run_synchronize()
    {
        require __DIR__ . '/../member/member_Model.php';
        ini_set("default_socket_timeout", 6000);
        ini_set('memory_limit', '250M');
        set_time_limit(0);
        
        //dong bo hoa du lieu
        $member_model = new member_Model;
        $member_model->do_synchronize();
    }
	
	public function run_internet_record()
	{
		require __DIR__ . '/../internet_record/internet_record_Model.php';
        //include class mail
        require SERVER_ROOT. DS . 'libs' . DS . 'mail_sender.php' ;
		
		ini_set("default_socket_timeout", 6000);
        ini_set('memory_limit', '250M');
        set_time_limit(0);
		
		//chuyen ho so ve 1 cua
        $sql = "SELECT
                    PK_RECORD
                  FROM t_ps_record
                  WHERE C_STATUS = 0";
        $arr_record = $this->model->db->getCol($sql);
        $record_model = new internet_record_Model();
        
        foreach($arr_record as $record_id)
        {
            $record_model->do_confirm_record($record_id);
            
            $arr_data = $record_model->get_xml_record_data($record_id);
            $ws_location    = $arr_data['ws_location'];
            $ws_uri         = $arr_data['ws_uri'];
            
            try {
                $client = new SoapClient($ws_location.'?wsdl', array('location' => $ws_location,
                                                    'uri' => $ws_uri));
                
                $record_model->do_confirm($record_id,$client);
            } catch (Exception $ex) {
                
            }
            
        }
	}
}
