var sv = {};

//khai bao cac thu vien
sv.url = {};
sv.data = {};

sv.url.base = SITE_ROOT + 'frontend/api_data/';
sv.url.getService = function (method)
{
    return sv.url.base + method;
};

sv.url.build_article = function (cat_slug, art_slug, website_id, cat_id, art_id) {
    return SITE_ROOT + 'tin-bai/' + cat_slug + '/' + art_slug + '/' + website_id + '-' + cat_id + '-' + art_id;
};
sv.url.build_category = function (cat_slug, website_id, cat_id) {
    return SITE_ROOT + 'chuyen-muc/' + cat_slug + '/' + website_id + '-' + cat_id;
};

sv.url.upload_file = function (file_name) {
    return SITE_ROOT + 'upload' + file_name;
}
sv.url.public_images = function (file_name) {
    return SITE_ROOT + 'public/images/' + file_name;
}
/*---------------------------------------------------------------------------------------*/
sv.data.getData = function (url, data, afuntion, async) {
    data.website_id = _VAR_WEBSITE_ID;
    $.ajax({
        method: "POST",
        url: url,
        data: data,
        async: async,
        dataType: "json",
        success: function (response) {
            if (typeof afuntion == 'string')
            {
                window[afuntion](response);
            }
            else
            {
                (afuntion)(response);
            }

        }
    });
}

/**
 * lay danh sach menu
 * @param {type} afunction
 * @param {type} async
 * @returns {undefined}
 */
sv.data.menu = function(afunction, async){
    var data = {};
    if (typeof async == 'undefined')
        async = true;
    sv.data.getData(sv.url.getService('get_menu'), data, afunction, async);
};

/**
 * lay danh sach tin bai noi bat
 * @param {type} afunction
 * @param {type} async
 * @returns {undefined}
 */
sv.data.sticky = function (afunction, async) {
    var data = {};
    if (typeof async == 'undefined')
        async = true;

    sv.data.getData(sv.url.getService('get_sticky'), data, afunction, async);
};

/**
 * chi tiet tin bai
 * @param {type} cat_id
 * @param {type} art_id
 * @param {type} afunction
 * @param {type} async
 * @returns {undefined}
 */
sv.data.article = function (cat_id, art_id, afunction, async) {
    var data = {
        category_id: cat_id,
        article_id: art_id
    };
    if (typeof async == 'undefined')
        async = true;

    sv.data.getData(sv.url.getService('get_article'), data, afunction, async);
};

/**
 * tin khac
 * @param {type} cat_id
 * @param {type} art_id
 * @param {type} afunction
 * @param {type} async
 * @returns {undefined}
 */
sv.data.other_article = function (cat_id, art_id, afunction, async) {
    var data = {
        category_id: cat_id,
        article_id: art_id
    };
    if (typeof async == 'undefined')
        async = true;

    sv.data.getData(sv.url.getService('get_other_article'), data, afunction, async);
};

/**
 * tin bai cua chuyen muc
 */
sv.data.art_of_cat = function (page, cat_id, key_word, afunction, async) {
    var data = {
        category_id: cat_id,
        page: page,
        key_word: key_word
    };
    if (typeof async == 'undefined')
        async = true;

    sv.data.getData(sv.url.getService('get_art_of_cat_by_page'), data, afunction, async);
};

/**
 * lay danh sach cau hoi cong dan
 * @param {type} data
 * @param {type} afunction
 * @param {type} async
 * @returns {undefined} * @param {type} data
 * @param {type} afunction
 * @param {type} async
 * @returns {undefined} 
 */
sv.data.all_cq = function (data, afunction, async) {
    if (typeof async == 'undefined')
        async = true;
    sv.data.getData(sv.url.getService('get_all_cq'), data, afunction, async);
};

/**
 * insert hoi dap
 */
sv.data.do_insesrt_cq = function (data, afunction, async) {
    if (typeof async == 'undefined')
        async = true;
    sv.data.getData(sv.url.getService('do_insert_cq'), data, afunction, async);

};

/**
 * chi tiet cau hoi
 */
sv.data.cq_detail = function (cq_id, afunction, async) {
    var data = {cq_id: cq_id};
    if (typeof async == 'undefined')
        async = true;
    sv.data.getData(sv.url.getService('get_cq_detail'), data, afunction, async);
};

sv.data.homepage_category = function(afunction, async){
    var data = {};
    if (typeof async == 'undefined')
        async = true;
    sv.data.getData(sv.url.getService('get_homepage_category'), data, afunction, async);
};

sv.data.weblink = function(type_code, afunction, async){
    var data = {type_code: type_code};
    if (typeof async == 'undefined')
        async = true;
    sv.data.getData(sv.url.getService('get_weblink'), data, afunction, async);
};

sv.data.get_cq_field = function(afunction,async){
        var data = {};
    if (typeof async == 'undefined')
        async = true;
    sv.data.getData(sv.url.getService('get_cq_field'), data, afunction, async);
};