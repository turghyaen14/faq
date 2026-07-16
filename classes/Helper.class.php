<?php
class Helper
{

    public static function switchLang($en, $cn = '', $bm = '')
    {
        global $lang;

        switch ($lang) {
            case 'zh':
                return (empty($cn)) ? self::iconvUtf8($en) : self::iconvUtf8($cn);
                break;
            case 'bm':
                return (empty($bm)) ? self::iconvUtf8($en) : self::iconvUtf8($bm);
                break;
            default:
                if (empty($en) && empty($cn)) {
                    return self::iconvUtf8($bm);
                }

                if (empty($en) && empty($bm)) {
                    return self::iconvUtf8($cn);
                }
                return self::iconvUtf8($en);
        }

    }

    public static function iconvUtf8($input)
    {
        if (mb_check_encoding($input, 'UTF-8'))
            return $input;

        if (!empty($input)) {
            //['GB2312','UTF-8','GBK'] 
            return iconv(mb_detect_encoding($input, ['GB2312', 'UTF-8', 'GBK'], true), "utf-8//IGNORE", $input);
        } else {
            return $input;
        }
    }

    public static function normalize_malaysia_phone($phone)
    {
        $phone = preg_replace('/\D+/', '', $phone);
        if (strpos($phone, '00') === 0) {
            $phone = substr($phone, 2);
        }

        if (strpos($phone, '60') === 0) {
            $phone = substr($phone, 2);
        }

        if (strpos($phone, '1') === 0) {
            return '+60' . $phone;
        }

        if (strpos($phone, '0') === 0) {
            $phone = substr($phone, 1);
            return '+60' . $phone;
        }
        return '+60' . $phone;
    }

    public static function normalizeSentence($text)
    {
        $text = str_replace(["\r\n", "\r", "\n"], ' ', $text);
        $text = preg_replace('/\s+/', ' ', $text);
        return trim($text);
    }


    public static function paginationComponent($currentPage, $totalRecords, $limit, $windowSize = 5)
    {
        $totalPages = ceil($totalRecords / $limit);

        if ($totalPages <= 1) {
            return '';
        }

        if ($currentPage < 1) {
            $currentPage = 1;
        }
        if ($currentPage > $totalPages) {
            $currentPage = $totalPages;
        }

        if ($windowSize < 1) {
            $windowSize = 5;
        }

        $half = floor($windowSize / 2);

        $start = $currentPage - $half;
        $end = $currentPage + $half;

        if ($start < 1) {
            $start = 1;
            $end = min($windowSize, $totalPages);
        }

        if ($end > $totalPages) {
            $end = $totalPages;
            $start = max(1, $totalPages - $windowSize + 1);
        }

        $prevDisabled = ($currentPage <= 1) ? 'disabled' : '';
        $nextDisabled = ($currentPage >= $totalPages) ? 'disabled' : '';

        $html = '<div class="paginationWrapper">';

        // Prev
        $html .= '
        <a class="prevButton shadowSm js-page-btn ' . $prevDisabled . '" aria-disabled="' . (($currentPage <= 1) ? 'true' : 'false') . '" data-page="' . ($currentPage - 1) . '">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        ';

        $html .= '<ul class="pageWrapper">';

        // Helper to render a page item
        $renderPage = function ($page, $currentPage) {
            $active = ($page == $currentPage) ? 'currentPage' : '';
            return '
            <li class="pageNum ' . $active . '">
                <a class="js-page-btn" data-page="' . $page . '">' . $page . '</a>
            </li>
        ';
        };

        // Helper to render dots
        $renderDots = function () {
            return '
            <li class="pageNum dots">
                <span>...</span>
            </li>
        ';
        };

        // Show first page if window doesn't start at 1
        if ($start > 1) {
            $html .= $renderPage(1, $currentPage);

            // If there's a gap between 1 and start, show dots
            if ($start > 2) {
                $html .= $renderDots();
            }
        }

        // Window pages
        for ($i = $start; $i <= $end; $i++) {
            $html .= $renderPage($i, $currentPage);
        }

        // Show last page if window doesn't end at totalPages
        if ($end < $totalPages) {
            // If there's a gap between end and last, show dots
            if ($end < ($totalPages - 1)) {
                $html .= $renderDots();
            }

            $html .= $renderPage($totalPages, $currentPage);
        }

        $html .= '</ul>';

        // Next
        $html .= '
        <a class="nextButton shadowSm js-page-btn ' . $nextDisabled . '" data-page="' . ($currentPage + 1) . '">
            <i class="fa-solid fa-arrow-right"></i>
        </a>
    ';

        $html .= '</div>';

        return $html;
    }

    public static function slugify($text)
    {
        // Decode HTML entities FIRST
        $text = html_entity_decode((string) $text, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        $text = trim($text);

        if (preg_match('/[\x{4E00}-\x{9FFF}]/u', $text)) {
            $converted = self::convertUTF8($text);
            $converted = trim((string) $converted);
            $converted = rawurlencode($converted);
            return $converted !== '' ? $converted : 'uncategorized';
        }
        $text = mb_strtolower($text, 'UTF-8');

        // Convert & to "and"
        $text = str_replace('&', 'and', $text);

        // Replace non-alphanumeric with dash
        $text = preg_replace('/[^a-z0-9]+/u', '-', $text);

        // Cleanup dashes
        $text = preg_replace('/-+/', '-', $text);
        $text = trim($text, '-');

        return $text !== '' ? $text : 'uncategorized';
    }

    public static function slugifyCompanyName($text)
    {
        // Decode HTML entities FIRST
        $text = html_entity_decode((string) $text, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        $text = trim($text);
        $text = mb_strtolower($text, 'UTF-8');

        // Convert & to "and"
        $text = str_replace('&', 'and', $text);

        // Replace non-alphanumeric with dash
        $text = preg_replace('/[^a-z0-9]+/u', '-', $text);

        // Cleanup dashes
        $text = preg_replace('/-+/', '-', $text);
        $text = trim($text, '-');

        return $text !== '' ? $text : '';
    }

    public static function convertUTF8($arr)
    {
        if (is_array($arr)) {
            foreach ($arr as $key => $value) {
                if (is_array($value)) {
                    $data[$key] = self::convertUTF8($value);
                } else {
                    $data[$key] = self::iconvUtf8($value);
                }
            }
        } else {
            $data = self::iconvUtf8($arr);
        }

        return $data;
    }

    public static function logUserInfo()
    {
        global $conn;
        global $db_8_np2u;

        if (!isset($conn)) {
            return;
        }

        $baseFolder = "visitor_log";
        $logFile = $baseFolder . '/visitor.log';

        if (!is_dir($baseFolder)) {
            mkdir($baseFolder, 0755, true);
        }

        $requestUri = !empty($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
        $path = parse_url($requestUri, PHP_URL_PATH);
        if ($path === null) {
            $path = '';
        }

        $companyId = 0;
        $faqId = 0;

        if (preg_match('~/company/(\d+)~i', $path, $m)) {
            $companyId = $m[1];
        } elseif (preg_match('~/id/(\d+)~i', $path, $m)) {
            $faqId = $m[1];
        }

        $ip = 'UNKNOWN';
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ipList = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $ip = trim($ipList[0]);
        } elseif (!empty($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        $userAgent = !empty($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'UNKNOWN';
        $referrer = !empty($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
        $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host = !empty($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
        $landing = $scheme . '://' . $host . $requestUri;

        $utmSource = 'direct';
        if (isset($_GET['utm_source'])) {
            $tmp = strtolower(trim($_GET['utm_source']));
            if ($tmp !== '') {
                $tmp = preg_replace('/[^a-z0-9_\-\.]/', '', $tmp);
                if ($tmp !== '') {
                    $utmSource = $tmp;
                }
            }
        }

        $refHost = '';
        if ($referrer !== '') {
            $parsedHost = parse_url($referrer, PHP_URL_HOST);
            if (is_string($parsedHost)) {
                $refHost = strtolower($parsedHost);
                $refHost = preg_replace('/^www\./', '', $refHost);
            }
        }

        $isChatGptRef = (
            $refHost === 'chatgpt.com' ||
            $refHost === 'chat.openai.com'
        );

        $isChatGptUtm = ($utmSource === 'chatgpt.com' || $utmSource === 'chatgpt');

        if (!$isChatGptRef && !$isChatGptUtm) {
            return;
        }

        $today = date('Y-m-d');
        $indexFile = $baseFolder . '/keys_' . $today . '.log';

        foreach (glob($baseFolder . '/keys_*.log') as $f) {
            if (is_file($f)) {
                $bn = basename($f);
                $d = substr($bn, 5, 10);
                if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $d)) {
                    $ts = strtotime($d);
                    if ($ts !== false && $ts < strtotime('-7 days')) {
                        unlink($f);
                    }
                }
            }
        }

        $dayKey = sha1($today . '|' . $ip . '|' . $userAgent . '|' . $path);
        $seen = false;

        if (is_file($indexFile)) {
            $content = file_get_contents($indexFile);
            if ($content !== false && strpos($content, $dayKey . "\n") !== false) {
                $seen = true;
            }
        }

        if ($seen) {
            return;
        }

        file_put_contents($indexFile, $dayKey . "\n", FILE_APPEND | LOCK_EX);

        $nowTs = time();
        $timeText = date('Y-m-d H:i:s', $nowTs);

        $safe = function ($s) {
            return str_replace(array("\r", "\n", "|"), ' ', (string) $s);
        };

        $line = $timeText
            . ' | ' . $safe($ip)
            . ' | ' . $safe($utmSource)
            . ' | ' . $safe($landing)
            . ' | ' . $safe($referrer)
            . ' | company_id=' . $companyId
            . ' | faq_id=' . $faqId
            . ' | ts=' . $nowTs
            . "\n";

        file_put_contents($logFile, $line, FILE_APPEND | LOCK_EX);

        $dbIp = mysqli_real_escape_string($conn, $ip);
        $dbUtm = mysqli_real_escape_string($conn, substr($utmSource, 0, 100));
        $dbRef = mysqli_real_escape_string($conn, $referrer);
        $dbLand = mysqli_real_escape_string($conn, substr($landing, 0, 255));

        $sql = "
        INSERT INTO $db_8_np2u.faq_visitor_logs
        (company_id, faq_id, ip_address, utm_source, referrer, landing, visited_at)
        VALUES
        ($companyId, $faqId, '$dbIp', '$dbUtm', '$dbRef', '$dbLand', $nowTs)
    ";

        mysqli_query($conn, $sql);
    }

}
?>