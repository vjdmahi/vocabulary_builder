<?php
use App\Models\Vocabulary;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
// Boot the application
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $v = Vocabulary::create([
        'word' => 'test_' . time(),
        'meaning' => 'test_m',
        'usage_example' => 'test_e',
        'action' => 'verified_action'
    ]);
    echo "\nTEST_RESULT: " . $v->action . "\n";
    $v->delete();
} catch (\Exception $e) {
    echo "\nTEST_ERROR: " . $e->getMessage() . "\n";
}
