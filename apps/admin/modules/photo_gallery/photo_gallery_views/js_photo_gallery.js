
function tinyMCE_init(){
    tinyMCE.init({
        //custom
        document_base_url : SITE_ROOT,
        relative_urls : false, 
        entity_encoding : "raw",
        entities: "",
        force_p_newlines : false,
        // General options
        mode : "none",
        width:'668',
        theme : "advanced",
        theme_advanced_resizing_max_width : 668,
        plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks",
        // Theme options
        theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,strikethrough,forecolor,backcolor,|,bullist,numlist,|,justifyleft,justifycenter,justifyright,justifyfull,search,replace,|,outdent,indent,blockquote,code,|,undo,redo,|,link,unlink,image",
        theme_advanced_buttons2 : "",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : true,

        // Example content CSS (should be your site CSS)
        content_css : "public/tinymce/css/content.css",

        // Drop lists for link/image/media/template dialogs
        template_external_list_url : "public/tinymce/lists/template_list.js",
        external_link_list_url : "public/tinymce/lists/link_list.js",
        external_image_list_url : "public/tinymce/lists/image_list.js",
        media_external_list_url : "public/tinymce/lists/media_list.js",

        // Skin options
        skin : "o2k7",
        skin_variant : "silver",
        
        // Style formats
        style_formats : [
        {
            title : 'Bold text', 
            inline : 'b'
        },

        {
            title : 'Red text', 
            inline : 'span', 
            styles : {
                color : '#ff0000'
            }
        },
        {
            title : 'Red header', 
            block : 'h1', 
            styles : {
                color : '#ff0000'
            }
        },
        {
            title : 'Example 1', 
            inline : 'span', 
            classes : 'example1'
        },
        {
            title : 'Example 2', 
            inline : 'span', 
            classes : 'example2'
        },
        {
            title : 'Table styles'
        },
        {
            title : 'Table row 1', 
            selector : 'tr', 
            classes : 'tablerow1'
        }
        ],

        // Replace values for the template plugin
        template_replace_values : {
            username : "Some User",
            staffid : "991234"
        }
         
        
    }); 
  
}//end tinymce init