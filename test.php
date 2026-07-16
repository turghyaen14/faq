<?php
header('Content-Type: text/plain; charset=utf-8');

require_once(__DIR__ . '/config/config.php');

$apiKey = getenv('OPENAI_API_KEY') ? getenv('OPENAI_API_KEY') : $OPENAI_API_KEY;
$model = getenv('OPENAI_MODEL') ? getenv('OPENAI_MODEL') : $OPENAI_MODEL;

echo "OpenAI API Key Test\n";
echo "===================\n\n";

if (empty($apiKey)) {
    echo "Status: FAILED\n";
    echo "Reason: OPENAI_API_KEY is empty.\n";
    echo "Fix: Set OPENAI_API_KEY in your server environment or config.php.\n";
    exit;
}

if (!function_exists('curl_init')) {
    echo "Status: FAILED\n";
    echo "Reason: PHP cURL extension is not enabled.\n";
    exit;
}

$maskedKey = substr($apiKey, 0, 7) . str_repeat('*', max(strlen($apiKey) - 11, 4)) . substr($apiKey, -4);
echo "Key Found: Yes\n";
echo "Key Preview: " . $maskedKey . "\n";
echo "Model: " . $model . "\n\n";

$payload = array(
    'model' => $model,
    'input' => 'Reply with exactly this sentence: OpenAI API key is working.',
    'max_output_tokens' => 80
);

$ch = curl_init('https://api.openai.com/v1/responses');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Authorization: Bearer ' . $apiKey
));
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_TIMEOUT, 45);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);

$body = curl_exec($ch);
$curlError = curl_error($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP Code: " . $httpCode . "\n";

if ($body === false || $curlError !== '') {
    echo "Status: FAILED\n";
    echo "cURL Error: " . $curlError . "\n";
    exit;
}

$response = json_decode($body, true);
if (!is_array($response)) {
    echo "Status: FAILED\n";
    echo "Reason: OpenAI response was not valid JSON.\n\n";
    echo "Raw Response:\n";
    echo $body . "\n";
    exit;
}

if ($httpCode < 200 || $httpCode >= 300) {
    echo "Status: FAILED\n";
    echo "OpenAI Error:\n";
    print_r($response);
    exit;
}

$outputText = '';
if (!empty($response['output_text'])) {
    $outputText = $response['output_text'];
} elseif (!empty($response['output']) && is_array($response['output'])) {
    foreach ($response['output'] as $output) {
        if (empty($output['content']) || !is_array($output['content'])) {
            continue;
        }
        foreach ($output['content'] as $content) {
            if (!empty($content['text'])) {
                $outputText .= $content['text'];
            }
        }
    }
}

echo "Status: SUCCESS\n\n";
echo "Model Output:\n";
echo trim($outputText) . "\n\n";
echo "Raw Response ID: " . (isset($response['id']) ? $response['id'] : 'N/A') . "\n";
?>
