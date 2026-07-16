<?php
class SearchPageController extends BaseTemplateController
{

    function displaySearchPage($array = [])
    {
        global $IMG_PATH;
        $SEARCHPAGE_TEMPLATE = new TEMPLATE();
        $SEARCHPAGE_TEMPLATE->getTemplate("view/searchedQuery.html");
        $FOR_FAQ_DATA = new TEMPLATE();
        $FOR_COMPANY_TAG_ARRAY = new TEMPLATE();

        $search_input = isset($_GET['input']) ? trim($_GET['input']) : '';
        if ($search_input === '') {
            $SEARCHPAGE_TEMPLATE->remove("/{START_SEARCH_INPUT_COMPONENT}(.+){END_SEARCH_INPUT_COMPONENT}/s");
        }
        $FAQ = new Faq();
        $COMPANY = new Company();
        $get_faq_list = $FAQ->getLimitFaqList(['search' => $search_input, 'page' => $_GET['page']]);
        $faqEntities = [];

        foreach ($get_faq_list as $key => $faq) {
            $company_id = $faq['company_id'];
            $company_data = $COMPANY->getCompanyDetails($company_id);
            $company_name = Helper::switchLang($company_data['company_name'], $company_data['company_name_cn'], $company_data['company_name_bm']);
            $company_name_check = Helper::slugifyCompanyName($company_data['company_name']);
            $company_logo = $IMG_PATH . $company_data['logo'];
            $company_url = $company_data['website'];
            $company_tag = $company_data['pages_title'];
            $company_area = $company_data['area'];
            $category_id = $faq['faq_category_id'];
            $category_name = $FAQ->getFaqCategoryNameByID($category_id);
            $category_name = Helper::slugify($category_name['category_title_en']);
            $tag_list = explode(',', $company_tag);
            $all_tag_item = '';
            if (!empty(array_filter($tag_list))) {
                foreach ($tag_list as $key => $tag) {
                    $FOR_COMPANY_TAG_ARRAY->renew("/{START_TAG_LIST:00}(.+){END_TAG_LIST:00}/s", $SEARCHPAGE_TEMPLATE->content());
                    $FOR_COMPANY_TAG_ARRAY->replace(
                        array(
                            "/{COMPANY_TAG}/s" => $tag,
                        )
                    );
                    $all_tag_item .= $FOR_COMPANY_TAG_ARRAY->content();
                }
            } else {
                $FOR_FAQ_DATA->remove("/{START_TAG_LIST:00}(.+){END_TAG_LIST:00}/s");
            }
            $FOR_FAQ_DATA->renew("/{START_FOR_FAQ_LIST:00}(.+){END_FOR_FAQ_LIST:00}/s", $SEARCHPAGE_TEMPLATE->content());
            $FOR_FAQ_DATA->remove("/{START_UNIQUE_COMPONENT}(.+){END_UNIQUE_COMPONENT}/s");

            $FOR_FAQ_DATA->replace(
                array(
                    "/{FAQ_ID}/s" => $faq['id'],
                    "/{FAQ_QUES}/s" => $faq['faq_question_en'],
                    "/{FAQ_ANS}/s" => $faq['faq_answer_en'],
                    "/{FAQ_COMPANY_PAGE}/s" => "company/" . $company_id . "/" . $company_name_check,
                    "/{START_TAG_LIST:00}(.+){END_TAG_LIST:00}/s" => $all_tag_item,
                    "/{FAQ_URL}/s" => "id/" . $faq['id'],
                    "/{COMPANY_NAME}/s" => $company_name,
                    "/{COMPANY_URL}/s" => $company_url,
                    "/{COMPANY_LOGO}/s" => $company_logo,
                    "/{FAQ_CATEGORY_NAME}/s" => $category_name,
                )
            );
            $all_faq_list_item .= $FOR_FAQ_DATA->content();

            $faqEntities[] = [
                "@type" => "Question",
                "name" => $faq['faq_question_en'],
                "acceptedAnswer" => [
                    "@type" => "Answer",
                    "text" => $faq['faq_answer_en'],
                ]
            ];
        }

        $total_search_result = $FAQ->getTotalfaqResult($search_input);
        $limit = 10;

        $currentPage = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        if ($currentPage < 1) {
            $currentPage = 1;
        }
        $pagination_component = Helper::paginationComponent($currentPage, $total_search_result, $limit, 3);
        $host = $_SERVER['HTTP_HOST'];
        $faq_path = '';
        if ($host === 'ryantest.newpages.com.my') {
            $faq_path = "/faq";
        }
        $SEARCHPAGE_TEMPLATE->replace(array(
            "/{SEARCH_INPUT}/s" => $search_input,
            "/{TOTAL_SEARCH_RESULT}/S" => $total_search_result,
            "/{START_FOR_FAQ_LIST:00}(.+){END_FOR_FAQ_LIST:00}/s" => $all_faq_list_item,
            "/{SERACH_QUERY_PAGINATION_COMPONENT}/s" => $pagination_component,
            "/{RYANTEST_FAQ_PATH}/s" => $faq_path,
        ));

        $schema = [
            "@context" => "https://schema.org",
            "@type" => "FAQPage",
            "mainEntity" => $faqEntities,
        ];

        $this->setSchema($schema);

        return $SEARCHPAGE_TEMPLATE->content(false, true);
    }
}
?>