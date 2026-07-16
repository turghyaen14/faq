<?php
class CompanyPageController extends BaseTemplateController
{

    function displayCompanyPage($array = [])
    {
        global $IMG_PATH;

        $COMPANYPAGE_TEMPLATE = new TEMPLATE();
        $COMPANYPAGE_TEMPLATE->getTemplate("view/companyIndex.html");
        $FOR_FAQ_DATA = new TEMPLATE();
        $FOR_EMAIL_ARRAY = new TEMPLATE();
        $FOR_CATEGORY_ARRAY = new TEMPLATE();
        $FOR_MOBILE_CATEGORY_ARRAY = new TEMPLATE();
        $FOR_COMPANY_TAG_ARRAY = new TEMPLATE();
        $all_category_data_item = '';
        $all_mobile_category_data_item = '';
        $all_faq_data_item = '';
        $all_email_item = '';
        $all_tag_item = '';

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

        $Faq = new Faq();
        $faq_details_list = $Faq->getFaqDetailsList($company_id);
        $faq_category_list = $Faq->getFaqCategoryList($company_id);
        $faqEntities = [];

        foreach ($faq_category_list as $key => $data) {
            $category_name = $data['category_title_en'];
            $slug = ($category_name === 'All Topics') ? 'all' : Helper::slugify($category_name);

            $FOR_CATEGORY_ARRAY->renew("/{START_FOR_CATEGORY_NAME_LIST:00}(.+){END_FOR_CATEGORY_NAME_LIST:00}/s", $COMPANYPAGE_TEMPLATE->content());
            $FOR_CATEGORY_ARRAY->replace(
                array(
                    "/{CATGEGORY_NAME}/s" => $category_name,
                    "/{CATGEGORY_NAME_SLUG}/s" => $slug,
                )
            );
            $all_category_data_item .= $FOR_CATEGORY_ARRAY->content();

            $FOR_MOBILE_CATEGORY_ARRAY->renew("/{START_FOR_MOBILE_CATEGORY_NAME_LIST:00}(.+){END_FOR_MOBILE_CATEGORY_NAME_LIST:00}/s", $COMPANYPAGE_TEMPLATE->content());
            $FOR_MOBILE_CATEGORY_ARRAY->replace(
                array(
                    "/{CATGEGORY_NAME}/s" => $category_name,
                    "/{CATGEGORY_NAME_SLUG}/s" => $slug,
                )
            );
            $all_mobile_category_data_item .= $FOR_MOBILE_CATEGORY_ARRAY->content();
        }

        foreach ($faq_details_list as $key => $data) {
            $faq_id = $data['id'];
            $category_id = $data['faq_category_id'];
            $category_name = $Faq->getFaqCategoryNameByID($category_id);
            $category_name = Helper::slugify($category_name['category_title_en']);
            $FOR_FAQ_DATA->renew("/{START_FOR_FAQ_LIST:00}(.+){END_FOR_FAQ_LIST:00}/s", $COMPANYPAGE_TEMPLATE->content());
            $FOR_FAQ_DATA->remove("/{START_UNIQUE_COMPONENT}(.+){END_UNIQUE_COMPONENT}/s");

            $FOR_FAQ_DATA->replace(
                array(
                    "/{FAQ_QUE}/s" => $data['faq_question_en'],
                    "/{FAQ_ANS}/s" => $data['faq_answer_en'],
                    "/{FAQ_URL}/s" => "../../id/$faq_id",
                    "/{FAQ_ID}/s" => $faq_id,
                    "/{CATEGORY_NAME}/s" => $category_name,
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
            "/{START_FOR_FAQ_LIST:00}(.+){END_FOR_FAQ_LIST:00}/s" => $all_faq_data_item,
            "/{START_FOR_CATEGORY_NAME_LIST:00}(.+){END_FOR_CATEGORY_NAME_LIST:00}/s" => $all_category_data_item,
            "/{START_FOR_MOBILE_CATEGORY_NAME_LIST:00}(.+){END_FOR_MOBILE_CATEGORY_NAME_LIST:00}/s" => $all_mobile_category_data_item,
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

        $cache_file_name = "schema_individual_" . $faq_id;
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
