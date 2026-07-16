<?php
class IndexPageController extends BaseTemplateController
{

    function displayIndexPage()
    {
        $INDEXPAGE_TEMPLATE = new TEMPLATE();
        $FOR_ARTICLE_CARD = new TEMPLATE();
        $FOR_FAQ_ITEM = new TEMPLATE();
        $INDEXPAGE_TEMPLATE->getTemplate("view/index.html");

        $Article = new Article();
        $featured = $Article->getFeatured();
        $article_cards = $Article->getCards(['limit' => 4]);
        $faq_items = DummyData::faqItems();

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

        $all_faq_item = '';
        foreach ($faq_items as $faq) {
            $FOR_FAQ_ITEM->renew("/{START_FAQ_ITEM:00}(.+){END_FAQ_ITEM:00}/s", $INDEXPAGE_TEMPLATE->content());
            $FOR_FAQ_ITEM->replace(
                array(
                    "/{FAQ_URL}/s" => $faq['url'],
                    "/{FAQ_QUESTION}/s" => $faq['question'],
                    "/{FAQ_COMPANY_NAME}/s" => $faq['company_name'],
                )
            );
            $all_faq_item .= $FOR_FAQ_ITEM->content();
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
            "/{START_FAQ_ITEM:00}(.+){END_FAQ_ITEM:00}/s" => $all_faq_item,
            "/{RYANTEST_FAQ_PATH}/s" => $faq_path,

        ));
        return $INDEXPAGE_TEMPLATE->content(false, true);
    }
}
?>