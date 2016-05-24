<?php
defined('DS') or die();
$this->is_service = isset($this->is_service) ? $this->is_service : false;
if ($this->is_service)
{
    $header = 'dsp_header_pop_win.php';
    $footer = 'dsp_footer_pop_win.php';
}
else
{
    $header                = 'dsp_header.php';
    $footer                = 'dsp_footer.php';
}
$this->_page_title = __('media');
?>
<style>
    #left, #right{float:left;padding:10px;min-height: 495px;}
    h4{font-size: 13px;}
    #left{width: 25%;background-color: #d2dfe8;}
    #right{width: 75%;background-color: #eeeeee;}
    #filemenu{padding: 5px;}
    #upload{border:4px dashed #ddd; width:80%; height:80px; padding:10px;margin:0 auto;margin-top:10px;margin-bottom: 30px;}
    #uploaded{border: 1px solid #ddd; width:80%; height:70px; padding:10px; overflow-y:auto;margin:0 auto;}
    /*table{background: white;}*/
    .BannerMenuLast a{color: red !important}
/*    table a,a:visited{color:#333;}*/
    #submenu{background-color: #eeeeee;line-height: 30px;}
    #txt_path{padding: 4px;}
    table tr.selected{background-color: lightsteelblue;}
    #table_container{height: 450px;overflow-y: auto;background-color: white;}
</style>
<link href="<?php echo SITE_ROOT; ?>public/js/jquery/jquery-ui.css" rel="stylesheet" type="text/css"/>

<link rel="stylesheet" type="text/css" href="<?php echo SITE_ROOT ?>public/js/jquery/jquery.treeview.css"/>
<script src="<?php echo SITE_ROOT ?>public/js/jquery/jquery.treeview.js"></script>
<!--upload-->
<script src="<?php echo SITE_ROOT; ?>public/js/mfupload.js" type="text/javascript"></script>

<?php
echo $this->hidden('controller', $this->get_controller_url());
echo $this->hidden('extensions', strtolower(Session::get('media_extensions')));
echo $this->hidden('htaccess', file_exists('.htaccess') ? 1 : '');

echo $this->hidden('hdn_upload', 'upload');
echo $this->hidden('hdn_drag_text', __('{drag text}'));
echo $this->hidden('hdn_uploaded', __('uploaded'));
echo $this->hidden('hdn_delete_msg', __('are you sure to delete all selected object?'));
echo $this->hidden('hdn_newdir_method', 'create_dir');
echo $this->hidden('hdn_delete_method', 'delete_items');
echo $this->hidden('hdn_details_method', 'dsp_item_details');
echo $this->hidden('get_dir_content', 'get_dir_content');

echo $this->hidden('DS', DS);
echo $this->hidden('lang_newdir_msg', __('please enter folder name'));
echo $this->hidden('lang_directory', __('directory'));
echo $this->hidden('lang_up_a_level', __('up a level'));
echo $this->hidden('lang_preview', __('preview'));
?>
<div id="file" class="row panel-default" style="margin-top:50px;">
    <div id="filemenu" class="panel panel-heading" style="margin:0;">
        <button type="button" id="btn_left_pane" style="margin-right: 10px;" class="btn btn-outline btn-primary">
            <i class="fa fa-list"></i> <?php echo __('left pane') ?>
        </button>
        <?php if ($this->is_service): ?>
            <button type="button" id="btn_pick_file" style="margin-right: 10px;" class="btn btn-outline btn-success" onclick="pick_file_onclick();">
                <i class="fa fa-check"></i> <?php echo __('pick file(s)') ?>
            </button>
        <?php endif; ?>
        <?php // if (Session::check_permission('THEM_MOI_MEDIA',0)): ?>
            <button type="button" id="btn_new_dir" style="margin-right: 10px;" class="btn btn-outline btn-warning" onclick="newdir_onclick();">
                <i class="fa fa-plus"></i> <?php echo __('new directory') ?>
            </button>
        <?php // endif; ?>
        <?php // if (Session::check_permission('XOA_MEDIA',0)): ?>
            <button type="button" id="btn_delete" style="margin-right: 10px;" class="btn btn-outline btn-danger" onclick="delete_onclick();">
                <i class="fa fa-times"></i> <?php echo __('delete') ?>
            </button>
        <?php // endif; ?>
    </div>
    <div id="submenu" class="panel-body">
        <input type="text" name="txt_path" id="txt_path" size="50" value="/" readonly/>
    </div>
    <div class="col-sm-12" style="padding:0;">
        <div id="left" class="col-sm-4">
            <div id="folder" class="ui-widget" style="position:relative;">   
                <div class="ui-widget-header ui-state-default ui-corner-top">
                    <h4><?php echo __('folders') ?></h4>
                </div>
                <div class="ui-widget-content" style="height:200px;overflow-y: auto;" id="category-content">
                    <div class="loading_overlay" style="display:none;"></div>
                    <ul  class="filetree treeview">
                        <li class="closed">
                            <span class="folder" onclick="item_onclick(this)" data-loaded="1" data-name="<?php echo __('root directory') ?>" data-path=""><?php echo __('root directory') ?></span>
                            <ul id="root_directory"></ul>
                        </li>
                    </ul>
                </div>
            </div>
            <h2></h2>
            <?php // if (Session::check_permission('THEM_MOI_MEDIA', 0)): ?>
                <div id="details" class="ui-widget">
                    <div class="ui-widget-header ui-state-default ui-corner-top">
                        <h4><?php echo __('upload') ?></h4>
                    </div>
                    <div class="ui-widget-content" style="height:200px;overflow-y: auto;position: relative;" id="category-content">
                        <div class="loading_overlay" style="display: none;text-align: center"></div>
                        <div id="upload"></div>
                        <div id="uploaded">
                        </div>
                    </div>
                </div>
            <?php // endif; ?>
        </div>
        <div id="right" class="col-sm-8">
            <table class="adminlist" width="100%" cellspacing="0" border="1">
                <colgroup>
                    <col width="10%">
                    <col width="45%">
                    <col width="20%">
                    <col width="35%">
                </colgroup>
                <tr>
                    <th><input type="checkbox" id="chk_all" onclick="chk_all_onclick()"/></th>
                    <th><?php echo __('item name') ?></th>
                    <th><?php echo __('item type') ?></th>
                    <th><?php echo __('modified') ?></th>
                </tr>
            </table>
            <div id="table_container" style="">
                <table class="adminlist data filetree" width="100%" cellspacing="0" border="1">
                    <colgroup>
                        <col width="10%">
                        <col width="45%">
                        <col width="20%">
                        <col width="35%">
                    </colgroup>
                </table>
            </div>
        </div>
    </div>
</div>
