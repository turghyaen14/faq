<?php
class AboutUsPageController extends BaseTemplateController
{

    function displayAboutUsPage($array = [])
    {
        $ABOUTUSPAGE_TEMPLATE = new TEMPLATE();
        $ABOUTUSPAGE_TEMPLATE->getTemplate("view/aboutUs.html");

        $host = $_SERVER['HTTP_HOST'];
        $faq_path = '';
        if ($host === 'ryantest.newpages.com.my') {
            $faq_path = "/faq";
        }
        $ABOUTUSPAGE_TEMPLATE->replace(array(
            "/{RYANTEST_FAQ_PATH}/s" => $faq_path,
        ));
        return $ABOUTUSPAGE_TEMPLATE->content(false, true);
    }
}
?>