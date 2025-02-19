<?php

use Aws\S3\Exception\S3Exception;
use Jukuan\PhpS3Admin\S3HandlerFactory;

global $s3aParams;

if (isset($_GET['status'])) {
    $s3aParams = [
        'page' => basename(__FILE__),
        'bucketName' => $_REQUEST['b'] ?? '',
        'keyName' => $_REQUEST['k'] ?? '',
        'prefix' => $_REQUEST['p'] ?? '',
        'status' => $_GET['status'],
        'msg' => $_REQUEST['msg'] ?? '',
    ];
} else {
    $s3aParams = [
        'page' => basename(__FILE__),
        'bucketName' => $_REQUEST['b'] ?? '',
        'keyName' => $_REQUEST['k'] ?? '',
        'prefix' => $_REQUEST['p'] ?? '',
    ];
}

// Handle file upload
if ('POST' === $_SERVER['REQUEST_METHOD']) {
    require_once __DIR__ . '/../vendor/autoload.php';
    $s3Client = (new S3HandlerFactory())->build();

    $bucket = $s3aParams['bucketName'] ?? '';
    $prefix = $s3aParams['prefix'] ?? '';
    $file = $_FILES['file'] ?? null;
    $params = [];

    if (UPLOAD_ERR_OK === $file['error']) {
        $filePath = $file['tmp_name'];
        $fileName = $file['name'];
        $key = rtrim($prefix, '/') . '/' . $fileName;
        $key = str_replace('//', '/', $key);

        try {
            $result = $s3Client->putObject([
                'Bucket' => $bucket,
                'Key' => $key,
                'SourceFile' => $filePath,
            ]);
            $params['status'] = 'ok';
            $params['msg'] = sprintf('File has been uploaded: %s', $result['ObjectURL']);
        } catch (S3Exception $ex) {
            $params['status'] = 'error';
            $params['msg'] = $ex->getMessage();
        }
    } else {
        $params['status'] = 'error';
        $params['errMsg'] = 'File upload error!';
    }

    $queryString = http_build_query($params);
    header("Location: {$_SERVER['PHP_SELF']}?$queryString");
    die();
}

require __DIR__ . '/../ui/twig/render.php';
