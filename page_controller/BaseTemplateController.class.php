<?php
class BaseTemplatecontroller
{
    var $meta_title;
    var $meta_description;
    var $schema;
    var $og;
    public function setSchema($string)
    {
        $this->schema = json_encode($string, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        $this->schema = html_entity_decode($this->schema);
        return;
    }

    function generateHeader()
    {
        global $META_TITLE;
        global $META_DESC;
        global $OG_TITLE;
        global $OG_DESC;
        global $OG_URL;
        global $OG_IMAGE;
        global $OG_SITENAME;
        global $OG_TYPE;

        $HEADER_TEMPLATE = new TEMPLATE();
        $HEADER_TEMPLATE->getTemplate("view/header.html");

        if (empty($this->meta_title)) {
            $this->setMetaTitle($META_TITLE);
        }

        if (empty($this->meta_description)) {
            $this->setMetaDescription($META_DESC);
        }

        if (empty($this->schema)) {
            $this->setSchema('');
        }

        if (empty($this->og)) {
            $this->setOG(["og_title" => $OG_TITLE, "og_desc" => $OG_DESC, "og_url" => $OG_URL, "og_image" => $OG_IMAGE, "og_sitename" => $OG_SITENAME, "og_type" => $OG_TYPE]);
        }
        $host = $_SERVER['HTTP_HOST'];
        $faq_path = '';
        if ($host === 'ryantest.newpages.com.my') {
            $faq_path = "/faq";
        }

        $company_index = '';
        if ($company_index) {
            $HEADER_TEMPLATE->remove("/{START_HEADER_WITHOUT_SENTENCES}(.+){END_HEADER_WITHOUT_SENTENCES}/s");
        }

        if ($_GET['route'] == 'notfound404') {
            $HEADER_TEMPLATE->remove("/{START_HEADER_COMPONENT}(.+){END_HEADER_COMPONENT}/s");
        }

        // Tagline text ("Explore answers with confidence...") only shows on
        // Home; every other page keeps it exactly as before. Search box
        // stays on every page - only this text is route-conditional.
        if (empty($_GET['route'])) {
            $HEADER_TEMPLATE->remove("/{START_HOME_TAGLINE_TEXT}(.+){END_HOME_TAGLINE_TEXT}/s");
        }

        $HEADER_TEMPLATE->replace(array(
            "/{META_TITLE}/s" => $this->meta_title,
            "/{META_DESCRIPTION}/s" => $this->meta_description,
            "/{RYANTEST_FAQ_PATH}/s" => $faq_path,
            "/{FAQ_SCHEMA_JSONLD}/s" => $this->schema,
            "/{OG_TITLE}/s" => $this->og['og_title'],
            "/{OG_DESC}/s" => $this->og['og_desc'],
            "/{OG_URL}/s" => $this->og['og_url'],
            "/{OG_IMAGE}/s" => $this->og['og_image'],
            "/{OG_SITENAME}/s" => $this->og['og_sitename'],
            "/{OG_TYPE}/s" => $this->og['og_type'],
        ));
        return $HEADER_TEMPLATE->content(false, true);
    }

    function generateFooter()
    {
        $FOOTER_TEMPLATE = new TEMPLATE();
        $FOOTER_TEMPLATE->getTemplate("view/footer.html");
        $current_year = date('Y');
        $target_year = 2026;

        if ($current_year >= $target_year) {
            $current_year = $target_year;
        } else {
            $current_year = $current_year . ' - ' . $target_year;
        }

        $host = $_SERVER['HTTP_HOST'];
        $faq_path = '';
        if ($host === 'ryantest.newpages.com.my') {
            $faq_path = "/faq";
        }

        $FOOTER_TEMPLATE->replace(array(
            // "/{VERSION_CONTROL}/s" => $VERSION_CONTROL['data']['current'],
            "/{CURRENT_YAER}/s" => $current_year,
            "/{RYANTEST_FAQ_PATH}/s" => $faq_path,

        ));
        return $FOOTER_TEMPLATE->content(false, true);
    }

    function wrapContent($html)
    {
        $header = $this->generateHeader();
        $footer = $this->generateFooter();
        
        if ($_GET['route'] == 'notfound404') {
            $footer = '';
        }
        return $header . $html . $footer;
    }

    private function normalizeMetaString($string)
    {
        $string = html_entity_decode($string, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $string = strip_tags($string);
        $string = preg_replace('/\s+/', ' ', $string);
        return trim($string);
    }

    public function setMetaTitle($string)
    {
        $string = $this->normalizeMetaString($string);
        $this->meta_title = $string;
        return;
    }

    public function setMetaDescription($string)
    {
        $string = $this->normalizeMetaString($string);
        $this->meta_description = $string;
        return;
    }

    public function setOG($og = [])
    {
        foreach ($og as $key => $data) {
            $og[$key] = $this->normalizeMetaString($data);
        }
        $this->og = $og;
        return;
    }

    public function redirectTo404()
    {
        $host = $_SERVER['HTTP_HOST'];
        $faq_path = '';
        if ($host === 'ryantest.newpages.com.my') {
            $faq_path = "/faq";
        }
        $header = $faq_path . '/notfound404';
        header('Location:' . $header);
        exit();
    }

    // Shared by IndividualPageController (/id/{id}, plain FAQs) and
    // BlogPageController (/blog/id/{id}, blog articles). Same data pipeline,
    // but the two routes render different templates: the FAQ page is the plain
    // Q&A+company card (view/individualFaq.html), while the blog page is the
    // rich article layout with splash image, body paragraphs and the "Other
    // FAQs" sidebar (view/individualBlog.html). $template selects which.
    // Called as $this->... so setMetaTitle/setSchema/setOG land on whichever
    // controller instance is actually calling it.
    function renderArticleDetail($faq_id, $template = "view/individualFaq.html")
    {
        global $IMG_PATH;
        global $OG_URL;
        global $OG_IMAGE;
        $INDIVIDUALPAGE_TEMPLATE = new TEMPLATE();
        $FOR_EMAIL_ARRAY = new TEMPLATE();
        $FOR_COMPANY_TAG_ARRAY = new TEMPLATE();
        $INDIVIDUALPAGE_TEMPLATE->getTemplate($template);

        global $USE_DUMMY_DATA;
        $Faq = new Faq();
        $Company = new Company();
        $Article = new Article();

        $article_detail = $Article->getDetailByFaqId($faq_id);
        // Only the blog template renders a splash; the plain FAQ template has
        // no {SPLASH_IMAGE} tag, so this replacement is a harmless no-op there.
        $splash_image = $article_detail['splash_image'];

        if ($USE_DUMMY_DATA) {
            // Dummy article IDs don't exist as real ex_faq rows, so the real
            // lookup below would 404 every time. While stubbed, source
            // everything from the Article dummy instead (see docs/DATA_CONTRACT.md).
            $ques = $article_detail['question'];
            $answ = $article_detail['answer'];
            $company_id = $article_detail['company']['company_id'];
            $category_name = $article_detail['category'];
            $company_name = $article_detail['company']['name'];
            $company_name_check = Helper::slugifyCompanyName($company_name);
            $company_desc = $article_detail['company']['description'];
            $email_list = $article_detail['company']['emails'];
            $company_logo_image = $article_detail['company']['logo'];
            $company_website = $article_detail['company']['website'];
            $company_address = $article_detail['company']['address'];
            $tag_list = $article_detail['company']['tags'];
            $company_area = '';
            $mapUrl = $article_detail['company']['map_url'];
        } else {
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

            $lat = $company_data['lat'];
            $lng = $company_data['lng'];
            $mapUrl = "https://www.google.com/maps/search/?api=1&query={$lat},{$lng}";
            $company_address = Helper::iconvUtf8($company_address);
        }

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

        $ques = Helper::normalizeSentence($ques);
        $answ = Helper::normalizeSentence($answ);

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

        $host = $_SERVER['HTTP_HOST'];
        $faq_path = '';
        if ($host === 'ryantest.newpages.com.my') {
            $faq_path = "/faq";
        }

        // Absolute paths (not "../"-relative): this method is shared by two
        // routes at different URL depths (/id/{id} vs /blog/id/{id}), so a
        // relative link would resolve to a different place depending on
        // which one the visitor is actually on.
        $FOR_RELATED_FAQ = new TEMPLATE();
        $all_related_faq_item = '';
        foreach ($article_detail['related_faqs'] as $related) {
            $FOR_RELATED_FAQ->renew("/{START_RELATED_FAQ:00}(.+){END_RELATED_FAQ:00}/s", $INDIVIDUALPAGE_TEMPLATE->content());
            $FOR_RELATED_FAQ->replace(
                array(
                    "/{RELATED_FAQ_URL}/s" => $faq_path . "/" . $related['url'],
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

        $INDIVIDUALPAGE_TEMPLATE->replace(array(
            "/{FAQ_QUESTION}/s" => $ques,
            "/{FAQ_ANSWER}/s" => $answ,
            "/{FAQ_COMPANY_PAGE}/s" => "$faq_path/company/$company_id/$company_name_check",
            "/{FAQ_CATEGORY_NAME}/s" => $category_name,
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
            // Blog article's sticky FAQ column beside the body; reuses the same
            // list HTML. Simple tag (not a block) so it can appear a second time
            // without clashing with the greedy RELATED_FAQ block regex above.
            "/{ARTICLE_FAQ_LIST}/s" => $all_related_faq_item,
            "/{CTA_COMPANY_FAQS_URL}/s" => "$faq_path/company/$company_id/$company_name_check",
            "/{CTA_WEBSITE_URL}/s" => $company_website,
            "/{CTA_BACK_URL}/s" => "$faq_path/",
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