<?php
class Faq
{

    function __construct()
    {
        global $conn;
        $this->conn = $conn;
        global $db_8_np2u;
        $this->db_8_np2u = $db_8_np2u;
    }
    function getFaqDetailsList($company_id)
    {
        $company_id = mysqli_real_escape_string($this->conn, htmlspecialchars($company_id));

        $sql = "SELECT * FROM $this->db_8_np2u.ex_faq WHERE company_id = '$company_id'";
        $result = mysqli_query($this->conn, $sql);
        if (!$result) {
            exit('error to select db');
        }
        while ($row = mysqli_fetch_assoc($result)) {
            $array[] = $row;
        }
        return $array;
    }

    function getFaqDetailsByID($faq_id)
    {
        $faq_id = mysqli_real_escape_string($this->conn, htmlspecialchars($faq_id));

        $cache_file_name = "faq_data_" . $faq_id;
        if (!ObjectCache::isCached($cache_file_name)) {
            $sql = "SELECT * FROM $this->db_8_np2u.ex_faq WHERE id = '$faq_id' LIMIT 1";
            $result = mysqli_query($this->conn, $sql);
            if (!$result) {
                exit('error to select db');
            }
            $faq_data = Helper::convertUTF8(mysqli_fetch_assoc($result));
            $faq_data['category_name'] = $this->getFaqCategoryNameByID($faq_data['faq_category_id'])['category_title_en'];
            ObjectCache::cache($cache_file_name, $faq_data, false);
        }

        //use cache
        if (empty($faq_data)) {
            $faq_data = ObjectCache::getCache($cache_file_name);
        }
        return $faq_data;
    }

    function getLimitFaqList($options)
    {
        $default_options = array(
            'page' => 1,
            'start' => 0,
            'limit' => 10,
            'search' => '',
            'order_column' => 'id',
            'order_dir' => 'DESC',
            'group_by' => ''
        );

        foreach ($default_options as $var => $val) {
            ${$var} = isset($options[$var]) ? $options[$var] : $val;
        }

        $page = intval($page);
        $limit = intval($limit);
        $start = intval(($page - 1) * $limit);
        $limit = intval($limit);

        if ($limit > 0) {
            $limitSQL = "LIMIT $start, $limit";
        } else {
            $limitSQL = "";
        }
        $appendSearchSQL = "";
        if (!empty($search)) {
            $safeSearch = addslashes($search);
            $safeSearch = mysqli_real_escape_string($this->conn, htmlspecialchars($safeSearch));

            $appendSearchSQL = "WHERE (`faq_question_en` LIKE '%$safeSearch%' OR `faq_answer_en` LIKE '%$safeSearch%')";
        }

        $appendGroupSQL = '';
        if (!empty($group_by)) {
            $appendGroupSQL = "GROUP BY company_id";
        }

        $order_column = in_array($order_column, $allowedColumns) ? $order_column : 'id';
        $order_dir = strtolower($order_dir) === 'asc' ? 'ASC' : 'DESC';

        $sql = "SELECT * FROM $this->db_8_np2u.ex_faq 
            $appendSearchSQL $appendGroupSQL 
            ORDER BY `$order_column` $order_dir
            $limitSQL";
        $result = mysqli_query($this->conn, $sql);
        if (!$result) {
            die("Get FAQ LIMIT Query Invalid: " . mysqli_error($this->conn));
        }

        $getArray = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $getArray[] = $row;
        }
        return $getArray;
    }

    function getTotalFaqResult($search)
    {
        $appendSearchSQL = "";
        if (!empty($search)) {
            $safeSearch = addslashes($search);
            $safeSearch = mysqli_real_escape_string($this->conn, htmlspecialchars($safeSearch));

            $appendSearchSQL = "WHERE (`faq_question_en` LIKE '%$safeSearch%' OR `faq_answer_en` LIKE '%$safeSearch%')";
        }

        $sql = "SELECT COUNT(*) as total_result FROM $this->db_8_np2u.ex_faq 
            $appendSearchSQL";
        $result = mysqli_query($this->conn, $sql);
        $row = mysqli_fetch_assoc($result);
        return $row['total_result'];
    }

    function getFaqCategoryList($company_id)
    {
        $company_id = mysqli_real_escape_string($this->conn, htmlspecialchars($company_id));

        $sql = "SELECT faq_category_id FROM $this->db_8_np2u.ex_faq WHERE company_id = '$company_id' GROUP BY faq_category_id";
        $result = mysqli_query($this->conn, $sql);
        if (!$result) {
            exit('error to select db');
        }
        while ($row = mysqli_fetch_assoc($result)) {
            $faq_category_id = mysqli_real_escape_string($this->conn, htmlspecialchars($row['faq_category_id']));
            $sql_category = "SELECT * FROM $this->db_8_np2u.ex_faq_category WHERE id = '$faq_category_id' LIMIT 1";
            $result_category = mysqli_query($this->conn, $sql_category);
            if (!$result_category) {
                exit('error to select db');
            }
            $faq_category_list[] = mysqli_fetch_assoc($result_category);
        }
        return $faq_category_list;
    }

    function getFaqCategoryNameByID($faq_id)
    {
        $faq_id = mysqli_real_escape_string($this->conn, htmlspecialchars($faq_id));
        $sql = "SELECT * FROM $this->db_8_np2u.ex_faq_category WHERE id = '$faq_id' LIMIT 1";
        $result = mysqli_query($this->conn, $sql);
        return mysqli_fetch_assoc($result);
    }
}
?>