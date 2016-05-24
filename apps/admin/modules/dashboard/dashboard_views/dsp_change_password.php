<?php if (!defined('SERVER_ROOT')) exit('No direct script access allowed');

?>

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel"><?php echo __('Đổi mật khẩu')?></h4>
                    <?php echo Session::get('user_name');?>
                </div>
                <form action="<?php echo $this->get_controller_url();?>do_change_password/" method="post" name="loginForm" id="loginForm">
                    <input type="hidden" name="task" value="login"/>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="col-lg-4">
                                        <label><?php echo __('current password')?></label>
                                    </div>
                                    <div class="col-lg-6">
                                        <input class="form-control" name="txt_current_password" type="password"
                                               onblur="check_password_onblur(this)" 
                                               size="15" onkeypress="login(event);"
                                               />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="col-lg-4">
                                        <label><?php echo __('new password')?></label>
                                    </div>
                                    <div class="col-lg-6">
                                        <input class="form-control" name="txt_new_password" type="password"
                                               onblur="check_password_onblur(this)" 
                                               size="15" onkeypress="login(event);"
                                               />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="col-lg-4">
                                        <label><?php echo __('confirm new password')?></label>
                                    </div>
                                    <div class="col-lg-6">
                                            <input class="form-control" name="txt_confirm_new_password" type="password"
                                                   size="15" onkeypress="login(event);"
                                                   />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <label id="pass_check" class="required"></label>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" name="btn_change_password" onclick="btn_change_password_onclick();"><?php echo __('reset password')?></button>
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('close')?></button>
                    </div>
                </div>
                </form>


<script>
//    var url = '<?php // echo SITE_ROOT; ?>license/public/dsp_all_record_news' + condition_page

    var url = '<?php echo SITE_ROOT . 'admin/dashboard/';?>do_change_password/' ;
            document.loginForm.txt_current_password.focus();
            function setFocus() {
                document.loginForm.txt_login_name.select();
                document.loginForm.txt_login_name.focus();
            }
            function check_password_onblur(pass)
            {
                var no = $(pass).val().length;
                var str = '&nbsp;<?php echo __("check password");?>';
                if(no <6 && no >0)
                {
                    $('#pass_check').html('');
                    $('#pass_check').html(str);
                }
                else
                {
                    $('#pass_check').html('');
                }
            }
            function btn_change_password_onclick(){
                if (document.loginForm.txt_current_password.value == ''){
                    alert("Ban phai nhap [Mat khau hien hanh]!");
                    document.loginForm.txt_current_password.focus();
                    return;
                }
                if (document.loginForm.txt_new_password.value == ''){
                    alert("Ban phai nhap [Mat khau moi]!");
                    document.loginForm.txt_new_password.focus();
                    return;
                }
                if (document.loginForm.txt_confirm_new_password.value == ''){
                    alert("Ban phai [Xac nhan mat khau moi]!");
                    document.loginForm.txt_confirm_new_password.focus();
                    return;
                }
                if (document.loginForm.txt_new_password.value != document.loginForm.txt_confirm_new_password.value){
                    alert("Xac nhan mat khau khong dung!");
                    document.loginForm.txt_confirm_new_password.focus();
                    return;
                }
                if($('#pass_check').html().length != '')
                {
                    alert("Độ dài của mật khẩu nhỏ hơn 6!");
                    return;
                }
                var txt_new_password = document.loginForm.txt_new_password.value;
                $.ajax({
                     url:url,
                     type: 'POST',
                     data: {txt_new_password :txt_new_password},
                     success:function(result){
//                         $('#announced_record .modal-detail-content').html(data);
//                         $('#announced_record').modal();
                             if(result='1'){
                                 $('#myModal').modal('hide');
                             }   
                     }
                  });
            
                
            }

            function login(evt){
                if(navigator.appName=="Netscape"){theKey=evt.which}
                if(navigator.appName.indexOf("Microsoft")!=-1){theKey=window.event.keyCode}
                if(theKey==13){
                    btn_login_onclick();
                }
            }
</script>
