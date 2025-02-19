<?php

use Jukuan\PhpS3Admin\S3HandlerFactory;
$twig = require_once __DIR__ . '/loader.php';

[$page, $s3aParams] = prepareRenderParams();
echo $twig->render($page, $s3aParams);

function prepareRenderParams(): array
{
    global $s3aParams;
    $s3aParams = (array)$s3aParams;
    $s3aParams['s3h'] = (new S3HandlerFactory())->build();

    if (isset($s3aParams['page'])) {
        $page = str_replace('.php', '.html.twig', $s3aParams['page']);
        unset($s3aParams['page']);
    } else {
        $page = 'index.html.twig';
    }

    return [$page, $s3aParams];
}