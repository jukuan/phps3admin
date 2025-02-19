<?php

declare(strict_types=1);

namespace Jukuan\PhpS3Admin\Config;

use Aws\S3\S3Client;
use Jukuan\PhpS3Admin\Exception\ConfigException;

class Builder
{
    private const DEFAULT_REGION = 'us-east-1';

    private S3Client $s3Client;

    final public function __construct(
        string $hostBase,
        string $accessKey,
        string $secretKey,
        string $region = '',
        string $version = '',
    )
    {
        if (!str_starts_with($hostBase, 'http')) {
            $hostBase = 'https://' . $hostBase;
        }

        $this->s3Client = new S3Client([
            'version' => $version ?: 'latest',
            'region'  => $region ?: self::DEFAULT_REGION,
            'endpoint' => $hostBase,
            'credentials' => [
                'key'    => $accessKey,
                'secret' => $secretKey,
            ],
        ]);
    }

    public static function fromArray(array $config): static
    {
        $host = $config['host_base'] ?: ($config['host'] ?: null);
        $key = $config['access_key'] ?: ($config['key'] ?: null);
        $secret = $config['secret_key'] ?: ($config['secret'] ?: null);

        if (
            null === $host ||
            null === $key ||
            null === $secret
        ) {
            throw new ConfigException();
        }

        return new static(
            $host,
            $key,
            $secret,
            $config['region'] ?? '',
            $config['version'] ?? '',
        );
    }

    public function getS3Client(): S3Client
    {
        return $this->s3Client;
    }
}