<?php

use App\Models\User;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Auth;

require __DIR__.'/../../vendor/autoload.php';
$app = require __DIR__.'/../../bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();
config(['session.driver' => 'array', 'app.url' => 'http://upedia-all.test']);
Auth::setUser((new User)->forceFill(['id' => 1]));
foreach (['firebase-client', 'reverb-client'] as $name) {
    $html = view('notifications::partials.'.$name)->render();
    preg_match_all('/<script>(.*?)<\/script>/s', $html, $matches);
    foreach ($matches[1] as $script) {
        echo json_encode(['name' => $name, 'script' => $script], JSON_THROW_ON_ERROR)."\n";
    }
}
