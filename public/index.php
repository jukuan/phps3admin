<?php

global $s3aParams;
$s3aParams = [
    'page' => basename(__FILE__)
];

require __DIR__ . '/../ui/twig/render.php';
