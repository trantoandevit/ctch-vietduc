<?php

Class admin_view extends View
{
    const THEME_GREY = 'theme-grey';

    protected $_layout = 'default_layout';
    protected $_page_title = _CONST_UNIT_NAME_ERRORS;
    protected $_page_heading;
    protected $_breadcrums;
    protected $_active_main_nav = 'dashboard';
    protected $_active_admin_nav;
    protected $_left_side_bar = null;
    protected $_pop_win_layout = 'pop_win_layout';
    public $function_active = '';
    function __construct($app, $module)
    {
        parent::__construct($app, $module);
        
    }
    
    function set_layout($layout)
    {
        $this->_layout = $layout;
        return $this;
    }
    

    function set_title($title)
    {
        $this->_page_title = $title;
        return $this;
    }

    function set_heading($heading)
    {
        $this->_page_heading = $heading;
        return $this;
    }

    function set_breadcrums($arr_breadcrums)
    {
        $this->_breadcrums = $arr_breadcrums;
        return $this;
    }

    function set_active_main_nav($nav)
    {
        $this->_active_main_nav = $nav;
        return $this;
    }

    function set_active_admin_nav($nav)
    {
        $this->_active_admin_nav = $nav;
        return $this;
    }

    function set_left_sidebar($template_name)
    {
        $this->_left_side_bar = $template_name;
        return $this;
    }

    function render($name, $VIEW_DATA = array(),$auto_include_layout = TRUE)
    {
        //noi dung thay doi moi trang
        $v_view_file = SERVER_ROOT . 'apps' . DS . $this->app_name . DS . 'modules' . DS . $this->module_name . DS . $this->module_name . '_views' . DS . $name . '.php';
        $v_layout_file = SERVER_ROOT . 'apps' . DS . $this->app_name . DS . $this->_layout . '.php';
        if (file_exists($v_view_file))
        {
            if (is_array($VIEW_DATA))
            {
                foreach ($VIEW_DATA as $key => $val)
                {
                    $$key = $val;
                }
            }
            
            ob_start();
            require $v_view_file;
            $content = ob_get_clean();
            
            if ($this->_layout != null && $auto_include_layout == TRUE)
            {//noi dung co dinh ko doi
                require $v_layout_file;
            } 
            else
            {//noi dung thay doi moi trang
                echo $content;
            }
        } 
        else
        {
            if (DEBUG_MODE)
                echo "Không tìm thấy <b>$v_view_file</b>";
            else
                $this->_render_error(1);
        }
    }

    function get_app_url()
    {
        return SITE_ROOT . 'apps/' . $this->app_name . '/';
    }
}
