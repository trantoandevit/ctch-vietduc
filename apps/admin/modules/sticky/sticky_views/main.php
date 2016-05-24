<?php
defined('DS') or die('no direct access');
$this->_page_title = __('sticky');
$controller            = $this->get_controller_url();

?>
<?php
echo $this->hidden('controller', $this->get_controller_url());
echo $this->hidden('hdn_delete_method', 'delete_sticky');
echo $this->hidden('hdn_insert_method', 'insert_sticky');
?>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header" style="font-size: 32px;"><?php echo __('sticky') ?></h1>
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
                        <a href="#category_content" data-toggle="tab"><?php echo __('homepage sticky') ?></a>
                    </li>
                    <li>
                        <a href="#category_content" data-toggle="tab"><?php echo __('category sticky') ?></a>
                    </li>
                    <li>
                        <a href="#category_content" data-toggle="tab"><?php echo __('breaking news') ?></a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane fade in active" id="category_content" style="margin-top:20px;">
                        
                    </div>
                </div>
            </div>
            <!-- /.panel-body -->
        </div>
    </div>
</div>    
    <script>
        var tab_index_url = {0:'<?php echo $controller . 'dsp_all_sticky/1' ?>',
                                1:'<?php echo $controller . 'dsp_all_sticky/0' ?>',
                                2:'<?php echo $controller . 'dsp_all_sticky/2' ?>'};
        $(document).ready(function(){
            get_arp_by_tab_index(0);
        });
        
        $('#category_tab a').click(function (e) {
            e.preventDefault();
            var tab_index = $($(this).parent('li')).index();
            get_arp_by_tab_index(tab_index);
        });
        
        function get_arp_by_tab_index(tab,data)
        {
            if(typeof data == 'undefined')
            {
                data = {};
            }
            
            var url = tab_index_url[tab];
            $.ajax({
                type: 'post',
                url: url,
                data: data,
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
        function reload_current_tab(data)
        {
            var tab_index = get_current_tab_index();
            get_arp_by_tab_index(tab_index,data);
        }
        function get_current_tab_index()
        {
            return $('#category_tab li.active').index();
        }
    </script>
