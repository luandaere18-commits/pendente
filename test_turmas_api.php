<?php

require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle($request = \Illuminate\Http\Request::create('/turmas?per_page=10', 'GET', [], [], [], ['HTTP_ACCEPT' => 'application/json']));

echo "Status: " . $response->status() . "\n";
echo "Content Type: " . $response->headers->get('content-type') . "\n\n";
echo "Response:\n";
echo $response->getContent();
?>
