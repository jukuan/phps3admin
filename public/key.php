<?php

use Jukuan\PhpS3Admin\S3HandlerFactory;

global $s3aParams;

$bucket = $_GET['b'] ?? '';
$key = $_GET['k'] ?? '';
$key = $_GET['k'] ?? '';

if (isset($_GET['status'])) {
    $s3aParams = [
        'page' => basename(__FILE__),
        'status' => $_GET['status'],
        'msg' => $_GET['msg'] ?? '',
    ];
} else {
    $s3aParams = [
        'page' => basename(__FILE__),
        'bucketName' => $bucket,
        'keyName' => $key,
    ];
}

if (isset($_GET['action'])) {
    if ('delete' == $_GET['action']) {
        require_once __DIR__ . '/../vendor/autoload.php';
        $s3h = (new S3HandlerFactory())->build();
        $params = [];

        try {
            $s3h->delete($bucket, $key);
            $params['status'] = 'ok';
            $params['msg'] = 'Object has been deleted';
        } catch (Throwable $ex) {
            $params['status'] = 'error';
            $params['msg'] = $ex->getMessage();
        }

        $queryString = http_build_query($params);
        header("Location: {$_SERVER['PHP_SELF']}?$queryString");
        die();
    }
}

require __DIR__ . '/../ui/twig/render.php';
