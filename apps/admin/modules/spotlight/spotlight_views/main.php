<?php
defined('DS') or die('no direct access');
$this->_page_title = __('spotlight');
$n                     = count($arr_all_position);
if(isset($arr_all_position[0]['PK_SPOTLIGHT_POSITION']))
{
    $v_position_id  = isset($_POST['hdn_position_id'])?$_POST['hdn_position_id']:$arr_all_position[0]['PK_SPOTLIGHT_POSITION'];
}
else
{
    $v_position_id = '';
}

?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header" style="font-size: 32px;"><?php echo __('spotlight') ?></h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<form name="frmMain" id="frmMain" action="" method="POST" class="form-horizontal">
    <?php
    echo $this->hidden('controller',$this->get_controller_url());
    echo $this->hidden('hdn_item_id',0);
    echo $this->hidden('hdn_item_id_list','');

    echo $this->hidden('hdn_dsp_single_method','dsp_single_position');
    echo $this->hidden('hdn_update_method','update_position');
    echo $this->hidden('hdn_delete_method','delete_position');
    echo $this->hidden('hdn_position_id',$v_position_id);
    echo $this->hidden('hdn_item_id_swap',0);
?>
    <div class="panel-body" id="tabs_menu">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" id="position_tab">
            <?php for ($i = 0; $i < $n; $i++): ?>
                <?php
                $item = $arr_all_position[$i];
                $v_id = $item['PK_SPOTLIGHT_POSITION'];
                $v_url = $this->get_controller_url() . 'dsp_single_position/' . $v_id;
                $v_name = $item['C_NAME'];
                ?>
                <li>
                    <span 
                        style="margin-top:6px;margin-right: 3px;right: 0;display: block;display: none;"
                        class="ui-icon ui-icon-close" onclick="item_delete_onclick(this);"
                        data-id="<?php echo $v_id; ?>"
                        >
                    </span>
                    
                    <a href="#position_detail_<?php echo $v_id ?>" 
                           id="tab_<?php echo $v_id ?>" 
                           value="<?php echo $v_id ?>" 
                           data-name="<?php echo $v_name ?>" 
                           onclick="single_position_onclick(this)"
                           aria-expanded="false" data-toggle="tab"> 
                               <?php echo $v_name ?>
                        </a>
                    
                    <!--a href="#position_<?php echo $v_id ?>" value="<?php echo $v_id?>" onclick="show_item_onclick(this)">
                        <?php echo $v_name ?>
                    </a-->
                </li>
            <?php endfor; ?>
            <li><a href="#add_new_position" data-toggle="tab" aria-expanded="false"><?php echo __('+') ?></a></li>
        </ul>
        <div class="tab-content" style="margin-top: 30px;">
            <?php
            foreach ($arr_all_position as $row):
                $v_position = $row['PK_SPOTLIGHT_POSITION'];
                ?>
                <div class="tab-pane fade in" id="position_detail_<?php echo $v_position; ?>" style="min-height: 368px;">
                </div>
            <?php endforeach; ?>
                <div class="tab-pane fade in" id="add_new_position" style="min-height: 368px;">
                    <div class="row" style="margin-top: 20px;">
                        <label class="col-lg-1" for="txt_name" style="padding-top:5px;"><?php echo __('name') ?><span class="required">(*)</span></label>
                        <div class="form-group col-lg-5">
                            <input class="form-control" type="text" name="txt_name" id="txt_name"     
                                   data-allownull="no" data-validate="text"
                                   data-name="<?php echo __('name'); ?>" 
                                   value="<?php echo $v_pos_name ?>"
                                   data-xml="no" data-doc="no"/>
                        </div>
                        <div class="col-sm-6">
                            <button type="button" class="btn btn-success btn-outline" onClick="frmMain_on_submit();"><i class="fa fa-check"></i> <?php echo __('apply'); ?></button>
                            <button type="button" class="btn btn-danger btn-outline" style="margin-left:10px;" onClick="$('span[data-id=<?php echo $v_pos_id ?>]').click();"><i class="fa fa-times"></i> <?php echo __('delete position'); ?></button>
                            <?php if (get_system_config_value(CFGKEY_CACHE) == 'true'): ?>
                                <button type="button" class="btn btn-outline btn-success"  style="margin-left:10px;" onClick="btn_cache_onclick(<?php echo $v_pos_id ?>)"><i class="fa fa-save"></i> <?php echo __('save cache') ?></button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</form>

<script>
    function frmMain_on_submit()
    {
        var f = document.frmMain;
        var xObj = new DynamicFormHelper('','',f);
        if (xObj.ValidateForm(f)){
            $.ajax({
                type: 'post',
                url: $('#controller').val() + 'update_position',
                data: $(f).serialize(),
                success: function(){
                    window.location.reload();
                }
            });
        }
        return false;
    }
    $(document).ready(function(){
        var tab = '';
        var current_position_id = $('#hdn_position_id').val();
        if(current_position_id == "")
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
       $('#hdn_position_id').val($(position).val());
       
       var position_name     = $(position).attr('data-name');
       var check_sitemap     = $(position).attr('data-sitemap');
       
       
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
    }
//   function new_position_onclick(){
//      
//       //var val = $('a').attr('value');
//       var tab = "#add_new_position";
//       
//       $.ajax({
//            type:'post',
//            url: '<?php echo $this->get_controller_url() . 'dsp_single_position/'; ?>',
//            beforeSend: function () {
//                img = '<center><img src="<?php echo SITE_ROOT; ?>public/images/loading.gif"/></center>';
//                $(tab).html(img);
//            },
//            success:function(resp){
//                
//                $(tab).html(resp);
//            }
//        });
//   }
   
    function item_delete_onclick(span_obj){
        if(!confirm("<?php echo __('are you sure to delete all selected object?') ?>"))
        {
            return;
        }
        var $pos_id = $(span_obj).attr('data-id');
        $.ajax({
            type: 'post',
            url: "<?php echo $this->get_controller_url() ?>delete_position/",
            data: {'position_id': $pos_id},
            success: function(){
                var panelId = $( span_obj ).parent().find("a").attr("href");
                $( span_obj ).closest( "li" ).remove();
                $( panelId ).remove();
                window.location.reload(true);
            }
        });
    }
    function reload_current_tab()
    {
        var tab = '';
        var current_position_id = $('#hdn_position_id').val();
        if(current_position_id == "")
        {
            tab = '#position_tab a:first';
        }
        else
        {
            tab = '#position_tab a' + '#tab_' + current_position_id;
        }
        $(tab).tab('show');

        single_position_onclick($(tab));
    }
</script>
