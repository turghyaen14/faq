<?php
$host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
if ($host === 'ryantest.newpages.com.my') {
    require_once($_SERVER['DOCUMENT_ROOT'] . "/faq/required.php");
} else {
    require_once($_SERVER['DOCUMENT_ROOT'] . "/required.php");
}

$previewToken = getenv('ARTICLE_PREVIEW_TOKEN') ? getenv('ARTICLE_PREVIEW_TOKEN') : '';
if ($previewToken !== '') {
    $token = isset($_GET['token']) ? $_GET['token'] : '';
    if (!hash_equals($previewToken, $token)) {
        header('HTTP/1.1 403 Forbidden');
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(array(
            'status' => 'failed',
            'error' => 'Forbidden'
        ), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }
}

$company_id = isset($_GET['company_id']) ? preg_replace('/[^0-9]/', '', $_GET['company_id']) : '';
if ($company_id === '' && isset($_GET['id'])) {
    $company_id = preg_replace('/[^0-9]/', '', $_GET['id']);
}

if ($company_id === '') {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(array(
        'error' => 'Please provide a company_id.',
        'example' => '/article_preview.php?company_id=28587'
    ), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit;
}

$Company = new Company();
$Faq = new Faq();
$ArticleGenerator = new OpenAiArticleGenerator();

$company_data = $Company->getCompanyDetails($company_id);
$faq_details_list = $Faq->getFaqDetailsList($company_id);
$faq_category_list = $Faq->getFaqCategoryList($company_id);
$cache_file_name = 'company_article_' . $company_id;
$was_cached = ObjectCache::isCached($cache_file_name, true, 2592000);
$article = $ArticleGenerator->getCompanyFaqArticleData($company_id, $company_data, $faq_details_list, $faq_category_list);
$is_cached_after = ObjectCache::isCached($cache_file_name, true, 2592000);

$company_name = isset($company_data['company_name']) ? Helper::iconvUtf8($company_data['company_name']) : '';
$faq_count = is_array($faq_details_list) ? count($faq_details_list) : 0;
$category_count = is_array($faq_category_list) ? count($faq_category_list) : 0;
$api_key_found = (!empty($OPENAI_API_KEY) || getenv('OPENAI_API_KEY')) ? 'Yes' : 'No';

header('Content-Type: application/json; charset=utf-8');

if (empty($article)) {
    echo json_encode(array(
        'error' => 'Article data is empty. Check OPENAI_API_KEY, PHP cURL, company FAQs, and OpenAI request status.'
    ), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit;
}

$output = $article;

if (isset($_GET['debug']) && $_GET['debug'] === '1') {
    $output['_debug'] = array(
        'company_id' => $company_id,
        'company_name' => $company_name,
        'faq_count' => $faq_count,
        'category_count' => $category_count,
        'openai_api_key_found' => $api_key_found,
        'was_cached_before_request' => $was_cached,
        'cached_after_request' => $is_cached_after,
        'cache_file' => $cache_file_name
    );
}

echo json_encode($output, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
