<?php

declare(strict_types=1);

namespace Jukuan\PhpS3Admin;

use Aws\Exception\AwsException;
use Aws\S3\S3Client;
use Jukuan\PhpS3Admin\Config\Detector;
use Jukuan\PhpS3Admin\Config\S3CfgReader;
use Jukuan\PhpS3Admin\Exception\ReadingException;

readonly class S3HandlerFactory
{

    public function __construct(
    ) {

    }

    public function build(string $configPath  = ''): S3Handler
    {
        if ('' === $configPath) {
            $configPath = (new Detector())->detect();
        }

        if (!$configPath) {
            throw ReadingException::create('Config file not found');
        }

        $s3Client = (new S3CfgReader($configPath))->buildClient();

        return new S3Handler($s3Client);
    }
}