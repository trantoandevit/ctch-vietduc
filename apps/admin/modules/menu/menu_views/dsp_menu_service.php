<?php
if (!defined('SERVER_ROOT')) {
    exit('No direct script access allowed');
}
$this->_page_title = 'Menu service';
$v_pop_win = isset($_REQUEST['pop_win']) ? '_pop_win' : '';
@session::init();
$v_is_admin = session::get('is_admin');
$v_user_id  = session::get('user_id');

$tab_select = get_request_var('type','');
?>
<form action="" name="frmMain" id="frmMain" method="POST">
    <div class="panel-body" id="tabs_service_menu">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_url" data-toggle="tab"><?php echo __('Url');?></a>
            </li>
            <li><a href="#tab_category" data-toggle="tab"><?php echo __('category');?></a>
            </li>
            <li><a href="#tab_article" data-toggle="tab" onclick="tab_article_onclick();"><?php echo __('article');?></a>
            </li>
            <li><a href="#tab_module" data-toggle="tab" onclick="tab_article_onclick();"><?php echo __('module');?></a>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content" style="margin-top:20px;">
            <div class="tab-pane fade in active" id="tab_url"> 
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo __('Url');?></label>
                        <div class="col-sm-10">
                            <input type="textbox" value="" name="txt_url" id="txt_url" class="form-control">
                        </div>
                    </div>
                    <div class="button-area">
                        <button type="button" class="btn btn-outline btn-success" onclick="btn_accept_url_onclick();">
                            <i class="fa fa-check" ></i> <?php echo __('update');?>
                        </button>
                        <button type="button" class="btn btn-outline btn-danger" onclick="btn_cancel_upload_onclick();">
                            <i class="fa fa-times" ></i> <?php echo __('cancel') ?>
                        </button>
                    </div> 
            </div>
            <div class="tab-pane fade" id="tab_category">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <colgroup>
                                    <col width="100%" />
                                </colgroup>
                                <tr>
                                    <th><?php echo __('category name'); ?></th>
                                </tr>
                                <?php $row = 0; ?>
                                <?php
                                foreach ($arr_all_category as $row_cat):
                                    $v_cat_name = $row_cat['C_NAME'];
                                    $v_cat_id = $row_cat['PK_CATEGORY'];
                                    $v_cat_slug = $row_cat['C_SLUG'];
                                    $v_status = $row_cat['C_STATUS'];
                                    $v_internal_order = $row_cat['C_INTERNAL_ORDER'];
                                    $v_level = strlen($v_internal_order) / 3 - 1;
                                    $v_level_text = '';
                                    for ($i = 0; $i < $v_level; $i++) {
                                        $v_level_text.=' -- ';
                                    }
                                    ?>
                                    <tr class="<?php echo ($v_status == 1) ? "row$row" : "line-through"; ?>">
                                        <td>
                                            <a 
                                            <?php if ($v_status == 1): ?>
                                                    href="javascript:void(0)" onclick="row_cat_onclick(this)" 
                                                <?php endif; ?>
                                                data-cat_id="<?php echo $v_cat_id; ?>"
                                                data-cat_name="<?php echo $v_cat_name; ?>"
                                                data-cat_slug="<?php echo $v_cat_slug; ?>">
                                                    <?php echo $v_level_text . $v_cat_name; ?>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php $row = ($row == 0) ? 1 : 0; ?>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    </div>
                    <div class="button-area">
                        <button type="button" name="trash" class="btn btn-outline btn-danger" onclick="btn_cancel_upload_onclick();">
                            <i class="fa fa-times" ></i> <?php echo __('cancel') ?>
                        </button>
                    </div>
            </div>
            <div class="tab-pane fade" id="tab_article">
                <iframe id="frame_article" name="frame_article" src="" style="width: 100%;min-height: 500px;margin-top:20px;overflow: hidden;">
                </iframe>
            </div>
            <div class="tab-pane fade" id="tab_module">
                <div class="form-group">
                    <div class="left-Col">
                        <label class="col-sm-2 control-label"><?php echo __('select module'); ?></label>
                    </div>
                    <div class="col-sm-10">
                        <select name="select_module" id="select_module" class="form-control">
                            <option value="public_service"><?php echo __('public service'); ?></option>
                            <option value="synthesis"><?php echo __('synthesis'); ?></option>
                            <option value="weblink"><?php echo __('weblink'); ?></option>
                            <option value="sitemap"><?php echo __('has sitemap'); ?></option>
                            <option value="feedback"><?php echo __('feedback'); ?></option>
                            <option value="evaluation"><?php echo __('cadre evaluation'); ?></option>
                            <option value="guidance"><?php echo __('administrative guide'); ?></option>
                            <option value="dsp_survey"><?php echo __('survey'); ?></option>
                            <option value="faq"><?php echo __('faq'); ?></option>
                            <option value="help"><?php echo __('help'); ?></option>
                            <option value="contact"><?php echo __('contact'); ?></option>
                        </select>
                    </div>
                </div>
                <div class="button-area">
                    <button type="button" class="btn btn-outline btn-success" onclick="btn_accept_module_onclick();">
                        <i class="fa fa-check" ></i> <?php echo __('update'); ?>
                    </button>
                    <button type="button" class="btn btn-outline btn-danger" onclick="btn_cancel_upload_onclick();">
                        <i class="fa fa-times" ></i> <?php echo __('cancel') ?>
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    $(document).ready(function(){
        $("#tabs_service_menu" ).tabs();
        var tab = '';
        <?php if($tab_select=='article'):?>
            tab = "#tab_<?php echo $tab_select;?>";
        $('#tabs_service_menu').tabs('select',tab);
        tab_article_onclick();
        <?php elseif($tab_select!=''):?>
            tab = "#tab_<?php echo $tab_select;?>";
        $('#tabs_service_menu').tabs('select',tab);
        <?php endif;?>
    });
    function btn_cancel_upload_onclick()
    {
        window.parent.hidePopWin();
    }
    function row_cat_onclick(row)
    {
        var arr_cat=new Array();
        arr_cat.push({'category_id':$(row).attr('data-cat_id'),
                      'category_name':$(row).attr('data-cat_name'),
                      'category_slug':$(row).attr('data-cat_slug'),
                      'service_type': 'category'
                     });
        returnVal = arr_cat;
        window.parent.hidePopWin(true);
    }
    function btn_accept_url_onclick()
    {
        var arr_url= new Array();
        arr_url.push({'url':$('#txt_url').val(),'service_type':'url'});
        returnVal = arr_url;
        window.parent.hidePopWin(true);
    }
    function btn_accept_module_onclick()
    {
        module_value=$('#tab_module select option:selected').val();
        module_name =$('#tab_module select option:selected').html();
        var arr_module= new Array();
        arr_module.push({'module_value':module_value,'module_name':module_name,'service_type':'module'});
        returnVal = arr_module;
        window.parent.hidePopWin(true);
    }
    function tab_article_onclick()
    {
        src='<?php echo $this->get_controller_url('article', 'admin').'dsp_all_article_svc/&parent_iframe_path=frame_article'; ?>';
        $('#frame_article').attr('src',src);
    }
</script>