<?php
class CompanyPageController extends BaseTemplateController
{

    function displayCompanyPage($array = [])
    {
        global $IMG_PATH;

        $COMPANYPAGE_TEMPLATE = new TEMPLATE();
        $COMPANYPAGE_TEMPLATE->getTemplate("view/companyIndex.html");
        $FOR_EMAIL_ARRAY = new TEMPLATE();
        $FOR_COMPANY_TAG_ARRAY = new TEMPLATE();
        $FOR_BLOG_CARD = new TEMPLATE();
        $FOR_BLOG_TAG = new TEMPLATE();
        $FOR_FAQ_DATA = new TEMPLATE();
        $all_email_item = '';
        $all_tag_item = '';
        $all_blog_card_item = '';
        $all_faq_data_item = '';

        $company_id = $array['company'];
        $requestUri = $_SERVER['REQUEST_URI'];

        $Company = new Company();
        $company_data = $Company->getCompanyDetails($company_id);
        $company_name = Helper::switchLang($company_data['company_name'], $company_data['company_name_cn'], $company_data['company_name_bm']);
        $company_name_check = Helper::slugifyCompanyName($company_data['company_name']);
        if (strpos($requestUri, $company_name_check) == false) {
            $this->redirectTo404();
        }

        $company_desc = Helper::switchLang($company_data['shortservices'], $company_data['shortservices_cn'], $company_data['shortservices_bm']);
        $company_email = $company_data['email'];
        $email_list = array_map('trim', explode(',', $company_email));
        $company_tag = $company_data['pages_title'];
        $tag_list = array_map('trim', explode(',', $company_tag));
        $company_logo_image = $IMG_PATH . $company_data['logo'];
        $company_website = $company_data['website'];
        $company_address = $company_data['address'];
        $company_area = $company_data['area'];

        $lat = $company_data['lat'];
        $lng = $company_data['lng'];
        $mapUrl = "https://www.google.com/maps/search/?api=1&query={$lat},{$lng}";
        $company_address = Helper::iconvUtf8($company_address);

        // Blog tab: same articleCard data/design as the standalone /blog
        // page, filtered to this company only.
        $Article = new Article();
        $blog_cards = $Article->getCards(['company_id' => $company_id]);
        foreach ($blog_cards as $card) {
            $all_blog_tag_item = '';
            foreach ($card['tags'] as $tag) {
                $FOR_BLOG_TAG->renew("/{START_BLOG_TAG:00}(.+){END_BLOG_TAG:00}/s", $COMPANYPAGE_TEMPLATE->content());
                $FOR_BLOG_TAG->replace(
                    array(
                        "/{BLOG_TAG}/s" => $tag,
                    )
                );
                $all_blog_tag_item .= $FOR_BLOG_TAG->content();
            }

            $FOR_BLOG_CARD->renew("/{START_BLOG_CARD:00}(.+){END_BLOG_CARD:00}/s", $COMPANYPAGE_TEMPLATE->content());
            $FOR_BLOG_CARD->replace(
                array(
                    "/{BLOG_URL}/s" => $card['url'],
                    "/{BLOG_TITLE}/s" => $card['title'],
                    "/{BLOG_EXCERPT}/s" => $card['excerpt'],
                    "/{BLOG_CATEGORY}/s" => $card['category'],
                    "/{BLOG_SLUG}/s" => $card['slug'],
                    "/{BLOG_IMAGE}/s" => $card['image'],
                    "/{BLOG_COMPANY_NAME}/s" => $card['company_name'],
                    "/{BLOG_COMPANY_URL}/s" => $card['company_url'],
                    "/{BLOG_COMPANY_LOGO}/s" => $card['company_logo'],
                    "/{START_BLOG_TAG:00}(.+){END_BLOG_TAG:00}/s" => $all_blog_tag_item,
                )
            );
            $all_blog_card_item .= $FOR_BLOG_CARD->content();
        }

        // FAQ tab: same full FAQ card design as the standalone /faqs page,
        // filtered to this company only. Company info (name/logo/url) is
        // the same for every row since they all belong to this one company.
        $Faq = new Faq();
        $faq_details_list = $Faq->getFaqDetailsList($company_id);
        $faqEntities = [];

        foreach ($faq_details_list as $key => $data) {
            $faq_id = $data['id'];
            $category_id = $data['faq_category_id'];
            $category_name = $Faq->getFaqCategoryNameByID($category_id);
            $category_name = Helper::slugify($category_name['category_title_en']);
            $FOR_FAQ_DATA->renew("/{START_FOR_FAQ_LIST:00}(.+){END_FOR_FAQ_LIST:00}/s", $COMPANYPAGE_TEMPLATE->content());
            $FOR_FAQ_DATA->replace(
                array(
                    "/{FAQ_ID}/s" => $faq_id,
                    "/{FAQ_QUES}/s" => Helper::normalizeSentence($data['faq_question_en']),
                    "/{FAQ_ANS}/s" => Helper::normalizeSentence($data['faq_answer_en']),
                    "/{FAQ_URL}/s" => "../../id/$faq_id",
                    "/{CATEGORY_NAME}/s" => $category_name,
                    "/{COMPANY_NAME}/s" => $company_name,
                    "/{COMPANY_LOGO}/s" => $company_logo_image,
                    "/{COMPANY_URL}/s" => $company_website,
                )
            );
            $all_faq_data_item .= $FOR_FAQ_DATA->content();

            $faqEntities[] = [
                "@type" => "Question",
                "name" => $data['faq_question_en'],
                "acceptedAnswer" => [
                    "@type" => "Answer",
                    "text" => $data['faq_answer_en'],
                ]
            ];
        }

        foreach ($email_list as $key => $email) {
            $FOR_EMAIL_ARRAY->renew("/{START_IF_MULTIPLE_EMAIL}(.+){END_IF_MULTIPLE_EMAIL}/s", $COMPANYPAGE_TEMPLATE->content());
            $FOR_EMAIL_ARRAY->replace(
                array(
                    "/{COMPANY_EMAIL}/s" => $email,
                )
            );
            $all_email_item .= $FOR_EMAIL_ARRAY->content();
        }

        foreach ($tag_list as $key => $tag) {
            $FOR_COMPANY_TAG_ARRAY->renew("/{START_COMPANY_TAG:00}(.+){END_COMPANY_TAG:00}/s", $COMPANYPAGE_TEMPLATE->content());
            $FOR_COMPANY_TAG_ARRAY->replace(
                array(
                    "/{COMPANY_TAG}/s" => $tag,
                )
            );
            $all_tag_item .= $FOR_COMPANY_TAG_ARRAY->content();
        }
        $host = $_SERVER['HTTP_HOST'];
        $faq_path = '';
        if ($host === 'ryantest.newpages.com.my') {
            $faq_path = "/faq";
        }
        $COMPANYPAGE_TEMPLATE->replace(array(
            "/{START_BLOG_CARD:00}(.+){END_BLOG_CARD:00}/s" => $all_blog_card_item,
            "/{START_FOR_FAQ_LIST:00}(.+){END_FOR_FAQ_LIST:00}/s" => $all_faq_data_item,
            "/{COMPANY_NAME}/s" => $company_name,
            "/{COMPANY_DESC}/s" => $company_desc,
            "/{COMPANY_WEBSITE}/s" => $company_website,
            "/{COMPANY_ADDRESS}/s" => $company_address,
            "/{COMPANY_MAP}/s" => $mapUrl,
            "/{COMPANY_LOGO_IMAGE}/s" => $company_logo_image,
            "/{START_IF_MULTIPLE_EMAIL}(.+){END_IF_MULTIPLE_EMAIL}/s" => $all_email_item,
            "/{START_COMPANY_TAG:00}(.+){END_COMPANY_TAG:00}/s" => $all_tag_item,
            "/{RYANTEST_FAQ_PATH}/s" => $faq_path,
        ));

        $url = "https://$host$requestUri";
        $schema = [
            "@graph" => [
                [
                    "@type" => "Organization",
                    "name" => "$company_name",
                    "url" => $url,
                    "email" => [
                        $email_list,
                    ],
                    "address" => [
                        "@type" => "PostalAddress",
                        "streetAddress" => "$company_address",
                    ],
                    "contactPoint" => [
                        [
                            "@type" => "ContactPoint",
                            "contactType" => "customer support",
                            "email" => [$email_list]
                        ]
                    ]
                ],
                [
                    "@context" => "https://schema.org",
                    "@type" => "FAQPage",
                    "mainEntity" => $faqEntities
                ]
            ]
        ];

        $cache_file_name = "schema_company_" . $company_id;
        if (!ObjectCache::isCached($cache_file_name)) {
            ObjectCache::cache($cache_file_name, $schema, false);
        }
        if (empty($schema)) {
            $schema = ObjectCache::getCache($cache_file_name);
        }
        $meta_title = 'List of Frequently Asked Question ' . $company_name . ' ' . $company_area . ' | FAQ2U';
        $meta_desc = 'Browse a clear and structured list of frequently asked questions with reliable answers to help users better understand ' . $company_name . ' ' . $company_area . ' | FAQ2U.';
        $this->setMetaTitle(sprintf($meta_title, ""));
        $this->setMetaDescription(sprintf($meta_desc, ""));
        $this->setSchema($schema);
        $this->setOG(["og_title" => $meta_title, "og_desc" => $meta_desc, "og_url" => $company_website, "og_image" => $company_logo_image, "og_sitename" => $company_name, "og_type" => 'website',]);

        return $COMPANYPAGE_TEMPLATE->content(false, true);
    }
}
?>
