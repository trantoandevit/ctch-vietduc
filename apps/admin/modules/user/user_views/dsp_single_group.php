<?php if (!defined('SERVER_ROOT')) { exit('No direct script access allowed');}

$arr_single_group           = $VIEW_DATA['arr_single_group'];
$arr_parent_ou_path         = $VIEW_DATA['arr_parent_ou_path'];
$arr_all_user_by_group      = $VIEW_DATA['arr_all_user_by_group'];
if (isset($arr_single_group['PK_GROUP']))
{
    $v_group_id    = $arr_single_group['PK_GROUP'];
    $v_code        = $arr_single_group['C_CODE'];
    $v_name        = $arr_single_group['C_NAME'];
    $v_is_built_in = $arr_single_group['C_BUILT_IN'];
}
else
{
    $v_group_id    = 0;
    $v_code        = '';
    $v_name        = '';
    $v_is_built_in = 0;
}
$v_xml_data = '';

//display header
$v_template_title = ($v_group_id > 0) ? __('update user group info') . $v_name : __('add user group');
$this->_page_title = $v_template_title;

$v_pop_win = isset($_REQUEST['pop_win']) ? '_pop_win' : '';
//------------------------------------------------------------------------------
?>
<form name="frmMain" method="post" id="frmMain" action=""><?php
    echo $this->hidden('controller', $this->get_controller_url());

    echo $this->hidden('hdn_dsp_single_method', 'dsp_single_group');
    echo $this->hidden('hdn_dsp_all_method', 'dsp_all_group');
    echo $this->hidden('hdn_update_method', 'update_group');
    echo $this->hidden('hdn_delete_method', 'delete_group');

    echo $this->hidden('hdn_item_id', $v_group_id);
    echo $this->hidden('XmlData', $v_xml_data);

    echo $this->hidden('pop_win', $v_pop_win);

    echo $this->hidden('hdn_user_id_list', '');
    
    echo $this->hidden('hdn_grant_category','');
    
    echo $this->hidden('hdn_grant_function', '');
    
    echo $this->hidden('hdn_website_id','');
    
    echo $this->hidden('hdn_grant_function_without_website','');
    ?>
    <!-- Toolbar -->
    <!--<h2 class="module_title">Cập nhật nhóm NSD</h2>-->

    <!-- Cot tuong minh -->
    <div class="panel-body" id="tabs_user">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs">
            <li class="active"><a href="#group_info" data-toggle="tab"><?php echo __('group info')?></a>
            </li>
            <li><a href="#group_user" data-toggle="tab"><?php echo __('members')?></a>
            </li>
            <li><a href="#group_permit" data-toggle="tab"><?php echo __('grant permission to group')?></a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade in active" id="group_info">
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo __('in ou')?></label>
                        <?php foreach ($arr_parent_ou_path as $id => $name): ?>
                        <label>/<?php echo $name;?></label>
                    <?php endforeach; ?>
                    <?php echo $this->hidden('hdn_parent_ou_id', $id);?>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo __('group code')?> <label class="required">(*)</label></label>
                        <div class="col-sm-9">
                            <input type="text" name="txt_code" id="txt_code" value="<?php echo $v_code; ?>"
                                   class="form-control" maxlength="255" style="width:40%"
                                   onKeyDown="return handleEnter(this, event);"
                                   data-allownull="no" data-validate="text"
                                   data-name="<?php echo __('group code') ?>"
                                   data-xml="no" data-doc="no"
                                   autofocus="autofocus"
                                   <?php echo ($v_is_built_in > 0) ? ' readonly="readonly"' : ''; ?>
                                   />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo __('group name')?> <label class="required">(*)</label></label>
                        <div class="col-sm-9">
                            <input type="text" name="txt_name" id="txt_name" value="<?php echo $v_name; ?>"
                                   class="form-control" maxlength="255" style="width:80%"
                                   onKeyDown="return handleEnter(this, event);"
                                   data-allownull="no" data-validate="text"
                                   data-name="<?php echo __('group name') ?>"
                                   data-xml="no" data-doc="no"
                                   <?php echo ($v_is_built_in > 0) ? ' readonly="readonly"' : ''; ?>
                                   />
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="group_user">
                <div id="users_in_group" class="edit-box">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="tbl_user_in_group">
                                <colgroup>
                                    <col width="5%" />
                                    <col width="95%" />
                                </colgroup>
                                <tr>
                                    <th>#</th>
                                    <th><?php echo __('user name') ?></th>
                                </tr>
                                <?php for ($i = 0; $i < count($arr_all_user_by_group); $i++): ?>
                                    <?php
                                    $v_user_id = $arr_all_user_by_group[$i]['PK_USER'];
                                    $v_user_name = $arr_all_user_by_group[$i]['C_NAME'];
                                    $v_status = $arr_all_user_by_group[$i]['C_STATUS'];

                                    $v_icon_file_name = ($v_status > 0) ? 'icon-16-user.png' : 'icon-16-user-inactive.png';
                                    $v_class = 'row' . strval($i % 2);
                                    ?>
                                    <tr class="<?php echo $v_class; ?>" id="tr_<?php echo $v_user_id; ?>">
                                        <td class="center">
                                            <input type="checkbox" name="chk" value="<?php echo $v_user_id; ?>" id="user_<?php echo $v_user_id; ?>" />
                                        </td>
                                        <td>
                                            <img src="<?php echo $this->template_directory . 'images/' . $v_icon_file_name; ?>" border="0" align="absmiddle" />
                                            <label for="user_<?php echo $v_user_id; ?>"><?php echo $v_user_name; ?></label>
                                        </td>
                                    </tr>
                                <?php endfor; ?>
                            </table>
                        </div>
                    </div>
                </div>
                <div id="users_in_ou_action">
                    <button type="button" name="btn_add_user" class="btn btn-outline btn-primary btn-sm" style="margin:10px 5px;" onclick="dsp_all_user_to_add();">
                        <i class="fa fa-plus"></i> <?php echo __('add user to group'); ?>
                    </button>
                    <button type="button" name="btn_remove_user" class="btn btn-outline btn-danger btn-sm" style="margin:0 5px;" onclick="remove_user_from_group();">
                        <i class="fa fa-times"></i> <?php echo __('remove user from group') ?>
                    </button>
                </div>
            </div>
            <div class="clear">&nbsp;</div>
            <div class="tab-pane fade" id="group_permit">
                <div id="permit_without_website">
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><?php echo __('Quyền quản trị')?></label>
                            <div class="col-sm-10">
                                <?php
                                $this->load_xml('xml_permission_without_website.xml');
                                echo $this->render_form_display_single();
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><?php echo __('select website')?></label>
                            <div class="col-sm-10">
                                <select name="sel_website" onchange="get_website_permit(this.value)" class="form-control">
                                    <option value="">&nbsp;</option>
                                    <?php echo $this->generate_select_option($arr_all_website_option); ?>
                                </select>
                            </div>
                        </div>
                        <div id="website_permit"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Button -->
    <div class="button-area">
        <button type="button" name="btn_update_group" class="btn btn-outline btn-success" onclick="btn_update_group_onclick();">
            <i class="fa fa-check"></i> <?php echo __('update'); ?>
        </button>
        <?php $v_back_action = ($v_pop_win === '') ? 'btn_back_onclick();' : 'try{window.parent.hidePopWin();}catch(e){window.close();};';?>
        <button type="button" name="cancel" class="btn btn-outline btn-danger" onclick="<?php echo $v_back_action;?>">
            <i class="fa fa-times"></i> <?php echo __('cancel'); ?>
        </button>
    </div>

    
    
</form>
<script>
    $(document).ready(function() {
    	$( "#tabs_group" ).tabs();
        
         v_url =  "<?php echo $this->get_controller_url(); ?>arp_group_permit_without_website/&group_id=" + $('#hdn_item_id').val();
                $.getJSON(v_url, function(current_permit) {
                    for (i=0; i<current_permit.length; i++)
                    {
                        q = '#' + current_permit[i];
                        $(q).attr('checked', true);
                    }
                });
    });


    function add_user(returnVal) {

        json_data = JSON.stringify(returnVal);

        for (i=0; i<returnVal.length; i++)
        {
            v_user_id = returnVal[i].user_id;
            v_user_name = returnVal[i].user_name;
            v_user_status = returnVal[i].user_status;

            //Neu user chua co trong group thi them vao
            q = '#user_' + v_user_id;
            if( $(q).length < 1 )
            {
                html = '<tr id="tr_' + v_user_id + '">';
                html += '<td class="center">';
                html +=     '<input type="checkbox" name="chk" value="' + v_user_id + '" id="user_' + v_user_id + '" />';
                html += '</td>';

                v_icon_file_name = (v_user_status > 0) ? 'icon-16-user.png' : 'icon-16-user-inactive.png';
                html += '<td>';
                html += '<img src="<?php echo $this->template_directory;?>images/' + v_icon_file_name + '" border="0" align="absmiddle" />';
                html += '<label for="user_' + v_user_id + '">' + v_user_name + '</label>';
                html += '</td></tr>';
                $('#tbl_user_in_group').append(html);
            }

        }
    }

    function dsp_all_user_to_add()
    {
        var url = '<?php echo $this->get_controller_url();?>/dsp_all_user_by_ou_to_add/&pop_win=1';

        showPopWin(url, 450, 350, add_user);
    }

    function remove_user_from_group()
    {
        var q = "input[name='chk']";
        $(q).each(function(index) {
            if ($(this).is(':checked'))
            {
                v_user_id = $(this).val();
                s = '#tr_' + v_user_id;
                $(s).remove();
            }
        });
    }

    //ghi lai danh sach User hien tai trong Group
    function btn_update_group_onclick()
    {
        // lay danh sach nguoi dung
        var arr_user_id = new Array();
        var q = "input[name='chk']";
        $(q).each(function(index) {
            arr_user_id.push($(this).val());
        });

        document.frmMain.hdn_user_id_list.value = arr_user_id.join();

        //Lay danh sach ma function da danh dau
        var q = "#permit_without_website input[type='checkbox']";
        var arr_checked_function_without_web = new Array();
        $(q).each(function (index){
            if ($(this).is(':checked') && parseBoolean($(this).attr('data-xml')))
            {
                arr_checked_function_without_web.push($(this).attr('id'));
            }
        });
        
        var q = "#website_permit input[type='checkbox']";
        var arr_checked_function = new Array();
        var arr_checked_category = new Array();
        $(q).each(function(index) {
            if ($(this).is(':checked') && parseBoolean($(this).attr('data-xml')))
            {
                if(parseBoolean($(this).attr('data-category')))
                {
                    arr_checked_category.push($(this).attr('data-id'));
                }
                else
                {
                    arr_checked_function.push($(this).attr('id'));
                }
            }
        });
        
        $('#hdn_grant_function_without_website').val(arr_checked_function_without_web.join());
        $('#hdn_grant_function').val(arr_checked_function.join());
        $('#hdn_grant_category').val(arr_checked_category.join());
        website_id = $('[name="sel_website"]').val();
        $('#hdn_website_id').val(website_id);
        
        btn_update_onclick();
    }


    function get_website_permit(website_id)
    {
        $.ajax({url:"<?php echo $this->get_controller_url();?>dsp_website_permit/"+website_id, success:function(result){
                $("#website_permit").html(result);
                //Danh dau cac quyen da duoc phan
                v_url =  "<?php echo $this->get_controller_url(); ?>arp_group_permit_on_website/&website_id=" + website_id + '&group_id=' + $('#hdn_item_id').val();
                $.getJSON(v_url, function(current_permit) {
                    for (i=0; i<current_permit.length; i++)
                    {
                        q = '#' + current_permit[i];
                        $(q).attr('checked', true);
                    }
                });

                v_url = "<?php echo $this->get_controller_url(); ?>arp_group_permit_on_category/&group_id=" + $('#hdn_item_id').val();
                $.getJSON(v_url, function(current_permit) {
                    for (i=0; i<current_permit.length; i++)
                    {
                        q = '#cat_' + current_permit[i];
                        $(q).attr('checked', true);
                    }
                });
            }
        });
    }


</script>
<?php $this->template->display('dsp_footer' .$v_pop_win . '.php');