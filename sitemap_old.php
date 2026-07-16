<?php
require_once 'required.php';

function getBaseUrl()
{
    $scheme = 'http';

    if (
        (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== '' && $_SERVER['HTTPS'] !== 'off')
        || (isset($_SERVER['SERVER_PORT']) && (int) $_SERVER['SERVER_PORT'] === 443)
    ) {
        $scheme = 'https';
    }

    $host = 'localhost';
    if (isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] !== '') {
        $host = $_SERVER['HTTP_HOST'];
    } elseif (isset($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] !== '') {
        $host = $_SERVER['SERVER_NAME'];
    }

    $basePath = '';
    if (isset($_SERVER['SCRIPT_NAME']) && $_SERVER['SCRIPT_NAME'] !== '') {
        $scriptName = $_SERVER['SCRIPT_NAME'];
        $dir = str_replace('\\', '/', dirname($scriptName));
        if ($dir !== '/' && $dir !== '.') {
            $basePath = rtrim($dir, '/');
        }
    }

    return $scheme . '://' . $host . $basePath;
}

function rrmdirFiles($dir, $pattern = '*.xml')
{
    if (!is_dir($dir)) {
        return;
    }
    foreach (glob(rtrim($dir, '/') . '/' . $pattern) as $file) {
        if (is_file($file)) {
            unlink($file);
        }
    }
}

function writeSitemapFile($filePath, array $urls)
{
    $fh = fopen($filePath, 'w');

    fwrite($fh, "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n");
    fwrite($fh, "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n");

    $now = gmdate('Y-m-d\TH:i:s\Z');

    foreach ($urls as $url) {
        fwrite($fh, "  <url>\n");
        fwrite($fh, "    <loc>{$url}</loc>\n");
        fwrite($fh, "    <lastmod>{$now}</lastmod>\n");
        fwrite($fh, "  </url>\n");
    }

    fwrite($fh, "</urlset>");
    fclose($fh);
}

function getTotal($conn, $sql)
{
    $res = mysqli_query($conn, $sql);
    if (!$res) {
        return 0;
    }
    $row = mysqli_fetch_assoc($res);
    return isset($row['total']) ? (int) $row['total'] : 0;
}

function fetchPage($conn, $sql)
{
    $res = mysqli_query($conn, $sql);
    if (!$res) {
        return [];
    }

    $rows = [];
    while ($r = mysqli_fetch_assoc($res)) {
        $rows[] = $r;
    }
    return $rows;
}

$baseUrl = rtrim(getBaseUrl(), '/');
$sitemapDir = __DIR__ . '/sitemaps/';
$indexFile = __DIR__ . '/sitemap.xml';
$stampFile = __DIR__ . '/.sitemap_last_run';

$perFile = 500;
$weekSeconds = 7 * 24 * 60 * 60;

$isForce = false;
$isClear = false;

if (isset($_GET['token'])) {
    if ($_GET['token'] === 'ryanwanttoforce') {
        $isForce = true;
    }

    if ($_GET['token'] === 'ryanwanttoclear') {
        $isClear = true;
    }
}


if (!is_dir($sitemapDir)) {
    mkdir($sitemapDir, 0755, true);
}

if ($isClear) {
    rrmdirFiles($sitemapDir, '*.xml');
    if (is_file($indexFile)) {
        unlink($indexFile);
    }
    if (is_file($stampFile)) {
        unlink($stampFile);
    }
    exit('Sitemap cleared.');
}

if (!$isForce && file_exists($stampFile)) {
    $lastRun = (int) file_get_contents($stampFile);
    if ((time() - $lastRun) < $weekSeconds) {
        exit('Sitemap still valid.');
    }
}

$sources = [
    [
        'type' => 'faq',
        'count_sql' => "SELECT COUNT(1) AS total FROM $db_8_np2u.ex_faq WHERE faq_category_id != '0'",
        'page_sql' => function ($limit, $offset) {
            global $db_8_np2u;
            return "SELECT id FROM $db_8_np2u.ex_faq WHERE faq_category_id != 0 ORDER BY id ASC LIMIT {$limit} OFFSET {$offset}";
        },
    ],
    [
        'type' => 'company',
        'count_sql' => "SELECT COUNT(DISTINCT cp.company_id) AS total
                        FROM $db_8_np2u.company_profile cp
                        INNER JOIN ex_faq f ON f.company_id = cp.company_id
                        WHERE cp.active = 1
                        AND f.faq_category_id != 0",
        'page_sql' => function ($limit, $offset) {
            global $db_8_np2u;
            return "SELECT DISTINCT cp.company_id
                    FROM $db_8_np2u.company_profile cp
                    INNER JOIN $db_8_np2u.ex_faq f ON f.company_id = cp.company_id
                    WHERE cp.active = 1 AND f.faq_category_id != 0
                    ORDER BY cp.company_id ASC
                    LIMIT {$limit} OFFSET {$offset}";
        },
    ],
];

$sitemapFiles = [];

foreach ($sources as $src) {
    $type = $src['type'];
    $total = getTotal($conn, $src['count_sql']);

    if ($total <= 0) {
        continue;
    }

    $totalFiles = (int) ceil($total / $perFile);

    for ($fileNo = 1; $fileNo <= $totalFiles; $fileNo++) {
        $offset = ($fileNo - 1) * $perFile;

        $sql = $src['page_sql']($perFile, $offset);
        $rows = fetchPage($conn, $sql);

        $urls = [];

        foreach ($rows as $row) {
            switch ($type) {
                case 'faq':
                    $urls[] = $baseUrl . '/id/' . $row['id'];
                    break;

                case 'company':
                    $urls[] = $baseUrl . '/company/' . $row['company_id'];
                    break;
            }
        }

        $fileName = $type . '.xml';
        if ($fileNo > 1) {
            $fileName = $type . '_' . $fileNo . '.xml';
        }

        $filePath = $sitemapDir . $fileName;
        writeSitemapFile($filePath, $urls);

        $sitemapFiles[] = $baseUrl . '/sitemaps/' . $fileName;
    }
}

$fh = fopen($indexFile, 'w');

fwrite($fh, "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n");
fwrite($fh, "<sitemapindex xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n");

$now = gmdate('Y-m-d\TH:i:s\Z');

foreach ($sitemapFiles as $sm) {
    fwrite($fh, "  <sitemap>\n");
    fwrite($fh, "    <loc>{$sm}</loc>\n");
    fwrite($fh, "    <lastmod>{$now}</lastmod>\n");
    fwrite($fh, "  </sitemap>\n");
}

fwrite($fh, "</sitemapindex>");
fclose($fh);

file_put_contents($stampFile, (string) time());

echo $force ? 'Sitemap force-regenerated successfully' : 'Sitemap generated successfully';
?>