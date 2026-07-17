<?php
class FaqsPageController extends BaseTemplateController
{

    function displayFaqsPage()
    {
        global $IMG_PATH;
        $FAQSPAGE_TEMPLATE = new TEMPLATE();
        $FOR_COMPANY_TAG_ARRAY = new TEMPLATE();
        $FOR_FAQ_DATA = new TEMPLATE();
        $FAQSPAGE_TEMPLATE->getTemplate("view/faqs.html");

        $Faq = new Faq();
        $Company = new Company();

        $get_faq_list = $Faq->getLimitFaqList(['group_by' => 'company_id', 'limit' => 12]);
        foreach ($get_faq_list as $key => $faq) {
            $company_id = $faq['company_id'];
            $company_data = $Company->getCompanyDetails($company_id);
            $company_name = Helper::switchLang($company_data['company_name'], $company_data['company_name_cn'], $company_data['company_name_bm']);
            $company_name_check = Helper::slugifyCompanyName($company_data['company_name']);
            $company_logo = $IMG_PATH . $company_data['logo'];
            $company_url = $company_data['website'];
            $company_tag = $company_data['pages_title'];
            $category_id = $faq['faq_category_id'];
            $category_name = $Faq->getFaqCategoryNameByID($category_id);
            $category_name = Helper::slugify($category_name['category_title_en']);
            $tag_list = explode(',', $company_tag);
            $all_tag_item = '';
            if (!empty(array_filter($tag_list))) {
                foreach ($tag_list as $key => $tag) {
                    $FOR_COMPANY_TAG_ARRAY->renew("/{START_TAG_LIST:00}(.+){END_TAG_LIST:00}/s", $FAQSPAGE_TEMPLATE->content());
                    $FOR_COMPANY_TAG_ARRAY->replace(
                        array(
                            "/{COMPANY_TAG}/s" => $tag,
                        )
                    );
                    $all_tag_item .= $FOR_COMPANY_TAG_ARRAY->content();
                }
            }
            $FOR_FAQ_DATA->renew("/{START_FOR_FAQ_LIST:00}(.+){END_FOR_FAQ_LIST:00}/s", $FAQSPAGE_TEMPLATE->content());
            $FOR_FAQ_DATA->replace(
                array(
                    "/{FAQ_ID}/s" => $faq['id'],
                    "/{FAQ_QUES}/s" => Helper::normalizeSentence($faq['faq_question_en']),
                    "/{FAQ_ANS}/s" => Helper::normalizeSentence($faq['faq_answer_en']),
                    "/{FAQ_URL}/s" => "id/" . $faq['id'],
                    "/{FAQ_COMPANY_PAGE}/s" => "company/" . $company_id . "/" . $company_name_check,
                    "/{START_TAG_LIST:00}(.+){END_TAG_LIST:00}/s" => $all_tag_item,
                    "/{COMPANY_NAME}/s" => $company_name,
                    "/{COMPANY_URL}/s" => $company_url,
                    "/{COMPANY_LOGO}/s" => $company_logo,
                    "/{CATEGORY_NAME}/s" => $category_name,
                )
            );
            $all_faq_list_item .= $FOR_FAQ_DATA->content();
        }

        $host = $_SERVER['HTTP_HOST'];
        $faq_path = '';
        if ($host === 'ryantest.newpages.com.my') {
            $faq_path = "/faq";
        }

        $FAQSPAGE_TEMPLATE->replace(array(
            "/{START_FOR_FAQ_LIST:00}(.+){END_FOR_FAQ_LIST:00}/s" => $all_faq_list_item,
            "/{RYANTEST_FAQ_PATH}/s" => $faq_path,

        ));
        return $FAQSPAGE_TEMPLATE->content(false, true);
    }
}
?>
