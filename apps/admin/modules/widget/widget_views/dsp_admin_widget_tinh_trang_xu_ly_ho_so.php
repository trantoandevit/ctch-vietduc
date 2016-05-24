<?php
defined('DS') or die('no direct access');
?>
<label>Tiêu đề hiển thị
    <input type="text" value="<?php echo $txt_title; ?>" id='txt_title' name="txt_title">
</label>
<label>Địa chỉ Webservice:<span class="required">(*)</span>
    <input type="text" value="<?php echo $txt_url; ?>" id='txt_url' name="txt_url">
</label>
<label>Tên đăng nhập:<span class="required">(*)</span>
    <input type="text" value="<?php echo $txt_account; ?>" id='txt_account' name="txt_account">
</label>
<label>mật khẩu:<span class="required">(*)</span>
    <input type="password" value="<?php echo $txt_password; ?>" id='txt_password' name="txt_password">
</label>
<label>Uri:<span class="required">(*)</span>
    <input type="text" value="<?php echo $txt_uri; ?>" id='txt_uri' name="txt_uri">
</label>
