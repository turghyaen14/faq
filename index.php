<?php
$host = $_SERVER['HTTP_HOST'];
if ($host === 'ryantest.newpages.com.my') {
    require_once($_SERVER['DOCUMENT_ROOT'] . "/faq/required.php");
} else {
    require_once($_SERVER['DOCUMENT_ROOT'] . "/required.php");
}
Helper::logUserInfo();
$routeRaw = '';
$segments = [];

if (isset($_GET['route']) && $_GET['route'] !== '') {
    $routeRaw = strtolower(trim($_GET['route'], '/'));
    $segments = explode('/', $routeRaw);
}

$context = [
    'route' => '',
    'params' => []
];

/* set route */
if (isset($segments[0]) && $segments[0] !== '') {
    $context['route'] = $segments[0];
}

/* parse params (start AFTER route) */
$i = 0;
$count = count($segments);

while ($i < $count) {
    $key = $segments[$i];

    if ($key === '') {
        $i++;
        continue;
    }

    if (!isset($segments[$i + 1])) {
        break;
    }

    $context['params'][$key] = $segments[$i + 1];
    $i += 2;
}

$routes = [
    'company' => [
        'controller' => 'CompanyPageController',
        'method' => 'displayCompanyPage'
    ],
    'id' => [
        'controller' => 'IndividualPageController',
        'method' => 'displayIndividualPage'
    ],
    'search' => [
        'controller' => 'SearchPageController',
        'method' => 'displaySearchPage'
    ],
    'aboutus' => [
        'controller' => 'AboutUsPageController',
        'method' => 'displayAboutUsPage'
    ],
    'notfound404' => [
        'controller' => 'NotFound404PageController',
        'method' => 'displayNotFound404Page'
    ],
    'default' => [
        'controller' => 'IndexPageController',
        'method' => 'displayIndexPage'
    ]
];

$routeKey = 'default';
if ($context['route'] !== '' && isset($routes[$context['route']])) {
    $routeKey = $context['route'];
}

$routeConfig = $routes[$routeKey];
$controllerClass = $routeConfig['controller'];
$displayMethod = $routeConfig['method'];

$controller = new $controllerClass();
echo $controller->wrapContent(
    $controller->$displayMethod($context['params'])
);
