<?php
class NotFound404PageController extends BaseTemplateController
{

    function displayNotFound404Page($array = [])
    {
        $NOTFOUND404PAGE_TEMPLATE = new TEMPLATE();
        $NOTFOUND404PAGE_TEMPLATE->getTemplate("view/notfound404.html");

        $host = $_SERVER['HTTP_HOST'];
        $faq_path = '';
        if ($host === 'ryantest.newpages.com.my') {
            $faq_path = "/faq";
        }
        $NOTFOUND404PAGE_TEMPLATE->replace(array(
            "/{RYANTEST_FAQ_PATH}/s" => $faq_path,
        ));
        return $NOTFOUND404PAGE_TEMPLATE->content(false, true);
    }
}
?>