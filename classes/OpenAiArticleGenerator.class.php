<?php
class OpenAiArticleGenerator
{
    function __construct()
    {
        global $OPENAI_API_KEY;
        global $OPENAI_MODEL;
        global $OPENAI_ARTICLE_CACHE_TTL;
        global $OPENAI_ARTICLE_MAX_FAQS;

        $this->apiKey = $OPENAI_API_KEY;
        $this->model = !empty($OPENAI_MODEL) ? $OPENAI_MODEL : 'gpt-5-mini';
        $this->cacheTtl = !empty($OPENAI_ARTICLE_CACHE_TTL) ? intval($OPENAI_ARTICLE_CACHE_TTL) : 2592000;
        $this->maxFaqs = !empty($OPENAI_ARTICLE_MAX_FAQS) ? intval($OPENAI_ARTICLE_MAX_FAQS) : 80;
    }

    public function getCompanyFaqArticleData($company_id, $company_data, $faq_details_list, $faq_category_list)
    {
        $company_id = preg_replace('/[^0-9]/', '', (string) $company_id);
        if ($company_id === '' || empty($faq_details_list)) {
            return array();
        }

        $cache_file_name = 'company_article_' . $company_id;
        if (ObjectCache::isCached($cache_file_name, true, $this->cacheTtl)) {
            $cached = ObjectCache::getCache($cache_file_name);
            if (!empty($cached['title']) || !empty($cached['sections'])) {
                return $cached;
            }
        }

        if (empty($this->apiKey)) {
            return array();
        }

        $article = $this->generateArticle($company_data, $faq_details_list, $faq_category_list);
        if (empty($article)) {
            return array();
        }

        ObjectCache::cache($cache_file_name, $article, false);

        return $article;
    }

    public function getCompanyFaqArticle($company_id, $company_data, $faq_details_list, $faq_category_list)
    {
        $article_data = $this->getCompanyFaqArticleData($company_id, $company_data, $faq_details_list, $faq_category_list);
        if (empty($article_data)) {
            return '';
        }

        return json_encode($article_data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    private function generateArticle($company_data, $faq_details_list, $faq_category_list)
    {
        $payload = array(
            'company' => $this->normalizeCompanyData($company_data),
            'categories' => $this->normalizeCategoryList($faq_category_list),
            'faqs' => $this->normalizeFaqList($faq_details_list)
        );

        $request = array(
            'model' => $this->model,
            'input' => array(
                array(
                    'role' => 'developer',
                    'content' => array(
                        array(
                            'type' => 'input_text',
                            'text' => $this->getDeveloperInstruction()
                        )
                    )
                ),
                array(
                    'role' => 'user',
                    'content' => array(
                        array(
                            'type' => 'input_text',
                            'text' => json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
                        )
                    )
                )
            ),
            'text' => array(
                'format' => array(
                    'type' => 'json_schema',
                    'name' => 'company_faq_article',
                    'strict' => true,
                    'schema' => $this->getJsonSchema()
                )
            ),
            'max_output_tokens' => 2500
        );

        $response = $this->postJson('https://api.openai.com/v1/responses', $request);
        if (empty($response)) {
            return array();
        }

        $json_text = $this->extractOutputText($response);
        if ($json_text === '') {
            return array();
        }

        $article = json_decode($json_text, true);
        if (!is_array($article)) {
            $json_text = $this->stripJsonFence($json_text);
            $article = json_decode($json_text, true);
        }

        return is_array($article) ? $article : array();
    }

    private function getDeveloperInstruction()
    {
        return "Generate an SEO-friendly article that summarizes the company FAQ page.\n"
            . "Use only the company profile, categories, questions, and answers provided.\n"
            . "Do not invent services, prices, awards, guarantees, opening hours, or contact details.\n"
            . "Do not include emoji.\n"
            . "Do not include HTML tags in JSON text fields.\n"
            . "Do not use <br>.\n"
            . "Use professional, helpful language for visitors who want a quick page overview.\n"
            . "Explain what the FAQs help users understand, what problems they may solve, and what users can do next.\n"
            . "Keep the article concise and easy to scan.";
    }

    private function getJsonSchema()
    {
        return array(
            'type' => 'object',
            'additionalProperties' => false,
            'required' => array('title', 'intro', 'sections', 'faq_summary', 'conclusion', 'formatting'),
            'properties' => array(
                'title' => array('type' => 'string'),
                'intro' => array('type' => 'string'),
                'sections' => array(
                    'type' => 'array',
                    'minItems' => 3,
                    'maxItems' => 5,
                    'items' => array(
                        'type' => 'object',
                        'additionalProperties' => false,
                        'required' => array('heading', 'body'),
                        'properties' => array(
                            'heading' => array('type' => 'string'),
                            'body' => array('type' => 'string')
                        )
                    )
                ),
                'faq_summary' => array(
                    'type' => 'array',
                    'minItems' => 1,
                    'maxItems' => 12,
                    'items' => array(
                        'type' => 'object',
                        'additionalProperties' => false,
                        'required' => array('question', 'summary'),
                        'properties' => array(
                            'question' => array('type' => 'string'),
                            'summary' => array('type' => 'string')
                        )
                    )
                ),
                'conclusion' => array('type' => 'string'),
                'formatting' => array(
                    'type' => 'object',
                    'additionalProperties' => false,
                    'required' => array('uses_br', 'uses_new_lines', 'uses_emoji'),
                    'properties' => array(
                        'uses_br' => array('type' => 'boolean'),
                        'uses_new_lines' => array('type' => 'boolean'),
                        'uses_emoji' => array('type' => 'boolean')
                    )
                )
            )
        );
    }

    private function normalizeCompanyData($company_data)
    {
        return array(
            'name' => $this->cleanText($this->arrayValue($company_data, 'company_name')),
            'name_cn' => $this->cleanText($this->arrayValue($company_data, 'company_name_cn')),
            'name_bm' => $this->cleanText($this->arrayValue($company_data, 'company_name_bm')),
            'description' => $this->cleanText($this->arrayValue($company_data, 'shortservices')),
            'area' => $this->cleanText($this->arrayValue($company_data, 'area')),
            'tags' => $this->splitList($this->arrayValue($company_data, 'pages_title')),
            'website' => $this->cleanText($this->arrayValue($company_data, 'website')),
            'address' => $this->cleanText($this->arrayValue($company_data, 'address'))
        );
    }

    private function normalizeCategoryList($faq_category_list)
    {
        $categories = array();
        foreach ((array) $faq_category_list as $category) {
            if (!empty($category['category_title_en'])) {
                $categories[] = $this->cleanText($category['category_title_en']);
            }
        }
        return array_values(array_unique(array_filter($categories)));
    }

    private function normalizeFaqList($faq_details_list)
    {
        $faqs = array();
        $count = 0;
        foreach ((array) $faq_details_list as $faq) {
            if ($count >= $this->maxFaqs) {
                break;
            }

            $question = $this->cleanText($this->arrayValue($faq, 'faq_question_en'));
            $answer = $this->cleanText($this->arrayValue($faq, 'faq_answer_en'));
            if ($question === '' && $answer === '') {
                continue;
            }

            $faqs[] = array(
                'question' => $this->limitText($question, 300),
                'answer' => $this->limitText($answer, 900)
            );
            $count++;
        }
        return $faqs;
    }

    private function postJson($url, $data)
    {
        if (!function_exists('curl_init')) {
            return array();
        }

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->apiKey
        ));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
        curl_setopt($ch, CURLOPT_TIMEOUT, 45);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);

        $body = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($body === false || $status < 200 || $status >= 300) {
            return array();
        }

        $decoded = json_decode($body, true);
        return is_array($decoded) ? $decoded : array();
    }

    private function extractOutputText($response)
    {
        if (!empty($response['output_text'])) {
            return trim($response['output_text']);
        }

        if (!empty($response['output']) && is_array($response['output'])) {
            foreach ($response['output'] as $output) {
                if (empty($output['content']) || !is_array($output['content'])) {
                    continue;
                }
                foreach ($output['content'] as $content) {
                    if (!empty($content['text'])) {
                        return trim($content['text']);
                    }
                }
            }
        }

        return '';
    }

    private function stripJsonFence($text)
    {
        $text = trim($text);
        $text = preg_replace('/^```json\s*/i', '', $text);
        $text = preg_replace('/^```\s*/', '', $text);
        $text = preg_replace('/\s*```$/', '', $text);
        return trim($text);
    }

    private function splitList($text)
    {
        $items = array();
        foreach (explode(',', (string) $text) as $item) {
            $item = $this->cleanText($item);
            if ($item !== '') {
                $items[] = $item;
            }
        }
        return $items;
    }

    private function arrayValue($array, $key)
    {
        return (is_array($array) && isset($array[$key])) ? $array[$key] : '';
    }

    private function cleanText($text)
    {
        $text = Helper::iconvUtf8((string) $text);
        $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text = strip_tags($text);
        $text = preg_replace('/\s+/', ' ', $text);
        return trim($text);
    }

    private function limitText($text, $limit)
    {
        if (mb_strlen($text, 'UTF-8') <= $limit) {
            return $text;
        }
        return mb_substr($text, 0, $limit, 'UTF-8') . '...';
    }

}
?>
