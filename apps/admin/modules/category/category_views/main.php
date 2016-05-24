
<?php
defined('SERVER_ROOT') or die('No direct script');
$this->_page_title = __('category management');

$v_active_tab = get_post_var('hdn_active_tab',0);
?>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header" style="font-size: 32px;"><?php echo __('category'); ?></h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">

            <!-- /.panel-heading -->
            <div class="panel-body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" id="category_tab">
                    <li class="active">
                        <a href="#category_content" data-toggle="tab"><?php echo __('category list') ?></a>
                    </li>
                    <li>
                        <a href="#category_content" data-toggle="tab"><?php echo __('featured category') ?></a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane fade in active" id="category_content">
                        
                    </div>
                </div>
            </div>
            <!-- /.panel-body -->
        </div>
    </div>
</div>    
<script>
        var tab_index_url = {0:'<?php echo $this->get_controller_url() . 'dsp_all_category/'?>',
                                1:'<?php echo $this->get_controller_url() . 'dsp_featured_category/'?>'};
        $(document).ready(function(){
            get_arp_by_tab_index(0);
        });
        
        $('#category_tab a').click(function (e) {
            e.preventDefault();
            var tab_index = $($(this).parent('li')).index();
            get_arp_by_tab_index(tab_index);
        });
        
        function get_arp_by_tab_index(tab)
        {
            var url = tab_index_url[tab];
            $.ajax({
                type: 'post',
                url: url,
                beforeSend: function () {
                    var img = '<center><img src="<?php echo SITE_ROOT; ?>public/images/loading.gif"/></center>';
                    $('#category_content').html(img);
                },
                success: function (result)
                {
                    
                    $('#category_content').html(result);
                }
            });
        }
        function reload_current_tab()
        {
            var tab_index = $('#category_tab li.active').index();
            get_arp_by_tab_index(tab_index);
        }
</script>