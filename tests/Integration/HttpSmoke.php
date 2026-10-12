<?php

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;

require __DIR__.'/../../vendor/autoload.php';
$email = getenv('UPEDIA_SMOKE_EMAIL');
$password = getenv('UPEDIA_SMOKE_PASSWORD');
if (! $email || ! $password) {
    throw new RuntimeException('Supply smoke credentials via process environment; never store them in this file.');
}
$client = new Client(['base_uri' => 'http://upedia-all.test', 'cookies' => new CookieJar,
    'timeout' => 30, 'http_errors' => false, 'allow_redirects' => false]);
$login = $client->get('/login');
$document = new DOMDocument;
@$document->loadHTML((string) $login->getBody());
$token = (new DOMXPath($document))->query('//input[@name="_token"]')->item(0)?->getAttribute('value');
if (! $token) {
    throw new RuntimeException('Login form token unavailable.');
}
$result = $client->post('/login', ['form_params' => ['email' => $email, 'password' => $password, '_token' => $token]]);
if ($result->getStatusCode() !== 302 || str_contains($result->getHeaderLine('Location'), '/login')) {
    throw new RuntimeException('Login failed; no further login attempts were made.');
}
$failures = 0;
$paths = ['/marketing', '/marketing/plans', '/marketing/plans/create', '/marketing/calendar',
    '/marketing/plans/calendar/events', '/marketing/scripts', '/marketing/scripts/create',
    '/marketing/complains', '/marketing/complains/create', '/marketing/quick-links', '/marketing/reports',
    '/it', '/it/statistics', '/it/asset-dashboard', '/it/reports', '/it/products', '/it/products/create',
    '/it/vendors', '/it/vendors/create', '/it/purchase', '/it/purchase/create', '/it/expenses', '/it/expenses/create',
    '/it/asset', '/it/asset/create', '/it/tickets', '/it/tickets/create', '/it/ticket-items',
    '/it/ticket-categories', '/it/ticket-priorities', '/it/filtered-tables', '/it/it-solutions', '/it/solutions'];
foreach ($paths as $path) {
    $response = $client->get($path);
    $status = $response->getStatusCode();
    $body = (string) $response->getBody();
    $passed = $status === 200 && strlen($body) > 0;
    echo ($passed ? 'PASS' : 'FAIL')." {$status} {$path}\n";
    if (! $passed) {
        $failures++;
        if ($status >= 500) {
            $document = new DOMDocument;
            @$document->loadHTML($body);
            $title = (new DOMXPath($document))->query('//title')->item(0)?->textContent;
            echo '  Error title: '.trim((string) $title)."\n";
        }
    }
}
echo 'HTTP checks: '.count($paths)."; failures: {$failures}. No CRUD writes were made.\n";
$client->post('/logout', ['form_params' => ['_token' => $token]]);
exit($failures ? 1 : 0);
