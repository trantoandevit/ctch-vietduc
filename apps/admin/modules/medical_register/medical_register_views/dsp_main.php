<?php
    $config['url']       = get_system_config_value('medical_register_url');
    $config['user_name'] = get_system_config_value('medical_register_user');
    $config['pass']      = get_system_config_value('medical_register_password');
?>

<form name="frmMain" id="frmMain" method="POST" action="<?php echo $config['url']?>">
	<input type="hidden" name="txt_uname" id="txt_uname" value="<?php echo $config['user_name']?>" />
	<input type="hidden" name="txt_passwd" id="txt_passwd" value="<?php echo $config['pass']?>" />
</form>
<script>
    $(document).ready(function(){
        $('#frmMain').submit();
    })
</script>