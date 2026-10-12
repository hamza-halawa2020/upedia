<?php

use App\Models\User;
use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/../../vendor/autoload.php';
$app = require __DIR__.'/../../bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();
echo "Transport: Firebase only; broadcasting disabled.\n";
echo 'Service-account file: '.(is_file((string) config('services.firebase.service_account_path')) ? 'present' : 'missing')."\n";
$user = User::where('email', $argv[1] ?? 'admin@example.com')->firstOrFail();
echo 'Active browser tokens for requested user: '.$user->deviceTokens()->where('is_active', true)->where('device_type', 'web')->count()."\n";
$domain = config('services.firebase.auth_domain');
$project = config('services.firebase.project_id');
if (str_ends_with((string) $domain, '.firebaseapp.com')) {
    echo 'Default web auth domain matches server project: '.($domain === $project.'.firebaseapp.com' ? 'yes' : 'NO')."\n";
}
if (preg_match('/^1:([^:]+):web:/', (string) config('services.firebase.app_id'), $match)) {
    echo 'Web app sender matches messaging sender ID: '.($match[1] === (string) config('services.firebase.messaging_sender_id') ? 'yes' : 'NO')."\n";
}
