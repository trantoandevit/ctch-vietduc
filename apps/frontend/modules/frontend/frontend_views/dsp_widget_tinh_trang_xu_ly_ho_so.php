<?php

$data['txt_uri']      = '';
ini_set('display_errors', 1);


///frontend/frontend/load_prgess_record_r3
;?>
<div class="panel panel-default wiget-progress-record">
    <div class="news-title">
        <span style="line-height:17px;"><img src="<?php echo SITE_ROOT . "public/images/slider/icon.png" ?>" /></span>
        <label style="text-transform: uppercase"><?php echo $widget_title; ?>
        </label>
    </div>
    <div class="panel-body" style="padding: 0;text-align: center;font-weight: bold">
        <br/>
        <p>Tháng <?PHP ECHO date('m/Y')?><br/>
        Huyện Sông Mã giải quyết</p>
        <h3 style="color: red;font-weight: bold;text-align: center;font-size: 40px;">
            <img  src="<?php echo SITE_ROOT?>public/images/loading.gif" /></h3>
        <p>
            Hồ sơ đúng hạn<br/>
        (Tự động cập nhật: <?php echo date('d-m-Y');?>)
        </p><br/>
    </div>
</div>
<script>
    
$('document').ready(function()
{
    
    var time_reload_progress_record_old = window.localStorage.getItem("time_reload_progress_record");
    var progress_record = window.localStorage.getItem("progress_record");
    if(typeof progress_record != 'undefined' && $.trim(progress_record) != '')
    {
        $('.wiget-progress-record .panel-body h3').html(progress_record);
    }
    var current_date = new Date();
    var current_time = current_date.setTime(current_date.getTime());
    if(time_reload_progress_record_old <= current_time)
    {
        setInterval(function(){
         load_progress_reocrd('<?php echo SITE_ROOT?>frontend/frontend/load_prgess_record_r3');
        },10000);
    }
});

if(typeof load_progress_reocrd != 'function')
{
    
    function load_progress_reocrd(url)
    {
        $.ajax({
           url: url 
           ,type:'GEt'
           ,data:{txt_url:'<?php echo $txt_url?>'}
           ,dataType: 'json'
           ,beforeSend: function (xhr) 
            {
            }
           ,success:function(response)
           {
                if(typeof(Storage) !== "undefined") 
                {
                    var date = new Date();
                    window.localStorage.setItem("time_reload_progress_record", date.setTime(date.getTime()+(10000)));
                    window.localStorage.setItem("progress_record", response.tyle);
                } 
             
                // Retrieve
               $('.wiget-progress-record .panel-body h3').html(response.tyle);
           }
           ,
            error: function (jqXHR, textStatus, errorThrown) 
            {
                        console.log('Xảy ra lỗi. Đồng bộ tình trạng xử lý hồ sơ thất bại');
            }
        });
    }
}
</script>