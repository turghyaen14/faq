<?php
class IndividualPageController extends BaseTemplateController
{

    function displayIndividualPage($array = [])
    {
        global $IMG_PATH;
        global $OG_URL;
        global $OG_IMAGE;
        $INDIVIDUALPAGE_TEMPLATE = new TEMPLATE();
        $FOR_EMAIL_ARRAY = new TEMPLATE();
        $FOR_COMPANY_TAG_ARRAY = new TEMPLATE();
        $INDIVIDUALPAGE_TEMPLATE->getTemplate("view/individualFaq.html");

        $faq_id = $array['id'];
        $Faq = new Faq();
        $Company = new Company();
        $Article = new Article();

        $faq_data = $Faq->getFaqDetailsByID($faq_id);
        if (empty($faq_data['faq_question_en']) || $faq_data['faq_question_en'] == '') {
            $this->redirectTo404();
        }
        $ques = $faq_data['faq_question_en'];
        $answ = $faq_data['faq_answer_en'];
        $company_id = $faq_data['company_id'];
        $category_name = $faq_data['category_name'];
        $company_data = $Company->getCompanyDetails($company_id);
        $company_name = Helper::switchLang($company_data['company_name'], $company_data['company_name_cn'], $company_data['company_name_bm']);
        $company_name_check = Helper::slugifyCompanyName($company_data['company_name']);
        $company_desc = Helper::switchLang($company_data['shortservices'], $company_data['shortservices_cn'], $company_data['shortservices_bm']);
        $company_email = $company_data['email'];
        $email_list = array_map('trim', explode(',', $company_email));
        $company_logo_image = $IMG_PATH . $company_data['logo'];
        $company_website = $company_data['website'];
        $company_address = $company_data['address'];
        $company_tag = $company_data['pages_title'];
        $tag_list = array_map('trim', explode(',', $company_tag));
        $company_area = $company_data['area'];

        foreach ($email_list as $key => $email) {
            $FOR_EMAIL_ARRAY->renew("/{START_IF_MULTIPLE_EMAIL}(.+){END_IF_MULTIPLE_EMAIL}/s", $INDIVIDUALPAGE_TEMPLATE->content());
            $FOR_EMAIL_ARRAY->replace(
                array(
                    "/{COMPANY_EMAIL}/s" => $email,
                )
            );
            $all_email_item .= $FOR_EMAIL_ARRAY->content();
        }
        foreach ($tag_list as $key => $tag) {
            $FOR_COMPANY_TAG_ARRAY->renew("/{START_COMPANY_TAG:00}(.+){END_COMPANY_TAG:00}/s", $INDIVIDUALPAGE_TEMPLATE->content());
            $FOR_COMPANY_TAG_ARRAY->replace(
                array(
                    "/{COMPANY_TAG}/s" => $tag,
                )
            );
            $all_tag_item .= $FOR_COMPANY_TAG_ARRAY->content();
        }

        $lat = $company_data['lat'];
        $lng = $company_data['lng'];

        $mapUrl = "https://www.google.com/maps/search/?api=1&query={$lat},{$lng}";
        $company_address = Helper::iconvUtf8($company_address);

        $ques = Helper::normalizeSentence($ques);
        $answ = Helper::normalizeSentence($answ);

        $article_detail = $Article->getDetailByFaqId($faq_id);
        $splash_image = $article_detail['splash_image'];

        $FOR_BODY_PARA = new TEMPLATE();
        $all_body_para_item = '';
        foreach ($article_detail['body'] as $paragraph) {
            $FOR_BODY_PARA->renew("/{START_BODY_PARA:00}(.+){END_BODY_PARA:00}/s", $INDIVIDUALPAGE_TEMPLATE->content());
            $FOR_BODY_PARA->replace(
                array(
                    "/{BODY_PARAGRAPH}/s" => $paragraph,
                )
            );
            $all_body_para_item .= $FOR_BODY_PARA->content();
        }

        $FOR_RELATED_FAQ = new TEMPLATE();
        $all_related_faq_item = '';
        foreach ($article_detail['related_faqs'] as $related) {
            $FOR_RELATED_FAQ->renew("/{START_RELATED_FAQ:00}(.+){END_RELATED_FAQ:00}/s", $INDIVIDUALPAGE_TEMPLATE->content());
            $FOR_RELATED_FAQ->replace(
                array(
                    "/{RELATED_FAQ_URL}/s" => $related['url'],
                    "/{RELATED_FAQ_QUESTION}/s" => $related['question'],
                )
            );
            $all_related_faq_item .= $FOR_RELATED_FAQ->content();
        }

        $cache_file_name = "schema_individual_" . $faq_id;
        if (!ObjectCache::isCached($cache_file_name)) {
            $schema = [
                "@context" => "https://schema.org",
                "@type" => "FAQPage",
                "mainEntity" => [
                    [
                        "@type" => "Question",
                        "name" => $ques,
                        "acceptedAnswer" => [
                            "@type" => "Answer",
                            "text" => $answ
                        ]
                    ]
                ]
            ];
            ObjectCache::cache($cache_file_name, $schema, false);
        }
        if (empty($schema)) {
            $schema = ObjectCache::getCache($cache_file_name);
        }

        $host = $_SERVER['HTTP_HOST'];
        $faq_path = '';
        if ($host === 'ryantest.newpages.com.my') {
            $faq_path = "/faq";
        }

        $INDIVIDUALPAGE_TEMPLATE->replace(array(
            "/{FAQ_QUESTION}/s" => $ques,
            "/{FAQ_ANSWER}/s" => $answ,
            "/{FAQ_COMPANY_PAGE}/s" => "../company/$company_id/$company_name_check",
            "/{FAQ_CATEGORY_NAME}/s" => $category_name,
            // "/{FAQ_TITLE}/s" => $title,
            "/{COMPANY_ID}/s" => $company_id,
            "/{COMPANY_NAME}/s" => $company_name,
            "/{COMPANY_DESC}/s" => $company_desc,
            "/{COMPANY_WEBSITE}/s" => $company_website,
            "/{COMPANY_ADDRESS}/s" => $company_address,
            "/{COMPANY_MAP}/s" => $mapUrl,
            "/{COMPANY_LOGO_IMAGE}/s" => $company_logo_image,
            "/{START_IF_MULTIPLE_EMAIL}(.+){END_IF_MULTIPLE_EMAIL}/s" => $all_email_item,
            "/{START_COMPANY_TAG:00}(.+){END_COMPANY_TAG:00}/s" => $all_tag_item,
            "/{SPLASH_IMAGE}/s" => $splash_image,
            "/{START_BODY_PARA:00}(.+){END_BODY_PARA:00}/s" => $all_body_para_item,
            "/{START_RELATED_FAQ:00}(.+){END_RELATED_FAQ:00}/s" => $all_related_faq_item,
            "/{CTA_COMPANY_FAQS_URL}/s" => "../company/$company_id/$company_name_check",
            "/{CTA_WEBSITE_URL}/s" => $company_website,
            "/{CTA_BACK_URL}/s" => "../",
            "/{RYANTEST_FAQ_PATH}/s" => $faq_path,
        ));

        $meta_title = $ques . ' ' . $company_area . ' | ' . $company_name;

        $this->setMetaTitle(sprintf($meta_title, ""));
        $this->setMetaDescription(sprintf($answ, ""));
        $this->setSchema($schema);
        $this->setOG(["og_title" => $ques, "og_desc" => $answ, "og_url" => $OG_URL, "og_image" => $OG_IMAGE, "og_sitename" => $ques, "og_type" => 'website',]);
        return $INDIVIDUALPAGE_TEMPLATE->content(false, true);
    }
}
?>