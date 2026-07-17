<?php
class IndexPageController extends BaseTemplateController
{

    function displayIndexPage()
    {
        global $IMG_PATH;
        $INDEXPAGE_TEMPLATE = new TEMPLATE();
        $FOR_ARTICLE_CARD = new TEMPLATE();
        $FOR_FAQ_DATA = new TEMPLATE();
        $FOR_COMPANY_TAG_ARRAY = new TEMPLATE();
        $INDEXPAGE_TEMPLATE->getTemplate("view/index.html");

        $Article = new Article();
        $featured = $Article->getFeatured();
        $article_cards = $Article->getCards(['limit' => 4]);

        $all_article_card_item = '';
        foreach ($article_cards as $article) {
            $FOR_ARTICLE_CARD->renew("/{START_ARTICLE_CARD:00}(.+){END_ARTICLE_CARD:00}/s", $INDEXPAGE_TEMPLATE->content());
            $FOR_ARTICLE_CARD->replace(
                array(
                    "/{ARTICLE_URL}/s" => $article['url'],
                    "/{ARTICLE_TITLE}/s" => $article['title'],
                    "/{ARTICLE_CATEGORY}/s" => $article['category'],
                    "/{ARTICLE_DATE}/s" => $article['date'],
                    "/{ARTICLE_IMAGE}/s" => $article['image'],
                )
            );
            $all_article_card_item .= $FOR_ARTICLE_CARD->content();
        }

        // FAQs column: real backend data (Faq/Company), same source as the
        // rest of the site — no stub needed, this data already exists live.
        $Faq = new Faq();
        $Company = new Company();
        $get_faq_list = $Faq->getLimitFaqList(['group_by' => 'company_id', 'limit' => 5]);

        $all_faq_list_item = '';
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
                    $FOR_COMPANY_TAG_ARRAY->renew("/{START_TAG_LIST:00}(.+){END_TAG_LIST:00}/s", $INDEXPAGE_TEMPLATE->content());
                    $FOR_COMPANY_TAG_ARRAY->replace(
                        array(
                            "/{COMPANY_TAG}/s" => $tag,
                        )
                    );
                    $all_tag_item .= $FOR_COMPANY_TAG_ARRAY->content();
                }
            }
            $FOR_FAQ_DATA->renew("/{START_FOR_FAQ_LIST:00}(.+){END_FOR_FAQ_LIST:00}/s", $INDEXPAGE_TEMPLATE->content());
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

        $INDEXPAGE_TEMPLATE->replace(array(
            "/{FEATURED_TITLE}/s" => $featured['title'],
            "/{FEATURED_IMAGE}/s" => $featured['image'],
            "/{FEATURED_URL}/s" => $featured['url'],
            "/{START_ARTICLE_CARD:00}(.+){END_ARTICLE_CARD:00}/s" => $all_article_card_item,
            "/{START_FOR_FAQ_LIST:00}(.+){END_FOR_FAQ_LIST:00}/s" => $all_faq_list_item,
            "/{RYANTEST_FAQ_PATH}/s" => $faq_path,

        ));
        return $INDEXPAGE_TEMPLATE->content(false, true);
    }
}
?>