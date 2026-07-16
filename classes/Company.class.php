<?php
class Company
{

    function __construct()
    {
        global $conn;
        $this->conn = $conn;
        global $db_8_np2u;
        $this->db_8_np2u = $db_8_np2u;
    }
    function getCompanyDetails($company_id)
    {
        $cache_file_name = "company_data_" . $company_id;
        if (!ObjectCache::isCached($cache_file_name)) {
            $company_id = mysqli_real_escape_string($this->conn, $company_id);

            $sql = "SELECT company_name, company_name_cn, company_name_bm, shortservices, shortservices_cn, area,
                    shortservices_bm, email, mobile1_no1, pages_title, logo, website, address, lat, lng, company_id 
                    FROM $this->db_8_np2u.company_profile WHERE company_id = '$company_id' LIMIT 1";
            $result = mysqli_query($this->conn, $sql);
            if (!$result) {
                exit('error to select db');
            }

            $company_profile = Helper::convertUTF8(mysqli_fetch_assoc($result));
            ObjectCache::cache($cache_file_name, $company_profile, false);
        }

        //use cache
        if (empty($company_profile)) {
            $company_profile = ObjectCache::getCache($cache_file_name);
        }
        return $company_profile;
    }

}
?>