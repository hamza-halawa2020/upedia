<?php

use Illuminate\Contracts\Broadcasting\Factory;
use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/../../vendor/autoload.php';
$app = require __DIR__.'/../../bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();
$options = config('broadcasting.connections.reverb.options');
if (($options['host'] ?? null) !== '127.0.0.1' || (int) ($options['port'] ?? 0) !== 8080) {
    throw new RuntimeException('This verifier only publishes to local Reverb on 127.0.0.1:8080.');
}
$app->make(Factory::class)->connection('reverb')->broadcast(
    ['private-upedia-verification'], 'verification.completed', ['synthetic' => true]
);
echo "PASS: local Reverb accepted a signed synthetic broadcast.\n";
echo "No user notification was created; browser receipt is not verified by this check.\n";
