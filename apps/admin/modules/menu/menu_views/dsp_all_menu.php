<?php if (!defined('SERVER_ROOT')) {exit('No direct script access allowed');}?>
<?php
//header
@session::init();
$v_website_id = session::get('session_website_id');
$this->_page_title = __('menu manager');
if(isset($arr_all_position[0]['PK_MENU_POSITION']))
{
    $v_position_id  = isset($_POST['hdn_position_id'])?$_POST['hdn_position_id']:$arr_all_position[0]['PK_MENU_POSITION'];
}
else
{
    $v_position_id = '';
}
// Lay gia chi C_TYPE cua menu load hien tai
$v_check_sitemap = 0;
for($i = 0;$i< count($arr_all_position);$i ++)
{
    if($arr_all_position[$i]['PK_MENU_POSITION'] == $v_position_id)
    {
        $v_check_sitemap = $arr_all_position[$i]['C_TYPE'];
        break;
    }
}
$v_chk_sitemap = ($v_check_sitemap == NULL OR $v_check_sitemap == 0)?0:$v_check_sitemap;

$v_theme_xml    = isset($arr_theme_position['C_XML_DATA'])?$arr_theme_position['C_XML_DATA']:'';

if($v_theme_xml!='')
{
    $dom    = simplexml_load_string($v_theme_xml);
    $x_path = '//data/item[@id="txtvitrimenu"]/value';
    $r      = $dom->xpath($x_path);
    if(isset($r[0]))
    {
       $arr_theme_position_menu =  explode(',', $r[0]);
    }
    else
    {
        $arr_theme_position_menu = array();
    }
}

if(isset($website_menu))
{
    $dom    = simplexml_load_string($website_menu);
    $x_path = '//theme_position[@id_website='.$v_website_id.']';
    $r      = $dom->xpath($x_path);
   
}
?>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header" style="font-size: 32px;"><?php echo __('menu manager'); ?></h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<form name="frmMain" id="frmMain" action="" method="POST" class="form-horizontal">
    <?php
    echo $this->hidden('controller',$this->get_controller_url());
    echo $this->hidden('hdn_item_id',0);
    echo $this->hidden('hdn_item_id_list','');

    echo $this->hidden('hdn_dsp_single_method','dsp_single_menu');
    echo $this->hidden('hdn_dsp_all_method','dsp_all_menu');
    echo $this->hidden('hdn_update_method','update_menu');
    echo $this->hidden('hdn_delete_method','delete_menu');
    echo $this->hidden('hdn_position_id',$v_position_id);
    echo $this->hidden('hdn_item_id_swap',0);
    
    //su dung de check site map
    echo $this->hidden('hdn_chk_sitemap',$v_chk_sitemap);
    ?>
    <div class="row">
    <div class="col-lg-12">
    <?php if ($arr_theme_position_menu != array()): ?>
        <div class="col-lg-3" id="theme_position">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?php echo __('theme position'); ?>
                </div>
                <div class="panel-body">
                    <?php foreach ($arr_theme_position_menu as $position_name): ?>
                        <div class="theme_position_item">
                            <div class="row">
                                <div class="col-sm-12"
                                    <div class="form-group">
                                        <label><?php echo $position_name; ?></label>
                                        <select class="form-control" name="theme_position_select" style="width: 100%" data-position_name="<?php echo $position_name; ?>">
                                            <option value="0">---- <?php echo __('select position'); ?> ----</option>
                                        <?php foreach ($arr_all_position as $row): ?>
                                            <option value="<?php echo $row['PK_MENU_POSITION']; ?>"
                                            <?php
                                            if (isset($website_menu)) {
                                                $dom = simplexml_load_string($website_menu);
                                                $x_path = '//theme_position[@id_website=' . $v_website_id . ']/
                                                                item[@position_menu_id="' . $row['PK_MENU_POSITION'] . '"]
                                                               [@position_code="' . $position_name . '"]/@position_menu_id';
                                                $r = $dom->xpath($x_path);
                                                echo isset($r[0]) ? 'selected' : '';
                                            }
                                            ?>
                                                    >
                                                        <?php echo $row['C_NAME']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                        </div>
                    <?php endforeach; ?>
                    <div class="button-area">
                        <button type="button" name="btn_accept_theme" class="btn btn-success" onClick="btn_accept_theme_onclick()"><i class="fa fa-check"></i> <?php echo __('update');?></button>
                    </div>
                </div>
            </div>
            <div class="button-area">
                <button type="button" name="save_cache" class="btn btn-primary" onClick="save_cache_onclick()"><i class="fa fa-save"></i> <?php echo __('save cache');?></button>
            </div>
        </div>
    <?php endif;?>
    <div class="col-lg-9">
        <div class="panel-body" id="tabs_menu">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" id="position_tab">
                <?php
                    $v_has_check_sitemap = 0;
                        for($i = 0; $i < count($arr_all_position);$i ++ )
                        {
                            if($arr_all_position[$i]['C_TYPE'] == 1)
                            {
                                $v_has_check_sitemap = 1;
                            }
                        }
                    ?>
                <?php foreach($arr_all_position as $row):?>
                    <li>
                        <a href="#position_detail_<?php echo $row['PK_MENU_POSITION']; ?>" 
                           id="tab_<?php echo $row['PK_MENU_POSITION']; ?>" 
                           value="<?php echo $row['PK_MENU_POSITION']; ?>" 
                           data-name="<?php echo $row['C_NAME']; ?>"
                           data-sitemap="<?php echo $row['C_TYPE']; ?>"
                           onclick="single_position_onclick(this)"
                           aria-expanded="false" data-toggle="tab"> 
                               <?php echo $row['C_NAME']; ?>
                        </a>
                    </li>
                <?php endforeach; ?>
                <?php if (session::check_permission('THEM_MOI_VI_TRI_MENU') > 0): ?>
                        <li><a href="#add_new_position" data-toggle="tab" aria-expanded="false" onclick="new_position_onclick()"><?php echo __('+') ?></a></li>
                <?php endif; ?>
            </ul>
            <div class="tab-content" style="margin-top: 30px;">
                <div id="info_position">
                    <!--sua vi tri menu-->
                    <div class="row">
                            <div class="col-lg-12">
                                    <label class="col-lg-3 control-label"><?php echo __('ministry menu name'); ?></label>
                                <div class="form-group col-lg-3">
                                    <input class ="form-control" type="textbox" value="" name="txt_position_name" id="txt_position_name">
                                </div>
                                <div class="col-lg-6">
                                    <?php if (session::check_permission('SUA_VI_TRI_MENU') > 0): ?>
                                    <button class="btn btn-outline btn-success" onclick="btn_update_position_onclick()" style="margin-right: 10px;">
                                        <i class="fa fa-check"></i> <?php echo __('update'); ?>
                                    </button>
                                    <?php endif; ?>
                                    <?php if (session::check_permission('XOA_VI_TRI_MENU') > 0): ?>
                                    <button class="btn btn-outline btn-danger" onclick="btn_delete_position_onclick()">
                                        <i class="fa fa-times"></i> <?php echo __('delete ministry menu'); ?>
                                    </button>
                                    <?php endif; ?>
                                </div>
                                    
                            </div>
                    </div>
                        <?php if (session::check_permission('SUA_VI_TRI_MENU') > 0): ?>
                            <div class="form-group">
                                <div class="col-lg-12">
                                    <label class="col-lg-3 control-label">&nbsp;</label>
                                    <input type="checkbox" name="chk_sitemap" id="chk_sitemap"><?php echo __('has sitemap'); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    <label class="required" id="check_err_position"></label>
                </div>
                <?php foreach ($arr_all_position as $row):
                    $v_position = $row['PK_MENU_POSITION'];
                    ?>
                    <div class="tab-pane fade in" id="position_detail_<?php echo $v_position; ?>" style="min-height: 368px;">
                    </div>
                <?php endforeach; ?>
                <!--add new position-->
                <?php if (session::check_permission('THEM_MOI_VI_TRI_MENU') > 0): ?>
                    <div class="tab-pane fade in" id="add_new_position" style="min-height: 368px;">
                        <div class="row">
                            <div class="col-lg-12">
                                    <label class="col-lg-2 control-label"><?php echo __('position name '); ?></label>

                                <div class="form-group col-lg-6">
                                    <input class ="form-control" type="textbox" value="" name="txt_new_position_name" id="txt_new_position_name">
                                </div>
                                <div class="col-lg-4">
                                    <button class="btn btn-outline btn-success" onclick="btn_update_position_onclick()">
                                        <i class="fa fa-check"></i> <?php echo __('update'); ?>
                                    </button>    
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-12">
                                <label class="col-lg-2 control-label">&nbsp;</label>
                                <input type="checkbox" name="chk_sitemap" id="chk_sitemap"><?php echo __('has sitemap'); ?>
                            </div>
                        </div>
                        
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    </div>
    </div>
</form>
<script type="text/javascript">
    $(document).ready(function(){
        var tab = '';
        var current_position_id = $('#hdn_position_id').val();
        if(current_position_id == '')
        {
            tab = '#position_tab a:first';
        }
        else
        {
            tab = '#position_tab a' + '#tab_' + current_position_id;
        }
        $(tab).tab('show');

        single_position_onclick($(tab));
    });
    
    function single_position_onclick(position)
    {
       $('#check_err_position').html('');
       $('#txt_new_position_name').val('');
       $('#info_position').css({'display':'block'});
       $('#hdn_position_id').val($(position).val());
       
       var position_name     = $(position).attr('data-name');
       var check_sitemap     = $(position).attr('data-sitemap');
       
       //thay doi bien hdn_chk_sitemap
       $('#hdn_chk_sitemap').val(check_sitemap);
       
       
       var value             = $(position).attr('value'); 
       var tab               = "#position_detail_" + value;
       $('#txt_position_name').attr('value',position_name);
       $('#hdn_position_id').attr('value',value);
       
       
       $.ajax({
           type: 'post',
           url: '<?php echo $this->get_controller_url() . 'dsp_single_position/';?>'+value,
           beforeSend: function() {
                     var img ='<center><img src="<?php echo SITE_ROOT;?>public/images/loading.gif"/></center>';
                     $(tab).html(img);
                 },
           success: function(result)
           {
               $(tab).html(result);
           }
       });
       
       //check site map
       chk_sitemap();
    }
    function swap_order_menu(id,id_swap)
    {
        $('#hdn_item_id').attr('value',id);
        $('#hdn_item_id_swap').attr('value',id_swap);
        var str = "<?php echo $this->get_controller_url()."swap_order"?>";
        $('#frmMain').attr('action',str);
        $('#frmMain').submit();
    }
    function new_position_onclick()
    {
        $('#info_position').css({'display':'none'});
    }
    function btn_update_position_onclick()
    {
        str="<?php echo $this->get_controller_url()."update_position";?>";
        $('#frmMain').attr('action',str);
        $('#frmMain').submit();
    }
    function btn_delete_position_onclick()
    {
        var tab     = "#position_detail_"+$('#hdn_position_id').val()+' input[name="chk"]';
        var count   = 0;
        $(tab).each(function(){
            count = count +1;
        });
        //alert(count);
        if(count < 1)
        {
            str="<?php echo $this->get_controller_url()."delete_position";?>";
            $('#frmMain').attr('action',str);
            $('#frmMain').submit();
        }
        else
        {
            $('#check_err_position').html('Vị trí này vẫn còn ảnh quảng cáo !!!');
        }
    }
    function btn_accept_theme_onclick()
    {
        var array = new Array();
        $('[name="theme_position_select"]').each(function(index){
            position_name  = $(this).attr('data-position_name');
            position_value = $(this).val();
            temp = position_name +':'+position_value;
            array.push(temp);
        });
        $('#hdn_item_id_list').val(array.join());
        var url='<?php echo $this->get_controller_url().'update_theme_position'?>';
        $('#frmMain').attr('action',url);
        $('#frmMain').submit();
    }
    function save_cache_onclick()
    {
        url = '<?php echo $this->get_controller_url()?>create_cache';
        $('#frmMain').attr('action',url);
        $('#frmMain').submit();
    }
    
    //check site map
    function chk_sitemap()
    {
        checked = parseInt($('#hdn_chk_sitemap').val());
        $('#chk_sitemap').attr('checked',checked);
    }
</script>
