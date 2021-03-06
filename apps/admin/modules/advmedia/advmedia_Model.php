<?php

defined('DS') or die('no direct access');

class advmedia_Model extends Model
{

    function __construct()
    {
        parent::__construct();
    }

    private function field_exists($table, $field)
    {
        return (bool) $this->db->getOne("select COL_LENGTH(?,?)", array($table, $field));
    }

    function create_dir($parentdir, $dirname)
    {
        $msg          = new stdClass();
        $msg->errors  = '';
        $msg->dirname = $dirname;
        if (file_exists($parentdir) && !is_dir($parentdir))
        {
            $parentdir = dirname($parentdir);
        }

        if (!is_dir($parentdir))
        {
            $msg->errors = __('parent directory not exists');
            return $msg;
        }

        if (is_dir($parentdir . DS . $dirname)) //thu muc can tao ko trung ten
        {
            $msg->errors = __('directory already exists');
            return $msg;
        }
        if (!mkdir($parentdir . DS . $dirname))
        {
            $msg->errors = __('directory creation failed');
            return $msg;
        }
        file_put_contents($parentdir . DS . $dirname . DS . 'index.html', 'nothing here');
        return $msg;
    }

    function delete_items($parent_dir, $items)
    {
        $msg                  = new stdClass();
        $msg->errors          = '';
        $msg->deleted_folders = array();
        $msg->deleted_files = array();

        if (file_exists($parent_dir) && !is_dir($parent_dir))
        {
            $parent_dir = dirname($parent_dir);
        }

        if (!is_dir($parent_dir)) // kiem tra thu muc me ton tai
        {
            $msg->errors = __('parent directory not exists');
            return $msg;
        }

//        if (!is_array($items) or Session::check_permission('XOA_MEDIA') == false) // ko co j de xoa
//        {
//            $msg->errors = __('invalid request data');
//            return $msg;
//        }
        
        foreach ($items as $item)
        {
            $itempath = $parent_dir . DS . $item;
            if (is_dir($itempath)) //xu ly thu muc
            {
                $scan = scandir($itempath);
                //kiem tra index.html
                $v_search = array_search('index.html', $scan);
                if(is_int($v_search))
                {
                    unset($scan[$v_search]);
                }
                
                //kiem tra index.html
                $v_search = array_search('index.htm', $scan);
                if(is_int($v_search))
                {
                    unset($scan[$v_search]);
                }
                
                
                if (count($scan) > 2) //scan bao gio cung >2 vi co ../ va ./ va index.html or index.htm
                {
                    $msg->errors .= __('directory not empty') . ': ' . $item . "\n";
                }
                else
                {
                    //xoa file co dinh
                    @unlink($itempath.'/index.html');
                    @unlink($itempath.'/index.htm');
                    
                    if (@rmdir($itempath)) //xoa thu muc thanh cong
                    {
                        $msg->deleted_folders[] = $item;
                    }
                    else //xoa thu muc that bai
                    {
                        $msg->errors .= __('error removing directory') . ': ' . $item . "\n";
                    }
                }
            }
            elseif (file_exists($itempath) && $item != 'index.html' && $item != 'index.htm') //xu ly file
            {
                if (@unlink($itempath)) //xoa file thanh cong
                { //xoa file thanh cong
                    $msg->deleted_files[] = $item;
                }
                else //xoa file that bai
                {
                    $msg->errors .= __('error removing file') . ': ' . $item . "\n";
                }
            }
            else //khong ton tai doi tuong
            {
                $msg->errors .= __('file not exists') . ': ' . $item . "\n";
            }
        }
        return $msg;
    }

    function update_db()
    {
        $this->db->debug = 1;
        error_reporting(E_ALL);
        //article
        if (!$this->field_exists('T_PS_ARTICLE', 'C_FILE_NAME'))
        {
            $this->db->execute('Alter Table T_PS_ARTICLE Add C_FILE_NAME nvarchar(1000)');
        }
        $sql = "Update T_PS_ARTICLE Set C_FILE_NAME = (Select C_FILE_NAME From T_PS_MEDIA Where FK_MEDIA = PK_MEDIA)";
        $this->db->execute($sql);

        //article_attachment
        if (!$this->field_exists('T_PS_ARTICLE_ATTACHMENT', 'C_FILE_NAME'))
        {
            $this->db->execute('Alter Table T_PS_ARTICLE_ATTACHMENT Add C_FILE_NAME nvarchar(1000)');
        }
//        $sql = "Update T_PS_ARTICLE_ATTACHMENT Set C_FILE_NAME = (Select C_FILE_NAME From T_PS_MEDIA Where FK_MEDIA = PK_MEDIA)";
//        $this->db->execute($sql);
        //event
        if (!$this->field_exists('T_PS_EVENT', 'C_FILE_NAME'))
        {
            $this->db->execute('Alter Table T_PS_EVENT Add C_FILE_NAME nvarchar(1000)');
        }
        $this->db->execute($sql);
        $sql = "Update T_PS_EVENT Set C_FILE_NAME = (Select C_FILE_NAME From T_PS_MEDIA Where FK_MEDIA = PK_MEDIA)";
        $this->db->execute($sql);

        //advertising
        if (!$this->field_exists('T_PS_ADVERTISING', 'C_FILE_NAME'))
        {
            $this->db->execute('Alter Table T_PS_ADVERTISING Add C_FILE_NAME nvarchar(1000)');
        }
        $sql = "Update T_PS_ADVERTISING Set C_FILE_NAME = (Select C_FILE_NAME From T_PS_MEDIA Where FK_MEDIA = PK_MEDIA)";
        $this->db->execute($sql);

        //banner
        if (!$this->field_exists('T_PS_BANNER', 'C_FILE_NAME'))
        {
            $this->db->execute('Alter Table T_PS_BANNER Add C_FILE_NAME nvarchar(1000)');
        }
        $sql = "Update T_PS_BANNER Set C_FILE_NAME = (Select C_FILE_NAME From T_PS_MEDIA Where FK_MEDIA = PK_MEDIA)";
        $this->db->execute($sql);

        //photo_gallery
        if (!$this->field_exists('T_PS_PHOTO_GALLERY', 'C_FILE_NAME'))
        {
            $this->db->execute('Alter Table T_PS_PHOTO_GALLERY Add C_FILE_NAME nvarchar(1000)');
        }
        $sql = "Update T_PS_PHOTO_GALLERY Set C_FILE_NAME = (Select C_FILE_NAME From T_PS_MEDIA Where FK_MEDIA = PK_MEDIA)";
        $this->db->execute($sql);

        //photo gallery details
        if (!$this->field_exists('T_PS_PHOTO_GALLERY_DETAIL', 'C_FILE_NAME'))
        {
            $this->db->execute('Alter Table T_PS_PHOTO_GALLERY_DETAIL Add C_FILE_NAME nvarchar(1000)');
        }
        $sql = "Update T_PS_PHOTO_GALLERY_DETAIL Set C_FILE_NAME = (Select C_FILE_NAME From T_PS_MEDIA Where FK_MEDIA = PK_MEDIA)";
        $this->db->execute($sql);

        //weblink
        if (!$this->field_exists('T_PS_WEBLINK', 'C_FILE_NAME'))
        {
            $this->db->execute('Alter Table T_PS_WEBLINK Add C_FILE_NAME nvarchar(1000)');
        }
        $sql = "Update T_PS_WEBLINK Set C_FILE_NAME = (Select C_FILE_NAME From T_PS_MEDIA Where FK_LOGO = PK_MEDIA)";
        $this->db->execute($sql);
    }

}

