<?php

require __DIR__.'/../vendor/autoload.php';

use GuzzleHttp\Client;

$word = 'hello';
$client = new Client();
$url = "https://api.dictionaryapi.dev/api/v2/entries/en/{$word}";

echo "Testing URL: $url\n";

try {
    $response = $client->request('GET', $url, ['verify' => false]); // check if SSL verify is the issue
    echo "Status Code: " . $response->getStatusCode() . "\n";
    echo "Body: " . substr($response->getBody(), 0, 100) . "...\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
