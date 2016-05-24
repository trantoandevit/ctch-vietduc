<?php

class api_data_Model extends Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * lay danh sach tin bai noi bat
     * @param type $website_id
     * @return type
     */
    public function qry_sticky($website_id) {
        $sql = "SELECT 
                    S.FK_WEBSITE,
                    C.PK_CATEGORY,
                    C.C_SLUG  AS C_CAT_SLUG,
                    A.PK_ARTICLE,
                    A.C_SLUG AS C_ART_SLUG,
                    A.C_TITLE,
                    A.C_FILE_NAME,
                    A.C_BEGIN_DATE,
                    DATE_FORMAT(C_BEGIN_DATE, '%d-%m-%Y') AS C_BEGIN_DATE_DDMMYYY,
                    A.C_SUMMARY
                  FROM t_ps_sticky S
                    LEFT JOIN t_ps_category C
                  ON S.FK_CATEGORY = C.PK_CATEGORY
                  LEFT JOIN t_ps_article A
                  ON S.FK_ARTICLE = A.PK_ARTICLE
                  WHERE S.C_DEFAULT = 1
                      AND S.FK_WEBSITE = $website_id";
        return $this->db->getAll($sql);
    }

    /**
     * chi tiet tin bai
     * @param type $website_id
     * @param type $category_id
     * @param type $article_id
     * @return type
     */
    public function qry_single_article($website_id, $category_id, $article_id) {
        $website_id = replace_bad_char($website_id);
        $category_id = replace_bad_char($category_id);
        $article_id = replace_bad_char($article_id);
        $v_default = _CONST_DEFAULT_ROWS_OTHER_NEWS;


        $stmt = "SELECT
                        DATE_FORMAT(C_BEGIN_DATE,'%d-%m-%Y %H:%i:%s') AS C_BEGIN_DATE,
                        C_TITLE,
                        C_SLUG                AS C_SLUG_ARTICLE,
                        C_SUB_TITLE,
                        C_PEN_NAME,
                        C_KEYWORDS,
                        C_TAGS,
                        C_CACHED_RATING,
                        C_CACHED_RATING_COUNT,
                        C_SUMMARY,
                        C_TAGS,
                        C_FILE_NAME,
                        C_CONTENT,
                        (SELECT
                           C_SLUG
                         FROM t_ps_category
                         WHERE PK_CATEGORY = ?) AS C_SLUG_CAT,
                        (SELECT
                           C_NAME
                         FROM t_ps_category
                         WHERE PK_CATEGORY = ?) AS C_CATEGORY_NAME
                      FROM t_ps_article a
                        INNER JOIN t_ps_category_article ca
                          ON a.PK_ARTICLE = ca.FK_ARTICLE
                      WHERE PK_ARTICLE = ?
                          AND FK_CATEGORY = ?
                          AND FK_CATEGORY IN(SELECT
                                               PK_CATEGORY
                                             FROM t_ps_category
                                             WHERE FK_WEBSITE = ?)
                          AND C_STATUS = 3
                          AND (SELECT
                                 C_STATUS
                               FROM t_ps_category
                               WHERE PK_CATEGORY = ?) = 1
                          AND C_BEGIN_DATE <= NOW()
                          AND C_END_DATE >= NOW()";
        $article = $this->db->getRow($stmt, array($category_id, $category_id, $article_id, $category_id, $website_id, $category_id));
        return $article;
    }

    /**
     * Lay danh sach tin bai cu hon TIN BAI DANG XEM CHI TIET (Cac tin khac)
     * @param unknown $categoryid
     * @param unknown $articleid
     */
    public function qry_all_other_article($categoryid, $articleid) {
        $v_default = _CONST_DEFAULT_ROWS_OTHER_NEWS;
        $v_use_index = '';
        $v_count = $this->_count_article_by_category($categoryid);
        if ($v_count > _CONST_MIN_ROW_TO_MYSQL_USE_INDEX) {
            $v_use_index = ' Use Index (C_BEGIN_DATE) ';
        }

        $sql = "Select
                    A.PK_ARTICLE
                    , A.C_SLUG
                    , A.C_TITLE
                    , DATE_FORMAT(A.C_BEGIN_DATE,'%d-%m-%Y %H:%i:%s') AS C_BEGIN_DATE
                    , C.PK_CATEGORY
                    , C.C_SLUG      as C_CAT_SLUG
                    , A.C_FILE_NAME
                    , A.C_SUMMARY
                From t_ps_category_article CA
                    Left Join t_ps_article A $v_use_index
                    On CA.FK_ARTICLE = A.PK_ARTICLE      
                        Left Join t_ps_category C
                        On CA.FK_CATEGORY = C.PK_CATEGORY
                Where C.PK_CATEGORY = $categoryid
                    And A.C_BEGIN_DATE < (Select C_BEGIN_DATE From t_ps_article Where PK_ARTICLE=$articleid)
                    And A.C_STATUS = 3
                    And A.C_BEGIN_DATE < Now()
                    And A.C_END_DATE > Now()  
                    And C.C_STATUS=1   
                Order By A.C_BEGIN_DATE Desc
                Limit $v_default";
        return $this->db->getAll($sql);
    }

    /**
     * Tin bài thuộc chuyên mục
     * @param type $page
     * @param type $website_id
     * @param type $category_id
     * @param type $key_word
     * @return type
     */
    public function qry_art_of_cat_by_page($page, $website_id, $category_id, $key_word = '') {

        $condition = '';
        $limit_cond = '';

        if ($key_word != '') {
            $condition = " AND A.C_SLUG like '%" . auto_slug($key_word) . "%'";
        }

        if ($page != '-1') {
            $limit = _CONST_DEFAULT_ROWS_PER_PAGE;
            $offset = ($page - 1) * _CONST_DEFAULT_ROWS_PER_PAGE;
            $limit_cond = " LIMIT $offset, $limit";
        }

        $arr_return = array();
        $sql = "SELECT
                        DATE_FORMAT(FA.C_BEGIN_DATE,'%d-%m-%Y %H:%i:%s') AS C_BEGIN_DATE,
                        FA.C_BEGIN_DATE AS C_BEGIN_DATE_YYYYMMDD,
                        FA.PK_ARTICLE AS PK_ARTICLE,
                        FA.C_TITLE AS C_TITLE,
                        FA.C_SUMMARY AS C_SUMMARY,
                        IF(FA.C_FILE_NAME IS NULL, '', FA.C_FILE_NAME) AS C_FILE_NAME,
                        IF(FA.C_SLUG IS NULL, '', FA.C_SLUG) AS C_SLUG
                    FROM t_ps_article FA
                      RIGHT JOIN (SELECT
                                    mrs.PK_ARTICLE
                                  FROM (SELECT
                                          A.PK_ARTICLE
                                        FROM t_ps_article A
                                          RIGHT JOIN (SELECT
                                                        MAX(CA.FK_CATEGORY) AS FK_CATEGORY,
                                                        CA.FK_ARTICLE
                                                      FROM t_ps_category_article AS CA
                                                        LEFT JOIN t_ps_category AS C
                                                          ON CA.FK_CATEGORY = C.PK_CATEGORY
                                                      WHERE C.FK_WEBSITE = $website_id
                                                          AND C.PK_CATEGORY = $category_id
                                                          AND C.C_STATUS = 1
                                                      GROUP BY FK_ARTICLE) fca
                                            ON A.PK_ARTICLE = fca.FK_ARTICLE
                                        WHERE A.C_STATUS = 3
                                            AND C_BEGIN_DATE <= NOW()
                                            AND C_END_DATE >= NOW()
                                            $condition
                                        ORDER BY C_BEGIN_DATE DESC
                                        $limit_cond) AS mrs) AS MA
                        ON FA.PK_ARTICLE = MA.PK_ARTICLE";
        $arr_return['data'] = $this->db->getAll($sql, array());

        $cat_info = $this->db->getRow("SELECT
                                            PK_CATEGORY,
                                            C_SLUG,
                                            C_NAME
                                          FROM t_ps_category
                                          WHERE PK_CATEGORY = $category_id");

        $total_record = $this->db->getOne("SELECT
                                                COUNT(*)
                                              FROM (SELECT
                                                      A.PK_ARTICLE
                                                    FROM t_ps_article A
                                                      RIGHT JOIN (SELECT
                                                                    MAX(CA.FK_CATEGORY) AS FK_CATEGORY,
                                                                    CA.FK_ARTICLE
                                                                  FROM t_ps_category_article AS CA
                                                                    LEFT JOIN t_ps_category AS C
                                                                      ON CA.FK_CATEGORY = C.PK_CATEGORY
                                                                  WHERE C.FK_WEBSITE = $website_id
                                                                      AND C.PK_CATEGORY = $category_id
                                                                      AND C.C_STATUS = 1
                                                                  GROUP BY FK_ARTICLE) fca
                                                        ON A.PK_ARTICLE = fca.FK_ARTICLE
                                                    WHERE A.C_STATUS = 3
                                                        AND C_BEGIN_DATE <= NOW()
                                                        AND C_END_DATE >= NOW()
                                                        $condition
                                                    ) AS mrs
                                                            ");

        $arr_return['CAT_ID'] = $cat_info['PK_CATEGORY'];
        $arr_return['CAT_SLUG'] = $cat_info['C_SLUG'];
        $arr_return['CAT_NAME'] = $cat_info['C_NAME'];
        $arr_return['TOTAL_RECORD'] = $total_record;

        return $arr_return;
    }

    /**
     * 
     * @param type $page
     * @param type $key_word
     * @return typelay danh sach cau hoi
     */
    public function qry_all_cq($page, $key_word = '') {
        $arr_return = array();
        $limit = _CONST_DEFAULT_ROWS_PER_PAGE;
        $offset = ($page - 1) * _CONST_DEFAULT_ROWS_PER_PAGE;
        $condition = "";

        if (!empty($key_word)) {
            $condition .= " AND C_TITLE LIKE '%$key_word%'";
        }

        $stmt = "SELECT
                    PK_CQ,
                    C_NAME,
                    C_TITLE,
                    C_CONTENT,
                    C_ANSWER,
                    DATE_FORMAT(C_DATE, '%d-%m-%Y %H:%i:%s') AS C_DATE_DDMMYYY
                  FROM t_ps_cq
                  WHERE C_STATUS = 1 $condition
                  ORDER BY C_ORDER
                  LIMIT $offset, $limit";

        $arr_return['data'] = $this->db->getAll($stmt, array());
        //dem tong so ban ghi
        $stmt = "SELECT
                    COUNT(*)
                  FROM t_ps_cq
                  WHERE C_STATUS = 1 $condition";

        $arr_return['count'] = $this->db->getOne($stmt, array());

        return $arr_return;
    }

    /**
     * thuc hien them moi cau hoi
     * @param type $website_id
     * @return string
     */
    public function do_insert_cq($spec, $name, $title, $phone, $email, $content) {
        $s_order = "SELECT MAX(C_ORDER) as C_ORDER FROM t_ps_cq";
        $order = $this->db->getOne($s_order);
        $order++;
        $date = date("Y-m-d h:i:s");
        $slug = auto_slug($title);
        $sql = "INSERT INTO t_ps_cq
            (
             FK_FIELD,
             C_NAME,
             C_ADDRESS,
             C_PHONE,
             C_EMAIL,
             C_TITLE,
             C_CONTENT,
             C_ANSWER,
             C_STATUS,
             C_ORDER,
             C_DATE,
             C_SLUG)
                VALUES ('$spec',
                        '$name',
                        '',
                        '$phone',
                        '$email',
                        '$title',
                        '$content',
                        '',
                        '0',
                        '$order',
                        '$date',
                        '$slug')";
        $query = $this->db->Execute($sql);
        $table_name = 't_ps_cq';
        $pk_field = 'PK_CQ';
        $order_field = 'C_ORDER';
        $pk_value = $this->db->Insert_ID();
        $assign_order = 1;
        $this->ReOrder($table_name, $pk_field, $order_field, $pk_value, $assign_order);
        $data = array();
        if ($query) {
            $data['stt'] = 'done';
            $data['msg_error'] = 'Câu hỏi của bạn đã gửi thành công và đang được kiểm duyệt, vui lòng quay lại sau!';
        } else {
            $data['stt'] = 'false';
            $data['msg_error'] = 'Xảy ra lỗi! Xin thử lại!';
        }

        return $data;
    }

    /**
     * chi tiet hoi dap
     * @param type $cq_id
     * @return type
     */
    public function qry_cq_detail($cq_id) {
        $sql = "SELECT * FROM t_ps_cq WHERE PK_CQ = ? and C_STATUS = ?";
        $result = $this->db->getRow($sql, array($cq_id, "1"));
        return $result;
    }

    /**
     * lay chuyen trang mac dinh
     * @return type
     */
    public function qry_default_website_id() {
        $sql = "Select PK_WEBSITE From t_ps_website Order By C_ORDER";
        return $this->db->GetOne($sql);
    }

    /**
     * dem so tin bai thuoc chuyen muc
     * @param type $v_category_id
     * @return type
     */
    private function _count_article_by_category($v_category_id) {
        $stmt = 'Select Count(*) From t_ps_category_article CA Where FK_CATEGORY = ?';
        $params = array($v_category_id);

        return $this->db->getOne($stmt, $params);
    }

    /**
     * lay danh sach lien ket web theo ma 
     * @param type $website_id
     * @param type $type_code
     * @return type
     */
    public function qry_weblink($website_id, $type_code) {

        return $this->db->getAll('SELECT *
                                    FROM t_ps_weblink
                                    WHERE C_STATUS = 1
                                        AND DATEDIFF(C_BEGIN_DATE, NOW()) <= 0
                                        AND DATEDIFF(NOW(), C_END_DATE) <= 0
                                        AND FK_TYPE = (SELECT
                                                         PK_LIST
                                                       FROM t_cores_list
                                                       WHERE C_CODE = ?)
                                        AND FK_WEBSITE = ? ORDER BY C_ORDER', array($type_code, $website_id));
    }
    public function get_cq_field()
    {
        return $this->db->GetAll('SELECT * FROM t_ps_cq_field WHERE C_STATUS = 1 ORDER BY C_ORDER');
    }
}
