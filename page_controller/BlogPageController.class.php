<?php
class BlogPageController extends BaseTemplateController
{

    function displayBlogPage($array = [])
    {
        // /blog/id/{id} - a blog article's own detail page, distinct from
        // /id/{id} (plain FAQs). Same rendering, different URL namespace;
        // see BaseTemplateController::renderArticleDetail().
        if (isset($array['id'])) {
            return $this->renderArticleDetail($array['id']);
        }

        $BLOGPAGE_TEMPLATE = new TEMPLATE();
        $BLOGPAGE_TEMPLATE->getTemplate("view/blog.html");
        $FOR_BLOG_CARD = new TEMPLATE();
        $FOR_BLOG_TAG = new TEMPLATE();

        $Article = new Article();
        $featured = $Article->getFeatured();
        $search_input = isset($_GET['input']) ? trim($_GET['input']) : '';
        $limit = 16;
        $currentPage = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        if ($currentPage < 1) {
            $currentPage = 1;
        }
        $blog_cards = $Article->getCards(['search' => $search_input, 'page' => $currentPage, 'limit' => $limit]);

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

        $total_blog_result = $Article->getTotalCards(['search' => $search_input]);
        $pagination_component = Helper::paginationComponent($currentPage, $total_blog_result, $limit, 3);

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
            "/{BLOG_PAGINATION_COMPONENT}/s" => $pagination_component,
            "/{RYANTEST_FAQ_PATH}/s" => $faq_path,
        ));
        return $BLOGPAGE_TEMPLATE->content(false, true);
    }
}
?>
