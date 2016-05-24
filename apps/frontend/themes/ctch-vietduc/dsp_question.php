<?php if (!defined('SERVER_ROOT')) exit('No direct script access allowed'); ?>
<?php
$VIEW_DATA['title'] = $this->website_name;

$VIEW_DATA['v_banner'] = $v_banner;
$VIEW_DATA['arr_all_website'] = $arr_all_website;
$VIEW_DATA['arr_all_menu_position'] = $arr_all_menu_position;

$VIEW_DATA['arr_css'] = array('question');
$VIEW_DATA['arr_script'] = array('jquery.slimscroll.min', 'my_js/cq/question');

$this->render('dsp_header', $VIEW_DATA, $this->theme_code);
require 'libs/recaptcha/recaptchav2.php';
?>
<script>
    var _CONST_LIST_DS_DOI_TAC = '<?php echo _CONST_LIST_DS_DOI_TAC ?>';
</script>
<section ng-cloak ng-controller="content">
    <div class="container content">
        <div class="row">
            <div class="col-md-5 q_left">

                <div class="ql_head">
                    <h3><i class="fa fa-question-circle-o"></i> Gửi câu hỏi</h3>
                </div>
                <div class="ql_content">
                    <form action="#" class="form" id="frmCQ" data-toggle="validator" role="form" >
                        <div class="row qrf_row">
                            <label class="col-sm-4 control-label">Họ và tên: <span>(*)</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="txt_name" id="txt_name" required>
                            </div>
                        </div>
                        <div class="row qrf_row">
                            <label class="col-sm-4 control-label">Tiêu đề câu hỏi:  <span>(*)</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="txt_title" id="txt_title" required>
                            </div>
                        </div>
                        <div class="row qrf_row">
                            <label class="col-sm-4 control-label">Số điện thoại:  <span>(*)</span></label>
                            <div class="col-sm-8">
                                <input type="text" data-minlength="10" pattern="^[_0-9]{1,}$" class="form-control" name="txt_phone" id="txt_phone" required>
                            </div>
                        </div>
                        <div class="row qrf_row">
                            <label class="col-sm-4 control-label">Email:  <span>(*)</span></label>
                            <div class="col-sm-8">
                                <input type="email" class="form-control" name="txt_email" id="txt_email" required>
                            </div>
                        </div>
                        <div class="row qrf_row">
                            <label class="col-sm-4 control-label">Lĩnh vực:  <span>(*)</span></label>
                            <div class="col-sm-8">
                                <select class="form-control" name="selSpec" id="">
                                    <option ng-repeat="cq_field in cq_field_list" value="{{cq_field.PK_FIELD}}">{{cq_field.C_NAME}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="row qrf_row">
                            <label class="col-sm-4 control-label">Nội dung:  <span>(*)</span></label>
                            <div class="col-sm-8">
                                <textarea class="form-control" rows="7" name="txt_content" id="txt_content" required></textarea>
                            </div>
                        </div>
                        <div class="row qrf_row">
                            <div class="recaptcha col-sm-12">
                                <div class="g-recaptcha" data-sitekey="<?php echo recaptchav2::$public_key ?>"></div>
                                <span id="msg_error_captchar" class="msg_error"></span>
                            </div>
                        </div>
                        <div class="row qrf_row_btn">
                            <label class="col-sm-4 control-label"></label>
                            <div class="col-sm-8">
                                <button type="submit" class="btn btn-primary" id="btn_send_question">Gửi câu hỏi</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-7 q_right">
                <div class="row">
                    <div class="col-md-12">
                        <div class="qr_head">
                            <h3><i class="fa fa-book"></i> Danh sách câu hỏi</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="qr_content">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="qri_search">
                                        <input type="text" id="key_search_cq" class="form-control" aria-describedby="inputSuccess2Status" placeholder="Nhập từ khóa tìm kiếm...">
                                        <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="list_cq">
                                <div ng-repeat="item in arr_question" class="col-md-12">   
                                    <div class="qrc_box">       
                                        <div class="row qrcb_head">           
                                            <div class="col-md-12">               
                                                <h3><i class="glyphicon glyphicon-question-sign"></i> {{item.C_TITLE}}</h3>           
                                            </div>      
                                        </div>      
                                        <div class="row qrcb_info_bottom">     
                                            <div class="col-md-12">         
                                                <h6>Người hỏi: {{item.C_NAME}} ({{item.C_DATE_DDMMYYY}})</h6>   
                                            </div>     
                                        </div>     
                                        <div class="row qrcb_content">   
                                            <div class="col-md-12">
                                                <p ng-bind-html="item.C_CONTENT"></p>
                                            </div>      
                                        </div>       
                                        <div class="row qrcb_view">     
                                            <div class="col-md-12">        
                                                <h5><a href="javascript:void(0);" data-toggle="modal" data-target="#myModalCTCH" ng-click="show_answer(item)" class="item_view_answer" data-id="70"><i class="fa fa-commenting-o"></i> Xem trả lời</a></h5> 
                                            </div>     
                                        </div> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="text-center">
                        <paging
                            page="paging.page" 
                            page-size="paging.pagesize" 
                            total="paging.total"
                            paging-action="paging.pagging_action()">
                        </paging> 
                    </div>
                </div>
            </div>


        </div>
    </div>
    <div class="modal fade" id="myModalCTCH" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog md_tra_cuu">
            <div class="modal-content">
                <div class="modal-header mh_header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h3 class="modal-title tc_header" id="myModalLabel">Nội dung hỏi đáp</h3> 
                </div>
                <div class="modal-body">
                    <div class="row loading" style="display: none; text-align: center">
                        <div class="col-lg-12">
                            <img src="<?php echo SITE_ROOT . 'public/images/loading.gif' ?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 detail">
                            <h4><i class="fa fa-user" aria-hidden="true"></i>  Người hỏi: {{popup_question.C_NAME}} ({{popup_question.C_DATE_DDMMYYY}})</h4>
                            <h4><i class="fa fa-question-circle" aria-hidden="true"></i>  Nội dung câu hỏi</h4>
                            <h5 ng-bind-html="popup_question.C_CONTENT"></h5>
                            <h4><i class="fa fa-hand-o-right" aria-hidden="true"></i>  Bác sĩ trả lời :</h4>
                            <h5 ng-bind-html="popup_question.C_ANSWER"></h5>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
</section>
<style>
    #myModalCTCH .modal-header
    {
        background-color:#005aab;
        color:white;
    }
    #myModalCTCH
    {
        font-family: "roboto";
    }
    #myModalCTCH h5
    {
        padding-left:10px;
    }
    #myModalCTCH .modal-header span
    {
        color:white;
    }
    #myModalCTCH .modal-header .close
    {
        opacity: 1;
    }
    #myModalCTCH .modal-body i
    {
        color:#005aab;
    }
    /*    .g-recaptcha
        {
            transform:scale(1);-webkit-transform:scale(1);transform-origin:0 0;-webkit-transform-origin:0 0;
        }*/
    .recaptcha
    {
        display:block;
        margin-top:15px;
    }
    .g-recaptcha div div
    {
        margin:0 auto;
    }
</style>
<?php
$this->render('dsp_footer', $VIEW_DATA, $this->theme_code);
