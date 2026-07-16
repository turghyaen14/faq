<?php
class BlogPageController extends BaseTemplateController
{

    function displayBlogPage($array = [])
    {
        $BLOGPAGE_TEMPLATE = new TEMPLATE();
        $BLOGPAGE_TEMPLATE->getTemplate("view/blog.html");
        $FOR_BLOG_CARD = new TEMPLATE();
        $FOR_BLOG_TAG = new TEMPLATE();

        $Article = new Article();
        $featured = $Article->getFeatured();
        $search_input = isset($_GET['input']) ? trim($_GET['input']) : '';
        $blog_cards = $Article->getCards(['search' => $search_input]);

        $all_blog_card_item = '';
        foreach ($blog_cards as $card) {
            $all_tag_item = '';
            foreach ($card['tags'] as $tag) {
                $FOR_BLOG_TAG->renew("/{START_BLOG_TAG:00}(.+){END_BLOG_TAG:00}/s", $BLOGPAGE_TEMPLATE->content());
                $FOR_BLOG_TAG->replace(
                    array(
                        "/{BLOG_TAG}/s" => $tag,
                    )
                );
                $all_tag_item .= $FOR_BLOG_TAG->content();
            }

            $FOR_BLOG_CARD->renew("/{START_BLOG_CARD:00}(.+){END_BLOG_CARD:00}/s", $BLOGPAGE_TEMPLATE->content());
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
                    "/{START_BLOG_TAG:00}(.+){END_BLOG_TAG:00}/s" => $all_tag_item,
                )
            );
            $all_blog_card_item .= $FOR_BLOG_CARD->content();
        }

        $host = $_SERVER['HTTP_HOST'];
        $faq_path = '';
        if ($host === 'ryantest.newpages.com.my') {
            $faq_path = "/faq";
        }

        $BLOGPAGE_TEMPLATE->replace(array(
            "/{FEATURED_TITLE}/s" => $featured['title'],
            "/{FEATURED_IMAGE}/s" => $featured['image'],
            "/{FEATURED_URL}/s" => $featured['url'],
            "/{START_BLOG_CARD:00}(.+){END_BLOG_CARD:00}/s" => $all_blog_card_item,
            "/{RYANTEST_FAQ_PATH}/s" => $faq_path,
        ));
        return $BLOGPAGE_TEMPLATE->content(false, true);
    }
}
?>
