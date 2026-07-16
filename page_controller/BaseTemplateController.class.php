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
}
?>