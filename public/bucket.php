<?php

global $s3aParams;
$s3aParams = [
    'page' => basename(__FILE__),
    'bucketName' => $_GET['b'] ?? '',
    'prefix' => $_GET['p'] ?? '',
    'show' => $_GET['show'] ?? 'all',
];

require __DIR__ . '/../ui/twig/render.php';
