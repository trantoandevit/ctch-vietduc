<?php
require_once __DIR__.'/admin_view.php';


function get_admin_controller_url($module, $type = NULL) 
{
    if (file_exists(SERVER_ROOT . '.htaccess')) {
        return SITE_ROOT . 'admin/' . $module . '/' . $type;
    }
    return SITE_ROOT . 'index.php?url=admin/' . $module . '/' . $type;
}