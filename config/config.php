<?php

$IMG_PATH = 'https://cdn1.npcdn.net/images/';
$META_TITLE = 'FAQ2U | Trusted & Professional FAQ Platform';
$META_DESC = 'FAQ2U brings all frequently asked questions into one easy-to-search platform, helping users quickly find clear answers without contacting support.';
$_OBJECT_CACHE_PATH = 'cache_object/';

// SECURITY: never hardcode the key here. Set the OPENAI_API_KEY env var instead.
// See docs/DEPLOYMENT_NOTES.md before deploying.
$OPENAI_API_KEY = getenv('OPENAI_API_KEY') ? getenv('OPENAI_API_KEY') : '';
$OPENAI_MODEL = getenv('OPENAI_MODEL') ? getenv('OPENAI_MODEL') : 'gpt-5-mini';
$OPENAI_ARTICLE_CACHE_TTL = 2592000; // 30 days
$OPENAI_ARTICLE_MAX_FAQS = 80;

$OG_TITLE = $META_TITLE;
$OG_DESC = $META_DESC;
$OG_URL = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$OG_IMAGE = "https://cdn1.npcdn.net/img/1769077153faq backdrop.png";
$OG_SITENAME = $META_TITLE;
$OG_TYPE = "website";
?>
