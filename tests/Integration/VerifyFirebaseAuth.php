<?php

use App\Services\Notifications\FirebaseAccessTokenService;
use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/../../vendor/autoload.php';
$app = require __DIR__.'/../../bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();
$path = config('services.firebase.service_account_path');
$credentials = json_decode(file_get_contents($path), true, flags: JSON_THROW_ON_ERROR);
if (($credentials['type'] ?? null) !== 'service_account'
    || ! openssl_pkey_get_private($credentials['private_key'] ?? '')) {
    throw new RuntimeException('Service-account private key is invalid.');
}
echo "PASS: service-account structure and private key parse.\n";
if (($credentials['project_id'] ?? null) !== config('services.firebase.project_id')) {
    throw new RuntimeException('Firebase project ID does not match service account.');
}
echo "PASS: configured Firebase project matches service account.\n";
$token = app(FirebaseAccessTokenService::class)->handle();
if (! is_string($token) || $token === '') {
    throw new RuntimeException('Firebase OAuth failed; inspect application logs without sharing credential contents.');
}
echo "PASS: Google OAuth accepted the service account. Access token not displayed.\n";
unset($token, $credentials);
foreach (['api_key', 'auth_domain', 'messaging_sender_id', 'app_id', 'vapid_key'] as $name) {
    echo 'Web setting '.$name.': '.(filled(config('services.firebase.'.$name)) ? 'present' : 'missing')."\n";
}
echo "This authenticates the server only; it does not verify browser push delivery.\n";
