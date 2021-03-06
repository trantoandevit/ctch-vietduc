<?php

class Lang
{

    private static $_dom_lang;

    public static function load_lang($lang)
    {
        $v_xml_lang_file = SERVER_ROOT . 'langs' . DS . $lang . '.xml';
        if (file_exists($v_xml_lang_file))
        {
            self::$_dom_lang = simplexml_load_file($v_xml_lang_file);
        }
        else
        {
            self::$_dom_lang = simplexml_load_string('<lang/>');
        }
    }

    public static function translate($text)
    {
        $xpath = "//text[@name='$text'][last()]/@value";
        if (self::$_dom_lang != false)
        {
            $r = self::$_dom_lang->xpath($xpath);
        }
        else
        {
            $r[0]    = $text;
        }
        $text = (sizeof($r) > 0 && !empty($r)) ? $r[0] : ucfirst($text);
        return strval($text);
    }

}

function __($text)
{
    $text = trim($text);
    return Lang::translate($text);
}