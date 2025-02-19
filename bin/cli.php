#!/usr/bin/php
<?php

use Jukuan\PhpS3Admin\S3HandlerFactory;
require_once __DIR__ . '/../vendor/autoload.php';

$s3Handler = (new S3HandlerFactory())->build();
$method = $argv[1] ?? null;

if (!$method || !method_exists($s3Handler, $method)) {
    die('Error: Invalid method'.PHP_EOL);
}

function show($data): void
{
    if (function_exists('dump')) {
        dump($data);
    } else {
        var_dump($data);
    }
}

$arguments = array_slice($argv, 2);

try {
    $result = call_user_func_array([$s3Handler, $method], $arguments);
    show($result);
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . PHP_EOL;
}
